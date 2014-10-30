<?php /* Smarty version 2.6.14, created on 2014-02-11 20:58:08
         compiled from file:account_banners.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['one_click_delivery'] )): ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['menu_banners']; ?>
</legend>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['banner_link_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<p style="border-bottom:1px solid #5e5e5e;">
<b><?php echo $this->_tpl_vars['marketing_group']; ?>
:</b> <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_group_name']; ?>
<br />
<b><?php echo $this->_tpl_vars['banners_size']; ?>
</b>: <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_size_1']; ?>
 x <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_size_2']; ?>
<br/>
<b><?php echo $this->_tpl_vars['banners_description']; ?>
</b>: <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_description']; ?>
<br/>
<b><?php echo $this->_tpl_vars['marketing_target_url']; ?>
</b>: <a href="<?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_target_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_target_url']; ?>
</a><BR /><BR />
<?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_display']; ?>
<br/><br/><?php echo $this->_tpl_vars['marketing_source_code']; ?>
<br/>
<textarea rows="5" class="input-block-level" style="background-color:#f2f6ff;"><?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_code']; ?>
</textarea>
</p>
<?php endfor; endif;  else: ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['menu_banners']; ?>
</legend>
<form method="POST" action="account.php" class="form-horizontal">
<input type="hidden" name="page" value="7">
<div class="row-fluid">
<div class="span9">
    <div class="control-group">
        <label class="control-label" ><?php echo $this->_tpl_vars['marketing_group_title']; ?>
</label>
        <div class="controls">                           
          <select size="1" name="banner_picked">
            <?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['banner_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <option value="<?php echo $this->_tpl_vars['banner_results'][$this->_sections['nr']['index']]['banner_group_id']; ?>
"><?php echo $this->_tpl_vars['banner_results'][$this->_sections['nr']['index']]['banner_group_name']; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        </div>
    </div>
    </div>
    <div class="span3">
        <input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['marketing_button']; ?>
 <?php echo $this->_tpl_vars['menu_banners']; ?>
">
    </div>
</div>
</form>
<?php if (isset ( $this->_tpl_vars['banner_group_chosen'] )): ?>
<h4 style="border-bottom:1px solid #5e5e5e;"><?php echo $this->_tpl_vars['marketing_group_title']; ?>
: <font color="#CC0000"><?php echo $this->_tpl_vars['banner_chosen_group_name']; ?>
</font></h4>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['banner_link_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<p style="border-bottom:1px solid #5e5e5e;">
    <b><?php echo $this->_tpl_vars['banners_size']; ?>
</b>: <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_size_1']; ?>
 x <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_size_2']; ?>
<BR />
    <b><?php echo $this->_tpl_vars['banners_description']; ?>
</b>: <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_description']; ?>
<BR />
    <b><?php echo $this->_tpl_vars['marketing_target_url']; ?>
</b>: <a href="<?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_target_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_target_url']; ?>
</a><BR /><BR />
    <?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_display']; ?>
<BR /><BR />
    <?php echo $this->_tpl_vars['marketing_source_code']; ?>
<BR />
    <textarea rows="5" class="input-block-level" style="background-color:#f2f6ff;"><?php echo $this->_tpl_vars['banner_link_results'][$this->_sections['nr']['index']]['banner_code']; ?>
</textarea>
</p>
<?php endfor; endif;  else:  endif;  endif; ?>