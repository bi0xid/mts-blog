<?php 

class OPanda_MailPoetSubscriptionService extends OPanda_Subscription {

    public function init( $options ) {
        parent::init( $options );
    }

    /**
     * Returns available Opt-In modes.
     * 
     * @since 1.0.0
     * @return mixed[]
     */
    public function getOptInModes() {
        return array( 'double-optin', 'quick-double-optin', 'quick' );
    }

    /**
     * Returns lists available to subscribe.
     * 
     * @since 1.0.0
     * @return mixed[]
     */
    public function getLists() {
        
        if ( !defined('WYSIJA') ) {
            throw new OPanda_SubscriptionException( __( 'The MailPet plugin is not found on your website.', 'optinpanda' ) ); 
        }
        
        $model_list = WYSIJA::get('list','model');
        
        $lists = array();
        foreach( $model_list->getLists() as $item ) {
            $lists[] = array(
                'title' => $item['name'],
                'value' => $item['list_id']
            );
        }

        return array(
            'items' => $lists
        ); 
    }

    /**
     * Subscribes the person.
     */
    public function subscribe( $identityData, $listId, $doubleOptin, $contextData ) {

        if ( !defined('WYSIJA') ) {
            throw new OPanda_SubscriptionException( __( 'The MailPet plugin is not found on your website.', 'optinpanda' ) ); 
        }
        
        $userModel = WYSIJA::get('user','model');
        $userListModel = WYSIJA::get('user_list','model');
        $manager = WYSIJA::get('user','helper');   
            
        $subscriber = $userModel->getOne(false, array('email' => $identityData['email'] ));
        
        // ---
        // if already subscribed
        
        if ( !empty( $subscriber ) ) {
            
            $subscriberId = intval( $subscriber['user_id'] );

            // adding the user to the specified list if the user has not been yet added
            
            $lists = $userListModel->get_lists( array( $subscriberId ) );

            if ( !isset( $lists[$subscriberId] ) || !in_array( $listId, $lists[$subscriberId] ) ) {
                $manager->addToList( $listId, array( $subscriberId ) );
            }
            
            if ( !$doubleOptin ) return array('status' =>  'subscribed');
            
            // sends the confirmation email
            
            $status = intval($subscriber['status'] );
            if ( 0 === $status ) $manager->sendConfirmationEmail( $subscriberId, true, array( $listId ) );
            
            return array('status' => 1 === $status ? 'subscribed' : 'pending');
        }
        
        // ---
        // if it's a new subscriber
        
        $ip = $manager->getIP();
        
        $userData = array(
            'email' => $identityData['email'],
            'status' => !$doubleOptin ? 1 : 0,
            'ip' => $ip,
            'created_at' => time()
        );
        
        if ( !empty( $identityData['name'] ) )
            $userData['firstname'] = $identityData['name'];

        if ( !empty( $identityData['family'] ) )
            $userData['lastname'] = $identityData['family'];

        if ( empty( $identityData['name'] ) && empty( $identityData['family'] ) && !empty( $identityData['displayName'] ) )
            $userData['firstname'] = $identityData['displayName'];
        
        $subscriberId = $userModel->insert( $userData );
        
        if ( !$subscriberId ) {
            throw new OPanda_SubscriptionException ( '[subscribe]: Unable to add a subscriber.' ); 
        }
        
        // adds the user the the specified list
        
        $manager->addToList( $listId, array( $subscriberId ) );
        
        // sends the confirmation email

        if ( $doubleOptin ) $manager->sendConfirmationEmail( $subscriberId, true, array( $listId ) );
        return array('status' => $doubleOptin ? 'pending' : 'subscribed');
    }
    
    /**
     * Checks if the user subscribed.
     */  
    public function check( $identityData, $listId, $contextData ) { 
        
        $userModel = WYSIJA::get('user','model');
        $userListModel = WYSIJA::get('user_list','model');
        $manager = WYSIJA::get('user','helper');   
        
        $subscriber = $userModel->getOne(false, array('email' => $identityData['email'] ));
        if ( empty( $subscriber ) ) {
            throw new OPanda_SubscriptionException( __( 'The operation is canceled because the website administrator deleted your email from the list.', 'optinpanda' ) ); 
        }
        
        $subscriberId = intval( $subscriber['user_id'] );
        
        // adding the user to the specified list if the user has not been yet added

        $lists = $userListModel->get_lists( array( $subscriberId ) );
        if ( !isset( $lists[$subscriberId] ) || !in_array( $listId, $lists[$subscriberId] ) ) {
            $manager->addToList( $listId, array( $subscriberId ) );
        }
        
        $status = intval( $subscriber['status'] );
        
        if ( 1 === $status ) return array('status' => 'subscribed');
        return array('status' => 'pending');
    }
}
