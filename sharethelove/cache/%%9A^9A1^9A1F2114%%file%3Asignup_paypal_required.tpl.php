<?php /* Smarty version 2.6.14, created on 2014-02-12 19:51:43
         compiled from file:signup_paypal_required.tpl */ ?>

<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['signup_paypal_required_title']; ?>
</legend>     
<input type="hidden" name="pp" value="1">   
<div class="control-group">
    <label for="<?php echo $this->_tpl_vars['signup_paypal_required_account']; ?>
" class="control-label"><?php echo $this->_tpl_vars['signup_paypal_required_account']; ?>
</label>
    <div class="controls">              
     <input type="text" class="input-xlarge span12" name="pp_account" value="<?php echo $this->_tpl_vars['pp_account']; ?>
" />
     <span class="help-block"><?php echo $this->_tpl_vars['signup_paypal_required_notes']; ?>
</span>
    </div>
</div>