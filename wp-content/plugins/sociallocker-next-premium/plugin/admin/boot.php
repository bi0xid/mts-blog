<?php
/**
 * A set of hooks for the admin part of the Social Locker plugin.
 * 
 * @author Paul Kashtanoff <pavelkashtanoff@gmail.com>
 * @copyright (c) 2014, OnePress
 * 
 * @since 4.0.0
 * @package sociallocker
 */

#comp merge
include(SOCIALLOCKER_DIR . '/plugin/admin/activation.php');
include(SOCIALLOCKER_DIR . '/plugin/admin/notices.php');
include(SOCIALLOCKER_DIR . '/plugin/admin/pages/license-manager.php');
#endcomp

// ---
// Assets
//

/**
 * Adds scripts and styles in the admin area.
 * 
 * @see the 'admin_enqueue_scripts' action
 * 
 * @since 1.0.0
 * @return void
 */
function sociallocker_icon_admin_assets( $hook ) { global $sociallocker;
if ( !in_array( $sociallocker->license->type, array( 'free' ) ) ) {
 return; 
}


    ?>
    <style>
        #toplevel_page_license-manager-sociallocker-next div.wp-menu-image,
        #toplevel_page_license-manager-sociallocker-next:hover div.wp-menu-image,
        #toplevel_page_license-manager-sociallocker-next.wp-has-current-submenu div.wp-menu-image {
            background-position: 8px -30px !important;
        }
    </style>
    <?php
}

add_action('admin_enqueue_scripts', 'sociallocker_icon_admin_assets');

// ---
// Help
//

/**
 * Registers a help section for the Connect Locker.
 * 
 * @since 1.0.0
 */
function sociallocker_register_help( $pages ) {
    global $opanda_help_cats;
    if ( !$opanda_help_cats ) $opanda_help_cats = array();
    
    array_unshift($pages, array(
        'name' => 'sociallocker',
        'title' => __('Plugin: Social Locker', 'optinpanda'),
        
        'items' => array(
            array(
                'name' => 'social-locker',
                'title' => __('Social Locker', 'optinpanda'),
                'hollow' => true,
                
                'items' => array(
                    array(
                        'name' => 'what-is-social-locker',
                        'title' => __('What is it?', 'optinpanda')
                    ), 
                    array(
                        'name' => 'usage-example-social-locker',
                        'title' => __('Quick Start Guide', 'optinpanda')
                    )
                    
                    /**
                    array(
                        'name' => 'other-notes-social-locker',
                        'title' => __('Other Notes', 'optinpanda')
                    )
                    */
                )
            ),
            array(
                'name' => 'signin-locker',
                'title' => __('Sign-In Locker', 'optinpanda'),
                'hollow' => true,
                
                'items' => array(
                    array(
                        'name' => 'what-is-signin-locker',
                        'title' => __('What is it?', 'optinpanda')
                    ),
                    array(
                        'name' => 'usage-example-signin-locker',
                        'title' => __('Quick Start Guide', 'optinpanda')
                    ),
                )
            )
        )
    ));

    return $pages;
}

add_filter('opanda_help_pages', 'sociallocker_register_help');


/**
 * Shows the intro page for the plugin Social Locker.
 * 
 * @since 1.0.0
 * @param FactoryPages321_AdminPage $manager
 * @return void
 */
function sociallocker_help_page_optinpanda( $manager ) {
    require SOCIALLOCKER_DIR . '/plugin/admin/pages/help/sociallocker.php';
}

add_action('opanda_help_page_sociallocker', 'sociallocker_help_page_optinpanda');


// ---
// Menu
//

/**
 * Changes the menu title if the Social Locker is an only plugin installed from BizPanda.
 * 
 * @since 1.0.0
 * @return string A new menu title.
 */
function sociallocker_change_menu_title( $title ) {
    if ( !BizPanda::isSinglePlugin() ) return $title;
    return __('Social Locker', 'opanda');
}

add_filter('opanda_menu_title', 'sociallocker_change_menu_title');


/**
 * Changes the menu icon if the Social Locker is an only plugin installed from BizPanda.
 * 
 * @since 1.0.0
 * @return string A new menu title.
 */
function sociallocker_change_menu_icon( $icon ) {
    if ( !BizPanda::isSinglePlugin() ) return $icon;
    return SOCIALLOCKER_URL . '/plugin/admin/assets/img/menu-icon.png';
}

add_filter('opanda_menu_icon', 'sociallocker_change_menu_icon');


/**
 * Changes the shortcode icon if the Social Locker is an only plugin installed from BizPanda.
 * 
 * @since 1.0.0
 * @return string A new menu title.
 */
function sociallocker_change_shortcode_icon( $icon ) {
    if ( !BizPanda::isSinglePlugin() ) return $icon;
    return SOCIALLOCKER_URL . '/plugin/admin/assets/img/shortcode-icon.png';
}

add_filter('opanda_shortcode_icon', 'sociallocker_change_shortcode_icon');

/**
 * Changes the menu title of the page 'New Item' if the Social Locker is an only plugin installed from BizPanda.
 * 
 * @since 1.0.0
 * @return string A new menu title.
 */
function sociallocker_change_new_item_menu_title( $title ) {
    if ( !BizPanda::isSinglePlugin() ) return $title;
    return __('+ New Locker', 'opanda');
}

add_filter('factory_menu_title_new-item-opanda', 'sociallocker_change_new_item_menu_title');


/**
 * Changes labels of Panda Items if the Social Locker is an only plugin installed from BizPanda.
 * 
 * @since 4.0.0
 * @return mixed A set of new labels
 */
function sociallocker_change_items_lables( $labels ) {
    if ( !BizPanda::isSinglePlugin() ) return $labels;
    $labels['all_items'] = __('All Lockers', 'opanda');
    $labels['add_new'] = __('+ New Locker', 'opanda');
    return $labels;
}

add_filter('opanda_items_lables', 'sociallocker_change_items_lables');


/**
 * Makes internal page "License Manager" for the Social Locker
 * 
 * @since 1.0.0
 * @return bool true
 */
function sociallocker_make_internal_license_manager( $internal ) {

    if ( BizPanda::isSinglePlugin() ) return $internal;
    return true;
}

add_filter('factory_page_is_internal_license-manager-sociallocker-next', 'sociallocker_make_internal_license_manager');


// ---
// Settings
//

function sociallocker_settings_screens( $screens ) {
    if ( !BizPanda::isSinglePlugin() ) return $screens;
    

    return $screens;
}

add_filter('opanda_settings_screens', 'sociallocker_settings_screens');