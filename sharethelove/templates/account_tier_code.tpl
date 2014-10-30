{*
-------------------------------------------------------
iDevAffiliate Version 6
Copyright - iDevDirect.com L.L.C.

Website: http://www.idevdirect.com/
Support: http://www.idevsupport.com/
Email:   support@idevdirect.com
-------------------------------------------------------
*}

{if isset($tier_enabled)}

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$tlinks_title}</font></b>
</td>
</tr>

{if isset($forced_links)}

<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$tlinks_forced_two}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td>
</tr>


<tr><td width="100%" bgcolor="{$lighter_cells}" align="center"><br />

  <table border="0" cellspacing="1" width="95%">
    <tr height="25">
      <td width="100%" align="center" colspan="2" bgcolor="{$white_back}"><textarea rows="2" cols="73">
{if isset($seo_links)}
<a href="{$seo_url}signup-{$textads_link}{$textads_link_html_added}">{$tlinks_forced_money}</a>
{else}
<a href="{$base_url}/index.php?ref={$link_id}">{$tlinks_forced_money}</a>
{/if}
</textarea></font></td>
    </tr>
    <tr height="25">
      <td width="100%" colspan="2" bgcolor="{$white_back}">&nbsp;<font color="#CC0000">{$tlinks_forced_paste}</font></td>
    </tr>
    <tr height="25">
      <td width="35%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_active}</b></td>
      <td width="65%" bgcolor="{$white_back}">&nbsp;{$tier_numbers}</td>
    </tr>
  </table>
  
<br /></td></tr>

{else}

<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
<tr><td width="100%" height="10"></td></tr>
<tr><td width="100%">{$tlinks_embedded_two}</td></tr>
<tr><td width="100%" height="10"></td></tr>
</table>
</td>
</tr>


<tr><td width="100%" bgcolor="{$lighter_cells}" align="center"><br />

  <table border="0" cellspacing="1" width="95%">
    <tr height="25">
      <td width="35%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_forced_code}</b></td>
      <td width="65%" bgcolor="{$white_back}">&nbsp;<font color="#707070">{$tlinks_embedded_one}</font></td>
    </tr>
    <tr height="25">
      <td width="35%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_active}</b></td>
      <td width="65%" bgcolor="{$white_back}">&nbsp;{$tier_numbers}</td>
    </tr>

  </table>
  
<br /></td></tr>


{/if}

</table>
</td>
</tr>
</table>

<br />

<table border="0" cellspacing="0" width="100%" bgcolor="{$page_border}" cellpadding="0">
<tr>
<td width="100%">
<table border="0" cellpadding="2" cellspacing="1" width="100%">
<tr>
<td width="100%" bgcolor="{$table_top}">&nbsp;<b><font color="{$section_head_txt}">{$tlinks_payout_structure}</font></b></td>
</tr>

<tr>
<td width="100%" bgcolor="{$lighter_cells}" align="center">
<table border="0" cellpadding="0" cellspacing="1" width="95%">
<tr><td width="100%" colspan="2" height="10"></td></tr>

{if isset($tier_1_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 1</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_1_amount}{$tier_1_type}</td>
    </tr>
{/if}
{if isset($tier_2_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 2</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_2_amount}{$tier_2_type}</td>
    </tr>
{/if}
{if isset($tier_3_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 3</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_3_amount}{$tier_3_type}</td>
    </tr>
{/if}
{if isset($tier_4_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 4</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_4_amount}{$tier_4_type}</td>
    </tr>
{/if}
{if isset($tier_5_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 5</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_5_amount}{$tier_5_type}</td>
    </tr>
{/if}
{if isset($tier_6_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 6</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_6_amount}{$tier_6_type}</td>
    </tr>
{/if}
{if isset($tier_7_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 7</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_7_amount}{$tier_7_type}</td>
    </tr>
{/if}
{if isset($tier_8_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 8</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_8_amount}{$tier_8_type}</td>
    </tr>
{/if}
{if isset($tier_9_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 9</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_9_amount}{$tier_9_type}</td>
    </tr>
{/if}
{if isset($tier_10_active)}
    <tr height="25">
      <td width="25%" bgcolor="{$white_back}">&nbsp;<b>{$tlinks_level} 10</b></td>
      <td width="75%" bgcolor="{$white_back}">&nbsp;{$tier_10_amount}{$tier_10_type}</td>
    </tr>
{/if}
<tr><td width="100%" colspan="2" height="10"></td></tr>
</table>
</td>
</tr>



</table>
</td>
</tr>
</table>


{/if}

<BR />
