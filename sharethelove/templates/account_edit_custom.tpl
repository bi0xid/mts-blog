{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}


{php}

$get_user_id=mysql_query("select id from idevaff_affiliates where username = '" . $_SESSION['idev_LoggedUsername'] . "'");
$result = mysql_fetch_array($get_user_id);
$linkid = $result['id'];

$getcellcolor = mysql_query("select lighter_cells, page_border, mid_cells, section_head_txt from idevaff_colors");
$cell_color_results = mysql_fetch_array($getcellcolor);
$lighter_cells = $cell_color_results['lighter_cells'];
$page_border = $cell_color_results['page_border'];
$table_top = $cell_color_results['mid_cells'];
$section_head_txt = $cell_color_results['section_head_txt'];

$getcustomrows = mysql_query("select id, title, name from idevaff_form_fields_custom where edit = '1' order by sort");
if (mysql_num_rows($getcustomrows)) {

echo "<table border=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"" . $page_border . "\" cellpadding=\"0\" align=\"center\">";
echo "<tr>";
echo "<td width=\"100%\">";

echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
echo "<tr>";
echo "<td width=\"100%\" bgcolor=\"" . $table_top . "\" colspan=\"2\">";

echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
echo "<tr>";
echo "<td width=\"100%\" bgcolor=\"" . $table_top . "\">&nbsp;<b><font color=\"" . $section_head_txt . "\">";
{/php}
{$custom_fields_title}
{php}
echo "</font></b></td>";
echo "</tr>";
echo "</table>";

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width=\"100%\" bgcolor=\"" . $lighter_cells . "\">";

echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
echo "<tr><td width=\"100%\" colspan=\"3\" height=\"10\"></td></tr>";

echo "<tr><td width=\"100%\" colspan=\"3\" height=\"10\">";
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
while ($qry = mysql_fetch_array($getcustomrows)) {
$group_id = $qry['id'];
$custom_title = $qry['title'];
$custom_name = $qry['name'];
$getvars = mysql_query("select id, custom_value from idevaff_form_custom_data where custom_id = '$group_id' and affid = '$linkid'");
$getvars = mysql_fetch_array($getvars);
$custom_value = $getvars['custom_value'];
$entry_id = $getvars['id'];
echo "<tr>";
echo "<td width='35%'>&nbsp;" . $custom_title . "</td>";
echo "<td width='37%'>\n\n<form method=\"POST\" action=\"account.php\">\n<input type='text' name='custom_value' size='20' value='" . $custom_value . "' style='width:250px'>\n</td>";
echo "<td width='28%'><input type=\"hidden\" name=\"custom_id\" value=\"" . $group_id . "\">\n<input type=\"hidden\" name=\"page\" value=\"17\">\n<input type=\"hidden\" name=\"id\" value=\"" . $linkid . "\">\n<input type=\"hidden\" name=\"id_update\" value=\"$entry_id\">\n<input type=\"submit\" value=\"";{/php}{$edit_custom_button}{php}echo "\">\n</td></form>";
echo "</tr>"; }
echo "<tr><td width=\"100%\" colspan=\"3\" height=\"10\"></td></tr>";
echo "</table>";

echo "</td></tr>";
echo "</table>";

echo "</td></tr>";

echo "</table>";

echo "</td>";
echo "</tr>";

echo "</table>";
echo "<BR />";

}

{/php}





