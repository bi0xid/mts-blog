<?php
/*
Plugin Name: No Login Author
Description: Add new author role without access to dashboard.
Author: Pavel Kavalenka
*/

class NoLoginAuthor
{
    public static function admin_init()
    {
        add_filter( 'editable_roles', array('NoLoginAuthor', 'editors_edit_users_filter_roles'));
        add_filter( 'map_meta_cap', array('NoLoginAuthor', 'map_meta_cap'),10,4);
        add_filter( 'hidden_meta_boxes', array('NoLoginAuthor', 'hidden_meta_boxes'));
        add_filter( 'views_users', array('NoLoginAuthor', 'views_users'));
        add_action( 'pre_get_users', array('NoLoginAuthor','pre_get_users'));
    }

    public static function pre_get_users($obj)
    {
        $user = wp_get_current_user();
        if ( in_array( 'editor', $user->roles ) ) {
            if (!$obj->query_vars['role']) {
                $obj->query_vars['role'] = 'nologin_author';
            }
        }
    }

    public function views_users($views)
    {
        $user = wp_get_current_user();
        if ( in_array( 'editor', $user->roles ) ) {
            foreach ($views as $k=>$v) {
                if (!in_array($k, array('all', 'nologin_author'))) {
                    unset($views[$k]);
                }
            }
        }

        return $views;
    }

    public static function hidden_meta_boxes($hidden)
    {
        $user = wp_get_current_user();
        if ( in_array( 'editor', $user->roles ) ) {
            $hidden = array_filter($hidden, function ($value) {
                return $value!=='authordiv';
            });
        }

        return $hidden;
    }

    public static function editors_edit_users_filter_roles( $roles ) {
        $user = wp_get_current_user();
        if ( in_array( 'editor', $user->roles ) ) {
            $tmp = array_keys( $roles );
            foreach ( $tmp as $r ) {
                if ( 'nologin_author' == $r ) continue;
                unset( $roles[$r] );
            }
        }

        return $roles;
    }

    public static function map_meta_cap( $caps, $cap, $user_id, $args ){

        switch( $cap ){
            case 'edit_user':
            case 'remove_user':
            case 'promote_user':
                if( isset($args[0]) && $args[0] == $user_id )
                    break;
                elseif( !isset($args[0]) )
                    $caps[] = 'do_not_allow';
                $other = new WP_User( absint($args[0]) );
                if( !$other->has_cap( 'nologin_author' ) ){
                    if(!current_user_can('administrator')){
                        $caps[] = 'do_not_allow';
                    }
                }
                break;
            case 'delete_user':
            case 'delete_users':
                if( !isset($args[0]) )
                    break;
                $other = new WP_User( absint($args[0]) );
                if( !$other->has_cap( 'nologin_author' ) ){
                    if(!current_user_can('administrator')){
                        $caps[] = 'do_not_allow';
                    }
                }
                break;
            default:
                break;
        }
        return $caps;
    }
}

function nologin_author_activate() {

    add_role(
        'nologin_author',
        __( 'No Login Author' ),
        array(
            'read'         => true,
            'edit_posts'   => true,
            'delete_posts' => false,
            'level_1'      => true
        )
    );

    foreach ( array( 'editor' ) as $r ) {
        $role = get_role( $r );
        if ( $role ) {
            $role->add_cap( 'create_users' );
            $role->add_cap( 'edit_users' );
            $role->add_cap( 'delete_users' );
            $role->add_cap( 'list_users' );
        }
    }
}
register_activation_hook( __FILE__, 'nologin_author_activate' );

function nologin_author_deactivate() {

    remove_role('nologin_author');

    foreach ( array( 'editor' ) as $r ) {
        $role = get_role( $r );
        if ( $role ) {
            $role->remove_cap( 'create_users' );
            $role->remove_cap( 'edit_users' );
            $role->remove_cap( 'delete_users' );
            $role->remove_cap( 'list_users' );
        }
    }
}
register_deactivation_hook( __FILE__, 'nologin_author_deactivate' );


function restrict_nologin_user_dashboard_access() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if ( is_admin() && ($user_role==='nologin_author') &&
        ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'restrict_nologin_user_dashboard_access' );

add_action('admin_init', array('NoLoginAuthor','admin_init'));