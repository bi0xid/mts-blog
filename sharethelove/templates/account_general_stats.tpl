{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="55%" bgcolor="{$table_top}" colspan="2">&nbsp;<b><font color="{$section_head_txt}">{$general_title}</font></b></td>
<td width="45%" align="center" rowspan="11" bgcolor="{$white_back}" valign="top">
{if isset($traffic_exists)}
{php}
include_once("templates/fusion/Includes/FusionCharts_Gen.php");
{/php}
{literal}
<SCRIPT LANGUAGE="Javascript" SRC="templates/fusion/FusionCharts/FusionCharts.js"></SCRIPT>{/literal}
{php}

$checkappforcharts=mysql_query("select id from idevaff_affiliates where username = '" . $_SESSION['idev_LoggedUsername'] . "'");
$resforcharts=mysql_fetch_array($checkappforcharts);
$linkidforcharts=$resforcharts['id'];

$chart_traffic = mysql_query("select COUNT(DISTINCT ip) from idevaff_iptracking where acct_id = '$linkidforcharts'");
$chart_traffic = mysql_fetch_row($chart_traffic);
$chart_traffic = $chart_traffic[0];

$chart_approved = mysql_query("select COUNT(*) from idevaff_sales where approved = '1' and bonus = '0' and id = '$linkidforcharts'");
$chart_approved = mysql_fetch_row($chart_approved);
$chart_approved = $chart_approved[0];

$chart_paid = mysql_query("select COUNT(*) from idevaff_archive where bonus = '0' and id = '$linkidforcharts'");
$chart_paid = mysql_fetch_row($chart_paid);
$chart_paid = $chart_paid[0];

$chart_commissions = $chart_approved + $chart_paid;

$chart_traffic_tag = "Unique Hits";
$chart_commissions_tag = "Total Sales";

	 $FC = new FusionCharts("Column2D","280","180"); 
	 $FC->setSWFPath("templates/fusion/FusionCharts/");
	 
	 $strParam="showDivLineValue=0;canvasBorderColor=FFFFFF;formatNumberScale=0;formatNumber=1;animation=1;decimalPrecision=0;canvasBorderThickness=0;canvasBgColor=FFFFFF;canvasBaseColor=5c5c5c;canvasBaseDepth=1;baseFont=arial;baseFontSize=11;outCnvBaseFont=arial;outCnvBaseFontSze=11;showLegend=1";
	 $FC->setChartParams($strParam);

	 $FC->addChartData($chart_traffic,"name=$chart_traffic_tag");
	 $FC->addChartData($chart_commissions, "name=$chart_commissions_tag");

	 $FC->renderChart();
{/php}
{/if}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$general_transactions}</td>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$current_transactions}</td>

</tr>
<tr>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$general_standard_earnings}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$current_approved_commissions}
</td>
</tr>
<tr>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$account_second_tier}</td>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$current_tier_commissions}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$account_recurring}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$current_recurring_commissions}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$white_back}"><b>&nbsp;{$general_current_earnings}</b></td>
<td width="25%" bgcolor="{$white_back}"><b>&nbsp;{$current_total_commissions}</b></td>
</tr>
<tr>
<td width="55%" bgcolor="{$table_top}" colspan="2">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_title}</font></b></td>
</tr>
<tr>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$general_traffic_visitors}</td>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$hin}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$general_traffic_unique}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$unchits}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$white_back}">&nbsp;{$general_traffic_sales}</td>
<td width="25%" bgcolor="{$white_back}">&nbsp;{$salenum}</td>
</tr>
<tr>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$general_traffic_ratio}</td>
<td width="25%" bgcolor="{$lighter_cells}">&nbsp;{$perc}%</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="30%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_pay_type}</font></b></td>
<td width="70%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$general_traffic_pay_level}</font></b></td>
</tr>
<tr>
<td width="30%" bgcolor="{$lighter_cells}">&nbsp;{$current_style}</td>
<td width="70%" bgcolor="{$lighter_cells}">&nbsp;{$current_level}</td>
</tr>
</table>
</td>
</tr>
</table>

<BR />

{include file='file:account_notes.tpl'}
