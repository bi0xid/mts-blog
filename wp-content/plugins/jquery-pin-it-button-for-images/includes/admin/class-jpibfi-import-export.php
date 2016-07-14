<?php

class JPIBFI_Import_Export {

    protected static $instance = null;

    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct(){
        add_filter( 'export_args', array( $this, 'export_args' ) );
        add_action( 'export_wp', array( $this, 'export_wp' ) );
        add_action( 'admin_init', array( $this, 'initialize' ) );
    }

    private function error_message( $message, $details = '' ) {
        echo '<div class="error notice is-dismissible"><p><strong>' . $message . '</strong>';
        if ( ! empty( $details ) ) {
            echo '<br />' . $details;
        }
        echo '</p></div>';
        return false;
    }

    private function success_message(){
        echo '<div class="updated notice is-dismissible"><p><strong>';
        _e('Import successful', 'jquery_pin_it_button_for_images');
        echo '</strong></p></div>';
    }

    /**
     * @param  array $args The export args being filtered.
     * @return array The (possibly modified) export args.
     */
    public function export_args( $args ) {
        if ( ! empty( $_GET['content'] ) && 'jpibfi' == $_GET['content'] ) {
            return array( 'jpibfi' => true );
        }
        return $args;
    }


    /**
     * Export options as a JSON file if that's what the user wants to do.
     *
     * @param  array $args The export arguments.
     * @return void
     */
    public function export_wp( $args ) {
        if (empty($args['jpibfi']))
            return;

        $filename = 'jpibfi_settings_' . date( 'Y-m-d' ) . '.json';

        header( 'Content-Description: File Transfer' );
        header( 'Content-Disposition: attachment; filename=' . $filename );
        header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ), true );

        $option_names = array();
        $option_names[] = JPIBFI_Selection_Options::get_option_name();
        $option_names[] = JPIBFI_Visual_Options::get_option_name();
        $option_names[] = JPIBFI_Advanced_Options::get_option_name();

        $export_options = array();

        foreach ( $option_names as $option_name ) {

            $option_value = get_option( $option_name );
            if ( $option_value !== false ) {
                $export_options[ $option_name ] = maybe_serialize( $option_value );
            }
        }
        $JSON_PRETTY_PRINT = defined( 'JSON_PRETTY_PRINT' ) ? JSON_PRETTY_PRINT : null;
        echo json_encode( array( 'options' => $export_options ), $JSON_PRETTY_PRINT );
        exit;
    }

    public function handle_import(){
        check_admin_referer( 'import-upload' );
        $file = wp_import_handle_upload();

        if ( isset( $file['error'] ) ) {
            return $this->error_message(
                __( 'Sorry, there has been an error.', 'jquery_pin_it_button_for_images' ),
                esc_html( $file['error'] )
            );
        }

        if ( ! isset( $file['file'], $file['id'] ) ) {
            return $this->error_message(
                __( 'Sorry, there has been an error.', 'jquery-pin-it-button-for-images' ),
                __( 'The file did not upload properly. Please try again.', 'jquery-pin-it-button-for-images' )
            );
        }

        if ( ! file_exists( $file['file'] ) ) {
            wp_import_cleanup( $file['id'] );
            return $this->error_message(
                __( 'Sorry, there has been an error.', 'jquery-pin-it-button-for-images' ),
                sprintf( __( 'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'jquery-pin-it-button-for-images' ), esc_html( $file['file'] ) )
            );
        }

        if ( ! is_file( $file['file'] ) ) {
            wp_import_cleanup( $file['id'] );
            return $this->error_message(
                __( 'Sorry, there has been an error.', 'jquery-pin-it-button-for-images' ),
                __( 'The path is not a file, please try again.', 'jquery-pin-it-button-for-images' )
            );
        }

        $file_contents = file_get_contents( $file['file'] );
        $data = json_decode( $file_contents, true );
        wp_import_cleanup( $file['id']);

        $options_to_import = $data['options'];
        foreach ( (array)$options_to_import as $option_name => $option_value ) {

            $val= maybe_unserialize( $option_value );
            update_option( $option_name, $val );
            //var_dump($option_name, get_option($option_name), $val);
        }
        $this->success_message();
    }

    public function initialize(){

        add_settings_section(
            'import_export_section',
            __( 'Import/Export Settings', 'jquery-pin-it-button-for-images' ),
            '__return_false',
            'jpibfi_import_export_options'
        );

        add_settings_field(
            'Export',
            __( 'Export', 'jquery-pin-it-button-for-images' ),
            array( $this, 'export_callback' ),
            'jpibfi_import_export_options',
            'import_export_section',
            array()
        );

        add_settings_field(
            'Import',
            __( 'Import', 'jquery-pin-it-button-for-images' ),
            array( $this, 'import_callback' ),
            'jpibfi_import_export_options',
            'import_export_section',
            array()
        );

        register_setting(
            'jpibfi_import_export_options',
            'jpibfi_import_export_options'
        );
    }

    public function export_callback( $args ){

        echo '<a class="button button-primary" href="' . admin_url('export.php?download=true&content=jpibfi'). '">'
                .__('Download Export File', 'jquery-pin-it-button-for-images')
            .'</a>';

    }

    public function import_callback(){
        _e( 'Choose a JSON (.json) file to upload, then click Upload file and import.', 'jquery-pin-it-button-for-images' );
        wp_import_upload_form( 'options-general.php?page=jpibfi_settings&tab=import_export');
    }
}


add_action( 'plugins_loaded', array( 'JPIBFI_Import_Export', 'get_instance' ) );