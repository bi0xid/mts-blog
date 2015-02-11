<?php
/**
 * Factory Forms
 * 
 * Factory Forms is a Factory module that provides a declarative
 * way to build forms without any extra html or css markup.
 * 
 * Factory is an internal professional framework developed by OnePress Ltd
 * for own needs. Please don't use it to create your own independent plugins.
 * In future the one will be documentated and released for public.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package factory-forms 
 * @since 1.0.0
 */

// the module provides function for the admin area only
if ( !is_admin() ) return;

// checks if the module is already loaded in order to
// prevent loading the same version of the module twice.
if (defined('FACTORY_FORMS_327_LOADED')) return;
define('FACTORY_FORMS_327_LOADED', true);

// absolute path and URL to the files and resources of the module.
define('FACTORY_FORMS_327_DIR', dirname(__FILE__));
define('FACTORY_FORMS_327_URL', plugins_url(null,  __FILE__ ));

#comp merge
require(FACTORY_FORMS_327_DIR . '/includes/providers/value-provider.interface.php');
require(FACTORY_FORMS_327_DIR . '/includes/providers/meta-value-provider.class.php');
require(FACTORY_FORMS_327_DIR . '/includes/providers/options-value-provider.class.php');

require(FACTORY_FORMS_327_DIR. '/includes/form.class.php');
require(FACTORY_FORMS_327_DIR. '/helpers.php');
#endcomp

/**
 * We add this code into the hook because all these controls quite heavy. So in order to get better perfomance, 
 * we load the form controls only on pages where the forms are created.
 * 
 * @see the 'factory_forms_327_register_controls' hook
 * 
 * @since 3.0.7
 */
if (!function_exists('factory_forms_327_register_default_controls')) {
    
    function factory_forms_327_register_default_controls( $plugin ) {

        if ( $plugin && !isset( $plugin->forms) ) {
            throw new Exception("The module Factory Forms is not loaded for the plugin '{$plugin->pluginName}'."); 
        }
        
        require_once(FACTORY_FORMS_327_DIR. '/includes/html-builder.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/form-element.class.php');    
        require_once(FACTORY_FORMS_327_DIR. '/includes/control.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/complex-control.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/holder.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/control-holder.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/custom-element.class.php');
        require_once(FACTORY_FORMS_327_DIR. '/includes/form-layout.class.php');

        // registration of controls
        $plugin->forms->registerControls(array(
            array(
                'type'      => 'checkbox',
                'class'     => 'FactoryForms327_CheckboxControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/checkbox.php'
            ),
            array(
                'type'      => 'list',
                'class'     => 'FactoryForms327_ListControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/list.php'
            ),
            array(
                'type'      => 'dropdown',
                'class'     => 'FactoryForms327_DropdownControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/dropdown.php'
            ),
            array(
                'type'      => 'hidden',
                'class'     => 'FactoryForms327_HiddenControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/hidden.php'
            ), 
            array(
                'type'      => 'hidden',
                'class'     => 'FactoryForms327_HiddenControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/hidden.php'
            ), 
            array(
                'type'      => 'radio',
                'class'     => 'FactoryForms327_RadioControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/radio.php'
            ), 
            array(
                'type'      => 'textarea',
                'class'     => 'FactoryForms327_TextareaControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/textarea.php'
            ),  
            array(
                'type'      => 'textbox',
                'class'     => 'FactoryForms327_TextboxControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/textbox.php'
            ),
            array(
                'type'      => 'url',
                'class'     => 'FactoryForms327_UrlControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/url.php'
            ),
            array(
                'type'      => 'wp-editor',
                'class'     => 'FactoryForms327_WpEditorControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/wp-editor.php'
            ), 
            array(
                'type'      => 'color',
                'class'     => 'FactoryForms327_ColorControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/color.php'        
            ),
            array(
                'type'      => 'color-and-opacity',
                'class'     => 'FactoryForms327_ColorAndOpacityControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/color-and-opacity.php'        
            ),
            array(
                'type'      => 'gradient',
                'class'     => 'FactoryForms327_GradientControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/gradient.php'          
            ),
            array(
                'type'      => 'font',
                'class'     => 'FactoryForms327_FontControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/font.php'        
            ),
            array(
                'type'      => 'google-font',
                'class'     => 'FactoryForms327_GoogleFontControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/google-font.php'        
            ),
            array(
                'type'      => 'pattern',
                'class'     => 'FactoryForms327_PatternControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/pattern.php'        
            ),
            array(
                'type'      => 'integer',
                'class'     => 'FactoryForms327_IntegerControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/integer.php'        
            ),
            array(
                'type'      => 'control-group',
                'class'     => 'FactoryForms327_ControlGroupHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/control-group.php'       
            ), 
            array(
                'type'      => 'paddings-editor',
                'class'     => 'FactoryForms327_PaddingsEditorControl',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/paddings-editor.php'       
            ), 
        ));

        // registration of control holders
        $plugin->forms->registerHolders(array(
            array(
                'type'      => 'tab',
                'class'     => 'FactoryForms327_TabHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/tab.php'
            ),
            array(
                'type'      => 'tab-item',
                'class'     => 'FactoryForms327_TabItemHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/tab-item.php'
            ),
            array(
                'type'      => 'accordion',
                'class'     => 'FactoryForms327_AccordionHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/accordion.php'        
            ),    
            array(
                'type'      => 'accordion-item',
                'class'     => 'FactoryForms327_AccordionItemHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/accordion-item.php'        
            ),    
            array(
                'type'      => 'control-group',
                'class'     => 'FactoryForms327_ControlGroupHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/control-group.php'        
            ),    
            array(
                'type'      => 'control-group-item',
                'class'     => 'FactoryForms327_ControlGroupItem',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/control-group-item.php'        
            ),    
            array(
                'type'      => 'form-group',
                'class'     => 'FactoryForms327_FormGroupHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/form-group.php'
            ), 
            array(
                'type'      => 'more-link',
                'class'     => 'FactoryForms327_MoreLinkHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/more-link.php'
            ),
            array(
                'type'      => 'div',
                'class'     => 'FactoryForms327_DivHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/div.php'
            ), 
            array(
                'type'      => 'columns',
                'class'     => 'FactoryForms327_ColumnsHolder',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/holders/columns.php'
            )            
        ));

        // registration custom form elements
        $plugin->forms->registerCustomElements(array(
            array(
                'type'      => 'html',
                'class'     => 'FactoryForms327_Html',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/customs/html.php',
            ),
            array(
                'type'      => 'separator',
                'class'     => 'FactoryForms327_Separator',
                'include'   => FACTORY_FORMS_327_DIR. '/controls/customs/separator.php',
            ), 
        ));


        // registration of form layouts
        $plugin->forms->registerFormLayout( array(
            'name'      => 'bootstrap-2',
            'class'     => 'FactoryForms327_Bootstrap2FormLayout',
            'include'   => FACTORY_FORMS_327_DIR. '/layouts/bootstrap-2/bootstrap-2.php'
        ));  
        $plugin->forms->registerFormLayout( array(
            'name'      => 'bootstrap-3',
            'class'     => 'FactoryForms327_Bootstrap3FormLayout',
            'include'   => FACTORY_FORMS_327_DIR. '/layouts/bootstrap-3/bootstrap-3.php'
        ));  
    }

    add_action('factory_forms_327_register_controls', 'factory_forms_327_register_default_controls');
}