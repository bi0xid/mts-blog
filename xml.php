<?php
/**
 * File for xml api.
 */
ini_set('display_errors', false);
error_reporting(0);

include('./wp-load.php');
        
class xmlRender
{
    private $xml = '';
    
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
    
    private static function getXmlForSinglePost($post = null)
    {
        if(!$post) return '';
        
        $res = '';        
        $res .= '<title>'. apply_filters('the_title' , $post->post_title ) .'</title>';
        $res .= '<publish_date>'. apply_filters('get_the_time' , $post->post_date ) .'</publish_date>';
        $res .= '<content>
			<![CDATA['. apply_filters('get_the_content' , $post->post_content ) .']]>
		</content>';

        $res .= '<link>'. get_permalink($post->ID)  .'</link>'; 
        
        $imagesTypes = array('thumbnail', 'medium', 'large', 'full');
        
        $imageContent = '';
        
        foreach($imagesTypes as $imageType)
        {
            $imgLink = '';
        
            $large_image_urls = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $imageType);

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
        
        foreach($attachments as $att_id => $attachment) 
        {
            $attachmentContent .= '<attachment>' . wp_get_attachment_url($attachment->ID) . '</attachment>';
        }
        
        $res .= '<images>'. 
                    $imageContent  . 
                    '<attachments>' 
                        . $attachmentContent . 
                    '</attachments>' .
                '</images>'; 
        
        $res .= '<author>'. get_the_author_meta('display_name', $post->post_author) .'</author>'; 
        
        $res .= '<authorUrl>'. get_the_author_meta('user_nicename' , $post->post_author) .'</authorUrl>'; 
        
        $res .= '<authorAvatar>'. get_the_author_meta('avatar' , $post->post_author) .'</authorAvatar>'; 
        
        $res .= '<url>'. $post->post_name .'</url>'; 
                
        return '<post>' . $res . '</post>';
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
    const PER_PAGE = 10;
    
    private $type = 'post';
    
    private $url = '';
    
    private $page = '';
    
    private $xmlRender = null;

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
    }
    
    public function isValid()
    {
        return (in_array($this->type, array('post', 'category')) && preg_match('/^[-\w\d]*$/', $this->url));
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