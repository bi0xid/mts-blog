<?php

class OPanda_SubscriptionServices {
    
    private static $_services = null;
    
    public static function getServices() {
        if ( !empty( self::$_services ) ) return self::$_services;
        
        $items = array(
            
            'none' => array(
                'title' => __('None', 'optinpanda'),
                'class' => 'OPanda_DatabaseSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/database/class.database.php',
            ),
            'mailchimp' => array(
                'title' => __('MailChimp', 'optinpanda'),
                'class' => 'OPanda_MailChimpSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/mailchimp/class.mailchimp.php',
            ),
            'aweber' => array(
                'title' => __('Aweber', 'optinpanda'),
                'class' => 'OPanda_AweberSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/aweber/class.aweber.php',
            ),
            'getresponse' => array(
                'title' => __('GetResponse', 'optinpanda'),
                'class' => 'OPanda_GetResponseSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/getresponse/class.getresponse.php',
            ),
            'mymail' => array(
                'title' => __('MyMail', 'optinpanda'),
                'class' => 'OPanda_MyMailSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/mymail/class.mymail.php',
            ),
            'mailpoet' => array(
                'title' => __('MailPoet', 'optinpanda'),
                'class' => 'OPanda_MailPoetSubscriptionService',
                'path' => OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/mailpoet/class.mailpoet.php',
            )
        );
        
        $items = apply_filters('opanda_subscription_services', $items);
        
        $services = array(); 
        require_once OPANDA_BIZPANDA_DIR . '/admin/includes/connect-handlers/handlers/subscription/libs/class.subscription.php';

        foreach( $items as $name => $item ) {
            require_once $item['path'];
            
            $item['name'] = $name;
            $services[$name] = new $item['class']( $item );
        }
        
        self::$_services = $services;
        return self::$_services;
    }
    
    public static function getService( $name = null, $init = false ) {
        
        $name = empty( $name ) ? get_option('opanda_subscription_service', 'none') : $name;
        $services = self::getServices( $name );
        
        if ( !isset( $services[$name] ) ) $name = 'none';
        $service = isset( $services[$name] ) ? $services[$name] : null;
        if ( empty( $service ) ) return null;
        
        if ( $init ) {
            $options = $service->getOptions();
            $options = apply_filters("opanda_subscription_service_options", $options);
            $options = apply_filters("opanda_{$name}_service_options", $options);
            $service->init( $options );
        }
        
        return $service;
    }
    
    public static function getOptInModes( $includes = array(), $toList = false ) {
        
        $modes = array(
            'double-optin' => array(
                'title' => __('Full Double Opt-In (recommended)', 'optinpanda'),
                'description' => __('After the user enters one\'s email address, sends the confirmation email (double opt-in) and waits until the user confirms the subscription. Then, unlocks the content.', 'optinpanda')
            ),
            'quick-double-optin' => array(
                'title' => __('Lazy Double Opt-In', 'optinpanda'),
                'description' => __('Unlocks the content immediately after the user enters one\'s email address but also sends the confirmation email (double opt-in) to confirm the subscription.', 'optinpanda')
            ),
            'quick' => array(
                'title' => __('Single Opt-In', 'optinpanda'),
                'description' => __('Unlocks the content immediately after the user enters one\'s email address. Doesn\'t send the confirmation email.', 'optinpanda')
            ),
        );
        
        if ( !is_array( $includes ) ) $includes = array( $includes );
        
        $result = array();
        foreach( $includes as $name ) {
            $result[$name] = $modes[$name];
        }

        if ( !$toList ) return $result;
            
        $finish = array();
        foreach( $result as $name => $mode ) {
            $finish[] = array( $name, $mode['title'], $mode['description'] );
        }
        
        return $finish;
    }
}