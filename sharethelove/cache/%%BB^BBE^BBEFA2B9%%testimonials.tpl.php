<?php /* Smarty version 2.6.14, created on 2014-02-12 13:53:56
         compiled from testimonials.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="container">
<div class="container-fluid">
    <div class="row-fluid">  
         <?php if (isset ( $this->_tpl_vars['testimonials'] ) && ( isset ( $this->_tpl_vars['testimonials_active'] ) )): ?>
             <table class="table table-striped" style="color:<?php echo $this->_tpl_vars['gb_text_color']; ?>
;">   
                <?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['testi_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <tr>
                    <td>  
                    <div class="span12">
                        <p style="font-style:italic;">"<?php echo $this->_tpl_vars['testi_results'][$this->_sections['nr']['index']]['testimonial']; ?>
"</p>
						<p class="pull-right"><?php echo $this->_tpl_vars['testi_results'][$this->_sections['nr']['index']]['affiliate_name'];  if (isset ( $this->_tpl_vars['show_testimonials_link'] )): ?> - <a href="<?php echo $this->_tpl_vars['testi_results'][$this->_sections['nr']['index']]['website_url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['testi_visit']; ?>
</a><?php endif; ?></p>
                    </div> 
                    </td>      
                    </tr>
                <?php endfor; endif; ?>
            </table>
         <?php else: ?>
                <p><?php echo $this->_tpl_vars['testi_na']; ?>
</p>
         <?php endif; ?>
    </div>
</div>
</div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'file:footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>