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
class OPanda_BasicOptionsMetaBox extends FactoryMetaboxes321_FormMetabox
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
    public $scope = 'opanda';
    
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
	
    public $cssClass = 'factory-bootstrap-328 factory-fontawesome-320';

    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
        $this->title = __('Basic Options', 'optinpanda');
    }
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes321_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms327_Form $form A form object to configure.
     * @return void
     */
    public function form( $form ) {
        $itemType = opanda_get_current_item_type();
        
        $form->add( 
                
            array(
                'type'  => 'hidden',
                'name'  => 'item',
                'default' => isset( $_GET['opanda_item'] ) ? $_GET['opanda_item'] : null
            )
        );
        
        $defaultHeader = __('This content is locked!', 'optinpanda');
        $defaultMessage = __('Please support us, use one of the buttons below to unlock the content.', 'optinpanda');
        
        switch ($itemType['name']) {
            
            case 'email-locker': 
                $defaultHeader = __('This Content Is Only For Subscribers', 'optinpanda');
                $defaultMessage = __('Please subscribe to unlock this content for free. Just enter your email to get instant access.', 'optinpanda');
                break;
            
            case 'connect-locker': 
                $defaultHeader = __('Sing In To Unlock This Content', 'optinpanda');
                $defaultMessage = __('Please sign in. It\'s free. Just click one of the buttons below to get instant access.', 'optinpanda');
                break;
        }
        
        
        $form->add(array(  
            
            array(
                'type'      => 'textbox',
                'name'      => 'header',
                'title'     => __('Locker header', 'optinpanda'),
                'hint'      => __('Type a header which attracts attention or calls to action. You can leave this field empty.', 'optinpanda'),
                'default'   => $defaultHeader
            ),
            
            array(
                'type'      => 'wp-editor',
                'name'      => 'message',
                'title'     => __('Locker message', 'optinpanda'),
                'hint'      => __('Type a message which will appear under the header.', 'optinpanda').'<br /><br />'. 
                               __('Shortcodes: [post_title], [post_url].', 'optinpanda'),
                'default'   => $defaultMessage,
                'tinymce'   => array(
                    'setup' => 'function(ed){ window.bizpanda.lockerEditor.bindWpEditorChange( ed ); }',
                    'height' => 100
                ),
                'layout'    => array(
                    'hint-position' => 'left'
                )
            ),
        ));
        
        if ( 'email-locker' === $itemType['name'] ) {
            
            $form->add( array(
                'type'      => 'columns',
                'items'   => array(
                    array(
                        'type'      => 'textbox',
                        'name'      => 'button_text',
                        'title'     => __('Buttton Text', 'optinpanda'),
                        'hint'      => __('The text on the button. Call to action!'),
                        'default'   => __('subscribe to unlock', 'optinpanda'),
                        'column'    => 1
                    ),
                    array(
                        'type'      => 'textbox',
                        'name'      => 'after_button',
                        'title'     => __('After Buttton', 'optinpanda'),
                        'hint'      => __('The text below the button. Guarantee something.'),
                        'default'   => __('Your email address is 100% safe from spam!', 'optinpanda'),
                        'column'    => 2
                    )  
                )
            ));
            
            $form->add( array(
                'type' => 'separator'
            ));
        }
            require_once OPANDA_BIZPANDA_DIR . '/includes/classes/themes-manager.class.php';
            $type = opanda_get_current_item_type();
         
            $form->add(array(  
                array(
                    'type'      => 'dropdown',
                    'name'      => 'style',
                    'data'      => OPanda_ThemeManager::getThemes($type['name'], 'dropdown'),
                    'title'     => __('Theme', 'optinpanda'),
                    'hint'      => __('Select the most suitable theme.', 'optinpanda'),
                    'default'   => 'secrets'
                )
            )); 
        

        
            $form->add(array(  
                array(
                    'type'      => 'dropdown',
                    'way'       => 'buttons',
                    'name'      => 'overlap',
                    'data'      => array(
                        array('full', '<i class="fa fa-lock"></i>'.__('Full (classic)', 'optinpanda')),
                        array('transparence', '<i class="fa fa-adjust"></i>'.__('Transparency', 'optinpanda') ),
                        array('blurring', '<i class="fa fa-bullseye"></i>'.__('Blurring', 'optinpanda'), __( 'Works in all browsers except IE 10-11 (In IE 10-10, the transparency mode will be applied)', 'optinpanda' ) )
                    ),
                    'title'     => __('Overlap Mode', 'optinpanda'),
                    'hint'      => __('Choose the way how your locker should lock the content.', 'optinpanda'),
                    'default'   => 'full'
                )
            )); 
        
        

        
        $form->add(array(  
            array(
                'type'      => 'dropdown',
                'name'      => 'overlap_position',
                'data'      => array(
                    array('top', __( 'Top Position', 'optinpanda' ) ),
                    array('middle', __( 'Middle Position', 'optinpanda' ) ),
                    array('scroll', __( 'Scrolling (N/A in Preview)', 'optinpanda' ) )
                ),
                'title'     => '',
                'hint'      => '',
                'default'   => 'middle'
            )
        )); 
    }
    
    /**
     * Replaces the 'blurring' overlap with 'transparence' in the free version.
     * 
     * @since 1.0.0
     * @param type $postId
     */
    public function onSavingForm( $postId ) {
    }
}

global $bizpanda;
FactoryMetaboxes321::register('OPanda_BasicOptionsMetaBox', $bizpanda);
