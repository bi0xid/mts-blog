<?php

class OPanda_Leads {
    
    /**
     * Adds a new lead.
     */
    public static function add( $identity = array(), $context = array(), $confirmed = false ) {
        global $wpdb;
        
        $email = isset( $identity['email'] ) ? $identity['email'] : false;
        $link = isset( $identity['link'] ) ? $identity['link'] : null;
        
        $itemId = isset( $context['itemId'] ) ? intval( $context['itemId'] ) : 0;
        $postId = isset( $context['postId'] ) ? intval( $context['postId'] ) : null;
        
        $lead = self::getByEmail( $email );
        
        // counts the number of new recivied emails
        if ( empty( $lead ) ) {
            OPanda_Stats::countMetrict( $itemId, $postId, 'email-received');
        }
        
        // updates the lead if it aleady exists
        if ( !empty( $lead ) ) return self::update( $lead, $identity, $context, $confirmed );
        
        $item = get_post( $itemId );
        $itemTitle = !empty( $item ) ? $item->post_title : null;
        $postTitle = self::extract('postTitle', $context);
        $postUrl = self::extract('postUrl', $context); 
        
        $catcher = self::extract('_catcher', $identity);
        
        $name = self::extract('name', $identity);
        $family = self::extract('family', $identity);
        
        $displayName = self::extract('displayName', $identity );
        if ( empty( $displayName ) ) {
            
            if ( !empty( $name ) && !empty( $family ) ) {
                $displayName = $name . ' ' . $family;
            } elseif ( !empty( $name ) ) {
                $displayName = $name;
            } else {
                $displayName = $family;
            }
        }
        
        $data = array(
            'lead_display_name' => $displayName,
            'lead_name' => $name,
            'lead_family' => $family,
            'lead_email' => $email,
            'lead_date' => time(),
            'lead_post_id' => $postId,
            'lead_post_url' => $postUrl,
            'lead_post_title' => $postTitle,
            'lead_item_id' => $itemId,
            'lead_item_title' => $itemTitle,   
            'lead_confirmed' => $confirmed ? 1 : 0,
            'lead_catcher' => $catcher,
            'lead_social_profile' => $link
        );
        
        // else inserts a new lead
        $wpdb->insert( $wpdb->prefix . 'opanda_leads', $data, array(
         '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%d', '%s', '%d', '%s', '%s'
        ));
         
        return $wpdb->insert_id;
    }
    
    /**
     * Returns a lead by email or null.
     */
    public static function getByEmail( $email ) {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}opanda_leads WHERE lead_email = %s", $email ));
    }
    
    /**
     * Updates a given lead.
     */
    public static function update( $leadToUpdate, $identity, $context, $confirmed = false ) {
        if ( !$confirmed ) return;
        global $wpdb;
        
        $itemId = isset( $context['itemId'] ) ? intval( $context['itemId'] ) : 0;
        $postId = isset( $context['postId'] ) ? intval( $context['postId'] ) : null;
        
        // counts the number of confirmed emails (subscription)
        if ( $confirmed && !$leadToUpdate->lead_confirmed ) {
            OPanda_Stats::countMetrict( $itemId, $postId, 'email-confirmed');
        }

        $name = self::extract('name', $identity);
        $family = self::extract('family', $identity);
        $link = isset( $identity['link'] ) ? $identity['link'] : null;
        
        $displayName = self::extract('displayName', $identity );
        if ( empty( $displayName ) ) {
            
            if ( !empty( $name ) && !empty( $family ) ) {
                $displayName = $name . ' ' . $family;
            } elseif ( !empty( $name ) ) {
                $displayName = $name;
            } else {
                $displayName = $family;
            }
        }
        
        if ( !empty( $displayName ) ) {
            $data['lead_display_name'] = $displayName;
        }
        
        if ( !empty( $name ) ) {
            $data['lead_name'] = $name;
        }
        
        if ( !empty( $link ) ) {
            $data['lead_social_profile'] = $link;
        }
        
        $data['lead_confirmed'] = 1;
        
        $where = array(
            'lead_email' => $leadToUpdate->lead_email
        );
        
        // else inserts a new lead
        $wpdb->update( $wpdb->prefix . 'opanda_leads', $data, $where, array(
            '%s', '%s', '%s', '%d'
        ), array( '%s' ));
    }

    protected static function extract( $name, $source, $default = null ) {
        $value = isset( $source[$name] ) ? trim( $source[$name] ) : $default;
        if ( empty( $value ) ) $value = $default;
        return $value;
    }
    
    public static function getCount( $cache = true ) {
        global $wpdb;
        
        $count = null;
        
        if ( $cache ) {
            $count = get_transient('opanda_subscribers_count');
            if ( $count === 0 || !empty( $count ) ) return $count;
        }
        
        if( $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}opanda_leads'") === $wpdb->prefix . 'opanda_leads' ) {
            $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}opanda_leads" );
            set_transient('opanda_subscribers_count', $count, 60 * 5);
        }

        return $count;
    }
    
    public static function updateCount() {
        self::getCount( false );
    }
}