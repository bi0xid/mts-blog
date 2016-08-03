<?php

/**
 * The base class of the BizPanda Framework.
 * 
 * @since 1.0.0
 */
class BizPanda {
    
    /**
     * Stores the number of the plugins using the BizPanda Framework.
     * 
     * @since 1.0.0
     * @var int 
     */
    protected static $pluginCount = 1;

    /**
     * Returns the number of plugins using the BizPanda Framework.
     * 
     * @since 1.0.0
     * @var int 
     */
    public static function getPluginCount() {
        return self::$pluginCount;
    }
    
    /**
     * Increases the value in the var $pluginCount by 1.
     * Calls when a plugin tries to create another BizPanda instance. 
     * 
     * @since 1.0.0
     * @var void 
     */
    public static function countCallerPlugin() {
        self::$pluginCount++;
    }
    
    /**
     * Returns true if only one plugin is usigin the  Framework.
     * 
     * @since 1.0.0
     * @var bool 
     */
    public static function isSinglePlugin() {
        return self::$pluginCount === 1;
    }
    
    protected static $_features = array();
    
    public static function hasFeature( $featureName ) {
        return isset( self::$_features[$featureName] ) && self::$_features[$featureName];
    }
    
    public static function enableFeature( $featureName ) {
        self::$_features[$featureName] = true;
    }
    
    public static function disableFeature( $featureName ) {
        self::$_features[$featureName] = true;
    } 
    
    
    protected static $_plugins = array();
    
    public static function hasPlugin( $name ) {
        return isset( self::$_plugins[$name] );
    }
    
    public static function registerPlugin( $plugin, $name = null ) {
        $pluginName = empty( $name ) ? $plugin->pluginName : $name;
        self::$_plugins[$pluginName] = $plugin;
    }  

    public static function hasDefaultMenuIcon() {
        $default = OPANDA_BIZPANDA_URL . '/assets/admin/img/menu-icon.png';
        $current = self::getMenuIcon();
        return $default == $current;        
    }
    
    public static function getMenuIcon() {
        $default = OPANDA_BIZPANDA_URL . '/assets/admin/img/menu-icon.png';
        return apply_filters('opanda_menu_icon', $default );
    }
    
    public static function getShortCodeIcon() {
        $default = OPANDA_BIZPANDA_URL . '/assets/admin/img/opanda-shortcode-icon.png';
        return apply_filters('opanda_shortcode_icon', $default );
    }
    
    public static function getMenuTitle() {
        $menuTitle = __('Biz<span class="onp-sl-panda">Panda</span>', 'opanda');
        return apply_filters('opanda_menu_title', $menuTitle );      
    }
    
    public static function getSubscriptionServiceName() {
        return get_option('opanda_subscription_service', 'database'); 
    }
}

/**
 * Returns an URL of the admin page of Business Panda.
 * 
 * @since 1.0.0
 * 
 * @param string $page A page id (for example, how-to-use).
 * @param array $args Extra query args.
 * @return string
 */
function opanda_get_admin_url( $page = 'how-to-use', $args = array() ) {
    $baseUrl = admin_url('edit.php?post_type=' . OPANDA_POST_TYPE);
    
    $args['page'] = $page . '-bizpanda';
    return add_query_arg( $args, $baseUrl );
}

function opanda_get_help_url( $page = null ) {
    return opanda_get_admin_url( 'how-to-use', array('onp_sl_page' => $page) );
}

function opanda_get_subscribers_url() {
    return opanda_get_admin_url('leads');
}

function opanda_get_settings_url( $screen ) {
    return opanda_get_admin_url( 'settings', array('opanda_screen' => $screen) ); 
}

function opanda_proxy_url() {
    $url = admin_url('admin-ajax.php');
    return add_query_arg(array(
        'action' => 'opanda_connect'
    ), $url);
}

function opanda_terms_url() {
    $terms = get_option('opanda_terms_of_use', null);
    if ( empty( $terms ) ) return;
    
    return get_permalink( $terms );
}

function opanda_privacy_policy_url() {
    $terms = get_option('opanda_privacy_policy', null);
    if ( empty( $terms ) ) return;
    
    return get_permalink( $terms );
}

function opanda_get_item_type_by_id( $id ) {
    return get_post_meta( $id, 'opanda_item', true );
}



/**
 * Returns the global option for the panda item.
 * 
 * @since 1.0.0
 */
function opanda_get_option( $id, $default = null ) {
    return get_option( 'opanda_' . $id, $default ) ;
}

/**
 * Returns the option for a given panda item.
 * 
 * @since 1.0.0
 */
function opanda_get_item_option( $id, $name, $isArray = false, $default = null ) {
    $options = opanda_get_item_options( $id );
    $value = isset( $options['opanda_' . $name] ) ? $options['opanda_' . $name] : null;

    return ($value === null || $value === '')
        ? $default 
        : ( $isArray ? maybe_unserialize($value) : stripslashes( $value ) ); 
}

/**
 * Cache for the locker options.
 */
global $opanda_item_options;
$opanda_item_options = array();

/**
 * Returns all the options for a given panda item.
 * 
 * @since 1.0.0
 */
function opanda_get_item_options( $id ) {
    global $opanda_item_options;
    if ( isset( $opanda_item_options[$id] ) ) return $opanda_item_options[$id];
    
    $options = get_post_meta($id, '');

    $real = array();
    foreach($options as $key => $values) {
        if ( !strpos($key, '__arr') ) $real[$key] = $values[0];
        else $real[$key] = $values;
    }

    $opanda_item_options[$id] = $real;
    return $real;
}

/**
 * Returns the connect handler options.
 * 
 * @since 1.0.0
 */
function opanda_get_handler_options( $handlerName ) {
    
    switch ( $handlerName ) {
        case 'twitter':
            
            $consumerKey = 'Fr5DrCse2hsNp5odQdJOexOOA';
            $consumerSecret = 'jzNmDGYPZOGV10x2HmN8tYMDqnMTowycXFu4xTTLbw3VBVeFKm';
            
            $optDefaultKeys = get_option('opanda_twitter_use_dev_keys', 'default');
            if ( 'default' !== $optDefaultKeys ) {
                $consumerKey = get_option('opanda_twitter_consumer_key');
                $consumerSecret = get_option('opanda_twitter_consumer_secret');        
            }
            
            return array(
                'consumer_key' => $consumerKey,
                'consumer_secret' => $consumerSecret,
                'proxy' => opanda_proxy_url()
            );

        case 'subscription':
            
            return array(
                'service' => get_option('opanda_subscription_service', 'database')
            );
            
        case 'signup':
            
            return array(
                'mode' => get_option('opanda_signup_mode', 'hidden')
            );
    }
}

/**
 * Normilize the values after receving them via ajax.
 * 
 * @since 1.0.0
 */
function opanda_normilize_values( $values = array() ) {
    if ( empty( $values) ) return $values;
    if ( !is_array( $values ) ) $values = array( $values );

    foreach ( $values as $index => $value ) {

        $values[$index] = is_array( $value )
                    ? opanda_normilize_values( $value ) 
                    : opanda_normilize_value( $value );
    }

    return $values;
}

/**
 * Normilize the value after receving them via ajax.
 * 
 * @since 1.0.0
 */
function opanda_normilize_value( $value = null ) {
    if ( 'false' === $value ) $value = false;
    elseif ( 'true' === $value ) $value = true;
    elseif ( 'null' === $value ) $value = null;
    return $value;
}

