<?php
/**
 * A class for the page providing the subscription settings.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2014, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * The Subscription Settings
 * 
 * @since 1.0.0
 */
class OPanda_SubscriptionSettings extends OPanda_Settings  {
 
    public $id = 'subscription';
    
    public function init() {

        if ( isset( $_GET['opanda_aweber_disconnected'] )) {
            $this->success = __('Your Aweber Account has been successfully disconnected.', 'optinpanda');
        }
    }
    
    /**
     * Shows the header html of the settings screen.
     * 
     * @since 1.0.0
     * @return void
     */
    public function header() {
        ?>
        <p><?php _e('Set up here how you would like to save emails of your subscribers.', 'optionpanda') ?></p>
        <?php
    }
    
    /**
     * Returns subscription options.
     * 
     * @since 1.0.0
     * @return mixed[]
     */
    public function getOptions() {
        
        $options = array();
        
        $options[] = array(
            'type' => 'separator'
        );
        
        $options[] = array(
            'type' => 'dropdown',
            'name' => 'subscription_service',
            'way' => 'ddslick',
            'width' => 400,
            'data' => array(
                
                array(
                    'value' => 'database',
                    'title' => 'None',
                    'hint' => sprintf( __('Emails of subscribers will be saved in the WP database.', 'optinpanda'), opanda_get_subscribers_url() )
                ),
                array(
                    'value' => 'mailchimp',
                    'title' => 'MailChimp',
                    'hint' => sprintf( __('Adds subscribers to your MailChimp account.', 'optinpanda'), opanda_get_subscribers_url() ),
                    'image' => OPTINPANDA_URL . '/plugin/admin/assets/img/mailing-services/mailchimp.png'
                ),
                array(
                    'value' => 'aweber',
                    'title' => 'Aweber',
                    'hint' => sprintf( __('Adds subscribers to your Aweber account.', 'optinpanda'), opanda_get_subscribers_url() ),
                    'image' => OPTINPANDA_URL . '/plugin/admin/assets/img/mailing-services/aweber.png'
                ),
                array(
                    'value' => 'getresponse',
                    'title' => 'GetResponse',
                    'hint' => sprintf( __('Adds subscribers to your GetResponse account.', 'optinpanda'), opanda_get_subscribers_url() ),
                    'image' => OPTINPANDA_URL . '/plugin/admin/assets/img/mailing-services/getresponse.png'
                ),
                array(
                    'value' => 'mymail',
                    'title' => 'MyMail',
                    'hint' => sprintf( __('Adds subscribers to the plugin MyMail.', 'optinpanda'), opanda_get_subscribers_url() ),
                    'image' => OPTINPANDA_URL . '/plugin/admin/assets/img/mailing-services/mymail.png'
                ),
                array(
                    'value' => 'mailpoet',
                    'title' => 'MailPoet',
                    'hint' => sprintf( __('Adds subscribers to the plugin MailPoet.', 'optinpanda'), opanda_get_subscribers_url() ),
                    'image' => OPTINPANDA_URL . '/plugin/admin/assets/img/mailing-services/mailpoet.png'
                )
            ),
            'default' => 'none',
            'title' => __('Mailing Service', 'optinpanda')
        );
        
        $options[] = array(
            'type'      => 'div',
            'id'        => 'opanda-mailchimp-options',
            'class'     => 'opanda-mail-service-options opanda-hidden',
            'items'     => array(

                array(
                    'type' => 'separator'
                ),
                array(
                    'type'      => 'textbox',
                    'name'      => 'mailchimp_apikey',
                    'after'     => sprintf( __( '<a href="%s" class="btn btn-default" target="_blank">Get API Key</a>', 'optinpanda' ), 'http://kb.mailchimp.com/accounts/management/about-api-keys#Finding-or-generating-your-API-key' ),
                    'title'     => __( 'API Key', 'optinpanda' ),
                    'hint'      => __( 'The API key of your MailChimp account.', 'optinpanda' ),
                )
            )
        );
                 
        if( !$this->isAweberConnected()) {
            
            $options[] = array(
                'type'      => 'div',
                'id'        => 'opanda-aweber-options',
                'class'     => 'opanda-mail-service-options opanda-hidden',
                'items'     => array(

                    array(
                        'type' => 'separator'
                    ),
                    array(
                        'type'      => 'html',
                        'html'      => array($this, 'showAweberHtml')
                    ),
                    array(
                        'type'      => 'textarea',
                        'name'      => 'aweber_auth_code',
                        'title'     => __( 'Authorization Code', 'optinpanda' ),
                        'hint'      => __( 'The authorization code you will see after log in to your Aweber account.', 'optinpanda' )
                    )
                )
            );    
            
        } else {
            
            $options[] = array(
                'type'      => 'div',
                'id'        => 'opanda-aweber-options',
                'class'     => 'opanda-mail-service-options opanda-hidden',
                'items'     => array(
                    array(
                        'type' => 'separator'
                    ),
                    array(
                        'type'      => 'html',
                        'html'      => array($this, 'showAweberHtml')
                    )                    
                )
            );
        }
        
        $options[] = array(
            'type'      => 'div',
            'id'        => 'opanda-getresponse-options',
            'class'     => 'opanda-mail-service-options opanda-hidden',
            'items'     => array(
                
                array(
                    'type' => 'separator'
                ),
                array(
                    'type'      => 'textbox',
                    'name'      => 'getresponse_apikey',
                    'title'     => __( 'API Key', 'optinpanda' ),
                    'after'     => sprintf( __( '<a href="%s" class="btn btn-default" target="_blank">Get API Key</a>', 'optinpanda' ), 'http://support.getresponse.com/faq/where-i-find-api-key' ),
                    'hint'      => __( 'The Twitter Consumer Secret of your Twitter App.', 'optinpanda' )
                )
            )
        );
        
        $options[] = array(
            'type'      => 'div',
            'id'        => 'opanda-mymail-options',
            'class'     => 'opanda-mail-service-options opanda-hidden',
            'items'     => array(
                
       
                array(
                    'type' => 'html',
                    'html' => array($this, 'showMyMailHtml')
                ),
                array(
                    'type' => 'separator'
                ),
                array(
                    'type'      => 'checkbox',
                    'way'       => 'buttons',
                    'name'      => 'mymail_redirect',
                    'title'     => __( 'Redirect To Locker', 'optinpanda' ),
                    'hint'      => sprintf( __( 'Set On, to redirect the user to the same page where the locker is located after clicking on the confirmation link.<br />If Off, the MyMail will redirect the user to the page specified in the option <a href="%s" target="_blank">Newsletter Homepage</a>.', 'optinpanda' ), admin_url('options-general.php?page=newsletter-settings&settings-updated=true#frontend') )
                )
            )
        );
        
        $options[] = array(
            'type'      => 'div',
            'id'        => 'opanda-mailpoet-options',
            'class'     => 'opanda-mail-service-options opanda-hidden',
            'items'     => array(
     
                array(
                    'type' => 'html',
                    'html' => array($this, 'showMailPoetHtml')
                )   
            )
        );
        
        $options[] = array(
            'type' => 'separator'
        );
        
        return $options;
    }
    
    public function showAweberHtml() {
        
        if( !$this->isAweberConnected()) {
        ?>
        
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="control-group controls col-sm-10 opanda-aweber-steps">
                <p><?php _e( 'To connect your Aweber account:', 'optinpanda' ) ?></p>
                <ul>
                    <li><?php _e( '<span>1.</span> <a href="https://auth.aweber.com/1.0/oauth/authorize_app/92c68137" class="button" target="_blank">Click here</a> <span>to open the authorization page and log in.</span>', 'optinpanda' ) ?></li>
                    <li><?php _e( '<span>2.</span> Copy and paste the authorization code in the field below.', 'optinpanda' ) ?></li>
                </ul>
            </div>
        </div>
        
        <?php } else { ?>
        
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="control-group controls col-sm-10 opanda-aweber-steps">
                <p><strong><?php _e( 'Your Aweber Account is connected.', 'optinpanda' ) ?></strong></p>
                <ul>
                    <li><?php _e( '<a href="' . $this->getActionUrl('disconnectAweber') . '" class="button onp-sl-aweber-oauth-logout">Click here</a> <span>to disconnect.</span>', 'optinpanda' ) ?></li>                    
                </ul>
            </div>
        </div>
        
        <?php  
        }
    }
    
    /**
     * Shows HTML for MyMail.
     * 
     * @since 1.0.7
     * @return void
     */
    public function showMyMailHtml() {
        
        if ( !defined('MYMAIL_VERSION') ) {
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="control-group controls col-sm-10">
                    <p><strong><?php _e('The MyMail plugin is not found on your website. Emails will be added to the WP database only.', 'opanda') ?></strong></p>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="control-group controls col-sm-10">
                    <p><?php _e('You can set a list where the subscribers should be added in the settings of a particular locker.', 'opanda') ?></p>
                </div>
            </div>
        <?php
        }
    }
    
    /**
     * Shows HTML for MyMail.
     * 
     * @since 1.0.7
     * @return void
     */
    public function showMailPoetHtml() {
        
        if ( !defined('WYSIJA') ) {
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="control-group controls col-sm-10">
                    <p><strong><?php _e('The MailPoet plugin is not found on your website. Emails will be added to the WP database only.', 'opanda') ?></strong></p>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="control-group controls col-sm-10">
                    <p><?php _e('You can set a list where the subscribers should be added in the settings of a particular locker.', 'opanda') ?></p>
                </div>
            </div>
        <?php
        }
    }
    
    /**
     * Calls before saving the settings.
     * 
     * @since 1.0.0
     * @return void
    */
    public function onSaving() {
        
        $service = isset( $_POST['opanda_subscription_service'] ) 
                ? $_POST['opanda_subscription_service']:
                null;
        
        $authCode = isset( $_POST['opanda_aweber_auth_code'] )
                ? trim( $_POST['opanda_aweber_auth_code'] ):
                null;
        
        unset( $_POST['opanda_aweber_auth_code'] );
        
        if ( 'aweber' !== $service || $this->isAweberConnected() ) return;
        
        // if the auth code is empty, show the error
        
        if ( empty( $authCode ) ) {
            return $this->showError( __('Unable to connect to Aweber. The Authorization Code is empty.', 'optinpanda' ) );    
        }
        
        // try to get credential via api, shows the error if the exception occurs

        require_once OPANDA_BIZPANDA_DIR.'/admin/includes/subscriptions.php';
        $aweber = OPanda_SubscriptionServices::getService('aweber');
        
        try {
            $credential = $aweber->getCredentialUsingAuthorizeKey( $authCode ); 
        } catch (Exception $ex) {
            return $this->showError( $ex->getMessage() );
        }

        // saves the credential

        if ( $credential && sizeof($credential) ) {
            foreach( $credential as $key => $value ) {
                update_option('opanda_aweber_'.$key, $value);
            }
        }
   }
    
    public function isAweberConnected() {
         return get_option('opanda_aweber_consumer_key', false);
    }   
   
    public function disconnectAweberAction() {

        delete_option('opanda_aweber_consumer_key');
        delete_option('opanda_aweber_consumer_secret');
        delete_option('opanda_aweber_access_key');
        delete_option('opanda_aweber_access_secret');
        delete_option('opanda_aweber_auth_code'); 
        delete_option('opanda_aweber_account_id'); 
        
        return $this->redirectToAction('index', array('opanda_aweber_disconnected' => true));
    }
}
