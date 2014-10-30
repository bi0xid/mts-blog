<?php

/*
	Plugin Name: SG Editor Permissions
	Description: This plugin change permissions of Editors. Allow Editors to add/edit user apart from administrator
	Author: Sergey Gorbach
	Version: 0.0.01
*/

//prevent editor from deleting, editing, or creating an administrator
// only needed if the editor was given right to edit users
 
class ISA_User_Caps {
 
  // Add our filters
  function ISA_User_Caps(){
    add_filter( 'editable_roles', array(&$this, 'editable_roles'));
    add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }
  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if(!current_user_can('administrator')){
      return (isset($roles['author'])) ? array('author' => $roles['author']) : array();      
    }
    
    return $roles;
  }
  // If someone is trying to edit or delete an
  // admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){
    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if(!$other->has_cap('author')){
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
            if(!$other->has_cap('author')){
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
 
function sg_deactivate(){
    $edit_editor = get_role('editor');
    $edit_editor->remove_cap('list_users');
    $edit_editor->remove_cap('create_users');
    $edit_editor->remove_cap('edit_users');
    
    if($edit_editor->has_cap('list_users') || $edit_editor->has_cap('create_users') || $edit_editor->has_cap('edit_users'))
        return false;
    return true;
}

function sg_editor_permissions_install(){
    $edit_editor = get_role('editor');
    $edit_editor->add_cap('list_users');
    $edit_editor->add_cap('create_users');
    $edit_editor->add_cap('edit_users');

    if($edit_editor->has_cap('list_users') && $edit_editor->has_cap('create_users') && $edit_editor->has_cap('edit_users'))
        return true;

    return false;
}

function sg_editor_permissions_uninstall(){
    return sg_deactivate();
}

function sg_editor_permissions_deactivation(){
    return sg_deactivate();
}

function sg_editor_permissions_admin_init(){
    add_action('pre_user_query','isa_pre_user_query');
    $ISA_User_Caps = new ISA_User_Caps();
}

function isa_pre_user_query($user_search) {    
  $user = wp_get_current_user();    
  if (!in_array('administrator', $user->roles)) { // Is not administrator, remove administrator
    global $wpdb;
    
    $user_search->query_where = str_replace('WHERE 1=1', 
        "WHERE 1=1 AND {$wpdb->users}.ID IN (
             SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}user_level' 
                AND {$wpdb->usermeta}.meta_value = 2)", 
        $user_search->query_where
    );
  }
}

register_activation_hook( __FILE__, 'sg_editor_permissions_install');
register_uninstall_hook(__FILE__, 'sg_editor_permissions_uninstall');
register_deactivation_hook(__FILE__, 'sg_editor_permissions_deactivation');
add_action('admin_init', 'sg_editor_permissions_admin_init');