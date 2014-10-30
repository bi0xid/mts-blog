<?php /* Smarty version 2.6.14, created on 2014-02-11 21:02:12
         compiled from file:training_videos.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['uploaded_training_videos'] )): ?>
<div class="clearfix"></div>
<h4 class="h3bg">Training Videos</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Uploaded_Video_Tutorials']; ?>
</table>
<?php endif; ?>

<?php if (isset ( $this->_tpl_vars['training_videos'] )): ?>
<div class="clearfix"></div>
<h4 class="h3bg">General Affiliate Marketing</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Table_Rows_General_Affiliate_Marketing']; ?>
</table>
<h4 class="h3bg">Marketing Materials</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Table_Rows_Marketing_Materials']; ?>
</table>
<h4 class="h3bg">Tier System</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Table_Rows_Tier_System']; ?>
</table>
<h4 class="h3bg">Advanced Affiliate Marketing</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Table_Rows_Advanced_Affiliate_Marketing']; ?>
</table>
<h4 class="h3bg">Advanced Marketing Materials</h4>
<table class="table table-bordered"><?php echo $this->_tpl_vars['Table_Rows_Advanced_Marketing_Materials']; ?>
</table>
<?php endif; ?>