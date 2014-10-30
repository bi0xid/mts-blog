<?php /* Smarty version 2.6.14, created on 2014-02-12 17:52:29
         compiled from contact.tpl */ ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container">





 <div class="container-fluid">

      <div class="row-fluid">

            <div class="span4">

                <div class="well">

                    <legend><img border="0" src="<?php echo $this->_tpl_vars['theme_folder']; ?>
/images/contact.gif" width="32" height="32"/> <?php echo $this->_tpl_vars['contact_left_column_title']; ?>
</legend>                   

                    <p style="color:<?php echo $this->_tpl_vars['gb_text_color']; ?>
;"><?php echo $this->_tpl_vars['contact_left_column_text']; ?>
</p>

                </div>

            </div>

            <div class="span8">                

            <form name="contact_form" method="POST" action="contact.php" class="form-horizontal">

            <input type="hidden" name="email_contact" value="1"/>

                <fieldset>                        

                        <legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['contact_title_display']; ?>
</legend>

                        <?php if (isset ( $this->_tpl_vars['display_contact_errors'] )): ?>

                            <div class="alert alert-error">

                                <button type="button" class="close" data-dismiss="alert">&times;</button>

                                <h4><?php echo $this->_tpl_vars['error_title']; ?>
</h4>

                                <?php echo $this->_tpl_vars['error_list']; ?>


                            </div>                           

                        <?php endif; ?>

						<?php if (isset ( $this->_tpl_vars['contact_email_received'] )): ?>

						<div class="alert alert-success">

						<button type="button" class="close" data-dismiss="alert">&times;</button>

						<?php echo $this->_tpl_vars['contact_received_display']; ?>


						</div>   

						<?php endif; ?>

                         <div class="control-group">

                            <label class="control-label" ><?php echo $this->_tpl_vars['contact_name_display']; ?>
</label>

                            <div class="controls">                           

                                <input type="text" name="name" class="input-xlarge span12" value="<?php echo $this->_tpl_vars['contact_name']; ?>
"/>

                            </div>

                          </div>

                          <div class="control-group">

                            <label class="control-label" ><?php echo $this->_tpl_vars['contact_email_display']; ?>
</label>

                            <div class="controls">                           

                                <input type="text" class="input-xlarge span12" name="email" value="<?php echo $this->_tpl_vars['contact_email']; ?>
"/>

                            </div>

                          </div>

                          <div class="control-group">

                            <label class="control-label" ><?php echo $this->_tpl_vars['contact_message_display']; ?>
</label>

                            <div class="controls">                           

                                <textarea name="message" class="input-xlarge span12" rows="6"><?php echo $this->_tpl_vars['contact_message']; ?>
</textarea>

                            </div>

                          </div>                         

                          <?php if (isset ( $this->_tpl_vars['security_required'] )): ?>
	                          <?php if ($this->_tpl_vars['security_required']): ?>
	
	                          <div class="control-group">
	
	                            <label class="control-label" ><?php echo $this->_tpl_vars['signup_security_code']; ?>
</label>
	
    <div class="controls">      

      <input class="input-xlarge span4" id="security_code" name="security_code" type="text" />

    </div>

    <div class="controls" style="margin-top:20px;">      

      <?php echo $this->_tpl_vars['captcha_image']; ?>


    </div>                        
	
	                          </div>
	
	                          <?php endif; ?>
                          <?php endif; ?>

                           <div class="control-group">

                          <?php if (! isset ( $this->_tpl_vars['contact_email_received'] )): ?>                         

                          <label class="control-label" ></label>

                          <div class="controls">                           

                                <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['contact_button_display']; ?>
"/>   

                            </div>                  

                                                   

                         <?php endif; ?>

                        </div>

                </fieldset>    

            </form>        

    </div>

</div>

</div>

</div>


    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>