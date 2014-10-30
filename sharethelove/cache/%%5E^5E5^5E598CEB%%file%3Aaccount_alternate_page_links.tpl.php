<?php /* Smarty version 2.6.14, created on 2014-05-27 23:21:10
         compiled from file:account_alternate_page_links.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['alternate_keywords_enabled'] )):  if (isset ( $this->_tpl_vars['display_custom_success'] )): ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>   
<h4><?php echo $this->_tpl_vars['custom_success_title']; ?>
</h4> 
<?php echo $this->_tpl_vars['custom_success_message']; ?>

</div> 
<?php elseif (isset ( $this->_tpl_vars['display_custom_errors'] )): ?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>   
<h4><?php echo $this->_tpl_vars['custom_error_title']; ?>
</h4> 
<?php echo $this->_tpl_vars['custom_error_list']; ?>

</div> 
<?php endif; ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['alternate_title']; ?>
</legend>
<form action="account.php" method="post">
<input type="hidden" name="create_alternate" value="1">
<input type="hidden" name="page" value="35">
<h4><?php echo $this->_tpl_vars['alternate_option_1']; ?>
</h4>
<div class="help-block">
<p><?php echo $this->_tpl_vars['alternate_info_1']; ?>
</p>
</div>
<div class="row-fluid">
    <div class="span9">
        <input class="input-xxlarge" type="text" name="custom_link" value="http://" />
    </div>
    <div class="span3">
       <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['alternate_button']; ?>
" name="<?php echo $this->_tpl_vars['alternate_button']; ?>
">
    </div>
</div>
</form>
<h5><?php echo $this->_tpl_vars['alternate_links_heading']; ?>
</h5>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['clinks_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['nr']['show'] = true;
$this->_sections['nr']['max'] = $this->_sections['nr']['loop'];
$this->_sections['nr']['step'] = 1;
$this->_sections['nr']['start'] = $this->_sections['nr']['step'] > 0 ? 0 : $this->_sections['nr']['loop']-1;
if ($this->_sections['nr']['show']) {
    $this->_sections['nr']['total'] = $this->_sections['nr']['loop'];
    if ($this->_sections['nr']['total'] == 0)
        $this->_sections['nr']['show'] = false;
} else
    $this->_sections['nr']['total'] = 0;
if ($this->_sections['nr']['show']):

            for ($this->_sections['nr']['index'] = $this->_sections['nr']['start'], $this->_sections['nr']['iteration'] = 1;
                 $this->_sections['nr']['iteration'] <= $this->_sections['nr']['total'];
                 $this->_sections['nr']['index'] += $this->_sections['nr']['step'], $this->_sections['nr']['iteration']++):
$this->_sections['nr']['rownum'] = $this->_sections['nr']['iteration'];
$this->_sections['nr']['index_prev'] = $this->_sections['nr']['index'] - $this->_sections['nr']['step'];
$this->_sections['nr']['index_next'] = $this->_sections['nr']['index'] + $this->_sections['nr']['step'];
$this->_sections['nr']['first']      = ($this->_sections['nr']['iteration'] == 1);
$this->_sections['nr']['last']       = ($this->_sections['nr']['iteration'] == $this->_sections['nr']['total']);
?>
<p><?php echo $this->_tpl_vars['clinks_results'][$this->_sections['nr']['index']]['clink_url']; ?>
</p>
<p><input class="input-xxlarge" type="text" name="sub_link" style="background-color:#f2f6ff;" value="<?php echo $this->_tpl_vars['clinks_results'][$this->_sections['nr']['index']]['clink_linkurl']; ?>
" /> [<a href="account.php?page=35&custom_remove=<?php echo $this->_tpl_vars['clinks_results'][$this->_sections['nr']['index']]['clink_id']; ?>
"><?php echo $this->_tpl_vars['alternate_links_remove']; ?>
</a>]</p>
<?php endfor; else: ?>
<p><?php echo $this->_tpl_vars['alternate_none']; ?>
</p>
<?php endif; ?>
<p><?php echo $this->_tpl_vars['alternate_links_note']; ?>
</p>
<p><a href="http://www.idevlibrary.com/docs/Custom_Links.pdf" target="_blank" class="btn btn-small btn-success"><?php echo $this->_tpl_vars['alternate_tutorial']; ?>
</a></p>
<div class="row-fluid">
<div class="span12">
<h4><?php echo $this->_tpl_vars['alternate_option_2']; ?>
</h4>
</div>
</div>
<p><?php echo $this->_tpl_vars['alternate_info_2']; ?>
</p>
<p><?php echo $this->_tpl_vars['alternate_variable']; ?>
: url</p>
<p><?php echo $this->_tpl_vars['alternate_build']; ?>
</p>
<p><input class="input-xxlarge" type="text" name="sub_link" value="<?php echo $this->_tpl_vars['alternate_keyword_linkurl']; ?>
" /></p>
<p><?php echo $this->_tpl_vars['alternate_example']; ?>
: <?php echo $this->_tpl_vars['alternate_keyword_linkurl']; ?>
&url=<b>http://www.yahoo.com</b></p>
<p><a href="http://www.idevlibrary.com/docs/Custom_Links.pdf" target="_blank" class="btn btn-small btn-success"><?php echo $this->_tpl_vars['alternate_tutorial']; ?>
</a></p>
<?php endif; ?>