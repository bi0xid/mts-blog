<?php 
/**
Plugin Name: Social Locker | BizPanda
Plugin URI: http://codecanyon.net/item/social-locker-for-wordpress/3667715?ref=OnePress&utm_source=plugin&utm_medium=plugin-uri&utm_campaign=plugin-uri
Description: Social Locker is a set of social buttons and a locker in one bottle. <strong>Give people a reason</strong> why they need to click your social buttons. Ask people to “pay” with a Like/Tweet/+1 to get access to your content, to get discount, to download, to watch a video, to view a funny picture or so. And it will help you to get more likes/tweets/+1s, traffic and customers!
Author: OnePress
Version: 4.0.8
Author URI: http://byoneress.com
*/

// ---
// Constatns & Resources
//

if (defined('SOCIALLOCKER_PLUGIN_ACTIVE')) return;
define('SOCIALLOCKER_PLUGIN_ACTIVE', true);



define('SOCIALLOCKER_DIR', dirname(__FILE__));
define('SOCIALLOCKER_URL', plugins_url( null, __FILE__ ));




// ---
// BizPanda Framework
//

// inits bizpanda and its items
require( SOCIALLOCKER_DIR . '/bizpanda/boot.php');

BizPanda::enableFeature('lockers');
BizPanda::enableFeature('terms');
        
// ---
// Social Locker
//

// creating the plugin object

global $sociallocker;
$sociallocker = new Factory325_Plugin(__FILE__, array(
    'name'          => 'sociallocker-next',
    'title'         => 'Social Locker',
    'version'       => '4.0.8',
    'assembly'      => 'premium',
    'lang'          => 'en_US',
    'api'           => 'http://api.byonepress.com/1.1/',
    'premium'       => 'http://api.byonepress.com/public/1.0/get/?product=sociallocker-next',
    'styleroller'   => 'http://api.byonepress.com/public/1.0/get/?product=sociallocker-next',
    'account'       => 'http://accounts.byonepress.com/',
    'updates'       => SOCIALLOCKER_DIR . '/plugin/updates/',
    'tracker'       => /*@var:tracker*/'0ec2f14c9e007ba464c230b3ddd98384'/*@*/,
    'childPlugins'  => array( 'bizpanda' )
));

BizPanda::registerPlugin($sociallocker, 'sociallocker');

// requires factory modules
$sociallocker->load(array(
    array( 'bizpanda/libs/factory/bootstrap', 'factory_bootstrap_328', 'admin' ),
    array( 'bizpanda/libs/factory/notices', 'factory_notices_322', 'admin' ),
    array( 'bizpanda/libs/onepress/api', 'onp_api_320' ),
    array( 'bizpanda/libs/onepress/licensing', 'onp_licensing_325' ),
    array( 'bizpanda/libs/onepress/updates', 'onp_updates_324' )
));

require(SOCIALLOCKER_DIR . '/panda-items/signin-locker/boot.php');
require(SOCIALLOCKER_DIR . '/panda-items/social-locker/boot.php');
require(SOCIALLOCKER_DIR . '/plugin/boot.php');
