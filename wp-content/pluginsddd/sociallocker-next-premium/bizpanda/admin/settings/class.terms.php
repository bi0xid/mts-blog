<?php
/**
 * A class for the page providing the basic settings.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

/**
 * The page Basic Settings.
 * 
 * @since 1.0.0
 */
class OPanda_TermsSettings extends OPanda_Settings  {
 
    public $id = 'terms';
    
    /**
     * Sets notices.
     * 
     * @since 1.0.0
     * @return void
     */
    public function init() {
        
        if ( isset( $_GET['onp_table_cleared'] )) {
            $this->success = __('The data has been successfully cleared.', 'optinpanda');
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
        <p><?php _e('Select the pages which contains Terms of Use and Privacy Policy. It\'s not mandatory, but usually improves transparency and conversions.', 'optionpanda') ?></p>
        <?php
    }
    
    /**
     * Returns options for the Basic Settings screen. 
     * 
     * @since 1.0.0
     * @return void
     */
    public function getOptions() {
        global $optinpanda;

        $options = array();
        
        $pages = get_pages();
        $result = array();
        
        $result[] = array('0', '- none -');
        foreach( $pages as $page ) {
            $result[] = array($page->ID, $page->post_title . ' [ID=' . $page->ID . ']');
        }
        
        
        $options[] = array(
            'type' => 'separator'
        );
        
        $options[] = array(
            'type'      => 'dropdown',
            'name'      => 'terms_of_use',
            'data'      => $result,
            'title'     => __('Terms of Use', 'optinpanda'),
            'hint'      => __('Select a page which contains the "Terms of Use" of the plugin.<br />When you activated the plugin, we created one by default. Read and change it if required.', 'optinpanda'),
            'default'   => true
        );

        $options[] = array(
            'type'      => 'dropdown',
            'name'      => 'privacy_policy',
            'data'      => $result,
            'title'     => __('Privacy Policy', 'optinpanda'),
            'hint'      => __('Select a page which contains the "Privacy Policy" of your website.<br />When you activated the plugin, we created one by default. Read and change it if required.', 'optinpanda'),
            'default'   => true
        );
        
        $options[] = array(
            'type' => 'separator'
        );
        
        return $options;
    }
}

