{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($display_testimonial_errors)}
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr><td width="100%"><font color="{$red_text}"><b>{$testimonial_error_title}</b></font><br />{$testimonial_error_list}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
{/if}

{if isset($display_testimonial_success)}
<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$testi_title}</font></b></td>
</tr>
<tr>
<td width="100%" colspan="2" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
<tr><td width="100%"><font color="{$red_text}"><b>{$testimonial_success_title}</b></font><br />{$testimonial_success_message}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
{/if}

{if isset($testimonials) && !isset($display_testimonial_success) }

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0" align="center">
<tr>
<td width="100%">

<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$testi_title}</font></b></td>
</tr>
<tr>
<td width="100%" colspan="2" bgcolor="{$lighter_cells}" align="center">


<table border="0" cellpadding="0" cellspacing="0" width="98%">
<form action="account.php" method="post">
<input type="hidden" name="create_testimonial" value="1">
<input type="hidden" name="page" value="41">
<tr><td width="100%" colspan="3" height="10"></td></tr>
<tr><td width="100%" colspan="3">{$testi_description}</td></tr>
<tr><td width="100%" colspan="3" height="10"></td></tr>
<tr><td width="16%"><b>{$testi_name}</b></td><td width="84%" colspan="2"><input type="text" name="submit_name" value="{$submit_name}" size="35" /></td></tr>
<tr><td width="100%" colspan="3" height="5"></td></tr>
<tr><td width="16%"><b>{$testi_url}</b></td><td width="84%" colspan="2"><input type="text" name="submit_website" value="{$submit_website}" size="35" /></td></tr>
<tr><td width="100%" colspan="3" height="5"></td></tr>
<tr><td width="16%" valign="top"><b>{$testi_content}</b></td><td width="84%" colspan="2"><textarea name="submit_testimonial" cols="62" rows="6">{$submit_testimonial}</textarea></td></tr>
<tr><td width="100%" colspan="3" height="5"></td></tr>
{if isset($testimonials_security)}
<tr>
<td width="16%" bgcolor="{$lighter_cells}"><b>{$testi_code}</b></td>
<td width="27%" bgcolor="{$lighter_cells}"><input id="security_code" name="security_code" type="text" /></td>
<td width="57%" bgcolor="{$lighter_cells}"><img src="includes/security_image.php?width=100&height=30&characters=6" alt="{$testi_code}" /></td>
</tr>
{/if}
<tr><td width="16%"></td><td width="84%" colspan="2"><input type="submit" value="{$testi_submit}" name="iDevAffiliate"></td></form></tr>
<tr><td width="100%" colspan="3" height="10"></td></tr>
</table>


</td></tr>
</table>

</td>
</tr>
</table>

{/if}

<br />

