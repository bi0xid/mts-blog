<?php

class JPIBFI_Lightbox_Options extends JPIBFI_Options {

    protected static $instance = null;

    protected $admin_advanced_options = null;

    private function __construct() {
        add_action( 'admin_init', array( $this, 'init' ) );
    }

    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function get_default_options(){
        $defaults = array(
            'enabled' => '0',
            'description_option'  => '1'
        );

        return apply_filters( 'jpibfi_default_lightbox_options', $defaults );
    }

    static function get_option_name(){
        return 'jpibfi_lightbox_options';
    }

    /* Defines selection options section and adds all required fields	 */
    public function init() {

        // First, we register a section.
        add_settings_section(
            'lightbox_options_section',
            __( 'Lightbox Settings', 'jquery-pin-it-button-for-images' ),
            array( $this, 'section_name_callback' ),
            'jpibfi_lightbox_options'
        );

        add_settings_field(
            'enabled',
            __( 'Enabled', 'jquery-pin-it-button-for-images' ),
            array( $this, 'enabled_callback' ),
            'jpibfi_lightbox_options',
            'lightbox_options_section',
            array(
                __( 'Activate lightbox in posts', 'jquery-pin-it-button-for-images' )
            )
        );

        add_settings_field(
            'description_option',
            __( 'Description source', 'jquery-pin-it-button-for-images' ),
            array( $this, 'description_option_callback' ),
            'jpibfi_lightbox_options',
            'lightbox_options_section',
            array(
                __( 'From where the lightbox description should be taken. Please note that "Image description" works properly only for images that were added to your Media Library.', 'jquery-pin-it-button-for-images' ),
            )
        );

        add_settings_field(
            'footer',
            '',
            array( $this, 'footer_callback' ),
            'jpibfi_lightbox_options',
            'lightbox_options_section',
            array(
                __( 'Lightbox module uses Colorbox. Visit <a href="http://www.jacklmoore.com/colorbox/" target="_blank">this page</a> to learn more about Colorbox.', 'jquery-pin-it-button-for-images' ),
            )
        );

        register_setting(
            'jpibfi_lightbox_options',
            'jpibfi_lightbox_options'
        );
    }

    public function section_name_callback() {
        echo '<p>' . __('Lightbox settings', 'jquery-pin-it-button-for-images') . '</p>';
    }

    public function enabled_callback( $args ){
        $options = $this->get_options();
        $enabled = JPIBFI_Admin_Utilities::exists_and_equal_to( $options, 'enabled', '1' );

        echo '<input type="checkbox" id="debug" name="jpibfi_lightbox_options[enabled]" value="1" ' . checked( "1", $enabled, false ) . '>';
        echo JPIBFI_Admin_Utilities::create_description( $args[0] );
    }

    public function description_option_callback( $args ) {
        $options = $this->get_options();

        $description_option = $options[ 'description_option' ];
        ?>

        <select id="description_option" name="jpibfi_lightbox_options[description_option]">
            <option value="1" <?php selected ( "1", $description_option ); ?>><?php _e( 'Page title', 'jquery-pin-it-button-for-images' ); ?></option>
            <option value="2" <?php selected ( "2", $description_option ); ?>><?php _e( 'Page description (excerpt)', 'jquery-pin-it-button-for-images' ); ?></option>
            <option value="3" <?php selected ( "3", $description_option ); ?>><?php _e( 'Image title or (if title not available) alt attribute', 'jquery-pin-it-button-for-images' ); ?></option>
            <option value="4" <?php selected ( "4", $description_option ); ?>><?php _e( 'Site title (Settings->General)', 'jquery-pin-it-button-for-images' ); ?></option>
            <option value="5" <?php selected ( "5", $description_option ); ?>><?php _e( 'Image description', 'jquery-pin-it-button-for-images' ); ?></option>
            <option value="6" <?php selected ( "6", $description_option ); ?>><?php _e( 'Image alt attribute', 'jquery-pin-it-button-for-images' ); ?></option>
        </select>

        <?php
        echo JPIBFI_Admin_Utilities::create_description( $args[0] );
    }

    public function footer_callback($args){
        echo '<span style="font-size: 18px">' . $args[0] . '</span>';
    }
}

add_action( 'plugins_loaded', array( 'JPIBFI_Lightbox_Options', 'get_instance' ) );