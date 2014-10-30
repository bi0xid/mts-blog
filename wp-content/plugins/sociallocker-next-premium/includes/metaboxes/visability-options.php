<?php #comp-page builds: premium, offline
/**
 * The file contains a class to configure the metabox Visibility Options.
 * 
 * Created via the Factory Metaboxes.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2013, OnePress Ltd
 * 
 * @package core 
 * @since 2.3.0
 */

/**
 * The class to configure the metabox Visibility Options.
 * 
 * @since 2.3.0
 */
class OnpSL_VisabilityOptionsMetaBox extends FactoryMetaboxes320_FormMetabox
{
    /**
     * A visible title of the metabox.
     * 
     * Inherited from the class FactoryMetabox.
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * 
     * @since 2.3.0
     * @var string
     */
    public $title;
    
    /**
     * A prefix that will be used for names of input fields in the form.
     * 
     * Inherited from the class FactoryFormMetabox.
     * 
     * @since 2.3.0
     * @var string
     */
    public $scope = 'sociallocker';
    
    /**
     * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * Inherited from the class FactoryMetabox.
     * 
     * @since 2.3.0
     * @var string
     */
    public $priority = 'core';
    
    /**
     * The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). 
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_meta_box
     * Inherited from the class FactoryMetabox.
     * 
     * @since 2.3.0
     * @var string
     */
    public $context = 'side';
    
    public function __construct( $plugin ) {
        parent::__construct( $plugin );
        
        $this->title = __('Visibility Options', 'sociallocker');
    }
    
    public $cssClass = 'factory-bootstrap-320';
    
    /**
     * Configures a form that will be inside the metabox.
     * 
     * @see FactoryMetaboxes320_FormMetabox
     * @since 1.0.0
     * 
     * @param FactoryForms320_Form $form A form object to configure.
     * @return void
     */ 
    public function form( $form ) {

        $form->add(array(  
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'hide_for_member',
                'title'     => __('Hide For Members', 'sociallocker'),
                'hint'      => __('If on, hides the locker for registered members.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/member-icon.png',
                'default'   => false
            ),
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'lock_delay',
                'title'     => __('Lock Delay', 'sociallocker'),
                'hint'      => __('If on, shows the locker only in posts older than specified age.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/icon-delay-lock.png',                
                'default'   => false
            ),
            array(
                'type'      => 'html',
                'html'      => array($this, 'htmlLockDelayOptions')
            ),
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'relock',
                'title'     => __('ReLock', 'sociallocker'),
                'hint'      => __('If on, being unlocked the locker will appear again after specified interval.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/icon-relock-3.png',                
                'default'   => false
            ),
            array(
                'type'      => 'html',
                'html'      => array($this, 'htmlReLockOptions')
            ),
            array(
                'type'      => 'checkbox',
                'way'       => 'buttons',
                'name'      => 'mobile',
                'title'     => __('Mobile', 'sociallocker'),
                'hint'      => __('If on, the locker will appear on mobile devices.', 'sociallocker'),
                'icon'      => ONP_SL_PLUGIN_URL . '/assets/admin/img/mobile-icon.png',
                'default'   => true
            )
        ));  
    }
        
    public function htmlLockDelayOptions() {
        $lockDelay = $this->provider->getValue('lock_delay', false);
        
        $interval = $this->provider->getValue('lock_delay_interval', 0);
        if ( $interval == 0 ) $interval = '';
        
        $units = $this->provider->getValue('lock_delay_interval_units', 'days');
        
        ?>
        <div class='onp-sl-sub <?php if ( !$lockDelay ) { echo 'hide'; } ?>' id='onp-sl-lock-delay-options'>
            <label class='control-label'><?php _e('The locker will appear in posts that are older than:', 'sociallocker') ?></label>
            <input type='text' class='form-control input' name='<?php echo $this->scope ?>_lock_delay_interval' value='<?php echo $interval ?>' />
            <select class='form-control' name='<?php echo $this->scope ?>_lock_delay_interval_units'>
                <option value='days' <?php selected('days', $units) ?>><?php _e('day(s)', 'sociallocker') ?></option>    
                <option value='hours' <?php selected('hours', $units) ?>><?php _e('hour(s)', 'sociallocker') ?></option>
                <option value='minute' <?php selected('hours', $units) ?>><?php _e('minute(s)', 'sociallocker') ?></option>     
            </select>
        </div>
        <?php
    }
    
    public function htmlReLockOptions() {
        $relock = $this->provider->getValue('relock', false);
        
        $interval = $this->provider->getValue('relock_interval', 0);
        if ( $interval == 0 ) $interval = '';
        
        $units = $this->provider->getValue('relock_interval_units', 'days');
        
        ?>
        <div class='onp-sl-sub <?php if ( !$relock ) { echo 'hide'; } ?>' id='onp-sl-relock-options'>
            <label class='control-label'><?php _e('The locker will reappear after:', 'sociallocker') ?></label>
            <input type='text' class='form-control input' name='<?php echo $this->scope ?>_relock_interval' value='<?php echo $interval ?>' />
            <select class='form-control' name='<?php echo $this->scope ?>_relock_interval_units'>
                <option value='days' <?php selected('days', $units) ?>><?php _e('day(s)', 'sociallocker') ?></option>    
                <option value='hours' <?php selected('hours', $units) ?>><?php _e('hour(s)', 'sociallocker') ?></option>
                <option value='minute' <?php selected('minute', $units) ?>><?php _e('minute(s)', 'sociallocker') ?></option>   
            </select>
            <p style="margin: 6px 0 0 0; font-size: 12px;"><?php _e('Any changes will apply only for new users.', 'sociallocker') ?></p>
        </div>
        <?php
    }    
    
    public function onSavingForm( $post_id) {
        parent::onSavingForm( $post_id );
        
        // saves delay lock options
        
        $delay = isset( $_POST[$this->scope . '_lock_delay'] ); 
        $interval = isset( $_POST[$this->scope . '_lock_delay_interval'] ) 
                ? intval( $_POST[$this->scope . '_lock_delay_interval'] )
                : 0;
        
        if ( $interval < 0 ) $interval = 0;
        
        $units = isset( $_POST[$this->scope . '_lock_delay_interval_units'] ) 
                ? $_POST[$this->scope . '_lock_delay_interval_units']
                : null;
        
        if ( !$units || !in_array($units, array('days', 'hours', 'minute') )) {
            $units = 'days';
        }
        
        if ( !$interval ) $_POST[$this->scope . '_lock_delay'] = null;
        if ( !$delay ) { 
            $interval = 0;
            $units = 'days';
        }
        
        $intervalInMinutes = $interval;
        if ( $units == 'days' ) $intervalInMinutes = 24 * 60 * $interval;
        if ( $units == 'hours' ) $intervalInMinutes = 60 * $interval;
        
        $this->provider->setValue('lock_delay_interval_in_seconds', $intervalInMinutes * 60 );
        $this->provider->setValue('lock_delay_interval', $interval);   
        $this->provider->setValue('lock_delay_interval_units', $units);  
        
        // saves relock options
        
        $delay = isset( $_POST[$this->scope . '_relock'] ); 
        $interval = isset( $_POST[$this->scope . '_relock_interval'] ) 
                ? intval( $_POST[$this->scope . '_relock_interval'] )
                : 0;
        
        if ( $interval < 0 ) $interval = 0;
        
        $units = isset( $_POST[$this->scope . '_relock_interval_units'] ) 
                ? $_POST[$this->scope . '_relock_interval_units']
                : null;
        
        if ( !$units || !in_array($units, array('days', 'hours', 'minute') )) {
            $units = 'days';
        }
        
        if ( !$interval ) $_POST[$this->scope . '_relock'] = null;
        if ( !$delay ) { 
            $interval = 0;
            $units = 'days';
        }
        
        $intervalInMinutes = $interval;
        if ( $units == 'days' ) $intervalInMinutes = 24 * 60 * $interval;
        if ( $units == 'hours' ) $intervalInMinutes = 60 * $interval;
        
        $this->provider->setValue('relock_interval_in_seconds', $intervalInMinutes * 60 );
        $this->provider->setValue('relock_interval', $interval);   
        $this->provider->setValue('relock_interval_units', $units);  
    }
}

FactoryMetaboxes320::register('OnpSL_VisabilityOptionsMetaBox', $sociallocker);