<?php

/**
 * Returns all items.
 * 
 * @since 1.0.0
 * @return mixed[]
 */
function opanda_get_item_types() {
    $items = array();
    return apply_filters( 'opanda_items', $items );
}

/**
 * Returns the list of ids of registered panda items.
 * 
 * @since 1.0.0
 * @return string[]
 */
function opanda_get_panda_item_ids() {
    $items = apply_filters( 'opanda_items', array() ); 
    return array_keys( $items );
}

/**
 * Manages panda items.
 * 
 * @since 1.0.0
 */
function opanda_get_item_type( $name ) {
    $items = opanda_get_item_types();
    return isset( $items[$name] ) ? $items[$name] : null;
}

/**
 * Returns current editing or viewing item.
 * 
 * @since 1.0.0
 */
function opanda_get_current_item_type() {
    
    // trying to determin the type of the item

    // - from the query
    $item = isset( $_GET['opanda_item'] ) ? $_GET['opanda_item'] : null;

    // - from the form hidden field
    if ( empty( $item ) ) {
        $item = isset( $_POST['opanda_item'] ) ? $_POST['opanda_item'] : null;
    }

    // - from the port meta data
    if ( !empty( $_GET['post'] ) ) {
        $postId = intval( $_GET['post'] );
        $value = get_post_meta( $postId, 'opanda_item', true );
        if ( !empty( $value ) ) $item = $value;
    }

    if ( empty( $item ) ) return null;
    return opanda_get_item_type( $item ); 
}

/**
 * Registers default optins (lockers, popups, forms).
 * 
 * @since 1.0.0
 */
function opanda_add_meta_boxes() {
    global $bizpanda;
    
    $type = opanda_get_current_item_type();
    if ( empty( $type ) ) return;
    $typeName = $type['name'];
    
    $data = array();

        $data[] = array(
            'class' => 'OPanda_BasicOptionsMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/basic-options.php'
        );

        $data[] = array(
            'class' => 'OPanda_PreviewMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/preview.php'
        );

        $data[] = array(
            'class' => 'OPanda_ManualLockingMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/manual-locking.php'
        );

        $data[] = array(
            'class' => 'OPanda_BulkLockingMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/bulk-locking.php'
        );

        $data[] = array(
            'class' => 'OPanda_VisabilityOptionsMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/visability-options.php'
        );

        $data[] = array(
            'class' => 'OPanda_AdvancedOptionsMetaBox',
            'path' => OPANDA_BIZPANDA_DIR . '/includes/metaboxes/advanced-options.php'
        );

    


    $data = apply_filters( "opanda_item_type_metaboxes", $data, $typeName );
    $data = apply_filters( "opanda_{$typeName}_type_metaboxes", $data );
    
    foreach( $data as $metabox ) {
        require_once $metabox['path'];
        FactoryMetaboxes321::registerFor( new $metabox['class']( $bizpanda ), OPANDA_POST_TYPE, $bizpanda);
    }
}

add_action( 'init', 'opanda_add_meta_boxes' );


/**
 * Fetchs the Panda items from a remote server.
 * 
 * @since 1.0.0
 * @return mixed[] A set of exising items registered on the remote server.
 */
function opanda_fetch_panda_items( $itemName = null ) {
    
    $items = array();
    
    if ( !defined('OPTINPANDA_PLUGIN_ACTIVE') ) {
        
        $items[] = array(
            'name' => 'optinpanda',
            'title' => __('Opt-In Panda', 'bizpanda'),
            'description' => __('<p>A lead-generation plugin which helps to build large mailing lists.</p><p>Also extends the Sign-In Locker by adding the subscription features.</p>', 'opanda'),
            'url' => 'http://api.byonepress.com/public/1.0/get/?product=optinpanda',
            'pluginName' => 'optinpanda'
        );
        
    }
    
    if ( !defined('SOCIALLOCKER_PLUGIN_ACTIVE') ) {
        
        $items[] = array(
            'name' => 'sociallocker',
            'title' => __('Social Locker', 'bizpanda'),
            'description' => __('<p>Helps to attract social traffic and improve spreading your content in social networks.</p><p>Also extends the Sign-In Locker by adding social actions you can set up to be performed.</p>', 'opanda'),
            'url' => 'http://api.byonepress.com/public/1.0/get/?product=sociallocker-next',
            'pluginName' => 'sociallocker-next'
        );
        
    }
    
    if ( empty( $itemName ) ) return $items;
    
    foreach( $items as $item ) {
        if ( $itemName === $item['name'] ) return $item;
    }
    
    return null;
}