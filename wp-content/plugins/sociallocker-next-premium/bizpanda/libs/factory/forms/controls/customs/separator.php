<?php
/**
 * Html Markup
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package factory-forms 
 * @since 1.0.0
 */

class FactoryForms327_Separator extends FactoryForms327_CustomElement
{
    public $type = 'separator';
    
    /**
     * Shows the html markup of the element.
     * 
     * @since 1.0.0
     * @return void
     */
    public function html( ) {
        ?>
        <div <?php $this->attrs()?>></div>
        <?php
    }
}
