<?php /* Smarty version 2.6.14, created on 2014-05-27 23:37:21
         compiled from file:account_commission_alert.tpl */ ?>

<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['commissionalert_title']; ?>
</legend>
<div class="well">
<?php echo $this->_tpl_vars['commissionalert_info']; ?>

</div>
<div class="block-help"><p><?php echo $this->_tpl_vars['commissionalert_hint']; ?>
</p></div>
<hr />
<div class="row-fluid">
    <div class="span8">
        <form method="POST" class="form-horizontal" action="commissionalert/download.php">
        <div class="control-group">
            <label class="control-label" ><?php echo $this->_tpl_vars['commissionalert_profile']; ?>
</label>
            <div class="controls">                           
                <input class="input-xlarge" type="text" size="20" value="<?php echo $this->_tpl_vars['sitename']; ?>
">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $this->_tpl_vars['commissionalert_username']; ?>
</label>
            <div class="controls">                           
                <input class="input-xlarge"  type="text" size="20" value="<?php echo $this->_tpl_vars['username']; ?>
">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $this->_tpl_vars['commissionalert_id']; ?>
</label>
            <div class="controls">                           
                <input class="input-xlarge"  type="text" size="20" value="<?php echo $this->_tpl_vars['link_id']; ?>
">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $this->_tpl_vars['commissionalert_source']; ?>
</label>
            <div class="controls">                           
                <input class="input-xlarge"  type="text" size="50" value="<?php echo $this->_tpl_vars['base_url']; ?>
/">
            </div>
        </div>
        <div class="control-group">
             <input type="hidden" name="affid" value="<?php echo $this->_tpl_vars['link_id']; ?>
">
             <label class="control-label"></label>
            <div class="controls">                           
                  <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['commissionalert_download']; ?>
">
            </div>
        </div>      
    </form>
    </div>
    <div class="span4">
        <img border="0" src="<?php echo $this->_tpl_vars['theme_folder']; ?>
/images/ca1.gif" width="148" height="59">
    </div>
</div>    