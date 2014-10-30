<?php /* Smarty version 2.6.14, created on 2014-05-27 22:44:10
         compiled from file:account_custom_reports.tpl */ ?>

<?php if (isset ( $this->_tpl_vars['custom_tracking_enabled'] )): ?>
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['cr_title']; ?>
</legend>
<form method="POST" action="account.php">
<input type="hidden" name="custom_report" value="1">
<input type="hidden" name="page" value="36">
<div class="row-fluid">
<div class="span4">
<p>
<?php 
$get_user_id=mysql_query("select id from idevaff_affiliates where username = '" . $_SESSION[$install_directory_name.'_idev_LoggedUsername'] . "'");
$result = mysql_fetch_array($get_user_id);
$linkid = $result['id'];
echo "<select size='1' name='tid1' class='input-xlarge span12'>\n";
$get1 = mysql_query("select distinct tid1 from idevaff_iptracking where tid1 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get1)) {
echo "<option value='none'>TID1: ";
  echo $this->_tpl_vars['cr_select']; ?>

<?php 
echo "</option>\n";
while ($qry = mysql_fetch_array($get1)) {
$tid1_value = $qry['tid1'];
echo "<option value='$tid1_value'>$tid1_value</option>\n";
} } else {
echo "<option value='none'>TID1: ";
  echo $this->_tpl_vars['cr_none']; ?>

<?php 
echo "</option>\n"; }
echo "</select>";
 ?>
</p>
<p>
<?php 
echo "<select size='1' name='tid2' class='input-xlarge span12'>\n";
$get2 = mysql_query("select distinct tid2 from idevaff_iptracking where tid2 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get2)) {
echo "<option value='none'>TID2: ";
  echo $this->_tpl_vars['cr_select']; ?>

<?php 
echo "</option>\n";
while ($qry = mysql_fetch_array($get2)) {
$tid2_value = $qry['tid2'];
echo "<option value='$tid2_value'>$tid2_value</option>\n";
} } else {
echo "<option value='none'>TID2: ";
  echo $this->_tpl_vars['cr_none']; ?>

<?php 
echo "</option>\n"; }
echo "</select>";
 ?>
</p>
</div>
<div class="span4">
<p>
<?php 
echo "<select size='1' name='tid3' class='input-xlarge span12'>\n";
$get3 = mysql_query("select distinct tid3 from idevaff_iptracking where tid3 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get3)) {
echo "<option value='none'>TID3: ";
  echo $this->_tpl_vars['cr_select']; ?>

<?php 
echo "</option>\n";
while ($qry = mysql_fetch_array($get3)) {
$tid3_value = $qry['tid3'];
echo "<option value='$tid3_value'>$tid3_value</option>\n";
} } else {
echo "<option value='none'>TID3: ";
  echo $this->_tpl_vars['cr_none']; ?>

<?php 
echo "</option>\n"; }
echo "</select>";
 ?>
</p>
<p>
<?php 
echo "<select size='1' name='tid4' class='input-xlarge span12'>\n";
$get4 = mysql_query("select distinct tid4 from idevaff_iptracking where tid4 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get4)) {
echo "<option value='none'>TID4: ";
  echo $this->_tpl_vars['cr_select']; ?>

<?php 
echo "</option>\n";
while ($qry = mysql_fetch_array($get4)) {
$tid4_value = $qry['tid4'];
echo "<option value='$tid4_value'>$tid4_value</option>\n";
} } else {
echo "<option value='none'>TID4: ";
  echo $this->_tpl_vars['cr_none']; ?>

<?php 
echo "</option>\n"; }
echo "</select>";
 ?>
</p>
</div>
<div class="span4">
<input class="btn btn-primary" type="submit" value="<?php echo $this->_tpl_vars['cr_button']; ?>
">
</div>
</div>
</form>
<?php if (isset ( $this->_tpl_vars['custom_logs_exist'] )): ?>
<div class="row-fluid">
    <div class="span12">
	<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['cr_title']; ?>
<span class="pull-right"><?php echo $this->_tpl_vars['report_total_links']; ?>
 <?php echo $this->_tpl_vars['cr_unique']; ?>
</span></legend>
    </div>
</div>
<table class="table table-bordered">
<tr>
<td width="60%"><strong><?php echo $this->_tpl_vars['cr_used']; ?>
</strong></td>
<td width="15%"><strong><?php echo $this->_tpl_vars['cr_found']; ?>
</strong></td>
<td width="25%"><strong><?php echo $this->_tpl_vars['cr_detailed']; ?>
</strong></td>
</tr>
<?php unset($this->_sections['nr']);
$this->_sections['nr']['name'] = 'nr';
$this->_sections['nr']['loop'] = is_array($_loop=$this->_tpl_vars['report_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<form method="POST" action="export/export.php">
<input type="hidden" name="export" value="1">
<input type="hidden" name="custom_links_report" value="1">
<input type="hidden" name="linkid" value="<?php echo $this->_tpl_vars['affiliate_id']; ?>
">
<input type="hidden" name="tid1" value="<?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_tid1']; ?>
">
<input type="hidden" name="tid2" value="<?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_tid2']; ?>
">
<input type="hidden" name="tid3" value="<?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_tid3']; ?>
">
<input type="hidden" name="tid4" value="<?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_tid4']; ?>
">
<tr>
<td width="60%"><?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_keywords']; ?>
</td>
<td width="15%"><?php echo $this->_tpl_vars['report_results'][$this->_sections['nr']['index']]['report_links']; ?>
 <?php echo $this->_tpl_vars['cr_times']; ?>
</td>
<td width="25%"><input type="submit" value="<?php echo $this->_tpl_vars['cr_export']; ?>
" class="btn btn-mini btn-primary"></td>
</tr>
</form>
<?php endfor; endif; ?>
</table>
<?php elseif (isset ( $this->_tpl_vars['no_results_found'] )): ?>
<div class="row-fluid">
<legend style="color:<?php echo $this->_tpl_vars['legend']; ?>
;"><?php echo $this->_tpl_vars['cr_title']; ?>
</legend>
<p><strong><?php echo $this->_tpl_vars['cr_no_results']; ?>
</strong><BR /><?php echo $this->_tpl_vars['cr_no_results_info']; ?>
<br /><BR /></p>
</div>
<?php endif;  endif; ?>