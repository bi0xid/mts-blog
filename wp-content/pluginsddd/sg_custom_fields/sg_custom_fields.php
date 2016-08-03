<?php

/*
	Plugin Name: SG Custom Fields
	Description: This plugin add additional field wherever you want:)
	Author: Sergey Gorbach
	Version: 0.0.01
*/

function sg_editor_permissions_install(){ return true; }
function sg_editor_permissions_uninstall(){ return true; }
register_activation_hook( __FILE__, 'sg_editor_permissions_install');
register_uninstall_hook(__FILE__, 'sg_editor_permissions_uninstall');

function addAdditionalCustomFieldToUserForm($oUser){   
    $affiliate_id_mts = get_user_meta($oUser->ID, 'affiliate_id_mts', true);
    if($affiliate_id_mts != '') $affiliate_id_mts = (int)$affiliate_id_mts;
    ?>
    <h3>Affiliate ID</h3>
    <table class="form-table">
        <tr>
            <th><label for="affiliate_id_mts">ID</label></th>
            <td>
                <input type="text" id="affiliate_id_mts" name="affiliate_id_mts" value="<?php echo $affiliate_id_mts; ?>" class="regular-text" size="16" />
                <br />
                <span class="description">Enter user's affiliate ID.</span>
            </td>
        </tr>
    </table>
<?php
}

function addAdditionalActionsDuringUpdateUserProfileInfo($user_id, $old_user_data){
    $affiliate_id_mts = (int)$_POST['affiliate_id_mts'];
    if(!$affiliate_id_mts) $affiliate_id_mts = '';
    update_user_meta($user_id, 'affiliate_id_mts', $affiliate_id_mts);    
}

add_action('edit_user_profile', 'addAdditionalCustomFieldToUserForm', 11, 1);
add_action('profile_update', 'addAdditionalActionsDuringUpdateUserProfileInfo', 10, 2);
