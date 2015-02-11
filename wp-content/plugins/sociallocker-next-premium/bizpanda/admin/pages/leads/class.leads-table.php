<?php

class OPanda_LeadsListTable extends WP_List_Table
{
    
    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    function get_columns() {
        
        return $columns = array(
           'opanda_lead_checkbox' => '',
           'opanda_lead_email' => __('Email', 'optinpanda'),
           'opanda_lead_how' => __('How', 'optinpanda'),   
           'opanda_lead_where' => __('Where', 'optinpanda'),
           'opanda_lead_date' => __('When', 'optinpanda'),
           'opanda_lead_confirmed' => __('Confirmed', 'optinpanda'),
        );
    }
    
    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns() {
        
       return $sortable = array(
           'opanda_lead_email' => 'lead_email',
           'opanda_lead_name' => 'lead_name',
           'opanda_lead_date' => 'lead_date'  
       );
    }
    
    /**
     * Prepare the table with different parameters, pagination, columns and table elements
     */
    function prepare_items() {
        global $wpdb, $_wp_column_headers;
        
        $query = "SELECT * FROM {$wpdb->prefix}opanda_leads";

        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY ' . $orderby . ' ' . $order; }

        $totalitems = $wpdb->query($query);
        $perpage = 50;

        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
        if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }
        $totalpages = ceil($totalitems/$perpage);
        
        if(!empty($paged) && !empty($perpage)){
            $offset=($paged-1)*$perpage;
            $query.=' LIMIT '.(int)$offset.','.(int)$perpage;
        }

        $this->set_pagination_args( array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage,
        ));
        
        $this->items = $wpdb->get_results($query);
    }
    
    /**
     * Display the rows of records in the table
     * @return string, echo the markup of the rows
     */
    function display_rows() {

        $records = $this->items;
        list( $columns, $hidden ) = $this->get_column_info();

        if( empty($records) ) return;
        foreach( $records as $record ){

            echo '<tr id="record_'.$record->ID.'">';
            foreach ( $columns as $columnName => $columnTitle ) {

                //Style attributes for each col
                $class = "class='$columnName column-$columnName'";
                $style = "";

                if ( in_array( $columnName, $hidden ) ) $style = ' style="display:none;"';
                $attributes = $class . $style;

                echo '<td '.$attributes.'>';

                $method = str_replace( 'Opanda', '', 'show' . $this->toCamelCase( $columnName, true ) );

                if ( method_exists($this, $method) ) call_user_func(array( $this, $method), $record );
                else call_user_func (array( $this, 'showColumnValue'), $columnName, $record );

                echo '</td>';
            }

        //Close the line
        echo'</tr>';
        }
    }
    
    function toCamelCase( $str, $capitalise_first_char = false ) {
        if( $capitalise_first_char ) $str[0] = strtoupper($str[0]);
        
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }
    
    public function showLeadCheckbox( $record ) {
        echo '<input type="checkbox" />';
    }
    
    public function showLeadEmail( $record ) {
        
        $displayName = !empty( $record->lead_display_name ) 
            ? $record->lead_display_name
            : '<i>' . __('(no name)', 'optinpanda') . '</i>';
        
        if ( empty( $record->lead_social_profile ) ) {
            echo $displayName . '<br />';    
        } else {
            echo '<a href="' . $record->lead_social_profile . '" target="_blank">' . $displayName . '</a><br />';    
        }

        echo '<strong>' . $record->lead_email . '</strong>';
    }

    public function showLeadHow( $record ) {
        global $optinpanda;
        
        $catcher = $record->lead_catcher;
        switch( $catcher ) {
            case 'form':
                $control = __('Form', 'optinapanda');
            break;
            case 'facebook':
                $control = __('Facebook', 'optinapanda');
            break; 
            case 'twitter':
                $control = __('Twitter', 'optinapanda');
            break; 
            case 'google':
                $control = __('Google', 'optinapanda');
            break;
            case 'linkedin':
                $control = __('LinkedIn', 'optinapanda');
            break;
            default: 
                $control = null;
            break;
        }
        
        $itemId = $record->lead_item_id;
        $itemTitle = $record->lead_item_title;

        $item = get_post( $itemId );
        
        if ( !empty( $item ) ) $itemTitle = $item->post_title;
        $itemTitle = '<a href="' . opanda_get_admin_url('stats', array('opanda_id' => $itemId)) . '"><strong>' . $itemTitle. '</strong></a>';
 
        if ( !empty( $control ) ) {
            $control = $control;
            $text = sprintf( __("Via %s (%s)", 'optinpanda'), $itemTitle, $control );
        } else {
            $text = sprintf( __("Via %s", 'optinpanda'), $itemTitle );
        }
        
        echo $text;
    }
    
    public function showLeadWhere( $record ) {

        $postUrl = $record->lead_post_url;
        $postTitle = $record->lead_post_title;

        $post = get_post( $record->lead_post_id );

        if ( !empty( $post) ){
            $postUrl = get_permalink( $post->ID );
            $postTitle = $post->post_title;
        }
        
        if ( empty( $postTitle) ) $postTitle = '<i>' . __('(no title)', 'optinpanda') . '</i>';

        ?>
        <a href="<?php echo $postUrl ?>"><strong><?php echo $postTitle ?></strong></a>
        <?php
    }
    
    public function showLeadDate( $record ) {

        $t_time = get_the_time( 'Y/m/d g:i:s A' );
        $m_time = $record->lead_date;
        $time_diff = time() - $m_time;

        if ( $time_diff > 0 && $time_diff < 24*60*60 )
            $h_time = sprintf( '%s ago', human_time_diff( $m_time ) );
        else
            $h_time = date( 'Y/m/d', $m_time );
        
        echo '<abbr title="' . esc_attr( $t_time ) . '">' . $h_time . '</abbr><br />';
    }
    
    public function showLeadConfirmed( $record ) {
        
        if ( $record->lead_confirmed) {
            ?><i title="<?php _e('This email is really owned by this user.', 'optinpanda') ?>"><?php _e('- yes -', 'optinapnda') ?></i><?php
        } else {
            ?><i title="<?php _e('This email is not confirmed.', 'optinpanda') ?>"><?php _e('- no -', 'optinapnda') ?></i><?php
        }
        ?>
        <?php
    }
    
    public function showColumnValue() {
        
    }
}
 