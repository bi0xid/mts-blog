<?php
/**
 * The file contains a short help info.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2014, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * Common Settings
 */
class OPanda_LeadsPage extends OPanda_AdminPage  {
 
    public function __construct( $plugin ) {   
        $this->menuPostType = OPANDA_POST_TYPE;
        $this->id = "leads";
        
        require_once OPANDA_BIZPANDA_DIR . '/admin/includes/leads.php';
        
        $count = OPanda_Leads::getCount();
        if ( empty( $count ) ) $count = '0';
        
        $this->menuTitle = sprintf( __('Leads (%d)', 'optinpanda'), $count );
        
        parent::__construct( $plugin );
    }
  
    public function assets($scripts, $styles) {
        $this->styles->add(OPANDA_BIZPANDA_URL . '/assets/admin/css/leads.010000.css'); 
        $this->scripts->add(OPANDA_BIZPANDA_URL . '/assets/admin/js/leads.010000.js'); 
        
        $this->scripts->request('jquery');
        
        $this->scripts->request( array( 
            'control.checkbox',
            'control.dropdown'
            ), 'bootstrap' );

        $this->styles->request( array( 
            'bootstrap.core', 
            'bootstrap.form-group',
            'bootstrap.separator',
            'control.dropdown',
            'control.checkbox',
            ), 'bootstrap' );
    }
    
    public function indexAction() {
        
        if(!class_exists('WP_List_Table')){
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        
        require_once( OPANDA_BIZPANDA_DIR . '/admin/classes/class.leads.table.php' );

        $table = new OPanda_LeadsListTable( array('screen' => 'bizpanda-leads') );
        $table->prepare_items();

        ?>
        <div class="wrap factory-fontawesome-320" id="opanda-leads-page">

            <h2>
                <?php _e('Leads', 'optinpanda') ?>
                <a href="<?php $this->actionUrl('export') ?>" class="add-new-h2"><?php _e( 'export', 'opanda' ); ?></a>
            </h2>
            
            <?php if ( BizPanda::isSinglePlugin() ) { ?>

                <?php if ( BizPanda::hasPlugin('optinpanda') ) { ?>
                    <p style="margin-top: 0px;"> <?php _e('This page shows contacts of visitors who opted-in or signed-in on your website through Email or Sign-In Lockers.', 'optinpanda'); ?></p>
                <?php } else { ?>
                    <p style="margin-top: 0px;"><?php printf( __('This page shows contacts of visitors who signed-in on your website through the <a href="%s">Sign-In Locker</a>.', 'optinpanda'), opanda_get_help_url('what-is-signin-locker') ); ?></p>
                <?php } ?>

            <?php } else { ?>
                <p style="margin-top: 0px;"> <?php _e('This page shows contacts of visitors who opted-in or signed-in on your website through Email or Sign-In Lockers.', 'optinpanda'); ?></p>
            <?php } ?>
        
            <?php
                $table->search_box(__('Search Leads', 'mymail'), 's');
                $table->views();
            ?>

            <form method="post" action="">
            <?php echo $table->display(); ?>
            </form>
        </div>
        <?php
        
        OPanda_Leads::updateCount();
    }
    
    public function exportAction() {
        global $bizpanda;
        
        $error = null;
        $warning = null;
        
        // getting a list of lockers
        
        $lockerIds = array();
        
        global $wpdb;
        $data = $wpdb->get_results(
            "SELECT l.lead_item_id AS locker_id, COUNT(l.ID) AS count, p.post_title AS locker_title "
           . "FROM {$wpdb->prefix}opanda_leads AS l "
           . "LEFT JOIN {$wpdb->prefix}posts AS p ON p.ID = l.lead_item_id "
           . "GROUP BY l.lead_item_id", ARRAY_A );
        
        $lockerList = array(
            array('all', __('Mark All', 'opanda') )
        );
        
        foreach( $data as $items ) {
            $lockerList[] = array( $items['locker_id'], $items['locker_title'] . ' (' . $items['count'] . ')');
            $lockerIds[] = $items['locker_id'];
        } 
        
        // default values
        
        $status = 'all';
        $fields = array('lead_email', 'lead_name', 'lead_family');
        $delimiter = ',';
                
        // exporting 
        
        if ( isset( $_POST['opanda_export'] ) ) {
            
            // - delimiter
            
            $delimiter = isset( $_POST['opanda_delimiter'] ) ? $_POST['opanda_delimiter'] : ',';
            if ( !in_array( $status, array(',', ';') ) ) $status = ',';
            
            // - channels
            
            $lockers = isset( $_POST['opanda_lockers'] ) ? $_POST['opanda_lockers'] : array();
            $lockerIds = array();
            foreach( $lockers as $lockerId ) {
                if ( 'all' == $lockerId ) continue;
                $lockerIds[] = intval( $lockerId );
            }
            
            // - status
            
            $status = isset( $_POST['opanda_status'] ) ? $_POST['opanda_status'] : 'all';
            if ( !in_array( $status, array('all', 'confirmed', 'not-confirmed') ) ) $status = 'all';

            // - fields
            
            $rawFields = isset( $_POST['opanda_fields'] ) ? $_POST['opanda_fields'] : array();
            $fields = array();
            
            foreach( $rawFields as $field ) {
                if ( !in_array( $field, array('lead_email', 'lead_display_name', 'lead_name', 'lead_family', 'lead_ip') ) ) continue;
                $fields[] = $field;
            } 
            
            if ( empty( $lockers) || empty( $fields ) ) {
                $error = __('Please make sure that you selected at least one channel and field.', 'opanda');
            } else {

                $sql = 'SELECT ' . implode(',', $fields) . ' FROM ' . $wpdb->prefix . 'opanda_leads WHERE lead_item_id IN (' . implode(',', $lockerIds) . ')';
                if ( 'all' != $status ) {
                    $sql .= ' AND lead_email_confirmed = '. ( ( 'confirmed' == $status ) ? '1' : '0' );
                }
                
                $result = $wpdb->get_results( $sql, ARRAY_A );
                if ( empty( $result ) ) {
                    $warning = __('No leads found. Please try to change the settings of exporting.', 'opanda');
                } else {
                    
                    $filename = 'leads-' . date('Y-m-d-H-i-s') . '.csv';
                    
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=" . $filename);
                    header("Cache-Control: no-cache, no-store, must-revalidate");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    
                    $output = fopen("php://output", "w");
                    foreach( $result as $row ) {
                       fputcsv($output, $row, $delimiter);
                    }
                    fclose($output);
                    
                    exit;
                }
            }
        }
        
        // creating a form

        $form = new FactoryForms327_Form(array(
            'scope' => 'opanda',
            'name'  => 'exporting'
        ), $bizpanda );
        
        $form->setProvider( new FactoryForms327_OptionsValueProvider(array(
            'scope' => 'opanda'
        )));

        $options = array(
            
            array(
                'type' => 'separator'
            ),    
            array(
                'type' => 'radio',
                'name' => 'format',
                'title' => __('Format', 'opanda'),
                'hint' => __('Only the CSV format is available currently.'),
                'data' => array(
                    array('csv', __('CSV File', 'opanda') )              
                ),
                'default' => 'csv'
            ),
            array(
                'type' => 'radio',
                'name' => 'delimiter',
                'title' => __('Delimiter', 'opanda'),
                'hint' => __('Choose a delimiter for a CSV document.'),
                'data' => array(
                    array(',', __('Comma', 'opanda') ),
                    array(';', __('Semicolon', 'opanda') )
                ),
                'default' => $delimiter
            ),
            array(
                'type' => 'separator'
            ),  
            array(
                'type' => 'list',
                'way' => 'checklist',
                'name' => 'lockers',
                'title' => __('Channels', 'opanda'),
                'hint' => __('Mark lockers which attracted leads you would like to export.'),
                'data' => $lockerList,
                'default' => implode(',', $lockerIds)
            ),   
            array(
                'type' => 'radio',
                'name' => 'status',
                'title' => __('Email Status', 'opanda'),
                'hint' => __('Choose the email status of leads to export.'),
                'data' => array(
                    array('all', __('All', 'opanda') ),
                    array('confirmed', __('Only Confirmed Emails', 'opanda') ),
                    array('not-confirmed', __('Only Not Confirmed', 'opanda') )
                ),
                'default' => $status
            ),
            array(
                'type' => 'separator'
            ),   
            array(
                'type' => 'list',
                'way' => 'checklist',
                'name' => 'fields',
                'title' => __('List of fields to export', 'opanda'),
                'data' => array(
                    array('lead_email', __('Email', 'opanda') ),
                    array('lead_display_name', __('Display Name', 'opanda') ),
                    array('lead_name', __('Firstname', 'opanda') ),
                    array('lead_family', __('Lastname', 'opanda') ),
                    array('lead_ip', __('IP', 'opanda') )  
                ),
                'default' => implode(',', $fields)
            ),
            array(
                'type' => 'separator'
            )
        );
        
        $form->add($options);
        ?>
        <div class="wrap" id="opanda-export-page">

            <h2>
                <?php _e('Exporting Leads', 'optinpanda') ?>
            </h2>
            <p style="margin-top: 0px;"> <?php _e('Select leads you would like to export and click the button "Export Leads".', 'optinpanda'); ?></p>
            
            <div class="factory-bootstrap-328 factory-fontawesome-320">
                
                <?php if ( $error ) { ?>
                <div class="alert alert-danger"><?php echo $error ?></div>
                <?php } ?>
                
                <?php if ( $warning ) { ?>
                <div class="alert alert-normal"><?php echo $warning ?></div>
                <?php } ?> 
                
                <form method="post" class="form-horizontal">
                    <?php $form->html(); ?>

                    <div class="form-group form-horizontal">
                        <label class="col-sm-2 control-label"> </label>
                        <div class="control-group controls col-sm-10">
                            <input name="opanda_export" class="btn btn-primary" type="submit" value="<?php _e('Export Leads', 'optinpanda') ?>"/>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
        <?php
    }
}

FactoryPages321::register($bizpanda, 'OPanda_LeadsPage');
