<?php
/**
 * The file contains a class to configure the metabox Basic Options.
 * 
 * Created via the Factory Metaboxes.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * The class to configure the metabox Basic Options.
 * 
 * @since 1.0.0
 */
class OnpSL_BasicOptionsMetaBox extends FactoryMetaboxes320_FormMetabox
{
    /**
     * A visible title of the metabox.
     * 
     * Inherited from the class FactoryMetabox.
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * 
     * @since 1.0.0
     * @var string
     */
    public $title;    
    
    
    /**
     * A prefix that will be used for names of input fields in the form.

     * Inherited from the class FactoryFormMetabox.
     * 
     * @since 1.0.0
     * @var string
     */
    public $scope = 'sociallocker';
    
    /**
     * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * Inherited from the class FactoryMetabox.
     * 
     * @since 1.0.0
     * @var string
     */
    public $priority = 'core';
	
    public $cssClass = 'factory-bootstrap-320 factory-fontawesome-320';

    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
        $this->title = __('Basic Options', 'sociallocker');
    }
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes320_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms320_Form $form A form object to configure.
     * @return void
     */
    public function form( $form ) {
        
        $form->add(array(  
            
            array(
                'type'      => 'textbox',
                'name'      => 'header',
                'title'     => __('Locker header', 'sociallocker'),
                'hint'      => __('Enter a header of the locker. You can leave this field empty.', 'sociallocker'),
                'default'   => __('This content is locked!', 'sociallocker')
            ),
            
            array(
                'type'      => 'wp-editor',
                'name'      => 'message',
                'title'     => __('Locker message', 'sociallocker'),
                'hint'      => __('Enter a message that appears under the header.', 'sociallocker').'<br /><br />'. 
                               __('Shortcodes: [post_title], [post_url].', 'sociallocker'),
                'default'   => __('Please support us, use one of the buttons below to unlock the content.', 'sociallocker'),
                'tinymce'   => array(
                    'setup' => 'function(ed){ window.onpsl.lockerEditor.bindWpEditorChange( ed ); }',
                    'height' => 100
                ),
                'layout'    => array(
                    'hint-position' => 'left'
                )
            ),
        ));
            require_once ONP_SL_PLUGIN_DIR . '/includes/classes/themes-manager.class.php';
            
            $form->add(array(  
                array(
                    'type'      => 'dropdown',
                    'name'      => 'style',
                    'data'      => OnpSL_ThemeManager::getThemes('dropdown'),
                    'title'     => __('Theme', 'sociallocker'),
                    'hint'      => __('Select one of predefined locker styles.', 'sociallocker'),
                    'default'   => 'secrets'
                )
            )); 
        
    
      
    }
}

FactoryMetaboxes320::register('OnpSL_BasicOptionsMetaBox', $sociallocker);