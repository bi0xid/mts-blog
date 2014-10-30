<?php
/**
 * Plugin Name: Advertising block
 * Description: Just add images from backend and display in front side
 * Version: 0.1
 * License: GPL2
 */

define('WSIGPATH',    plugin_dir_path(__FILE__));
define('WSIGURL',     plugins_url('', __FILE__));

register_deactivation_hook(__FILE__, 'wsig_deactivated');
register_activation_hook(__FILE__, 'wsig_activated');

function wsig_activated(){
    global $wpdb;
    $table_name = $wpdb->prefix . "advertising_block";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            image VARCHAR(500) NOT NULL,
            title VARCHAR(255) NOT NULL,
            created_at DATETIME ,
            modified_at DATETIME,
            UNIQUE KEY id (id)
            );";
        $wpdb->query($sql);
    }
}

function wsig_deactivated(){}

add_action('admin_menu', 'wsig_plugin_menu');

function wsig_plugin_menu(){
    add_menu_page("Advertising block", "Advertising block", "list_users", "advertising_block", "advertising_block", "", "87");
}

function advertising_block(){

    include(WSIGPATH.'/includes/crud.php');
}

add_action('admin_print_scripts', 'wsig_admin_scripts');
function wsig_admin_scripts(){
    wp_enqueue_media();
}


add_action('admin_print_styles', 'wsig_admin_styles');

function wsig_admin_styles(){
    wp_enqueue_style( 'wsig-admin.css', WSIGURL.'/css/wsig-admin.css' );
    wp_enqueue_script( 'validate.js', WSIGURL.'/js/validate.js');
}

add_action('wp_print_styles', 'wsig_print_styles');

function wsig_print_styles(){
    $myCssFile = WSIGURL . '/css/wsig.css';
    wp_register_style('wsig.css', $myCssFile);
    wp_enqueue_style( 'wsig.css');
}


add_action( 'wp_enqueue_scripts', 'wsig_print_scripts' );

function wsig_print_scripts(){
    wp_enqueue_style( 'prettyPhoto.css', WSIGURL.'/css/prettyPhoto.css' );
    wp_enqueue_style( 'wsig.css', WSIGURL.'/css/wsig.css' );
    wp_enqueue_script( 'fancybox-init.js', WSIGURL.'/js/preetyphoto-init.js');
    wp_enqueue_script( 'preetyPhoto.js', WSIGURL.'/js/jquery.prettyPhoto.js');

}

function wsig_get_gallery(){
    global $wpdb;
    $output = '';
    $table_name = $wpdb->prefix . "gallery";
    $results = $wpdb->get_results( "SELECT id, title,image FROM $table_name ORDER BY id DESC" );

    if(!empty($results) && count($results) > 0){
        $output.= '<div class="ws">';
        $output.= '<ul class="galleryImages">';
        foreach($results as $key=>$val){
            $image = wp_get_attachment_image( $val->image, 'thumb');
            $image_full = wp_get_attachment_image_src( $val->image, 'full');
            $output.= '<li>';
            $output.= '<a  rel="prettyPhoto[pp_gal]"  href="'.$image_full[0].'">';
            $output.= $image;
            $output.= '</a>';
            $output.= '</li>';
        }
        $output.= '</ul>';
        $output.= '</div>';
        return $output;
    }else{
        return 'No images yet';
    }
}

add_action("add_meta_boxes", "add_post_additional_area");

function add_post_additional_area($post)
{
    add_meta_box('se20892273_custom_meta_box', 'Advertising block', 'se20892273_custom_meta_box', 'post', 'normal', 'core');
}

function se20892273_custom_meta_box($post)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "advertising_block";
    $results = $wpdb->get_results( "SELECT id, title,image FROM $table_name ORDER BY id DESC" );
    
    $imageAdd = (int)get_post_meta($post->ID, 'addvertising_image', true);
    
    //$image = wp_get_attachment_image( $val->image, 'thumb');
    
    $sHtml = "<script type='text/javascript'>
                jQuery(document).ready(function(){
                    jQuery('#select_options').change(function(){
                        jQuery('.addver_images').hide();
                        var sSelector = '#image_add_id_' + parseInt(jQuery(this).val());
                        jQuery(sSelector).show();
                    });
                });
           </script>";
    
    $sImagesDiv = "";    
    $sSelect = "<select name='addver_id_image' id='select_options'>";
    $sSelect .= "<option value='-1' >Without add</option>";
    foreach($results as $value){
        $image = wp_get_attachment_image( $value->image, 'thumb');
        $sSelect .= "<option value='{$value->id}' ".(((int)$imageAdd == (int)$value->id) ? "selected" : "")." >{$value->title}</option>";
        $sImagesDiv .= "<div class='addver_images' id='image_add_id_{$value->id}' style='".(((int)$imageAdd == (int)$value->id) ? "display: block;" : "display: none;")."'>{$image}</div>";
    }
    $sSelect .= "</select>";
    echo $sSelect . $sImagesDiv . $sHtml;
}

add_shortcode( 'advertising_block', 'wsig_get_gallery' );

function advertising_block_save_meta_box_data( $post_id ){
    $iImagePost = (int)(isset($_POST['addver_id_image']) ? $_POST['addver_id_image'] : 0);
    $post_id = (int)$post_id;
    if(!update_post_meta($post_id, 'addvertising_image', $iImagePost))
            add_post_meta($post_id, 'addvertising_image', $iImagePost);
}


add_action( 'save_post', 'advertising_block_save_meta_box_data' );

function getAddvertithingForPost($id_post){
    $imageAdd = (int)get_post_meta($id_post, 'addvertising_image', true);
    if($imageAdd == -1) return false;    
    if(!$imageAdd) $imageAdd = (int)get_option('default_image_for_addvertising', 0); 
    
    global $wpdb;
    $table_name = $wpdb->prefix . "advertising_block";
    $res =  $wpdb->get_row("SELECT id,image,title, url FROM $table_name WHERE id={$imageAdd}");
    if(!$res) return false;
    
    $image = wp_get_attachment_image_src($res->image, 'full');
    $width = (int)$image[1]/2;
    $height = (int)$image[2]/2;
    return array('scr' => $image[0], 'width' => $width, 'height' => $height, 'title' => $res->title, 'url' => $res->url);
}