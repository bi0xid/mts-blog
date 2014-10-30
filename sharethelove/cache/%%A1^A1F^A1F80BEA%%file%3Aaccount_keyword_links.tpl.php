<?php /* Smarty version 2.6.14, created on 2014-05-27 21:55:37
         compiled from file:account_keyword_links.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['custom_links_enabled'] )): ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['keyword_title']; ?>
</legend>
<?php echo $this->_tpl_vars['keyword_info']; ?>
<br /><br />
<table class="table table-bordered">
    <tr>
      <td width="25%" colspan="2"><strong><?php echo $this->_tpl_vars['keyword_heading']; ?>
</strong></td>
    </tr>
    <tr>
      <td width="25%"><strong><?php echo $this->_tpl_vars['keyword_tracking']; ?>
 1</strong></td>
      <td width="75%">tid1</td>
    </tr>
    <tr>
      <td width="25%"><strong><?php echo $this->_tpl_vars['keyword_tracking']; ?>
 2</strong></td>
      <td width="75%">tid2</td>
    </tr>
    <tr>
      <td width="25%"><strong><?php echo $this->_tpl_vars['keyword_tracking']; ?>
 3</strong></td>
      <td width="75%">tid3</td>
    </tr>
    <tr>
      <td width="25%"><strong><?php echo $this->_tpl_vars['keyword_tracking']; ?>
 4</strong></td>
      <td width="75%">tid4</td>
    </tr>
</table>
  
<?php echo $this->_tpl_vars['keyword_build']; ?>
<br />
<input class="input-block-level" style="background-color:#f2f6ff;" type="text" name="sub_link" value="<?php echo $this->_tpl_vars['custom_keyword_linkurl']; ?>
"/><br />
<?php echo $this->_tpl_vars['keyword_example']; ?>
: <?php echo $this->_tpl_vars['custom_keyword_linkurl']; ?>
&tid1=<b>google</b><br />
<a href="http://www.idevlibrary.com/docs/Custom_Links.pdf" target="_blank" class="btn btn-mini btn-primary"><b><?php echo $this->_tpl_vars['keyword_tutorial']; ?>
</b></a>
<?php endif; ?>