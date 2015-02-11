<?php
/**
 * Url Control
 * 
 * Main options:
 *  @see FactoryForms327_TextboxControl
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package factory-forms 
 * @since 1.0.0
 */

class FactoryForms327_UrlControl extends FactoryForms327_TextboxControl 
{
    public $type = 'url';
    
    /**
     * Adding 'http://' to the url if it was missed.
     * 
     * @since 1.0.0
     * @return string
     */
    public function getSubmitValue( $name, $subName  ) {
        $value = parent::getSubmitValue( $name, $subName );
        if ( !empty( $value ) && substr($value, 0, 4) != 'http' ) $value = 'http://' . $value;
        return $value;
    }
}
