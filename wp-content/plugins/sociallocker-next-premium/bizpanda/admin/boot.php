<?php

require OPANDA_BIZPANDA_DIR . '/admin/activation.php';
require OPANDA_BIZPANDA_DIR . '/admin/panda-items.php';
require OPANDA_BIZPANDA_DIR . '/admin/bulk-lock.php';


// ---
// Pages
//

#comp merge
require OPANDA_BIZPANDA_DIR . '/admin/pages/base.php';
require OPANDA_BIZPANDA_DIR . '/admin/pages/new-item.php';

if ( defined('OPTINPANDA_PLUGIN_ACTIVE') ) {  
    require OPANDA_BIZPANDA_DIR . '/admin/pages/leads.php';
}
    
require OPANDA_BIZPANDA_DIR . '/admin/pages/stats.php';    
require OPANDA_BIZPANDA_DIR . '/admin/pages/settings.php';    
require OPANDA_BIZPANDA_DIR . '/admin/pages/how-to-use.php'; 
#endcomp


// ---
// Ajax
//

// we include a handler only if the current actions points to a given handler

if ( isset( $_REQUEST['action'] ) ) {
    switch ( $_REQUEST['action'] ) {
        
        case 'onp_sl_preview':
            require OPANDA_BIZPANDA_DIR . '/admin/ajax/preview.php';  
            break;
        case 'opanda_connect':
        case 'opanda_get_subscrtiption_lists':
            require OPANDA_BIZPANDA_DIR . '/admin/ajax/proxy.php';
            break;      
        case 'opanda_loader':
            require OPANDA_BIZPANDA_DIR . '/admin/ajax/shortcode.php';
            break;
        case 'opanda_statistics':
            require OPANDA_BIZPANDA_DIR . '/admin/ajax/stats.php';
            break;
        case 'get_opanda_lockers':
            require OPANDA_BIZPANDA_DIR . '/admin/ajax/tinymce.php';
    }
}


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
function opanda_admin_assets( $hook ) {
    
    // prints the CSS for a menu item of the Business Panda
  
    ?>
    <style>
        #menu-posts-opanda-item div.wp-menu-image,
        #menu-posts-opanda-item:hover div.wp-menu-image,
        #menu-posts-opanda-item.wp-has-current-submenu div.wp-menu-image {
            background-position: 8px -30px !important;
        }
        #menu-posts-opanda-item .wp-menu-name .onp-sl-panda {
           font-weight: bold;
        }
    </style>
    <?php
}

add_action('admin_enqueue_scripts', 'opanda_admin_assets');


// ---
// Admin Menu
//

/**
 * Removes the default 'new item' from the admin menu to add own pgae 'new item' later.
 * 
 * @see menu_order
 * @since 1.0.0
 */
function opanda_remove_new_item( $menu ) {
    global $submenu;
    if ( !isset( $submenu['edit.php?post_type=' . OPANDA_POST_TYPE] ) ) return $menu;
    unset( $submenu['edit.php?post_type=' . OPANDA_POST_TYPE][10] );
    return $menu;
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'opanda_remove_new_item');


/**
 * If the user tried to get access to the default 'new item',
 * redirects forcibly to our page 'new item'.
 *  
 * @see current_screen
 * @since 1.0.0
 */
function opanda_redirect_to_new_item() {
    $screen = get_current_screen();
    
    if ( empty( $screen) ) return;
    if ( 'add' !== $screen->action || 'post' !== $screen->base || OPANDA_POST_TYPE !== $screen->post_type ) return;
    if ( isset( $_GET['opanda_item'] ) ) return;
    
    global $bizpanda;
    
    $url = admin_url('edit.php?post_type=' . OPANDA_POST_TYPE . '&page=new-item-' . $bizpanda->pluginName );
    wp_redirect( $url );
    
    exit;
}

add_action('current_screen', 'opanda_redirect_to_new_item');


// ---
// Editor
//

/**
 * Registers the BizPanda button for the TinyMCE
 * 
 * @see mce_buttons
 * @since 1.0.0
 */
function opanda_register_button($buttons) {  
    
    if ( !current_user_can('edit_' . OPANDA_POST_TYPE) ) return $buttons;
    array_push($buttons, "optinpanda");
    return $buttons;
}

add_filter('mce_buttons', 'opanda_register_button'); 


/**
 * Registers the BizPanda plugin for the TinyMCE 
 * 
 * @see mce_external_plugins
 * @since 1.0.0
 */
function opanda_add_plugin($plugin_array) {  
    
    if ( !current_user_can('edit_' . OPANDA_POST_TYPE) ) return $plugin_array;
    global $wp_version;

    if ( version_compare( $wp_version, '3.9', '<' ) ) {
        $plugin_array['optinpanda'] = OPANDA_BIZPANDA_URL . '/assets/admin/js/optinpanda.tinymce3.js';  
    } else {
        $plugin_array['optinpanda'] = OPANDA_BIZPANDA_URL . '/assets/admin/js/optinpanda.tinymce4.js';  
    }

    // styles for the plugin shorcodes
    $shortcodeIcon = BizPanda::getShortCodeIcon();
    $shortcodeTitle = strip_tags( BizPanda::getMenuTitle() );

    ?>
    <style>
        i.onp-sl-shortcode-icon {
            background: url("<?php echo $shortcodeIcon ?>");
        }
    </style>
    <script>
        var bizpanda_shortcode_title = '<?php echo $shortcodeTitle ?>';
    </script>
    <?php

    return $plugin_array;  
}

add_filter('mce_external_plugins', 'opanda_add_plugin'); 


// ---
// Key Events
//

/**
 * Calls when anyone subscribed.
 * Adds the subsriber to the table 'leads & emails' and collects some stats data.
 * 
 * @since 1.0.0
 * @return void
 */

/**
 * Calls always when we subscribe an user.
 */
function opanda_subscribe( $status, $identity, $context ) {
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/leads.php';
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/stats.php'; 
    
    if ( 'subscribed' == $status ) {
        
        // if the current service is 'database', 
        // then all emails should be added as unconfirmed
        
        $serviceName = BizPanda::getSubscriptionServiceName();
        $confirmed = $serviceName === 'database' ? false : true;
        
        OPanda_Leads::add( $identity, $context, $confirmed );
        
    } elseif ( 'pending' == $status ) {
        OPanda_Leads::add( $identity, $context, false );
    }
}

add_action('opanda_subscribe', 'opanda_subscribe', 10, 3);

/**
 * Calls always when we check the subscription status of the user.
 */
function opanda_check( $status, $identity, $context ) {
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/leads.php';
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/stats.php'; 
    
    if ( 'subscribed' == $status ) {
        OPanda_Leads::add( $identity, $context, true );
    }
}

add_action('opanda_check', 'opanda_check', 10, 3);

/**
 * Calls when a new user is registered.
 */
function opanda_registered( $identity, $context = array() ) {
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/stats.php'; 
    
    $itemId = isset( $context['itemId'] ) ? intval( $context['itemId'] ) : 0;
    $postId = isset( $context['postId'] ) ? intval( $context['postId'] ) : null;

    OPanda_Stats::countMetrict( $itemId, $postId, 'account-registered');
}
add_action('opanda_registered', 'opanda_registered', 10, 2 );

/**
 * Calls when a new user is followerd on Twitter.
 */
function opanda_got_twitter_follower( $context = array() ) {
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/stats.php'; 
    
    $itemId = isset( $context['itemId'] ) ? intval( $context['itemId'] ) : 0;
    $postId = isset( $context['postId'] ) ? intval( $context['postId'] ) : null;

    OPanda_Stats::countMetrict( $itemId, $postId, 'got-twitter-follower');
}

add_action('opanda_got_twitter_follower', 'opanda_got_twitter_follower');

/**
 * Calls when a new user places a tweet.
 */
function opanda_tweet_posted( $context = array() ) {
    require_once OPANDA_BIZPANDA_DIR . '/admin/includes/stats.php'; 
    
    $itemId = isset( $context['itemId'] ) ? intval( $context['itemId'] ) : 0;
    $postId = isset( $context['postId'] ) ? intval( $context['postId'] ) : null;

    OPanda_Stats::countMetrict( $itemId, $postId, 'tweet-posted');
}

add_action('opanda_tweet_posted', 'opanda_tweet_posted');


// ---
// View Table
//

// includes the view table only if the current page is the list of panda items
if ( isset( $_GET['post_type'] ) && 'opanda-item' === $_GET['post_type'] ) {
    
    function opanda_filter_panda_items_in_view_table() {
        global $wp_query;
        $wp_query->query_vars['meta_key'] = 'opanda_item';
        $wp_query->query_vars['meta_value'] = opanda_get_panda_item_ids();
    }
    add_action( 'pre_get_posts', 'opanda_filter_panda_items_in_view_table' );
    
    require OPANDA_BIZPANDA_DIR . '/admin/includes/viewtables/locker-viewtable.class.php';
}