<?php

if ( defined('BIZPANDA_SIGNIN_LOCKER_ACTIVE') ) return;
define('BIZPANDA_SIGNIN_LOCKER_ACTIVE', true);

define('BIZPANDA_SIGNIN_LOCKER_DIR', dirname(__FILE__));
define('BIZPANDA_SIGNIN_LOCKER_URL', plugins_url( null, __FILE__ ));

if ( is_admin() ) require BIZPANDA_SIGNIN_LOCKER_DIR . '/admin/boot.php';

if ( !function_exists('opanda_register_signin_locker') ) {

    global $bizpanda;
    
    /**
     * Registers the Sign-In Locker item.
     * 
     * @since 1.0.0
     */
    function opanda_register_signin_locker( $items ) {

        $items['signin-locker'] = array(
            'name' => 'signin-locker',
            'title' => __('Sign-In Locker', 'optinpanda'),
            'help' => opanda_get_help_url('what-is-signin-locker'),
            'description' => __('<p>Locks the content until the user sign in through social networks.</p><p>You can set up various social actions to be performed to sign in (e.g. subscribe, follow, share).</p>', 'optinpanda'),
            'shortcode' => 'signinlocker'
        );

        return $items;
    }
    add_filter('opanda_items', 'opanda_register_signin_locker', 2);
    
    /**
     * Adds options to print at the frontend.
     * 
     * @since 1.0.0
     */
    function opanda_signin_locker_options( $options, $id ) {

        $actions = explode( ',', opanda_get_item_option($id, 'connect_buttons') );
        $hasEmailForm = in_array( 'email', $actions );

        if ( $hasEmailForm ) {
            $emailFormIndex = array_search ('email', $actions);
            unset( $actions[$emailFormIndex] );  
        }

        $options['groups'] = $hasEmailForm
            ? array('connect-buttons', 'subscription')
            : array('connect-buttons');

        // connect buttons

        $options['connectButtons'] = array();
        $options['connectButtons']['order'] = $actions;


        $options['connectButtons']['facebook'] = array(
            'appId' => opanda_get_option('facebook_appid'),
            'actions'=> explode( ',', opanda_get_item_option($id, 'facebook_actions') )
        );

        $options['connectButtons']['twitter'] = array(
            'actions' => explode( ',', opanda_get_item_option($id, 'twitter_actions') ),
            'follow' => array(
                'user' => opanda_get_item_option($id, 'twitter_follow_user'),
                'notifications' => opanda_get_item_option($id, 'twitter_follow_notifications'),
            ),
            'tweet'=> array(
                'message' => opanda_get_item_option($id, 'twitter_tweet_message')
            )
        ); 

        $options['connectButtons']['google'] = array(
            'clientId' => opanda_get_option('google_client_id'),
            'actions' => explode( ',', opanda_get_item_option($id, 'google_actions') ),

            'youtubeSubscribe' => array(
                'channelId' => opanda_get_item_option($id, 'google_youtube_channel_id')
            )
        );

        $options['connectButtons']['linkedin'] = array(
            'actions' => explode( ',', opanda_get_item_option($id, 'linkedin_actions') ),
            'apiKey' => opanda_get_option('linkedin_api_key'),

            'follow' => array(
                'company' => opanda_get_item_option($id, 'linkedin_follow_company')
            )
        );

        // subscription options

        if ( $hasEmailForm ) { 
            $options['subscription'] = array();
            $options['subscription']['text'] = opanda_get_item_option($id, 'subscribe_before_form', false);
            $options['subscription']['form'] = array(
                'buttonText' => opanda_get_item_option($id, 'subscribe_button_text', false),
                'noSpamText' => opanda_get_item_option($id, 'subscribe_after_button', false)      
            );
        }

        $optinMode = opanda_get_item_option($id, 'subscribe_mode');

        $service = opanda_get_option('subscription_service', 'database');
        $listId = ( 'database' === $service ) ? 'default' : opanda_get_item_option($id, 'subscribe_list', false);

        $options['subscribeActionOptions'] = array(
            'listId' => $listId,
            'service' => $service,
            'doubleOptin' => in_array( $optinMode, array('quick-double-optin', 'double-optin') ),
            'confirm' => in_array( $optinMode, array('double-optin') ),
            'requireName' => opanda_get_item_option($id, 'subscribe_name')
        );

        return $options;
    }

    add_filter('opanda_signin-locker_item_options', 'opanda_signin_locker_options', 10, 2);


    /**
     * A shortcode for the Sign-In Locker
     * 
     * @since 1.0.0
     */
    class OPanda_SignInLockerShortcode extends OPanda_LockerShortcode {

        /**
         * Shortcode name
         * @var string
         */
        public $shortcodeName = array( 
            'signinlocker', 'signinlocker-1', 'signinlocker-2', 'signinlocker-bulk'
        );

        protected function getDefaultId() {
            return get_option('opanda_default_signin_locker_id');
        }
    }

    FactoryShortcodes320::register( 'OPanda_SignInLockerShortcode', $bizpanda );
}