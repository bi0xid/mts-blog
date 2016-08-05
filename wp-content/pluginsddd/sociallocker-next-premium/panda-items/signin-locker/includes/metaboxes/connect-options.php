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
class OPanda_ConnectOptionsMetaBox extends FactoryMetaboxes321_FormMetabox
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
        
       $this->title = __('Connect Options', 'optinpanda');
    }
    
    /**
     * Configures the connect buttons options.
     */ 
    public function form( $form ) {

        $options = array();
        
        $options[] = array(
            'type'      => 'html',
            'html'      => '<div class="opanda-fullwidth opanda-hint">
                            <strong>'.__('How to setup', 'optinpanda').'</strong>: ' . 
                            '<ol>' . 
                            '<li>' . __('Select social networks which will be available to sign in.', 'optinpanda') . 
                            '<li>' . __('For each social network, select actions which have to be performed to sign in.', 'optinpanda') .
                            '<li>' . __('Configure each selected action by clicking on its title.', 'optinpanda') .
                            '</ol>' .
                            '</div>'
        );

        $options[] =  array(
            'type'      => 'html',
            'html'      => array( $this, 'showConnectButtonsControl' )
        );
        
        // leads options
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-lead-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off factory-fontawesome-320',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml(
                        __('Action: Save Email', 'optinpanda'),
                        __('This action retrieves an email and some other personal data of the user and saves it in the database.', 'optinpanda')
                    )
                ),
                array(
                    'type' => 'html',
                    'html' => array($this,'getLeadExplanationOption')
                )
            )
        );
        
        // subscription options
        
        $subscription = array();
        
        $subscription[] = array(
            'type' => 'html',
            'html' => $this->getOptionsHeaderHtml(
                __('Action: Subscribe', 'optinpanda'),
                __('This action allows to subscribe the user to the specified mailing list when one clicks on the Sign In button.', 'optinpanda')
            )
        );
        
        require_once OPANDA_BIZPANDA_DIR . '/admin/includes/subscriptions.php';
        $service = OPanda_SubscriptionServices::getService();
        
        if ( BizPanda::hasPlugin('optinpanda') ) {
            
            $subscription[] = array(
                'type' => 'html',
                'html' => array($this, 'showSubscriptionService')
            );

            if ( 'none' !== $service->name ) {

                $subscription[] = array(
                    'type' => 'dropdown',
                    'name' => 'subscribe_list',
                    'data' => array(
                        'ajax' => true,
                        'url' => admin_url('admin-ajax.php'),
                        'data' => array(
                            'action' => 'opanda_get_subscrtiption_lists',
                            'opanda_service' => $service->name
                        )
                    ),
                    'empty' => sprintf( '- empty -', $service->title ),
                    'title' => __('List', 'opanda'),
                    'hint' => sprintf( 'Select the list in your %s account to add subscribers.', $service->title )
                );
            } 
        }

        $subscription[] = array(
            'type' => 'dropdown',
            'name' => 'subscribe_mode',
            'hasGroups' => false,
            'hasHints' => true,
            'data' => OPanda_SubscriptionServices::getOptInModes( $service->getOptInModes(), true ),
            'title' => __('Opt-In Mode', 'opanda')
        );

        $subscription[] = array(
            'type' => 'checkbox',
            'way' => 'buttons',
            'name' => 'subscribe_name',
            'title' => __('Require Name', 'opanda'),
            'hint' => 'If On, requires to specify the name to unlock.'
        );
        
        $subscription[] = array(
            'type' => 'separator'
        );
       
        $subscription[] = array(
            'type'      => 'textbox',
            'name'      => 'subscribe_before_form',
            'title'     => __('Before Form', 'optinpanda'),
            'hint'      => __('The text before the form.', 'optinpanda'),
            'default'   => __('Cannot sign in via social networks? Enter your email manually.', 'optinpanda')
        ); 
        
        $subscription[] = array(
            'type'      => 'textbox',
            'name'      => 'subscribe_button_text',
            'title'     => __('Buttton Text', 'optinpanda'),
            'hint'      => __('The text on the button.', 'optinpanda'),
            'default'   => __('sign in to unlock', 'optinpanda')
        );
        
        $subscription[] = array(
            'type'      => 'textbox',
            'name'      => 'subscribe_after_button',
            'title'     => __('After Buttton', 'optinpanda'),
            'hint'      => __('The text below the button. Guarantee something.', 'optinpanda'),
            'default'   => __('Your email address is 100% safe from spam!', 'optinpanda')
        );
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-subscribe-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off factory-fontawesome-320',
            
            'items'     => $subscription
        );
        
        // signup options
        
        $rolesItems = array();
        foreach (get_editable_roles() as $roleName => $roleInfo) {
            $rolesItems[] = array($roleName, $roleName);
        }
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-signup-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off factory-fontawesome-320',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml(
                        __('Action: Create Account', 'optinpanda'),
                        __('This action registers the user on your website (the password will be generated randomly).', 'optinpanda')
                    )
                ), 
                array(
                    'type' => 'dropdown',
                    'name' => 'signup_mode',
                    'hasGroups' => false,
                    'hasHints' => true,
                    'data' => array(
                        // array('hidden', __('Auto (Recommended)', 'bizpanda'), __('The user will be logged in automatically after clicking on the Sign-In Buttons.', 'bizpanda')),
                        array('postponed', __('Manual', 'bizpanda'), __('The account will be created but the user will not be logged in. The user will have to log in manually by using the login details sent via email. The locked content will get available instantly after clicking on the Sign-In buttons.', 'bizpanda'))
                    ),
                    'title' => __('Login Mode', 'bizpanda'),
                    'default' => 'hidden'
                ),
                array(
                    'type' => 'html',
                    'html' => array($this,'getSignupRoleOption')
                ),
                array(
                    'type' => 'html',
                    'html' => array($this,'getSignupWelcomeOption')
                ),
            )
        );

        // twitter follow options
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-twitter-follow-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml( 
                        __('Twitter Action: Follow', 'optinpanda'),
                        __('This action makes the user following you on Twitter after clicking the Sign In button.', 'optinpanda')
                    )
                ), 
                array(
                    'type'  => 'textbox',
                    'title' => __('User to follow', 'optinpanda'),
                    'hint'  => __('Set a user screen name to follow (for example, <a href="http://twitter.com/byonepress" target="_blank">byonepress</a>)', 'optinpanda'),
                    'name'  => 'twitter_follow_user'
                ), 
                array(
                    'type'  => 'checkbox',
                    'way'   => 'buttons',
                    'title' => __('Notifications', 'optinpanda'),
                    'hint'  => __('If On, the follower will get notifications about new tweets (usually via sms).', 'optinpanda'),
                    'name'  => 'twitter_follow_notifications',
                    'default' => false
                )
            )
        );
        
        // twitter tweet options
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-twitter-tweet-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml( 
                        __('Twitter Action: Tweet', 'optinpanda'),
                        __('Sends the specified tweet below from behalf of the user after signing in.', 'optinpanda')
                    )
                ), 
                array(
                    'type'  => 'textarea',
                    'title' => __('Tweet', 'optinpanda'),
                    'hint'  => __('Type a message to tweet. It may include any URL.', 'optinpanda'),
                    'name'  => 'twitter_tweet_message'
                ),
            )
        );

        // youtube subscribe options
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-google-youtube-subscribe-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml( 
                        __('Google Action: Subscribe To Youtube Channel', 'optinpanda'),
                        __('This action subscribers the user to the specified Youtube channel.', 'optinpanda')
                    )
                ), 
                array(
                    'type'  => 'textbox',
                    'title' => __('Youtube Channel ID', 'optinpanda'),
                    'hint'  => __('Set a channel ID to subscribe (for example, <a href="http://www.youtube.com/channel/UCANLZYMidaCbLQFWXBC95Jg" target="_blank">UCANLZYMidaCbLQFWXBC95Jg</a>).', 'optinpanda'),
                    'name'  => 'google_youtube_channel_id'
                )
            )
        );
        
        // linkedin follow options
        
        $options[] =  array(
            'type'      => 'div',
            'id'        => 'opanda-linkedin-follow-options',
            'cssClass'  => 'opanda-connect-buttons-options opanda-off',
            
            'items'     => array(
                array(
                    'type' => 'html',
                    'html' => $this->getOptionsHeaderHtml( 
                        __('LinkedIn Action: Follow', 'optinpanda'),
                        __('This action subscribers the user to the specified company page.', 'optinpanda')
                    )
                ), 
                array(
                    'type'  => 'textbox',
                    'title' => __('Company', 'optinpanda'),
                    'hint'  => __('Set a company ID or name to follow (for example, <a href="https://www.linkedin.com/company/1441" target="_blank">1441</a> or <a href="https://www.linkedin.com/company/google" target="_blank">google</a>).', 'optinpanda'),
                    'name'  => 'linkedin_follow_company'
                )
            )
        );
        
        // hidden files to save active buttons and their actions
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'connect_buttons',
            'default'   => 'facebook,twitter,google,email'
        );
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'facebook_actions',
            'default'   => 'lead'
        ); 
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'twitter_actions',
            'default'   => 'lead'
        );
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'google_actions',
            'default'   => 'lead'
        ); 
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'linkedin_actions',
            'default'   => 'lead'
        );
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'email_actions',
            'default'   => 'lead'
        );   
        
        $options[] = array(
            'type'      => 'hidden',
            'name'      => 'catch_leads',
            'default'   => true
        );    
        
        $options = apply_filters('onp_sl_connect_options', $options);
        $form->add( $options ); 
    }
    
    public function getOptionsHeaderHtml( $title, $description = null ) {
        $title = '<strong>' . $title . '</strong>';
        $description = empty( $description ) ? '' : '<p>' . $description . '</p>';
        
        return '<div class="form-group opanda-header"><label class="col-sm-2 control-label"></label><div class="control-group col-sm-10"><div class="opanda-inner-wrap">' . $title . $description . '</div></div></div>';
    }
    
    public function getLeadExplanationOption() {
        
        $socialItem = opanda_fetch_panda_items('optinpanda');
        $url = $socialItem['url'];
            
        ?>

        <div class="form-group" style="margin-bottom: 10px;">
            <label class="col-sm-2 control-label">
                 <?php _e('How to use', 'opanda') ?>
            </label>
            <div class="control-group col-sm-10">
                <p style="padding-top: 3px;">
                    <?php printf( __('<a href="%s" class="button" target="_blank">See emails</a> of users who already signed-up or <a href="%s" class="button" target="_blank">export emails</a> in the CSV format.', 'opanda'), admin_url('edit.php?post_type=opanda-item&page=leads-bizpanda'), admin_url('admin.php?page=leads-bizpanda&action=export') ) ?>
                </p>
                <p>
                    <?php printf( __('Install the plugin <a href="%s" target="_blank">Opt-In Panda</a> to automatically subscribe all the signed-up users to your mailing list.'), $url ) ?>
                </p>
            </div>
        </div>

        <?php
   
    }
    
    public function getSignupRoleOption() {
        $defaultRole = get_option('default_role');
        ?>

        <div class="form-group" style="margin-bottom: 10px;">
            <label class="col-sm-2 control-label">
                <?php _e('New User Role', 'optinpanda') ?>
            </label>
            <div class="control-group col-sm-10">
                <p style="padding-top: 7px;">
                    <?php printf( __('All new users will be assigned to the role <strong>%s</strong> (<a href="%s" target="_blank">change</a>).', 'optinpanda' ), $defaultRole, admin_url('options-general.php') ) ?>
                </p>
            </div>
        </div>

        <?php

    }
    
    public function getSignupWelcomeOption() {
        $defaultRole = get_option('default_role');
        ?>

        <div class="form-group">
            <label class="col-sm-2 control-label">
                <?php _e('Welcome E-mail', 'optinpanda') ?>
            </label>
            <div class="control-group col-sm-10">
                <p style="padding-top: 7px;">
                    <?php printf( __('By default new users receive the standard wordpress welcome message. You can change it if you want.<br /><a href="https://wordpress.org/plugins/search.php?q=Welcome+Email" target="_blank">Click here</a> to select a free plugin to customize the welcome email.', 'optinpanda' ), $defaultRole, admin_url('options-general.php') ) ?>
                </p>
            </div>
        </div>

        <?php

    }
    
    // ------------------------------------------------------------------------------
    // Shows the control to manage the Connect Buttons
    // ------------------------------------------------------------------------------
    
    /**
     * Shows the control to manage the connect buttons.
     * 
     * @since 1.0.0
     * @return string
     */
    public function showConnectButtonsControl() {

        $buttons = array(

            'facebook' => array(
                'title' => __('Facebook', 'optinpanda'),
                'errors' => array($this, 'getFacebookErrors'),
                'actions' => array(
                    'lead' => array(
                        'on'    => true,
                        'title' => __('Save Email', 'bizpanda'),
                        'always' => true
                    ),
                    'subscribe' => array(
                        'title' => __('Subscribe', 'bizpanda')
                    ),
                    'signup' => array(
                        'on'    => true,
                        'title' => __('Create Account', 'bizpanda')
                    )
                )
            ),
            
            'twitter' => array(
                'title' => __('Twitter', 'optinpanda'),
                'errors' => array($this, 'getTwitterErrors'),
                'actions' => array(
                    'lead' => array(
                        'on'    => true,
                        'title' => __('Save Email', 'bizpanda'),
                        'always' => true
                    ),
                    'subscribe' => array(
                        'title' => __('Subscribe', 'bizpanda')
                    ),
                    'signup' => array(
                        'on'    => true,
                        'title' => __('Create Account', 'bizpanda')
                    ),
                    'follow' => array(
                        'title' => __('Follow', 'bizpanda'),
                        'type'  => 'social'
                    ),
                    'tweet' => array(
                        'title' => __('Tweet', 'bizpanda'),
                        'type'  => 'social'
                    )
                )
            ),
            
            'google' => array(
                'title' => __('Google', 'optinpanda'),
                'errors' => array($this, 'getGoogleErrors'),
                'actions' => array(
                    'lead' => array(
                        'on'    => true,
                        'title' => __('Save Email', 'bizpanda'),
                        'always' => true
                    ),
                    'subscribe' => array(
                        'title' => __('Subscribe', 'bizpanda')
                    ),
                    'signup' => array(
                        'on'    => true,
                        'title' => __('Create Account', 'bizpanda')
                    ),
                    'youtube-subscribe' => array(
                        'title' => __('Subscribe (YT)', 'bizpanda'),
                        'type'  => 'social'
                    )
                )
            ),
            
            'linkedin' => array(
                'title' => __('LinkedIn', 'optinpanda'),
                'errors' => array($this, 'getLinkedInErrors'),
                'actions' => array(
                    'lead' => array(
                        'on'    => true,
                        'title' => __('Save Email', 'bizpanda'),
                        'always' => true
                    ),
                    'subscribe' => array(
                        'title' => __('Subscribe', 'bizpanda')
                    ),
                    'signup' => array(
                        'on'    => true,
                        'title' => __('Create Account', 'bizpanda')
                    ),
                    'follow' => array(
                        'title' => __('Follow', 'bizpanda'),
                        'type'  => 'social'
                    )
                )
            ),
            
            'email' => array(
                'title' => __('Email Form', 'optinpanda'),
                'actions' => array(
                    'lead' => array(
                        'on'    => true,
                        'title' => __('Save Email', 'bizpanda'),
                        'always' => true
                    ),
                    'subscribe' => array(
                        'title' => __('Subscribe', 'bizpanda')
                    ),
                    'signup' => array(
                        'on'    => true,
                        'title' => __('Create Account', 'bizpanda')
                    )
                )
            )
        );
        
        // activates the subscription action
        if ( defined('OPTINPANDA_PLUGIN_ACTIVE') ) {
            
            foreach( $buttons as $buttonName => $buttonData ) {
                $buttons[$buttonName]['actions']['subscribe']['on'] = true;      
            }
            
        } else {
            
            $socialItem = opanda_fetch_panda_items('optinpanda');
            $url = $socialItem['url'];
            
            foreach( $buttons as $buttonName => $buttonData ) {
                $buttons[$buttonName]['actions']['subscribe']['error'] = sprintf( __('To enable this action, please install the plugin Opt-In Panda which provides subscription features. <a href="%s" target="_blank">Click here to learn more</a>.', 'bizpanda'), $url );  
            }  
            
        }
            
        // activates the social actions
        if ( defined('SOCIALLOCKER_PLUGIN_ACTIVE') ) {

            foreach( $buttons as $buttonName => $buttonData ) {
                foreach( $buttons[$buttonName]['actions'] as $actionName => $actionData ) {
                    
                    if ( isset( $actionData['type'] ) && 'social' === $actionData['type'] ) {
                        $buttons[$buttonName]['actions'][$actionName]['on'] = true;
                    }   
                }   
            }
            
        } else {
            
            $socialItem = opanda_fetch_panda_items('sociallocker');
            $url = $socialItem['url'];
            
            foreach( $buttons as $buttonName => $buttonData ) {
                foreach( $buttons[$buttonName]['actions'] as $actionName => $actionData ) {
                    
                    if ( isset( $actionData['type'] ) && 'social' === $actionData['type'] ) {
                        $buttons[$buttonName]['actions'][$actionName]['error'] = sprintf( __('To enable this action, please install the Social Locker plugin which provides social features. <a href="%s" target="_blank">Click here to learn more</a>.', 'bizpanda'), $url );
                    }   
                }   
            }
            
        }    
        
        $buttons = apply_filters('opanda_connect_buttons_options', $buttons);
        $commonActions = array('subscribe', 'signup', 'lead');
        ?>
        <div class="opanda-connect-buttons factory-fontawesome-320">

            <?php foreach( $buttons as $name => $button ) { ?>
                <?php $errors = isset( $button['errors'] ) ? call_user_func( $button['errors'] ) : null ?>
            
                <div class="opanda-button opanda-button-<?php echo $name ?> opanda-off <?php if ( $errors ) { echo 'opanda-has-error'; } ?>" data-name="<?php echo $name ?>">
                    <div class="opanda-inner-wrap">
                        <label class="opanda-button-title" for="opanda-button-<?php echo $name ?>-activated">
                            
                            <?php if ( $errors ) { ?>
                            <span class="opanda-error">
                                <i class="fa fa-exclamation-triangle"></i>
                                <div class='opanda-error-text'><?php echo $errors ?></div>
                            </span>
                            <?php } else { ?>
                            <span class='opanda-checkbox'>
                                <input type="checkbox" value="<?php echo $name ?>" id="opanda-button-<?php echo $name ?>-activated" />
                            </span>
                            <?php } ?>
  
                            <span><?php echo $button['title'] ?></span>

                        </label>
                        <ul class='opanda-actions'>
                            <?php foreach( $button['actions'] as $actionName => $actionData ) { ?>
                            <?php if ( isset( $button['actions'][$actionName]['on'] ) ) { ?>
                                <?php
                                    $actionTitle = $actionData['title'];
                                ?>
                                <?php $isCommon = in_array( $actionName, $commonActions ); ?>
                            
                                <li class='opanda-action opanda-action-<?php echo $actionName ?>'>
                                    <span>
                                        <input 
                                            type="checkbox" 
                                            value="1" 
                                            data-common="<?php echo ( $isCommon ? '1' : '0' ); ?>" 
                                            data-button="<?php echo $name ?>" 
                                            data-action="<?php echo $actionName ?>" 
                                            disabled="disabled" />
                                    </span>
                                    
                                    <a href="#" class="opanda-action-link" data-common="<?php echo ( $isCommon ? '1' : '0' ); ?>" data-button="<?php echo $name ?>" data-action="<?php echo $actionName ?>"><?php echo $actionTitle ?></a>
                                </li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                        <ul class='opanda-actions opanda-actions-disabled'>
                            <?php foreach( $button['actions'] as $actionName => $actionData ) { ?>
                            <?php if ( !isset( $button['actions'][$actionName]['on'] ) ) { ?>
                            <?php
                                $actionTitle = $actionData['title'];
                            ?>
                            <?php $isCommon = in_array( $actionName, $commonActions ); ?>
                            <li class='opanda-action opanda-action-disabled opanda-action-<?php echo $actionName ?>'>
                                <span class="opanda-error-wrap">
                                    <input type="checkbox" disabled="disabled" value="1" />
                                    <span class='opanda-error-text'><?php echo $actionData['error'] ?></span>
                                    <a href="#" class="opanda-action-link" data-common="<?php echo ( $isCommon ? '1' : '0' ); ?>" data-button="<?php echo $name ?>" data-action="<?php echo $actionName ?>"><?php echo $actionTitle ?></a>  
                                </span>
                            </li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>  
        <?php
    }
    
    /**
     * Returns errors of the Facebook Connect button.
     * 
     * @since 1.0.0
     * @return string
     */
    public function getFacebookErrors() {
        
        $appId = get_option('opanda_facebook_appid', null);
        if ( empty( $appId ) || '117100935120196' === $appId ) {
            return sprintf( __('You need to register a Facebook App for your website. Please <a href="%s" target="_blank">click here</a> to learn more.', 'optinpanda'), admin_url('admin.php?page=how-to-use-' . $this->plugin->pluginName . '&onp_sl_page=facebook-app') );
        }
        
        return false;
    }
    
    /**
     * Returns errors of the Twitter Connect button.
     * 
     * @since 1.0.0
     * @return string
     */
    public function getTwitterErrors() {
        
        $twitterAppMode = get_option('opanda_twitter_use_dev_keys', 'default');
        if ( 'default' === $twitterAppMode ) return false;
        
        $key = get_option('opanda_twitter_consumer_key');
        $secret = get_option('opanda_twitter_consumer_secret');
        
        if ( empty( $key ) || empty( $secret ) ) {
            return sprintf( __('Please set the Key & Secret of your Twitter App or select the default app. Please <a href="%s" target="_blank">click here</a> to learn more.', 'optinpanda'), admin_url('admin.php?page=how-to-use-' . $this->plugin->pluginName . '&onp_sl_page=twitter-app') );
        }
        
        return false;
    }
    
    /**
     * Returns errors of the Facebook Connect button.
     * 
     * @since 1.0.0
     * @return string
     */
    public function getGoogleErrors() {
        
        $clientId = get_option('opanda_google_client_id', null);
        if ( empty( $clientId ) ) {
            return sprintf( __('You need to get a Google Client ID for your website. Please <a href="%s" target="_blank">click here</a> to learn more.', 'optinpanda'), admin_url('admin.php?page=how-to-use-' . $this->plugin->pluginName . '&onp_sl_page=google-client-id') );
        }
        
        return false;
    }
    
    /**
     * Returns errors of the LinkedIn Connect button.
     * 
     * @since 1.0.0
     * @return string
     */
    public function getLinkedInErrors() {
        
        $apiKey = get_option('opanda_linkedin_api_key', null);
        if ( empty( $apiKey ) ) {
            return sprintf( __('You need to get a LinkedIn API Key for your website. Please <a href="%s" target="_blank">click here</a> to learn more.', 'optinpanda'), admin_url('admin.php?page=how-to-use-' . $this->plugin->pluginName . '&onp_sl_page=linkedin-api-key') );
        }
        
        return false;
    }    
    
    public function showSubscriptionService() {
        
        $service = get_option('opanda_subscription_service', 'database');
        
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="control-group controls col-sm-10">

                <?php if ( 'database' === $service ) { ?>
                    <?php printf( __('The emails will be saved in the <a href="%s" target="_blank">local database</a> because you haven\'t selected a mailing service', 'optinpanda'), opanda_get_subscribers_url() ) ?>
                <?php } elseif ( 'mailchimp' === $service ) { ?>
                    <?php _e('You selected MailChimp as your mailing service', 'optinpanda') ?>
                <?php } elseif ( 'aweber' === $service ) { ?>
                    <?php _e('You selected Aweber as your mailing service', 'optinpanda') ?>
                <?php } elseif ( 'getresponse' === $service ) { ?>
                    <?php _e('You selected GetResponse as your mailing service', 'optinpanda') ?>
                <?php } ?>

                (<a href="<?php echo opanda_get_settings_url('subscription') ?>" target="_blank"><?php _e('change', 'optinpanda') ?></a>).
            </div>
        </div>
        <?php
    }
    
    /**
     * Removes the action 'lead' from options of the buttons because it's a virtual action.
     */
    public function onSavingForm( $postId ) {

        $buttons = array('facebook', 'twitter', 'google', 'linkedin', 'email');
        foreach( $buttons as $buttonName ) {
            
            $strActions = isset( $_POST['opanda_' . $buttonName . '_actions'] ) 
                            ? $_POST['opanda_' . $buttonName . '_actions'] 
                            : '';
            
            $rawActions = explode(',', $strActions);
            $filteredActions = array();
            
            foreach( $rawActions as $action ) {
                if ( 'lead' == $action ) continue;
                $filteredActions[] = $action;
            } 
            
            $_POST['opanda_' . $buttonName . '_actions'] = implode(',', $filteredActions);
        }
    }
}

FactoryMetaboxes321::register('OPanda_ConnectOptionsMetaBox', $bizpanda);