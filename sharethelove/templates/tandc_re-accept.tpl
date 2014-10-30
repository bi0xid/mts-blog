{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}


<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr>
<td>
<table border="0" cellpadding="4" cellspacing="0" width="100%" bgcolor="{$white_back}">

<tr>
<td width="100%" align="center"><br /><br /><font size="3"><b>{$tc_reaccept_title}</b></font><br />{$tc_reaccept_sub_title}<br />
</td>
</tr>

<tr>
<td width="100%" align="center"><textarea rows="10" name="terms" cols="65" readonly>{$terms_t}</textarea></td>
</tr>

<form method="post" value="account.php">
<input type="hidden" name="terms_accepted" value="true">
<tr>
<td width="100%" align="center"><input type="submit" name="Re-Accept Terms and Conditions" value="{$tc_reaccept_button}"></textarea><br /><br /><br /></td></form>
</tr>

</table>
</td>
</tr>
</table>

