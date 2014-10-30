<?php

/*
	Plugin Name: SG User Login Registration
	Description: This plugin allow only user login/registration with certain email
	Author: Sergey Gorbach
	Version: 0.0.01
*/

define('DB_USER_CUSTOM', 'mytiuser');
define('DB_PASS_CUSTOM', 'Q2w3e4r5t');
define('DB_HOST_CUSTOM', '10.30.200.51');
define('DB_NAME_CUSTOM', 'mytinyse_pres518');

//define('DB_USER_CUSTOM', 'sgorbach');
//define('DB_PASS_CUSTOM', 'fm0a4fefiouIKUJBLde4');
//define('DB_HOST_CUSTOM', 'localhost');
//define('DB_NAME_CUSTOM', 'sgorbach_mytinysecretsshop1');









function sg_editor_permissions_install(){
        return true;
}

function sg_editor_permissions_uninstall(){
    return true;
}

register_activation_hook( __FILE__, 'sg_editor_permissions_install');
register_uninstall_hook(__FILE__, 'sg_editor_permissions_uninstall');

function checkIfUserExistsInPrestaDbByEmail($sEmail = ''){
    $aEmails = array('ritamenere@gmail.com');
    if(in_array($sEmail, $aEmails)) return true;
    if(is_email($sEmail)){
        $oDbh = new PDO('mysql:host=' . DB_HOST_CUSTOM . ';dbname=' . DB_NAME_CUSTOM, DB_USER_CUSTOM, DB_PASS_CUSTOM);
        $aResult = (int)$oDbh->query("SELECT count(*) as lim FROM `ps_customer` c WHERE c.`email` = {$oDbh->quote($sEmail)} LIMIT 1")->fetchColumn();
        $oDbh = null; 
        unset($oDbh);
        
        if($aResult) return true;
    }
    
    return false;
}

add_filter('authenticate', 'checkIfUserExistDuringLogin', 20, 3);
add_filter('registration_errors', 'checkIfUserExistDuringRegistration', 1, 3);

function checkIfUserExistDuringLogin($user, $username, $password)
{
    $sEmail = '';
    if(is_a($user, 'WP_User')){
        $sEmail = $user->user_email;
    }
    if(is_email($sEmail)){
        if (!checkIfUserExistsInPrestaDbByEmail($sEmail))
        {
            return new WP_Error('fail_custom', __("<strong>ERROR:</strong> Sorry Beautiful, at the moment only people are allowed in that bought something from the <a href='http://mytinysecrets.com/shop/' target='_blank'>MyTinySecrets Shop</a>.", "spike"));
        }
    }
    return $user;
}

function checkIfUserExistDuringRegistration($errors, $sanitized_user_login, $user_email){
    if(is_email($user_email)){
        if(!checkIfUserExistsInPrestaDbByEmail($user_email)){
            $errors->add('fail_custom', __("<strong>ERROR:</strong> Sorry Beautiful, at the moment only people are allowed in that bought something from the <a href='http://mytinysecrets.com/shop/' target='_blank'>MyTinySecrets Shop</a>.", "spike"), null);
        }
    }
    return $errors;
}
