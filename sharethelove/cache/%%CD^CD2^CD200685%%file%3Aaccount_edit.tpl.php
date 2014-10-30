<?php /* Smarty version 2.6.14, created on 2014-05-27 22:28:10
         compiled from file:account_edit.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['display_edit_errors'] )): ?>
<br /><br /><br />
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4><?php echo $this->_tpl_vars['error_title']; ?>
</h4>
    <?php echo $this->_tpl_vars['error_list']; ?>

</div>   
<?php endif; ?>

<?php if (isset ( $this->_tpl_vars['edit_success'] )): ?>
<br /><br /><br />
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $this->_tpl_vars['edit_success']; ?>

</div>   
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:account_edit_custom.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<form method="POST" action="account.php" class="form-horizontal">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="page" value="17">
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;">General Preferences</legend>  
<div class="control-group">
    <label for="email" class="control-label">Email Language</label>
    <div class="controls">                  
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:account_edit_email_preferences.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>  
<?php if (isset ( $this->_tpl_vars['optionals_used'] )):  if (isset ( $this->_tpl_vars['row_email'] )): ?>
       <div class="control-group">
        <label for="email" class="control-label"><?php echo $this->_tpl_vars['edit_standard_email']; ?>
</label>
        <div class="controls">                  
          <input type="text" class="input-xxlarge span12" name="email" size="30" value="<?php echo $this->_tpl_vars['postemail']; ?>
"  tabindex="4">
        </div>
      </div>  
<?php endif; ?>
 <?php if (isset ( $this->_tpl_vars['row_company'] )): ?>
      <div class="control-group">
        <label for="company" class="control-label"><?php echo $this->_tpl_vars['edit_standard_company']; ?>
</label>
        <div class="controls">           
          <input type="text" class="input-xxlarge span12" name="company" size="30" value="<?php echo $this->_tpl_vars['postcompany']; ?>
"  tabindex="5">
        </div>
      </div>  
 <?php endif; ?>
 <?php if (isset ( $this->_tpl_vars['row_checks'] )): ?>
              <div class="control-group">
                <label for="payable" class="control-label"><?php echo $this->_tpl_vars['edit_standard_checkspayable']; ?>
</label>
                <div class="controls">             
                  <input type="text" class="input-xxlarge span12" name="payable" size="30" value="<?php echo $this->_tpl_vars['postchecks']; ?>
"  tabindex="6">
                </div>
              </div>  
<?php endif; ?>
 <?php if (isset ( $this->_tpl_vars['row_website'] )): ?>
          <div class="control-group">
            <label for="url" class="control-label"><?php echo $this->_tpl_vars['edit_standard_weburl']; ?>
</label>
            <div class="controls">           
              <input type="text" class="input-xxlarge span12" name="url" size="30" value="<?php echo $this->_tpl_vars['postwebsite']; ?>
"  tabindex="7">
            </div>
          </div>  
<?php endif; ?>
  <?php if (isset ( $this->_tpl_vars['row_taxinfo'] )): ?>
  <div class="control-group">
    <label for="tax_id_ssn" class="control-label"><?php echo $this->_tpl_vars['edit_standard_taxinfo']; ?>
</label>
    <div class="controls">             
      <input type="text" class="input-xxlarge span12" name="tax_id_ssn" size="30" value="<?php echo $this->_tpl_vars['posttax']; ?>
"  tabindex="8">
    </div>
  </div>  
  <?php endif;  endif; ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['edit_personal_title']; ?>
</legend>        
   <div class="control-group">
    <label for="f_name" class="control-label"><?php echo $this->_tpl_vars['edit_personal_fname']; ?>
</label>
    <div class="controls">              
      <input type="text" class="input-xxlarge span12" name="f_name"  value="<?php echo $this->_tpl_vars['postfname']; ?>
"  tabindex="9">
    </div>
  </div>
   <div class="control-group">
    <label for="l_name" class="control-label"><?php echo $this->_tpl_vars['edit_personal_lname']; ?>
</label>
    <div class="controls">            
      <input type="text" class="input-xxlarge span12" name="l_name"  value="<?php echo $this->_tpl_vars['postlname']; ?>
"  tabindex="10">
    </div>
  </div>
 
     <div class="control-group">
    <label for="phone" class="control-label"><?php echo $this->_tpl_vars['edit_personal_phone']; ?>
</label>
    <div class="controls">              
      <input type="text" class="input-xxlarge span12" name="phone"  value="<?php echo $this->_tpl_vars['postphone']; ?>
"  tabindex="15">
    </div>
  </div>
  <div class="control-group">
    <label for="fax" class="control-label"><?php echo $this->_tpl_vars['edit_personal_fax']; ?>
</label>
    <div class="controls">             
      <input type="text" class="input-xxlarge span12" name="fax"  value="<?php echo $this->_tpl_vars['postfaxnm']; ?>
"  tabindex="16">
    </div>
  </div>
 
  <div class="control-group">
    <label for="address_one" class="control-label"><?php echo $this->_tpl_vars['edit_personal_addr1']; ?>
</label>
    <div class="controls">           
      <input type="text" class="input-xxlarge span12" name="address_one"  value="<?php echo $this->_tpl_vars['postaddr1']; ?>
"  tabindex="11">
    </div>
  </div>
  <div class="control-group">
    <label for="address_two" class="control-label"><?php echo $this->_tpl_vars['edit_personal_addr2']; ?>
</label>
    <div class="controls">             
      <input type="text" class="input-xxlarge span12" name="address_two"  value="<?php echo $this->_tpl_vars['postaddr2']; ?>
"  tabindex="12">
    </div>
  </div>
  <div class="control-group">
    <label for="city" class="control-label"><?php echo $this->_tpl_vars['edit_personal_city']; ?>
</label>
    <div class="controls">            
      <input type="text" class="input-xxlarge span12" name="city"  value="<?php echo $this->_tpl_vars['postcity']; ?>
"  tabindex="13">
    </div>
  </div>
  <div class="control-group">
    <label for="state" class="control-label"><?php echo $this->_tpl_vars['edit_personal_state']; ?>
</label>
    <div class="controls">              
      <input type="text" class="input-xxlarge span12" name="state"  value="<?php echo $this->_tpl_vars['poststate']; ?>
"  tabindex="14">
    </div>
  </div>
    
     <div class="control-group">
    <label for="zip" class="control-label"><?php echo $this->_tpl_vars['edit_personal_zip']; ?>
</label>
    <div class="controls">            
      <input type="text" class="input-xxlarge span12" name="zip"  value="<?php echo $this->_tpl_vars['postzip']; ?>
"  tabindex="17">
    </div>
  </div>
   
  <div class="control-group">
    <label for="countries" class="control-label"><?php echo $this->_tpl_vars['edit_personal_country']; ?>
</label>
    <div class="controls">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:account_edit_countries.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>
<?php if (isset ( $this->_tpl_vars['paypal_required'] )):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:account_edit_paypal_required.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif;  if (isset ( $this->_tpl_vars['paypal_optional'] )):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:account_edit_paypal_optional.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
 <div class="control-group">
    <label for="" class="control-label"></label>
    <div class="controls">
       <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['edit_button']; ?>
">
    </div>
</div>
</form>