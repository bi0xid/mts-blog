<?php /* Smarty version 2.6.14, created on 2014-05-28 11:20:21
         compiled from file:account_faq.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['faq_enabled'] )): ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['faq_page_title']; ?>
</legend>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['faq_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<div class="well" style="color:<?php echo $this->_tpl_vars['bg_text_color']; ?>
;">
<strong><?php echo $this->_tpl_vars['faq_results'][$this->_sections['nr']['index']]['faq_question']; ?>
</strong><br />
<?php echo $this->_tpl_vars['faq_results'][$this->_sections['nr']['index']]['faq_answer']; ?>

</div>
<?php endfor; else: ?>
<div class="well" style="color:<?php echo $this->_tpl_vars['bg_text_color']; ?>
;">
<?php echo $this->_tpl_vars['faq_page_none']; ?>

</div>
<?php endif;  endif; ?>