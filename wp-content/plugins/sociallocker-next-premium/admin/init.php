<?php
// actiovation
include_once(ONP_SL_PLUGIN_DIR . '/admin/activation.php');

// metaboxes
include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/basic-options.php');
include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/preview.php');
include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/manual-locking.php');
include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/bulk-locking.php');
    include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/visability-options.php');
    include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/advanced-options.php');
    include_once(ONP_SL_PLUGIN_DIR . '/includes/metaboxes/social-options.php');



// view tables
include_once(ONP_SL_PLUGIN_DIR . '/includes/viewtables/locker-viewtable.class.php');

// pages and ajax calls
include_once(ONP_SL_PLUGIN_DIR . '/admin/pages/common-settings.php');
include_once(ONP_SL_PLUGIN_DIR . '/admin/pages/statistics.php');
include_once(ONP_SL_PLUGIN_DIR . '/admin/pages/preview.php');
include_once(ONP_SL_PLUGIN_DIR . '/admin/pages/how-to-use.php');
    include_once(ONP_SL_PLUGIN_DIR . '/admin/pages/license-manager.php');



include_once(ONP_SL_PLUGIN_DIR . '/admin/ajax/tracking.php');
include_once(ONP_SL_PLUGIN_DIR . '/admin/ajax/shortcode.php'); global $sociallocker;
if ( in_array( $sociallocker->license->type, array( 'paid','trial' ) ) ) {


            /**
             * Adds the "Add-ons" menu item.
             * 
             * @since 3.4.6
             */
            function sociallocker_addon_menu(){
                add_submenu_page(
                  'edit.php?post_type=social-locker',
                   __('&equiv; Add-Ons', 'sociallocker'), 
                   __('&equiv; Add-Ons', 'sociallocker'),
                   'manage_options', 
                   'sociallocker-addons', 
                   'sociallocker_show_page_for_addons'); 
            }
            add_action('admin_menu', 'sociallocker_addon_menu');
            
            /**
             * Shows a page with the offer to visit the add-on page.
             * 
             * @since 3.4.6
             */
            function sociallocker_show_page_for_addons() {
                global $sociallocker;
                $url = $sociallocker->options['addons'];
                ?>
                <div style="padding-top: 20px;">
                    <?php echo sprintf( __('Please visit: <a href="%s">%s</a>'), $url, $url ) ?>
                </div>
                <?php
            }
            
            /**
             * Shows a page with the offer to visit the add-on page.
             * 
             * @since 3.4.6
             */
            function sociallocker_addons_redirect() {
                $page = isset( $_GET['page'] ) ? $_GET['page'] : null;
                if ( $page !== 'sociallocker-addons' ) return;
                
                global $sociallocker;
                wp_redirect( $sociallocker->options['addons'] );
                exit;
            }
            add_action('admin_init', 'sociallocker_addons_redirect');
        
}

    




/**
 * Adds scripts and styles in the admin area.
 * 
 * @see the 'admin_enqueue_scripts' action
 * 
 * @since 1.0.0
 * @return void
 */
function sociallocker_admin_assets( $hook ) {

    // sytles for the plugin notices
    if ( $hook == 'index.php' || $hook == 'plugins.php' || $hook == 'edit.php' )
        wp_enqueue_style( 'onp-sl-notices', ONP_SL_PLUGIN_URL . '/assets/admin/css/notices.030100.css' ); 
    
    // styles for the plugin shorcodes
    if ( in_array( $hook, array('edit.php', 'post.php', 'post-new.php')) ) {
        ?>
        <style>
            i.onp-sl-shortcode-icon {
                background: url("<?php echo ONP_SL_PLUGIN_URL ?>/assets/admin/img/shortcode-icon.png");
            }
        </style>
        <?php
    }
}
add_action('admin_enqueue_scripts', 'sociallocker_admin_assets'); global $sociallocker;
if ( in_array( $sociallocker->license->type, array( 'free' ) ) ) {

        return;
    
}




add_filter('mce_external_plugins', 'sociallocker_add_plugin'); 
add_filter('mce_buttons', 'sociallocker_register_button'); 

function sociallocker_register_button($buttons) {  
    if ( !current_user_can('edit_social-locker') ) return $buttons;
    array_push($buttons, "sociallocker");
    return $buttons;
}  

function sociallocker_add_plugin($plugin_array) {  
    if ( !current_user_can('edit_social-locker') ) return $plugin_array;
    global $wp_version;

    if ( version_compare( $wp_version, '3.9', '<' ) ) {
        $plugin_array['sociallocker'] = ONP_SL_PLUGIN_URL . '/assets/admin/js/sociallocker.tinymce3.js';  
    } else {
        $plugin_array['sociallocker'] = ONP_SL_PLUGIN_URL . '/assets/admin/js/sociallocker.tinymce4.js';  
    }

    return $plugin_array;  
}

    
add_action('wp_ajax_get_sociallocker_lockers', 'sociallocker_get_lockers');
function sociallocker_get_lockers() {

    $lockers = get_posts(array('post_type' => 'social-locker'));

    $result = array();
    foreach($lockers as $locker)
    {
        $result[] = array(
            'title' => empty( $locker->post_title ) ? 'No title [' . $locker->ID . ']' : $locker->post_title,
            'id' => $locker->ID,
            'defaultType' => get_post_meta( $locker->ID, 'sociallocker_is_default', true )
        );
    }

    echo json_encode($result);
    die();
}

add_action('admin_print_footer_scripts',  'sociallocker_quicktags');
function sociallocker_quicktags()
{ ?>
    <script type="text/javascript">
        (function(){
            if (!window.QTags) return;
            window.QTags.addButton( 'sociallocker', 'sociallocker', '[sociallocker]', '[/sociallocker]' );
        }());
    </script>
<?php 
}

/**
 * Returns an URL where we should redirect a user after success activation of the plugin.
 * 
 * @since 3.1.0
 * @return string
 */
function onp_sl_license_manager_success_button() {
    return 'Learn how to use the plugin <i class="fa fa-lightbulb-o"></i>';
}
add_action('onp_license_manager_success_button_sociallocker-next', 'onp_sl_license_manager_success_button');

/**
 * Returns an URL where we should redirect a user after success activation of the plugin.
 * 
 * @since 3.1.0
 * @return string
 */
function onp_sl_license_manager_success_redirect() {
    global $sociallocker;
    
    $args = array(
        'post_type' => 'social-locker',
        'page' => 'how-to-use-' . $sociallocker->pluginName
    );

    return admin_url( 'edit.php?' . http_build_query( $args ) );
}
add_action('onp_license_manager_success_redirect_sociallocker-next',  'onp_sl_license_manager_success_redirect');

/**
 * Registers default themes.
 * 
 * We don't need to include the file containing the file OnpSL_ThemeManager because this function will
 * be called from the hook defined inside the class OnpSL_ThemeManager.
 * 
 * @see onp_sl_register_themes
 * @see OnpSL_ThemeManager
 * 
 * @since 3.3.3
 * @return void 
 */
function onp_sl_register_default_themes() {

        OnpSL_ThemeManager::registerTheme(array(
            'name' => 'starter',
            'title' => 'Starter (default)',
            'path' => ONP_SL_PLUGIN_DIR . '/themes/starter'
        ));

        OnpSL_ThemeManager::registerTheme(array(
            'name' => 'secrets',
            'title' => 'Secrets',
            'path' => ONP_SL_PLUGIN_DIR . '/themes/secrets'
        )); 

        OnpSL_ThemeManager::registerTheme(array(
            'name' => 'dandyish',
            'title' => 'Dandyish',
            'path' => ONP_SL_PLUGIN_DIR . '/themes/dandyish'
        )); 

        OnpSL_ThemeManager::registerTheme(array(
            'name' => 'glass',
            'title' => 'Glass',
            'path' => ONP_SL_PLUGIN_DIR . '/themes/glass'
        ));

        OnpSL_ThemeManager::registerTheme(array(
            'name' => 'flat',
            'title' => 'Flat',
            'path' => ONP_SL_PLUGIN_DIR . '/themes/flat'
        ));
         
    

}
add_action('onp_sl_register_themes', 'onp_sl_register_default_themes');
    
    /**
     * Shows offers to purhcase the StyleRoller from time to time.
     * 
     * @since 3.5.0
     */
    function sociallocker_styleroller_notices( $notices ) {
        if ( defined('ONP_SL_STYLER_PLUGIN_ACTIVE') ) return $notices;

        // show messages only for administrators
        if ( !factory_320_is_administrator() ) return $notices; global $sociallocker;
if ( in_array( $sociallocker->license->type, array( 'free','trial' ) ) ) {

            return $notices;
        
}

        
        global $sociallocker;
        $closed = get_option('factory_notices_closed', array());

        // leans when the premium versio was activated
        $premiumActivated = isset( $sociallocker->license->data['Activated'] )
            ? $sociallocker->license->data['Activated'] // for new users
            : 0;                                        // for old users

        $isNewUser = ( $premiumActivated !== 0 );
        $secondsInDay = 60*60*24;
        
        $inSeconds = time() - $premiumActivated;
        $inDays = $inSeconds / $secondsInDay;
             
        $forceToShow = defined('ONP_DEBUG_SHOW_STYLEROLLER_MESSAGE') && ONP_DEBUG_SHOW_STYLEROLLER_MESSAGE;

        // offers a discount for new users who purchased the Social Locker a day ago
        if ( ( $isNewUser && $inDays >= 1 && $inDays <= 3 && !isset( $closed['sociallocker-styleroller-after-a-day'] ) )
              || $forceToShow ) {
            
            $premiumActivated = $premiumActivated + 24 * 60 * 60;
            $expiresIn = ceil( ( 3 - $inDays ) * 24 );
            
            $notices[] = array(
                'id'        => 'sociallocker-styleroller-after-a-day',

                // content and color
                'class'     => 'call-to-action sociallocker-styleroller-banner',
                'header'    => '<span class="onp-hightlight">' . __('You\'ve got a discount! Get StyleRoller For $10 Off Now!', 'sociallocker') . '</span>' . sprintf( __('(Expires In %sh)', 'sociallocker'), $expiresIn ),
                'message'   => __('It\'s a day since you activated the premium versoin of Social Locker. We offer you, as for a new user, a discount for the StyleRoller, a powerful add-on for creating your own attention-grabbing themes for Social Locker. Improve conversions of your lockers by up to 300%!', 'sociallocker'),   
                'plugin'    => $sociallocker->pluginName,
                'where'     => array('plugins','dashboard', 'edit'),
                
                // buttons and links
                'buttons'   => array(
                    array(
                        'class'     => 'btn btn-primary',
                        'title'     => 'Get StyleRoller For $10 Off',
                        'action'    => 'http://sociallocker.org/styleroller-special' . '?' . http_build_query(array(
                            'onp_special' => md5( $premiumActivated ) . $premiumActivated,
                            'onp_target' => base64_encode( get_site_url() ),
                            'utm_source' => 'plugin',
                            'utm_medium' => 'styleroller-banner',
                            'utm_campaign' => 'after-a-day'
                        ))
                    ),
                    array(
                        'title'     => __('Hide this message', 'onepress-ru'),
                        'class'     => 'btn btn-default',
                        'action'    => 'x'
                    )
                )
            );
        }
        
        // offers a discount for new users who purchased the Social Locker a week ago
        if ( ( $isNewUser && $inDays >= 7 && $inDays <= 9 && !isset( $closed['sociallocker-styleroller-after-a-week'] ) ) || $forceToShow ) {
            
            $premiumActivated = $premiumActivated + 7 * 24 * 60 * 60;
            $expiresIn = ceil( ( 9 - $inDays ) * 24 );
                        
            $notices[] = array(
                'id'        => 'sociallocker-styleroller-after-a-week',

                // content and color
                'class'     => 'call-to-action sociallocker-styleroller-banner',
                'icon'      => 'fa fa-frown-o',  
                'header'    => '<span class="onp-hightlight">' . __('Last Chance To Get StyleRoller For $10 Off!', 'sociallocker') . '</span>' . sprintf( __('(Expires In %sh)', 'sociallocker'), $expiresIn ),
                'message'   => __('We have noticed you have been using the Social Locker already more than a week. Did you know what via the StyleRoller, an add-on for creating own attention-grabbing themes, you can improve conversions of your lockers by up to 300%? Learn how, click the button below.', 'sociallocker'),   
                'plugin'    => $sociallocker->pluginName,
                'where'     => array('plugins','dashboard', 'edit'),
                
                // buttons and links
                'buttons'   => array(
                    array(
                        'class'     => 'btn btn-primary',
                        'title'     => 'Get StyleRoller For $10 Off',
                        'action'    => 'http://sociallocker.org/styleroller-special' . '?' . http_build_query(array(
                            'onp_special' => md5( $premiumActivated ) . $premiumActivated,
                            'onp_target' => base64_encode( get_site_url() ),
                            'utm_source' => 'plugin',
                            'utm_medium' => 'styleroller-banner',
                            'utm_campaign' => 'after-a-week'
                        ))
                    ),
                    array(
                        'title'     => __('Hide this message', 'onepress-ru'),
                        'class'     => 'btn btn-default',
                        'action'    => 'x'
                    )
                )
            );
        }
        
        // this banner only for old users
        if ( ( !$isNewUser ) || $forceToShow ) {

            $firstShowTime = get_option('onp_sl_styleroller_firt_time', false);
            if ( !$firstShowTime ) { 
                $firstShowTime = time();
                update_option( 'onp_sl_styleroller_firt_time', time() );
            }

            $inSeconds = time() - $firstShowTime;
            $inDays = $inSeconds / $secondsInDay;
            
            // this offer is available only 2 days
            if ( ( $inDays <= 2 && !isset( $closed['sociallocker-styleroller-new-addon'] ) ) || $forceToShow ) {
                
                $expiresIn = ceil( ( 2 - $inDays ) * 24 );
            
                $notices[] = array(
                    'id'        => 'sociallocker-styleroller-new-addon',

                    // content and color
                    'class'     => 'call-to-action sociallocker-styleroller-banner',
                    'icon'      => 'fa fa-frown-o',  
                    'header'    => '<span class="onp-hightlight">' . __('You\'ve got a discount! Get StyleRoller For $10 Off Now!', 'sociallocker') . '</span>' . sprintf( __('(Expires In %sh)', 'sociallocker'), $expiresIn ),
                    'message'   => __('Hi there! Have you checked our new add-on which improves conversions of Social Locker by up to 300%? It\'s called "StyleRoller" and allows to create your own attention-grabbing themes for your lockers. Click the button to learn more and get the discount.', 'sociallocker'),   
                    'plugin'    => $sociallocker->pluginName,
                    'where'     => array('plugins','dashboard', 'edit'),
                    
                    // buttons and links
                    'buttons'   => array(
                        array(
                            'class'     => 'btn btn-primary',
                            'title'     => 'Get StyleRoller For $10 Off',
                        'action'    => 'http://sociallocker.org/styleroller-special' . '?' . http_build_query(array(
                                'onp_special' => md5( $firstShowTime ) . $firstShowTime,
                                'onp_target' => base64_encode( get_site_url() ),
                                'utm_source' => 'plugin',
                                'utm_medium' => 'styleroller-banner',
                                'utm_campaign' => 'new-addon'
                            ))
                        ),
                        array(
                            'title'     => __('Hide this message', 'onepress-ru'),
                            'class'     => 'btn btn-default',
                            'action'    => 'x'
                        )
                    )
                ); 
            }

            // this offer apperas after a week withing a day
            if ( ( $inDays >= 7 && $inDays <= 9 && !isset( $closed['sociallocker-styleroller-new-addon-after-a-week'] ) ) || $forceToShow ) {
            
                $firstShowTime = $firstShowTime + 7 * 24 * 60 * 60;
                $expiresIn = ceil( ( 9 - $inDays ) * 24 );
            
                $notices[] = array(
                        'id'        => 'sociallocker-styleroller-new-addon-after-a-week',

                    // content and color
                    'class'     => 'call-to-action sociallocker-styleroller-banner',
                    'icon'      => 'fa fa-frown-o',  
                    'header'    => '<span class="onp-hightlight">' . __('Last Chance To Get StyleRoller For $10 Off!', 'sociallocker') . '</span>' . sprintf( __('(Expires In %sh)', 'sociallocker'), $expiresIn ),
                    'message'   => __('Did you know what via the StyleRoller, an add-on for creating own attention-grabbing themes for Social Locker, you can improve conversions of your lockers by up to 300%? Click the button to learn more and get the discount.', 'sociallocker'),   
                    'plugin'    => $sociallocker->pluginName,
                    'where'     => array('plugins','dashboard', 'edit'),

                    // buttons and links
                    'buttons'   => array(
                        array(
                            'class'     => 'btn btn-primary',
                            'title'     => 'Get StyleRoller For $10 Off',
                            'action'    => 'http://sociallocker.org/styleroller-special' . '?' . http_build_query(array(
                                    'onp_special' => md5( $firstShowTime ) . $firstShowTime,
                                    'onp_target' => base64_encode( get_site_url() ),
                                    'utm_source' => 'plugin',
                                    'utm_medium' => 'styleroller-banner',
                                    'utm_campaign' => 'new-addon-after-a-week'
                            ))
                        ),
                        array(
                            'title'     => __('Hide this message', 'onepress-ru'),
                            'class'     => 'btn btn-default',
                            'action'    => 'x'
                        )
                    )
                );
            }
        }
        
        return $notices;
    }
    
    global $sociallocker;
    add_filter('factory_notices_' . $sociallocker->pluginName, 'sociallocker_styleroller_notices');



