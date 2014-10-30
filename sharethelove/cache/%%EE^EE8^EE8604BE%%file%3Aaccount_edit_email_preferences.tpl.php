<?php /* Smarty version 2.6.14, created on 2014-05-27 22:28:10
         compiled from file:account_edit_email_preferences.tpl */ ?>

<select size="1" name="email_language" class="input-large">
<?php 
// ----------------------------------
// Get Affiliate Override Language
// ----------------------------------
$default_email_language = mysql_query("select email_override from idevaff_affiliates where username = '" . $_SESSION[$install_directory_name.'_idev_LoggedUsername'] . "'");
$default_email_language = mysql_fetch_array($default_email_language);
$email_table_extension = $default_email_language['email_override'];
if (!$email_table_extension) {
// ----------------------------------
// Get Default Email Language
// ----------------------------------
$default_email_language = mysql_query("select table_name from idevaff_email_language_packs where def = '1'");
$default_email_language = mysql_fetch_array($default_email_language);
$email_table_extension = $default_email_language['table_name'];
}
$get_countries = mysql_query("select name, table_name from idevaff_email_language_packs where status = '1' order by name");
if (mysql_num_rows($get_countries)) {
while ($available_countries = mysql_fetch_array($get_countries)) {
$pack_table = $available_countries['table_name'];
$pack_name = $available_countries['name'];
echo "\n<option value='" . $pack_table . "'";
if ($email_table_extension == $pack_table) { echo " selected"; }
echo ">" . ucwords($pack_name) . "</option>\n";
} }
 ?>
</select>