<?php
/**
 * File for xml api.
 */
ini_set('display_errors', false);
error_reporting(0);

include('./wp-load.php');

function removeAuthorNotes($content = '')
{   
    $pattern = "/(?<authorTags><h6(?<attr>[^>]*)>(?<value>.*?)<\/h6>)/s";
    
    preg_match_all($pattern, $content, $m);
    
    $toRemove = [];

    if(isset($m['authorTags'])){
        foreach($m['authorTags'] as $tag){
            if(preg_match('/^<h6>(<[^>]*>)*[ ]?[b|B]y/s', $tag)){
                    $toRemove[] = $tag;
            }
        }
    }
    
    if(count($toRemove) == 1){
        if(isset($toRemove[0])){
            $tag = $toRemove[0];
            $pos = strpos($content, $tag);
            $end = substr ($content, $pos);
            
            if(mb_strlen($end) < 1100){
                $content = substr ($content, 0, $pos);
            }
        }
    }
    
    return $content;
}

function addPTag($content = '')
{
    $content = preg_replace(array("/\r/", "/\n/"), '|#&newLineTag&#|', $content);
    
    $lines = explode('|#&newLineTag&#|', $content);
    
    foreach($lines as $key => &$line){
        
        if($line == ''){
            unset($lines[$key]);
            continue;
        }

        /* if line contains image then parse it */        
        
        $tmpLine = '';
        
        if(preg_match('/<img/', $line)){                    
            $line = preg_replace(array('/<p>/', '/<\/p>/'), '', $line);
            preg_match_all('/(?<images><img[^>]*>)/', $line, $matches);
            
            if(isset($matches['images'])){
                foreach($matches['images'] as $image){
                    $tmpLine .= $image . "\n";
                    $line = str_replace($image, '', $line);
                }
            }
            
            /* check if there is link and it is not empty */
            preg_match_all('/(?<links><a[^>]*>[^<]*<\/a>)/', $line, $matches);
                
            if(isset($matches['links'])){
                 foreach($matches['links'] as $link){
                     if(preg_replace('/\s+/', '', strip_tags($link)) == ''){
                         $line = str_replace($link, '', $line);
                     }
                 }
            }

            /* if line contains only empty tag - remove this line */                
            if(preg_replace('/\s+/', '', strip_tags($line)) == ''){
                    $line = '';
            }            
        }
        
        if(
            !preg_match('/^<p/', $line) && 
            !preg_match('/^<h1/', $line) &&
            !preg_match('/^<blockquote/', $line)
          ){
            $line = "<p>{$line}</p>";
          }
          
          $line = $tmpLine.$line;
                
    }    
    
    return implode("\n", $lines);
}

function removePluginTags($content = '')
{
    $content = preg_replace('/\[sociallocker id="?\d+\"?]/', '', $content);
    $content = preg_replace('/\[\/sociallocker\]/', '', $content);
    $content = preg_replace('/\[caption[^\]]+/', '', $content);
    $content = preg_replace('/\[\/caption\]/', '', $content);
    $content = preg_replace('/activate javascript/', '', $content);        
    $content = preg_replace(array('/<noscript>/', '/<\/noscript>/'), '', $content);        
    
    return $content;
}

function onlyImagesAndLinks($string = '')
{
    return preg_match('/<img/', $string) || preg_match('/<a/', $string);
}

function replaceH1($string = '')
{
    $paterns = array('/<h[2-6]+([^>]*)>/', '/<\/h[2-6]>/s');
    $replacements = array('<h1$1>', '</h1>');
    return preg_replace($paterns, $replacements, $string);
}

function replaceTag($tag, $content = '')
{
    $patern = "/<{$tag}(?<attr>[^>]*)>(?<value>.*?)<\/{$tag}>/s";
    
    return preg_replace_callback(
                $patern,
                function ($matches) use ($tag) {
                    $value = $matches['value'];
                    $attr = $matches['attr'];
                    
                    $string = str_replace(array("\r", "\n"), '', $value);    
                    
                    if($tag != 'blockquote' && onlyImagesAndLinks($string)){
                        $tag = 'p';
                    }else{
                        $string = strip_tags($string);
                    }
                    
                    return "<{$tag}{$attr}>" .  $string . "</{$tag}>";
                },
                $content
            ); 
}

function removeNewLineInsideTags($content = '')
{
    $tags = ['h1', 'blockquote', 'p', 'strong', 'em', 'a'];
    
    foreach($tags as $tag){
        
        $patern = "/<{$tag}(?<attr>[^>]*)>(?<value>.*?)<\/{$tag}>/s";
        
        $content = preg_replace_callback(
                $patern,
                function ($matches) use ($tag) {
                    $value = $matches['value'];
                    $attr = $matches['attr'];
                    
                    $string = str_replace(array("\r", "\n"), '', $value);    
                    
                    return "<{$tag}{$attr}>" .  $string . "</{$tag}>";
                },
                $content
            ); 
    }
    
    
    return $content;    
}

function removeTags($string = '')
{
    $tags = "<h1></h1><blockquote></blockquote><p></p><strong></strong><em></em><br><br/><img><a></a>";
        
    return strip_tags($string, $tags);
}

function getReplaceYoutubeVideos($content = '')
{
    $pattern = '/<iframe(?P<content>[^>]*)>.*(<\/iframe>)?/i';      
        
    $counter = 0;
    $videos = array();
    
    $content = preg_replace_callback(
            $pattern,
            function ($matches) use (&$counter, &$videos) {
                $counter++;
                
                $src = '';
                if(preg_match('/src="(?P<video>[^"]+)"/', $matches['content'], $video)){
                    $videos[$counter] = $video['video'];
                }
                
                return "#|video_{$counter}|#";
            }, 
            $content
        );
            
    return array(
            'content' => $content,
            'youtubeUlr' => $videos
        );
}

class xmlRender
{
    private $xml = '';
    
    public static $imagesTypes = array('thumbnail', 'medium', 'large', 'full');
    
    private static $counter = 0;
    
    public function __construct()
    {        
        /* add xml header */
        $this->xml .= '<?xml version="1.0" encoding="'. get_option('blog_charset') .'"?>
                            <root>';
    }
    
    public function addXml($string = '')
    {
        $this->xml .= $string;
    }
    
    public function getXml()
    {
        $this->xml .= '</root>';
        return $this->xml;
    }
    
    public static function getXmlForPosts($posts = array())
    {
        $res = '';
        
        if(!empty($posts))
        {
            foreach($posts as $post){
                $res .= self::getXmlForSinglePost($post);
            }
        }
        
        return '<posts>' . $res . '</posts>';
    }
    
    public static function getAllSizeOfAttachmentsById($id)
    {
        $result = array();
        
        foreach(self::$imagesTypes as $type)
        {
            $img = wp_get_attachment_image_src($id, $type);
            
            if(!empty($img) && isset($img[0]))
            {
                $result[$type] = $img[0];
            }
        }
        
        return $result;
    }
    
    private static function getXmlForSingYoutubeVideo($post = null)
    {           
        if(!$post) return '';
        
        setup_postdata( $post );
        
        $res = '';
        $res .= '<id>'. $post->post_excerpt .'</id>';
        $res .= '<title>'. get_the_title($post) .'</title>';
        $res .= '<publish_date>'. apply_filters('get_the_time' , $post->post_date ) .'</publish_date>';
        
        $res .= '<content>
			<![CDATA['. get_the_content() .']]>
		</content>';
        
        $res .= '<link>'. $post->guid  .'</link>'; 
        
        $res .= '<viewCount>' . $post->comment_count . '</viewCount>';
        
        wp_reset_postdata();
        
        return '<post isYoutube="1">' . $res . '</post>';
    }
    
    private static function getXmlForSinglePost($post = null)
    {
        if(!$post) return '';
                
        if($post->post_type == 'youtube-video'){
            return self::getXmlForSingYoutubeVideo($post);
        }
        
        setup_postdata( $post );
                
        $res = '';        
        $res .= '<title>'. get_the_title($post) .'</title>';
        $res .= '<publish_date>'. apply_filters('get_the_time' , $post->post_date ) .'</publish_date>';
        
        $postContent = get_the_content();

        $customThumbnailName = '';

        if(preg_match('/(?<img><img[^>]+>)/', $postContent, $tmpMatches))
        {
            if(preg_match('/src="(?<img1>[^"]+)"/i', $tmpMatches['img'], $tm))
            {
                $customThumbnailName = $tm['img1'];
            }
        }
        
        $content = removePluginTags($postContent);
        
        $content = removeAuthorNotes($content);

        $result = getReplaceYoutubeVideos($content);

        $content = $result['content'];
        
        $youtubeUlrs = $result['youtubeUlr'];

        $content = replaceH1($content);

        $content = replaceTag('blockquote', $content);

        $content = replaceTag('h1', $content);

        $content = removeTags($content);

        $content = removeNewLineInsideTags($content);
        
        $reformatContent = addPTag($content);

        $res .= '<content>
			<![CDATA['. $reformatContent .']]>
		</content>';

        $res .= '<link>'. get_permalink($post->ID)  .'</link>'; 
        
        $categories = '';
        
        foreach(wp_get_post_categories($post->ID) as $category)
        {
            $postCategory = get_category( $category );
            
            $categories .= '<category>
                    <name>' . $postCategory->name . '</name>
                    <slug>' . $postCategory->slug . '</slug>
                 </category>';
        }
        
        $res .= '<categories>' . $categories . '</categories>';
        
        $youtubeVideo = '';
        
        if(isset($youtubeUlrs) && !empty($youtubeUlrs)){
            foreach($youtubeUlrs as $youtubeKey => $url){
                $youtubeVideo .= "<url tagName='#|video_{$youtubeKey}|#'>{$url}</url>";
            }
        }
        
        $res .= "<youtube>{$youtubeVideo}</youtube>";
        
        global $wpdb;
                
        $imageObject = null;
        $isRealThumbnail = 0;
        
        if($customThumbnailName != ''){
            $imageObject = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE guid Like '%$customThumbnailName'");
        }
        
        $thumbnail_id = -1;
        
        if(!$imageObject)
        {
            $isRealThumbnail = 1;
            $thumbnail_id = get_post_thumbnail_id($post->ID);            
        }else{
            $thumbnail_id = $imageObject->ID;
        }
        
        $image = self::getAllSizeOfAttachmentsById($thumbnail_id);
        
        $attachmentsTypes = '';
        
        foreach(self::$imagesTypes as $type)
        {
            $src = isset($image[$type]) ? $image[$type] : '';
            $src = str_replace('http://mytinysecrets.com/', 'http://cdn.mytinysecrets.com/', $src);
            
            $attachmentsTypes .= "<{$type}>{$src}</{$type}>";
        }
        
        $res .= "<image isRealThumbnail='{$isRealThumbnail}'>{$attachmentsTypes}</image>"; 
        
        $res .= '<author>'. get_the_author_meta('display_name', $post->post_author) .'</author>'; 
        
        $res .= '<authorUrl>'. get_the_author_meta('user_nicename' , $post->post_author) .'</authorUrl>'; 
        
        $res .= '<authorAvatar>'. self::getAuthorAvatarUrl(get_avatar($post->post_author, 100)) .'</authorAvatar>'; 
        
        $res .= '<url>'. $post->post_name .'</url>'; 
                
        $socialCounters = 0;
        $socialCounters += (int)get_post_meta($post->ID, 'fblikecount_shares_count', true);
        $socialCounters += (int)get_post_meta($post->ID, 'fbsharecount_shares_count', true);
        $socialCounters += (int)get_post_meta($post->ID, 'twitter_shares_count', true);
        $socialCounters += (int)get_post_meta($post->ID, 'mail_post_type', true);
        
        $res .= '<countOfSocialShares>'. $socialCounters .'</countOfSocialShares>'; 
        
        wp_reset_postdata();
        
        return '<post isYoutube="0">' . $res . '</post>';
    }
    
    public static function getAuthorAvatarUrl($img)
    {
        $url = '';
        
        if(preg_match('/src="(?<img>[^"]+)"/i', $img, $matches))
        {
            $url = isset($matches['img']) ? $matches['img'] : '';
        }
        
        return $url;
    }
    
    public static function getXmlForCategories($categories = array())
    {
        $res = '';
        
        if(!empty($categories))
        {
            foreach($categories as $category)
                $res .= self::getXmlForSingleCategory($category);
        }
                
        return '<categories>' . $res . '</categories>';
    }
    
    private static function getXmlForSingleCategory($category = null)
    {
        if(empty($category)) return '';

        $res = '';
        
        $res .= '<name>' . $category->cat_name . '</name>';
        
        $res .= '<url>' . $category->slug . '</url>';
        
        $res .= '<postCount>' . $category->count . '</postCount>';
        
        if(property_exists ($category, 'postsResult') && is_array($category->postsResult))
                $res .= self::getXmlForPosts($category->postsResult);
        
        return '<category>' . $res . '</category>';
    }
}

class CoreController
{
    const PER_PAGE = 5;
    
    private $type = 'post';
    
    private $url = '';
    
    private $page = '';
    
    private $xmlRender = null;
    
    private $s = '';

    public function __construct()
    {
        $this->setVariables();
        
        if(!$this->isValid())
        {
            $this->forbidden();
            die();
        }
        
        $this->xmlRender = new xmlRender();
        
        $this->process();
    }
    
    private function setVariables()
    {
        $this->type = isset($_GET['type']) ? (string)$_GET['type'] : 'post';
        $this->url = isset($_GET['url']) ? (string)$_GET['url'] : '';
        $this->page = (int)abs(isset($_GET['page']) ? (int)$_GET['page'] : 1);
        $this->s = isset($_GET['s']) ? (string)$_GET['s'] : '';
    }
    
    public function isValid()
    {
        return (in_array($this->type, array('post', 'category', 'search', 'youtube')) && preg_match('/^[-;\w\d]*$/', $this->url));
    }
    
    private function process()
    {
        switch ($this->type) 
        {
            case 'post':
                
                $posts = $this->getPosts();

                $this->xmlRender->addXml(
                                xmlRender::getXmlForPosts($posts)
                            );
            break;
                
            case 'youtube':
                $youtubeVideos = $this->getYoutubeVideos();
                $this->xmlRender->addXml(
                                xmlRender::getXmlForPosts($youtubeVideos)
                            );
            break; 
                
            case 'category':
                
                $categories = array();
                
                if($this->url != '')
                {
                    $category = get_category_by_slug($this->url);          
                    
                    if($category)
                    {
                        $category->postsResult = $this->getPosts($category->term_id);
                        $categories = array($category);
                    }
                    
                }else{                
                    $categories = $this->getCategories();
                }
                
                $this->xmlRender->addXml(
                                xmlRender::getXmlForCategories($categories)
                            );
            break;
            
            case 'search':
               
                $posts = $this->getSearch();
                
                $this->xmlRender->addXml(
                                xmlRender::getXmlForPosts($posts)
                            );                
            break;

        
            default:
                $this->forbidden(); die();                
            break;
        }
    }
    
    public function render()
    {
        header('Content-Type: application/xml; charset=' . get_option('blog_charset'), true);  
        echo $this->xmlRender->getXml();
        die();
    }
    
    public function getSearch()
    {
        $query_args = array('s' => $this->s,  
                            'post_type'      => array('page', 'post', 'youtube-video'),
                            'post_status'    => 'publish',
                            'posts_per_page' => self::PER_PAGE,
                            'offset'         => (int)(($this->page - 1)*self::PER_PAGE));
        
        $query = new WP_Query( $query_args );

        return $query->get_posts();
    }
    
    public function getPosts($categoryId = 0)
    {
        $args = array(
            'post_type'      => array('post', 'youtube-video'),
            'post_status'    => 'publish',
            'posts_per_page' => self::PER_PAGE,
            'offset'           => (int)(($this->page - 1)*self::PER_PAGE),
        );
        
        $names = [];
        
        if($this->url != '' && !$categoryId){
            $names = array_unique(explode(';', $this->url));
        }

        if($categoryId)
        {
            $args['category'] =  $categoryId;
            unset($args['name']);
        }
        
        $result = [];
        
        if(!empty($names)){
            
            foreach($names as $name)
            {
                $args['name'] = $name;
                if(($post = (get_posts($args)))){
                    $result = array_merge($result, $post);
                }
            }

            return $result;
        }
        
        $result = get_posts($args);
        
        return $result;
    }
    
    public function getYoutubeVideos()
    {
        $args = array(
            'post_type'      => array('youtube-video'),
            'post_status'    => 'publish',
            'posts_per_page' => self::PER_PAGE,
            'offset'           => (int)(($this->page - 1)*self::PER_PAGE),
        );
        
        $result = get_posts($args);
        
        return $result;
    }
    
    public function getCategories()
    {
        $args = array(
                'type'                     => 'post',
                'child_of'                 => 0,
                'parent'                   => '',
                'orderby'                  => 'name',
                'order'                    => 'ASC',
                'hide_empty'               => 1,
                'hierarchical'             => 1,
                'exclude'                  => '',
                'include'                  => '75,76,204,205,206',
                'number'                   => '',
                'taxonomy'                 => 'category',
                'pad_counts'               => false 
        ); 
        
        $categories = get_categories($args);
        
        return $categories;
    }
    
    private function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die();
    }
}

$object = new CoreController();
$object->render();
die();

?>