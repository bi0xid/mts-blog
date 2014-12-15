<?php
/**
 * The file contains a class to configure the metabox Social Options.
 * 
 * Created via the Factory Metaboxes.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * The class configure the metabox Social Options.
 * 
 * @since 1.0.0
 */
class OnpSL_SocialOptionsMetaBox extends FactoryMetaboxes320_FormMetabox
{
    /**
     * A visible title of the metabox.
     * 
     * Inherited from the class FactoryMetabox.
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * 
     * @since 1.0.0
     * @var string
     */
    public $title;    
   
    /**
     * A prefix that will be used for names of input fields in the form.
     * 
     * Inherited from the class FactoryFormMetabox.
     * 
     * @since 1.0.0
     * @var string
     */
    public $scope = 'sociallocker';
    
    /**
     * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * Inherited from the class FactoryMetabox.
     * 
     * @since 1.0.0
     * @var string
     */
    public $priority = 'core';
	
    public $cssClass = 'factory-bootstrap-325';
    
    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
       $this->title = __('Social Options', 'sociallocker');
    }
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes320_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms324_Form $form A form object to configure.
     * @return void
     */ 
    public function form( $form ) {

        $tabs =  array(
            'type'      => 'tab',
            'align'     => 'vertical',
            'class'     => 'social-settings-tab',
            'items'     => array()
        );
            $facebookIsActiveByDefault = true;
            $twitterActiveByDefault = true;
            $googleIsActiveByDefault = true;
            $vkIsActiveByDefault = false; 
        


        // - Facebook Like Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'facebook-like',
            'items'     => array(

                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'facebook-like_available',
                    'default' => $facebookIsActiveByDefault
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to like', 'sociallocker'),
                    'hint'  => __('Set an URL (a facebook page or website page) which the user has to like in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'facebook_like_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'facebook_like_title',
                    'default' => __('like', 'sociallocker')
                ),  
                
                array(
                    'type'      => 'more-link',
                    'name'      => 'like-button-options',
                    'title'     => __('Show more options', 'sociallocker'),
                    'count'     => 1,
                    'items'     => array(
                        
                        array(
                            'type'  => 'checkbox',
                            'way'   => 'buttons',
                            'title' => __( 'I see the "confirm" link after a like', 'sociallocker' ),
                            'hint'  => __( '<p style="margin-top: 8px;">Optional. Facebook has an automatic Like-spam protection that happens if the Like button gets clicked a lot (for example, while testing the plugin). Don\'t worry, it will go away automatically within some hours/days.</p><p>Just during the time, when Facebook asks to confirm likes on your website, turn on this option and the locker will wait the confirmation to unlock the content.</p>', 'sociallocker' ),
                            'name'  => 'facebook_like_confirm_issue',
                            'default' => false
                        )
                   )
                )
            )
        );
        
        
        
        // - Twitter Tweet Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'title'     => '',
            'name'      => 'twitter-tweet',
            'items'     => array(

                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'twitter-tweet_available',
                    'default' => $twitterActiveByDefault
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to tweet', 'sociallocker'),
                    'hint'  => __('Set an URL which the user has to tweet in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'twitter_tweet_url'
                ),
                array(
                    'type'  => 'textarea',
                    'title' => __('Tweet', 'sociallocker'),
                    'hint'  => __('Type a message to tweet. Leave this field empty to use default tweet (page title + URL). Also you can use the shortcode [post_title] in order to insert automatically a post title into the tweet.', 'sociallocker'),
                    'name'  => 'twitter_tweet_text'
                ), 
                array(
                    'type'  => 'url',
                    'title' => __('Counter URL', 'sociallocker'),
                    'hint'  => __('Optional. If you use a shorter tweet URL, paste here a full URL for the counter.', 'sociallocker'),
                    'name'  => 'twitter_tweet_counturl'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Via', 'sociallocker'),
                    'hint'  => __('Optional. Screen name of the user to attribute the Tweet to (without @).', 'sociallocker'),
                    'name'  => 'twitter_tweet_via'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'twitter_tweet_title',
                    'default' => __('tweet', 'sociallocker')
                ),
                
            )
        );
        
        // - Google Plus Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'google-plus',
            'items'     => array(

                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'google-plus_available',
                    'default' => $googleIsActiveByDefault
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to +1', 'sociallocker'),
                    'hint'  => __('Set an URL which the user has to +1 in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'google_plus_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'google_plus_title',
                    'default' => __('+1 us', 'sociallocker')
                ) 
            )
        );
        
        // - Facebook Share Tab
        
        // if the user has not updated the facebook app id, show a notice
        $facebookAppId = get_option('sociallocker_facebook_appid', '117100935120196' );
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'facebook-share',
            'items'     => array(
                array(
                    'off' =>   !empty($facebookAppId) && $facebookAppId !== '117100935120196',
                    'type'  => 'html',
                    'html'  => '<div class="alert alert-warning">'.
                                sprintf( __('Please make sure that you <a href="%s">set a facebook app id</a> for your domain, otherwise the button will not work. The Facebook Share button requires an app id registered for a domain where it\'s used.', 'sociallocker'), admin_url( 'edit.php?post_type=social-locker&page=common-settings-' . $this->plugin->pluginName ) )
                                .'</div>'
                ),
                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'facebook-share_available',
                    'default' => false
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'sociallocker'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'facebook_share_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'facebook_share_title',
                    'default' => __('share', 'sociallocker')
                ),
            
                array(
                    'type'      => 'more-link',
                    'name'      => 'share-button-options',
                    'title'     => __('Show more options', 'sociallocker'),
                    'count'     => 5,
                    'items'     => array(
                        
                       array(
                           'type'  => 'form-group',
                           'title' => __('Data To Share', 'sociallocker'),
                           'hint'  => __('By default data extracted from the URL will be used to publish a message on a user wall. But you can specify other data you want users to share.', 'sociallocker'),
                           'items' => array(
                               
                                array(
                                    'type'  => 'textbox',
                                    'title' => __('Name', 'sociallocker'),
                                    'hint'  => __('Optional. The name of the link attachment.', 'sociallocker'),
                                    'name'  => 'facebook_share_message_name'
                                ),
                                array(
                                    'type'  => 'textbox',
                                    'title' => __('Caption', 'sociallocker'),
                                    'hint'  => __('Optional. The caption of the link (appears beneath the link name). If not specified, this field is automatically populated with the URL of the link.', 'sociallocker'),
                                    'name'  => 'facebook_share_message_caption'
                                ),
                                array(
                                    'type'  => 'textbox',
                                    'title' => __('Description', 'sociallocker'),
                                    'hint'  => __('Optional. The description of the link (appears beneath the link caption). If not specified, this field is automatically populated by information scraped from the link, typically the title of the page.', 'sociallocker'),
                                    'name'  => 'facebook_share_message_description'
                                ),  
                                array(
                                    'type'  => 'textbox',
                                    'title' => __('Image', 'sociallocker'),
                                    'hint'  => __('Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'sociallocker'),
                                    'name'  => 'facebook_share_message_image'
                                ),  
                           )
                       )
                    )
                )
            )
        );
        
        // - Twitter Follow Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'twitter-follow',
            'items'     => array(

                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'twitter-follow_available',
                    'default' => false
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('User to follow', 'sociallocker'),
                    'hint'  => __('Set a full URL of your Twitter profile to which the user has to follow in order to unlock your content.', 'sociallocker'),
                    'name'  => 'twitter_follow_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'twitter_follow_title',
                    'default' => __('follow us', 'sociallocker')
                )
            )
        );
        
        // - Google Share Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'google-share',
            'items'     => array(
                array(
                    'type'  => 'html',
                    'html'  => '<div class="alert alert-warning">'.
                                __('<strong>Warning!</strong> The Google Share button will not appear on mobile devices because it\'s not possible to catch the moment when the mobile user clicks on the button. Also please pay attention the plugin cannot track whether the user shared actually or not. If the user closes the Share Dialog without sharing, the content will be unlocked.', 'sociallocker').
                                '</div>'
                ),
                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'google-share_available'
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'sociallocker'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'google_share_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'google_share_title',
                    'default' => __('share', 'sociallocker')
                )
            )
        );
        
        // - LinkedIn Share Tab
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'linkedin-share',
            'items'     => array(

                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'sociallocker'),
                    'hint'  => __('Set On, to activate the button.', 'sociallocker'),
                    'name'  => 'linkedin-share_available',
                    'default' => false
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'sociallocker'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'sociallocker'),
                    'name'  => 'linkedin_share_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'sociallocker'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sociallocker'),
                    'name'  => 'linkedin_share_title',
                    'default' => __('share', 'sociallocker')
                )
            )
        );
        
        $tabs = apply_filters('onp_sl_social_options', $tabs);
        
        $form->add(array(  
  
            array(
                'type'  => 'checkbox',
                'way'   => 'buttons',
                'name'      => 'show_counters',
                'title'     => __('Show counters', 'sociallocker'),
                'default'   => true
            ), 
            
            array(
                'type'      => 'html',
                'html'      => '<div class="onp-sl-metabox-hint">
                                <strong>'.__('Hint', 'sociallocker').'</strong>: '. 
                                __('Drag and drop the tabs to change the order of the buttons.', 'sociallocker').
                                '</div>'
            ), 
            
            array(
                'type'      => 'hidden',
                'name'      => 'buttons_order',
                'default'   => 'vk-like,twitter-tweet,facebook-like'
            ),
            
            $tabs
        )); 
    }
    
}

FactoryMetaboxes320::register('OnpSL_SocialOptionsMetaBox', $sociallocker);
