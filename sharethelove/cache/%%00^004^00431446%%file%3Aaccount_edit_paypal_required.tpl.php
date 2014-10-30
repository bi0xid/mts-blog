<?php /* Smarty version 2.6.14, created on 2014-05-27 22:28:10
         compiled from file:account_edit_paypal_required.tpl */ ?>

<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['edit_paypal_required_account']; ?>
</legend>     
<input type="hidden" name="pp" value="1">   
<div class="control-group">
    <label for="<?php echo $this->_tpl_vars['edit_paypal_required_account']; ?>
" class="control-label"><?php echo $this->_tpl_vars['edit_paypal_required_account']; ?>
</label>
    <div class="controls">              
     <input type="text" class="input-xlarge" name="pp_account" value="<?php echo $this->_tpl_vars['pp_account']; ?>
" />
     <a href="http://www.paypal.com/" target="_blank"><img border="0" src="<?php echo $this->_tpl_vars['theme_folder']; ?>
/images/paypal_small.gif" width="52" height="15"></a>
     <span class="help-block"><?php echo $this->_tpl_vars['edit_paypal_required_notes']; ?>
</span>
    </div>
</div>