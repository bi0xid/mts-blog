<?php /* Smarty version 2.6.14, created on 2014-02-11 20:59:21
         compiled from file:account_email_links.tpl */ ?>

<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['email_title']; ?>
</legend>
<form method="POST" action="account.php" class="form-horizontal">
<input type="hidden" name="page" value="10">
<div class="row-fluid">
<div class="span9">
    <div class="control-group">
        <label class="control-label" ><?php echo $this->_tpl_vars['email_group']; ?>
</label>
        <div class="controls">                           
          <select size="1" name="email_picked" class="span12">
            <?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['email_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <option value="<?php echo $this->_tpl_vars['email_results'][$this->_sections['nr']['index']]['email_group_id']; ?>
"><?php echo $this->_tpl_vars['email_results'][$this->_sections['nr']['index']]['email_group_name']; ?>
</option>
            <?php endfor; endif; ?>
            </select>
        </div>
    </div>
    </div>
    <div class="span3">
       <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['email_button']; ?>
">
    </div>
</div>
</form>
<?php if (isset ( $this->_tpl_vars['email_group_chosen'] )): ?>
<h4 style="border-bottom:1px solid #5e5e5e;"><?php echo $this->_tpl_vars['email_group']; ?>
: <font color="#CC0000"><?php echo $this->_tpl_vars['email_chosen_group_name']; ?>
</font></h4>
<p style="border-bottom:1px solid #5e5e5e; padding:20px 0 20px 0;"><?php echo $this->_tpl_vars['email_ascii']; ?>
<span class="pull-right"><?php echo $this->_tpl_vars['email_source']; ?>
</span><br /><textarea rows="3" class="input-block-level" style="background-color:#f2f6ff;"><?php echo $this->_tpl_vars['email_chosen_url']; ?>
</textarea></p>
<p style="border-bottom:1px solid #5e5e5e; padding:20px 0 20px 0;"><?php echo $this->_tpl_vars['email_html']; ?>
<span class="pull-right"><?php echo $this->_tpl_vars['email_source']; ?>
</span><br /><textarea rows="3" class="input-block-level" style="background-color:#f2f6ff;"><a href="<?php echo $this->_tpl_vars['email_chosen_url'];  echo $this->_tpl_vars['rel_values']; ?>
"><?php echo $this->_tpl_vars['email_chosen_group_name']; ?>
</a></textarea></p>
<p><b><?php echo $this->_tpl_vars['email_test']; ?>
</b>: <a href="<?php echo $this->_tpl_vars['email_chosen_url'];  echo $this->_tpl_vars['rel_values']; ?>
" target="_blank"><?php echo $this->_tpl_vars['email_chosen_display_tag']; ?>
</a></p>
<p><?php echo $this->_tpl_vars['email_test_info']; ?>
</p>
<?php else:  endif; ?>