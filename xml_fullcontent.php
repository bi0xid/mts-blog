<?php
/**
 * File for xml api.
 */
//ini_set('display_errors', false);
//error_reporting(0);

include('./wp-load.php');

class xmlRender
{
    private $xml = '';
    
    private static $dom = null;
    
    private static $counter = 0;
    
    public function __construct()
    {
        self::$dom = new domDocument;
        
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
            foreach($posts as $post)
                $res .= self::getXmlForSinglePost($post);
        }
        
        return '<posts>' . $res . '</posts>';
    }
    
    public static function getImageNameFromUrl($sUrl = '')
    {
        $imageName = '';
        
        if(preg_match('/\/(?<imageName>[^\/]+)$/', $sUrl, $m))
        {
            $imageName = $m['imageName'];
        }

        return $imageName;
    }
    
    private static function reformatPostContent($content = '')
    {
        $youtubeUlrs = array();
                
        //Replace all h[2-6] tag to h1 tag
        $paterns = array('/<h[2-6]+([^>]*)>/', '/<\/h[2-6]>/');
        $replacements = array('<h1$1>', '</h1>');
        $content = preg_replace($paterns, $replacements, $content);
        
        
        //Replace all iframes
        $pattern = '/<iframe(?P<content>[^>]*)>.*(<\/iframe>)?/i';      
        
        if(preg_match_all($pattern, $content, $youtubeMatches)){
            
            self::$counter = 0;

            $content = preg_replace_callback(
                $pattern,
                function ($matches) {
                    $c = ++self::$counter;
                    return "#|video_{$c}|#";
                },
                $content
            );
            
            foreach($youtubeMatches['content'] as $value){
                $src = '';
                if(preg_match('/src="(?P<video>[^"]+)"/', $value, $video)){
                    $src = $video['video'];
                }
                
                $youtubeUlrs[] = $src;
            }
        }
        
        $result = array(
            'content' => $content,
            'youtubeUlr' => $youtubeUlrs
        );
        
        return $result;
    }
    
    private static function getXmlForSinglePost($post = null)
    {
        if(!$post) return '';
        
        setup_postdata( $post );
                
        $res = '';        
        $res .= '<title>'. get_the_title($post) .'</title>';
        $res .= '<publish_date>'. apply_filters('get_the_time' , $post->post_date ) .'</publish_date>';
        
        $postContent = get_the_content();
        
        $customThumbnailName = '';

        if(preg_match('/^.*(?<img><img[^>]+>)/', $postContent, $tmpMatches))
        {
            if(preg_match('/src="(?<img1>[^"]+)"/i', $tmpMatches['img'], $tm))
            {
                $customThumbnailName = self::getImageNameFromUrl($tm['img1']);
            }
        }

        $reformatContent = self::reformatPostContent($postContent);
        
        $res .= '<content>
			<![CDATA['. $postContent .']]>
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
        
        if(isset($reformatContent['youtubeUlr']) && !empty($reformatContent['youtubeUlr'])){
            $c = 1;
            foreach($reformatContent['youtubeUlr'] as $url){
                $youtubeVideo .= "<url tagName='#|video_{$c}|#'>{$url}</url>";
                $c++;
            }
        }
        
        $res .= "<youtube>{$youtubeVideo}</youtube>";
        
        $imagesTypes = array('thumbnail', 'medium', 'large', 'full');
        
        $imageContent = '';
        
        $post_thumbnail_id = -1;
        
        foreach($imagesTypes as $imageType)
        {
            $imgLink = '';
        
            $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
            
            $large_image_urls = wp_get_attachment_image_src($post_thumbnail_id , $imageType);

            if(!empty($large_image_urls) && isset($large_image_urls[0]))
            {
                $imgLink = $large_image_urls[0];
            }
            $imageContent .= "<{$imageType}>{$imgLink}</{$imageType}>"; 
        }
        
        $attachmentContent = '';
        
        $attachments = get_children(array('post_parent' => $post->ID,
                        'post_status' => 'inherit',
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'order' => 'ASC',
                        'orderby' => 'menu_order ID'));
        
        $tmpAttachments = array();
        
        $isSet = false;
        
        foreach($attachments as $att_id => $attachment) 
        {
            $isConsideredAsThumbnail = 0;
            
            $large_image_urls = wp_get_attachment_image_src($attachment->ID, 'large');

            if(!empty($large_image_urls) && isset($large_image_urls[0]))
            {
                $imageName = self::getImageNameFromUrl($large_image_urls[0]);
                
                if($customThumbnailName && $imageName && $customThumbnailName == $imageName && !$isSet)
                {
                    $isConsideredAsThumbnail = 1;
                    $isSet = true;
                }
            
                $tmpAttachments[] = array(
                    'isConsideredAsThumbnail' => $isConsideredAsThumbnail,
                    'url' => $large_image_urls[0],
                    'isThumbnail' => ($attachment->ID == $post_thumbnail_id) ? 1 : 0
                );
            }
        }
        
        if(!$isSet && isset($tmpAttachments[0]))
        {
            $tmpAttachments[0]['isConsideredAsThumbnail'] = 1;
        }
        
        foreach($tmpAttachments as $tmpAttachment)
        {
            $attachmentContent .= '<attachment isThumbnail="' . $tmpAttachment['isThumbnail'] . '" isConsideredAsThumbnail="' . $tmpAttachment['isConsideredAsThumbnail'] . '">' . $tmpAttachment['url'] . '</attachment>';
        }
        
        $res .= '<images>'. 
                    $imageContent  . 
                    '<attachments>' 
                        . $attachmentContent . 
                    '</attachments>' .
                '</images>'; 
        
        $res .= '<author>'. get_the_author_meta('display_name', $post->post_author) .'</author>'; 
        
        $res .= '<authorUrl>'. get_the_author_meta('user_nicename' , $post->post_author) .'</authorUrl>'; 
        
        $res .= '<authorAvatar>'. self::getAuthorAvatarUrl(get_avatar($post->post_author, 100)) .'</authorAvatar>'; 
        
        $res .= '<url>'. $post->post_name .'</url>'; 
                
        wp_reset_postdata();
        
        return '<post>' . $res . '</post>';
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
        return (in_array($this->type, array('post', 'category', 'search')) && preg_match('/^[-\w\d]*$/', $this->url));
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
                            'post_type'      => 'any',
                            'post_status'    => 'publish',
                            'posts_per_page' => self::PER_PAGE,
                            'offset'         => (int)(($this->page - 1)*self::PER_PAGE));
        
        $query = new WP_Query( $query_args );

        return $query->get_posts();
    }
    
    public function getPosts($categoryId = 0)
    {
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => self::PER_PAGE,
            'offset'           => (int)(($this->page - 1)*self::PER_PAGE),
        );
        
        if($this->url != '')
            $args['name'] = $this->url;
        
        if($categoryId)
        {
            $args['category'] =  $categoryId;
            unset($args['name']);
        }
        
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