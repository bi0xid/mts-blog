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
class OPanda_SocialOptionsMetaBox extends FactoryMetaboxes321_FormMetabox
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
    public $scope = 'opanda';
    
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
	
    public $cssClass = 'factory-bootstrap-328';
    
    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
       $this->title = __('Social Options', 'optinpanda');
    }
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes321_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms327_Form $form A form object to configure.
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
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'facebook-like_available',
                    'default' => $facebookIsActiveByDefault
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to like', 'optinpanda'),
                    'hint'  => __('Set an URL (a facebook page or website page) which the user has to like in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'facebook_like_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'facebook_like_title',
                    'default' => __('like', 'optinpanda')
                ),  
                
                array(
                    'type'      => 'more-link',
                    'name'      => 'like-button-options',
                    'title'     => __('Show more options', 'optinpanda'),
                    'count'     => 1,
                    'items'     => array(
                        
                        array(
                            'type'  => 'checkbox',
                            'way'   => 'buttons',
                            'title' => __( 'I see the "confirm" link after a like', 'optinpanda' ),
                            'hint'  => __( '<p style="margin-top: 8px;">Optional. Facebook has an automatic Like-spam protection that happens if the Like button gets clicked a lot (for example, while testing the plugin). Don\'t worry, it will go away automatically within some hours/days.</p><p>Just during the time, when Facebook asks to confirm likes on your website, turn on this option and the locker will wait the confirmation to unlock the content.</p>', 'optinpanda' ),
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
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'twitter-tweet_available',
                    'default' => $twitterActiveByDefault
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to tweet', 'optinpanda'),
                    'hint'  => __('Set an URL which the user has to tweet in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'twitter_tweet_url'
                ),
                array(
                    'type'  => 'textarea',
                    'title' => __('Tweet', 'optinpanda'),
                    'hint'  => __('Type a message to tweet. Leave this field empty to use default tweet (page title + URL). Also you can use the shortcode [post_title] in order to insert automatically a post title into the tweet.', 'optinpanda'),
                    'name'  => 'twitter_tweet_text'
                ), 
                array(
                    'type'  => 'url',
                    'title' => __('Counter URL', 'optinpanda'),
                    'hint'  => __('Optional. If you use a shorter tweet URL, paste here a full URL for the counter.', 'optinpanda'),
                    'name'  => 'twitter_tweet_counturl'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Via', 'optinpanda'),
                    'hint'  => __('Optional. Screen name of the user to attribute the Tweet to (without @).', 'optinpanda'),
                    'name'  => 'twitter_tweet_via'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'twitter_tweet_title',
                    'default' => __('tweet', 'optinpanda')
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
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'google-plus_available',
                    'default' => $googleIsActiveByDefault
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to +1', 'optinpanda'),
                    'hint'  => __('Set an URL which the user has to +1 in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'google_plus_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'google_plus_title',
                    'default' => __('+1 us', 'optinpanda')
                ) 
            )
        );
        
        // - Facebook Share Tab
        
        // if the user has not updated the facebook app id, show a notice
        $facebookAppId = get_option('opanda_facebook_appid', '117100935120196' );
        
        $tabs['items'][] = array(
            'type'      => 'tab-item',
            'name'      => 'facebook-share',
            'items'     => array(
                array(
                    'off' =>   !(empty($facebookAppId) || $facebookAppId == '117100935120196'),
                    'type'  => 'html',
                    'html'  => '<div class="alert alert-warning">'.
                                sprintf( __('Please make sure that you <a href="%s">set a facebook app id</a> for your domain, otherwise the button will not work. The Facebook Share button requires an app id registered for a domain where it\'s used.', 'sociallocker'), opanda_get_settings_url('social') )
                                .'</div>'
                ),
                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'facebook-share_available',
                    'default' => false
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'optinpanda'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'facebook_share_url'
                ),
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'facebook_share_title',
                    'default' => __('share', 'optinpanda')
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
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'twitter-follow_available',
                    'default' => false
                ),        
                array(
                    'type'  => 'url',
                    'title' => __('User to follow', 'optinpanda'),
                    'hint'  => __('Set a full URL of your Twitter profile to which the user has to follow in order to unlock your content.', 'optinpanda'),
                    'name'  => 'twitter_follow_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'twitter_follow_title',
                    'default' => __('follow us', 'optinpanda')
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
                                __('<strong>Warning!</strong> The Google Share button will not appear on mobile devices because it\'s not possible to catch the moment when the mobile user clicks on the button. Also please pay attention the plugin cannot track whether the user shared actually or not. If the user closes the Share Dialog without sharing, the content will be unlocked.', 'optinpanda').
                                '</div>'
                ),
                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'google-share_available'
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'optinpanda'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'google_share_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'google_share_title',
                    'default' => __('share', 'optinpanda')
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
                    'title' => __('Available', 'optinpanda'),
                    'hint'  => __('Set On, to activate the button.', 'optinpanda'),
                    'name'  => 'linkedin-share_available',
                    'default' => false
                ),      
                array(
                    'type'  => 'url',
                    'title' => __('URL to share', 'optinpanda'),
                    'hint'  => __('Set an URL which the user has to share in order to unlock your content. Leave this field empty to use an URL of the page where the locker will be located.', 'optinpanda'),
                    'name'  => 'linkedin_share_url'
                ),  
                array(
                    'type'  => 'textbox',
                    'title' => __('Button Title', 'optinpanda'),
                    'hint'  => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'optinpanda'),
                    'name'  => 'linkedin_share_title',
                    'default' => __('share', 'optinpanda')
                )
            )
        );
        
        $tabs = apply_filters('onp_sl_social_options', $tabs);
        
        $form->add(array(  
  
            array(
                'type'  => 'checkbox',
                'way'   => 'buttons',
                'name'      => 'show_counters',
                'title'     => __('Show counters', 'optinpanda'),
                'default'   => true
            ), 
            
            array(
                'type'      => 'html',
                'html'      => '<div class="onp-sl-metabox-hint">
                                <strong>'.__('Hint', 'optinpanda').'</strong>: '. 
                                __('Drag and drop the tabs to change the order of the buttons.', 'optinpanda').
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

FactoryMetaboxes321::register('OPanda_SocialOptionsMetaBox', $bizpanda);
