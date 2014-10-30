<?php

/*
	Plugin Name: SG Custom Text Widget Area
	Description: This plugin add new custom widget
	Author: Sergey Gorbach
	Version: 0.0.01
*/

class SG_Custom_TextWidget_Area
{
	private static $oInstance = null;
	
	public static function getInstance()
	{
		if(self::$oInstance === null)
		{
			self::$oInstance = new SG_Custom_TextWidget_Area();
		}
		
		return self::$oInstance;
	}
	
	public function install()
	{
		return true;
	}	
	
	public function uninstall()
	{
		return true;
	}
	
	public function init()
	{
		$oSGReactShare = self::getInstance();
		
		$oSGReactShare->_addActions();
		
		$oSGReactShare->_setJsAndCss();
	}
	
	private function _addActions()
	{
		return true;
	}
	
	private function _setJsAndCss()
	{
		return true;
	}
	
	public function admin_init()
	{
		
	}
}

class WP_Widget_TextCustom extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_text-custom', 'description' => __('Arbitrary text or HTML Custom.'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('text-custom', __('Custom Text Widget'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
<?php
	}
}

register_activation_hook( __FILE__, array('SG_Custom_TextWidget_Area', 'install'));
register_uninstall_hook(__FILE__, array('SG_Custom_TextWidget_Area', 'uninstall'));
add_action('init', array('SG_Custom_TextWidget_Area', 'init'));
add_action('admin_init', array('SG_Custom_TextWidget_Area', 'admin_init'));
add_action( 'widgets_init', function(){	register_widget( 'WP_Widget_TextCustom' ); });