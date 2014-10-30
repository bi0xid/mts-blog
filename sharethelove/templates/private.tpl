{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{include file='file:header.tpl'}

<table align="{$page_align}" border="0" cellspacing="0" width="{$panel_width}{$joinperc}" bgcolor="{$page_border}">
<tr><td width="100%">

<table border="0" cellspacing="0" width="100%" cellpadding="4" bgcolor="{$white_back}">
<tr>
<td width="25%" bgcolor="{$left_column}" align="center" valign="top">

<table border="0" cellpadding="0" cellspacing="0" width="96%">
<tr><td width="100%" height="20"></td></tr>
<tr>
<td width="100%"><img border="0" src="images/signup.gif" width="32" height="32"><BR /><BR /><font size="2"><b>{$private_heading}</b></font><br />{$private_info}<br /><br /></td>
</tr>
<tr><td width="100%" height="20"></td></tr>
</table>

</td>

<td width="75%" align="center" valign="top">

{if isset($display_signup_errors)}
<table border="0" cellspacing="1" width="100%" bgcolor="{$white_back}">
    <tr>
      <td width="100%" bgcolor="{$red_text}">&nbsp;<font color="{$section_head_txt}"><b>{$error_title}</b></font></td>
	</tr>
    <tr>
      <td width="100%" bgcolor="{$lighter_cells}" height="25">&nbsp;{$error_list}</td>
	</tr>
</table>
{/if}

<table border="0" cellspacing="1" width="100%" bgcolor="{$white_back}">
<form method="POST" action="private.php">
{if isset($display_signup_errors)}
<tr><td width="100%" height="20" colspan="2"></td></tr>
{/if}
    <tr>
      <td width="100%" colspan="2" bgcolor="{$table_top}">&nbsp;<font color="{$section_head_txt}"><b>{$private_required_heading}</b></font></td>
    </tr>
    <tr>
      <td width="20%" bgcolor="{$lighter_cells}">&nbsp;{$private_code_title}</td>
      <td width="80%" bgcolor="{$lighter_cells}">&nbsp;<input type="text" name="signup_code" size="20" value="{if isset($signup_code)}{$signup_code}{/if}" style="width:150px;"></td>
	</td>
    </tr>
    <tr>
      <td width="20%" bgcolor="{$lighter_cells}">&nbsp;</td>
      <td width="80%" bgcolor="{$lighter_cells}">&nbsp;<input type="submit" value="{$private_button}"></td></form>
	</td>
    </tr>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

{include file='file:footer.tpl'}
