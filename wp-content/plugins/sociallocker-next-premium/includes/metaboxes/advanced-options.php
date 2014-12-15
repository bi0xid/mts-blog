<?php
/**
 * The file contains a class to configure the metabox Advanced Options.
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
 * The class to configure the metabox Advanced Options.
 * 
 * @since 1.0.0
 */
class OnpSL_AdvancedOptionsMetaBox extends FactoryMetaboxes320_FormMetabox
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
     * 
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
    
    /**
     * The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). 
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * Inherited from the class FactoryMetabox.
     * 
     * @since 1.0.0
     * @var string
     */
    public $context = 'side';
    
    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
        $this->title = __('Advanced Options', 'sociallocker');
    }
    
    public $cssClass = 'factory-bootstrap-325';
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes320_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms324_Form $form A form object to configure.
     * @return void
     */ 
    public function form( $form ) {
        
        
        $options = array(  
            
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'close',
                'title'     => __('Close Icon', 'sociallocker'),
                'hint'      => __('Shows the Close Icon at the corner.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/close-icon.png',
                'default'   => false
            ),
            
            array(
                'type'      => 'textbox',
                'name'      => 'timer',
                'title'     => __('Timer Interval', 'sociallocker'),
                'hint'      => __('Sets a countdown interval for the locker.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/timer-icon.png',
                'default'   => false
            ),
            
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'ajax',
                'title'     => __('AJAX', 'sociallocker'),
                'hint'      => __('If On, locked content will be cut from a page source code.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/ajax-icon.png',
                'default'   => false
            ),
            
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'highlight',
                'title'     => __('Highlight', 'sociallocker'),
                'hint'      => __('Defines whether the locker must use the Highlight effect.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/highlight-icon.png',
                'default'   => true
            )
        );  
        
        $options = apply_filters('onp_sl_advanced_options', $options);
        $form->add($options);
    }
}

FactoryMetaboxes320::register('OnpSL_AdvancedOptionsMetaBox', $sociallocker);
