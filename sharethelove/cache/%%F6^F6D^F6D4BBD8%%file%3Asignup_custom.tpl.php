<?php /* Smarty version 2.6.14, created on 2014-02-12 19:51:43
         compiled from file:signup_custom.tpl */ ?>



<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['custom_fields_title']; ?>
</legend>  

<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['custom_input_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<div class="control-group">
<label class="control-label"><?php echo $this->_tpl_vars['custom_input_results'][$this->_sections['nr']['index']]['custom_title']; ?>
</label>
<div class="controls"> <input type="text" name="<?php echo $this->_tpl_vars['custom_input_results'][$this->_sections['nr']['index']]['custom_name']; ?>
" class="input-xxlarge span12" value="<?php echo $this->_tpl_vars['custom_input_results'][$this->_sections['nr']['index']]['custom_value']; ?>
" /></div>
</div>
<?php endfor; endif; ?>

