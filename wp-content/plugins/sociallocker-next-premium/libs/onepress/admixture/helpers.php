<?php
/**
 * Helpers Admixture
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2014, OnePress Ltd
 * 
 * @package onepress-admixture 
 * @since 1.0.0
 */

if (!function_exists('factory_run_code')) {
    
    /**
     * A global helper method to run code.
     * 
     * @since 1.0.0
     * @return mixed
     */
    function factory_run_code( $codeToRun ) {
        return eval( $codeToRun );
    }
}

if (!function_exists('factory_glob')) {
    
    /**
     * A global helper method to get global variable by its name.
     * 
     * @since 1.0.0
     * @return mixed
     */
    function factory_glob( $name, $default = null ) {
        return isset( $GLOBALS ) ? $GLOBALS[$name] : $default;
    } 
}