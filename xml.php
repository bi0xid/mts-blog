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
            foreach($posts as $post)
                $res .= self::getXmlForSinglePost($post);
        }
        
        return '<posts>' . $res . '</posts>';
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
        
        $tags = "<h1></h1><blockquote></blockquote><p></p><strong></strong><em></em><br><br/><img><a></a>";
        
        $result = array(
            'content' => strip_tags($content, $tags),
            'youtubeUlr' => $youtubeUlrs
        );
        
        return $result;
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
    
    private static function getXmlForSinglePost($post = null)
    {
        if(!$post) return '';
        
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

        $reformatContent = self::reformatPostContent($postContent);
        
        $res .= '<content>
			<![CDATA['. $reformatContent['content'] .']]>
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
        
        $attachmentContent = '';
        
        $attachments = get_children(array('post_parent' => $post->ID,
                        'post_status' => 'inherit',
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'order' => 'ASC',
                        'orderby' => 'menu_order ID'));
        
        global $wpdb;
        
        $imageObject = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE guid Like '%$customThumbnailName'");
        
        $image = self::getAllSizeOfAttachmentsById($imageObject->ID);
        
        $attachmentsTypes = '';
        
        foreach(self::$imagesTypes as $type)
        {
            $src = isset($image[$type]) ? $image[$type] : '';
            $attachmentsTypes .= "<{$type}>{$src}</{$type}>";
        }
        
        $res .= "<image>{$attachmentsTypes}</image>"; 
        
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