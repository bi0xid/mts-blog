{*
-------------------------------------------------------
	iDevAffiliate HTML Front-End Template
-------------------------------------------------------
	Template   : Bootstrap 2 - Fixed Width Responsive
-------------------------------------------------------
	Copyright  : iDevDirect.com LLC
	Website    : www.idevdirect.com
-------------------------------------------------------
*}

{if isset($custom_tracking_enabled)}
<legend style="color:{$legend};">{$cr_title}</legend>
<form method="POST" action="account.php">
<input type="hidden" name="custom_report" value="1">
<input type="hidden" name="page" value="36">
<div class="row-fluid">
<div class="span4">
<p>
{php}
$get_user_id=mysql_query("select id from idevaff_affiliates where username = '" . $_SESSION[$install_directory_name.'_idev_LoggedUsername'] . "'");
$result = mysql_fetch_array($get_user_id);
$linkid = $result['id'];
echo "<select size='1' name='tid1' class='input-xlarge span12'>\n";
$get1 = mysql_query("select distinct tid1 from idevaff_iptracking where tid1 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get1)) {
echo "<option value='none'>TID1: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get1)) {
$tid1_value = $qry['tid1'];
echo "<option value='$tid1_value'>$tid1_value</option>\n";
} } else {
echo "<option value='none'>TID1: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}
</p>
<p>
{php}
echo "<select size='1' name='tid2' class='input-xlarge span12'>\n";
$get2 = mysql_query("select distinct tid2 from idevaff_iptracking where tid2 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get2)) {
echo "<option value='none'>TID2: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get2)) {
$tid2_value = $qry['tid2'];
echo "<option value='$tid2_value'>$tid2_value</option>\n";
} } else {
echo "<option value='none'>TID2: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}
</p>
</div>
<div class="span4">
<p>
{php}
echo "<select size='1' name='tid3' class='input-xlarge span12'>\n";
$get3 = mysql_query("select distinct tid3 from idevaff_iptracking where tid3 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get3)) {
echo "<option value='none'>TID3: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get3)) {
$tid3_value = $qry['tid3'];
echo "<option value='$tid3_value'>$tid3_value</option>\n";
} } else {
echo "<option value='none'>TID3: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}
</p>
<p>
{php}
echo "<select size='1' name='tid4' class='input-xlarge span12'>\n";
$get4 = mysql_query("select distinct tid4 from idevaff_iptracking where tid4 != '' and acct_id = '$linkid'");
if (mysql_num_rows($get4)) {
echo "<option value='none'>TID4: ";
{/php}
{$cr_select}
{php}
echo "</option>\n";
while ($qry = mysql_fetch_array($get4)) {
$tid4_value = $qry['tid4'];
echo "<option value='$tid4_value'>$tid4_value</option>\n";
} } else {
echo "<option value='none'>TID4: ";
{/php}
{$cr_none}
{php}
echo "</option>\n"; }
echo "</select>";
{/php}
</p>
</div>
<div class="span4">
<input class="btn btn-primary" type="submit" value="{$cr_button}">
</div>
</div>
</form>
{if isset($custom_logs_exist)}
<div class="row-fluid">
    <div class="span12">
	<legend style="color:{$legend};">{$cr_title}<span class="pull-right">{$report_total_links} {$cr_unique}</span></legend>
    </div>
</div>
<table class="table table-bordered">
<tr>
<td width="60%"><strong>{$cr_used}</strong></td>
<td width="15%"><strong>{$cr_found}</strong></td>
<td width="25%"><strong>{$cr_detailed}</strong></td>
</tr>
{section name=nr loop=$report_results}
<form method="POST" action="export/export.php">
<input type="hidden" name="export" value="1">
<input type="hidden" name="custom_links_report" value="1">
<input type="hidden" name="linkid" value="{$affiliate_id}">
<input type="hidden" name="tid1" value="{$report_results[nr].report_tid1}">
<input type="hidden" name="tid2" value="{$report_results[nr].report_tid2}">
<input type="hidden" name="tid3" value="{$report_results[nr].report_tid3}">
<input type="hidden" name="tid4" value="{$report_results[nr].report_tid4}">
<tr>
<td width="60%">{$report_results[nr].report_keywords}</td>
<td width="15%">{$report_results[nr].report_links} {$cr_times}</td>
<td width="25%"><input type="submit" value="{$cr_export}" class="btn btn-mini btn-primary"></td>
</tr>
</form>
{/section}
</table>
{elseif isset($no_results_found)}
<div class="row-fluid">
<legend style="color:{$legend};">{$cr_title}</legend>
<p><strong>{$cr_no_results}</strong><BR />{$cr_no_results_info}<br /><BR /></p>
</div>
{/if}
{/if}