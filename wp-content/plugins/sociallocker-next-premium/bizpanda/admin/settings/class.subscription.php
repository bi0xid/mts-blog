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
            'way'  => 'buttons',
            'name' => 'subscription_service',
            'data' => array(
                array('database', __('None', 'optinpanda'), sprintf( __('The emails will be saved in the <a href="%s" target="_blank">database</a> only. You will be able to import them later.', 'optinpanda'), opanda_get_subscribers_url() ) ),
                array('mailchimp', __('MailChimp', 'optinpanda'), sprintf( __('The emails will be added automatically to your MailChimp account and also saved in the <a href="%s" target="_blank">database</a>.', 'optinpanda'), opanda_get_subscribers_url() ) ),
                array('aweber', __('Aweber', 'optinpanda'), sprintf( __('The emails will be added automatically to your Aweber account and also saved in the <a href="%s" target="_blank">database</a>.', 'optinpanda'), opanda_get_subscribers_url() ) ),
                array('getresponse', __('GetResponse', 'optinpanda'), sprintf( __('The emails will be added automatically to your GetResponse account and also saved in the <a href="%s" target="_blank">database</a>.', 'optinpanda'), opanda_get_subscribers_url() ) ),
            ),
            'default' => 'none',
            'title' => __('Mail Service', 'optinpanda')
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
