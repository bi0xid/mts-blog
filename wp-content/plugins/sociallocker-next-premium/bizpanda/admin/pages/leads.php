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
        
        $this->menuTitle = sprintf( __('Users & Leads (%d)', 'optinpanda'), $count );
        
        parent::__construct( $plugin );
    }
  
    public function assets($scripts, $styles) {
        $this->styles->add(OPANDA_BIZPANDA_URL . '/assets/admin/css/leads.010000.css'); 
    }
    
    public function indexAction() {
        
        if(!class_exists('WP_List_Table')){
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        
        require_once( OPANDA_BIZPANDA_DIR . '/admin/pages/leads/class.leads-table.php' );

        $table = new OPanda_LeadsListTable( array('screen' => 'bizpanda-leads') );
        $table->prepare_items();

        ?>
        <div class="wrap factory-fontawesome-320" id="opanda-leads-page">
            
            <h2><?php _e('Users & Leads', 'optinpanda') ?></h2>
            <p style="margin-top: 0px;"> <?php _e('This page contains a list of the registered or/and subscribed users. Currently it does not support importing. A bit later such the ability will be added.', 'optinpanda'); ?></p>
            
            <?php echo $table->display(); ?>
        </div>
        <?php
        
        OPanda_Leads::updateCount();
    }
}

FactoryPages321::register($bizpanda, 'OPanda_LeadsPage');
