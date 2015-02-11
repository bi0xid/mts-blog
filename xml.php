<?php
/**
 * File for xml api.
 */

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
        $res = '<posts>';
        
        if(!empty($posts))
        {
            foreach($posts as $post)
                $res .= self::getXmlForSinglePost($post);
        }
        
        $res .= '</posts>';
        
        return $res;
    }
    
    private static function getXmlForSinglePost($post = null)
    {
        if(!$post) return '';

        $res = '<post>';        
        $res .= '<title>'. apply_filters('the_title' , $post->post_title ) .'</title>';
        $res .= '<publish_date>'. apply_filters('get_the_time' , $post->post_date ) .'</publish_date>';
        $res .= '<content>
			<![CDATA['. apply_filters('get_the_content' , $post->post_content ) .']]>
		</content>';
        $res .= '<link>'. get_permalink($post->ID)  .'</link>'; 
        
        $imgLink = '';
        
        $large_image_urls = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail');

        if(!empty($large_image_urls) && isset($large_image_urls[0]))
        {
            $imgLink = $large_image_urls[0];
        }
        $res .= '<thumbnail>'. $imgLink .'</thumbnail>'; 
        
        $res .= '<author>'. get_the_author_meta('display_name', $post->post_author) .'</author>'; 
        
        $res .= '<authorSlug>'. get_the_author_meta('user_nicename' , $post->post_author) .'</authorSlug>'; 
        
        $res .= '<authorAvatar>'. get_the_author_meta('avatar' , $post->post_author) .'</authorAvatar>'; 
        
        $res .= '<slug>'. $post->post_name .'</slug>'; 
        
        $res .= '</post>';
        
        return $res;
    }
}

class controller
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
        $this->page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
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
            'posts_per_page' => self::PER_PAGE
        );
        
        if($this->url != '')
            $args['name'] = $this->url;
        
        if($categoryId)
            $args['category'] =  $categoryId;
                
        $result = get_posts($args);
        
        return $result;
    }
    
    private function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die();
    }
}

$object = new controller();
$object->render();
die();

//header('Content-Type: application/xml; charset=' . get_option('blog_charset'), true);        
        
$categories = get_categories();




die('here');
?>
<<?php echo '?'; ?>xml version="1.0" encoding="<?php echo get_option('blog_charset'); ?>"?>
<root>
    <?php foreach($categories as $category): ?>
        <category>
            <name><?php echo $category->cat_name ?></name>
            <?php
                $args = array('offset'=> -1, 'category' =>  $category->term_id );
                $posts = get_posts(
                        array(
                            'posts_per_page' => -1,
                            'offset'=> -1, 
                            'category' =>  $category->term_id
                            )
                        );
            ?>
            
            <?php if(!empty($posts)): ?>
                <posts>
                    <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
                        <post>
                            <title><?php the_title(); ?></title>
                        </post>
                    <?php endforeach; ?>
                </posts>
            <?php endif; ?>
        </category>    
    <?php endforeach; ?>    
</root>
