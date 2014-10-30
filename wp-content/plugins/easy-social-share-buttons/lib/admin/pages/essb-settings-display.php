<?php

$msg = "";

$cmd = isset($_POST["cmd"]) ? $_POST["cmd"] : "";

if ($cmd == "update") {
	//print_r($_POST);
	$options = $_POST ["general_options"];
	
	$current_options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	$current_options['hide_social_name'] = (int)$options['hide_social_name']==1 ? 1 : 0;
	$current_options['show_counter'] = (int)$options['show_counter']==1 ? 1 : 0;
	
	//if ( is_array($options['display_in_types']) && count($options['display_in_types']) > 0 ) {
	if (!isset($options['display_in_types'])) { $options['display_in_types'] = array(); }
		$current_options['display_in_types'] = $options['display_in_types'];
	//}
	$current_options['display_where'] = in_array($options['display_where'], array('bottom', 'top', 'both', 'nowhere', 'float')) ? $options['display_where'] : 'bottom';
	
	
	update_option(EasySocialShareButtons::$plugin_settings_name, $current_options);
	$msg = "Settings are saved.";
}

function essb_select_content_type() {
	$pts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => false ) );
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	$all_lists_selected = '';
	if (is_array ( $options ['display_in_types'] )) {
		$all_lists_selected = in_array ( 'all_lists', $options ['display_in_types'] ) ? 'checked="checked"' : '';
	}
	
	if (is_array ( $options ) && isset ( $options ['display_in_types'] ) && is_array ( $options ['display_in_types'] )) {
		
		global $wp_post_types;
		// classical post type listing
		foreach ( $pts as $pt ) {
			
			$selected = in_array ( $pt, $options ['display_in_types'] ) ? 'checked="checked"' : '';
			
			$icon = "";
			echo '<input type="checkbox" name="general_options[display_in_types][]" id="' . $pt . '" value="' . $pt . '" ' . $selected . '> <label for="' . $pt . '">' . $icon . ' ' . $wp_post_types [$pt]->label . '</label><br />';
		}
		
		// custom post types listing
		if (is_array ( $cpts ) && ! empty ( $cpts )) {
			foreach ( $cpts as $cpt ) {
				
				$selected = in_array ( $cpt, $options ['display_in_types'] ) ? 'checked="checked"' : '';
				
				$icon = "";
				echo '<input type="checkbox" name="general_options[display_in_types][]" id="' . $cpt . '" value="' . $cpt . '" ' . $selected . '> <label for="' . $cpt . '">' . $icon . ' ' . $wp_post_types [$cpt]->label . '</label><br />';
			}
		}
	}
	echo '<input type="checkbox" name="general_options[display_in_types][]" id="all_lists" value="all_lists" ' . $all_lists_selected . '> <label for="all_lists">' . "" . ' ' . sprintf ( __ ( 'Lists of articles <br />%s(blog, archives, search results, etc.)%s', ESSB_TEXT_DOMAIN ), '<em>', '</em>' ) . '</label>';
}

function essb_setting_radio_where() {
	
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	$w_bottom = $w_top = $w_both = $w_nowhere = $w_float = "";
	if (is_array ( $options ) && isset ( $options ['display_where'] ))
		${'w_' . $options ['display_where']} = " checked='checked'";
	
	echo '	<input id="" value="bottom" name="general_options[display_where]" type="radio" ' . $w_bottom . ' />
	<label for="">' . __ ( 'Content bottom', ESSB_TEXT_DOMAIN ) . '</label><br/>
		
	<input id="" value="top" name="general_options[display_where]" type="radio" ' . $w_top . ' />
	<label for="">' . __ ( 'Content top', ESSB_TEXT_DOMAIN ) . '</label><br/>
		
	<input id="" value="both" name="general_options[display_where]" type="radio" ' . $w_both . ' />
	<label for="">' . __ ( 'Both (content bottom and top)', ESSB_TEXT_DOMAIN ) . '</label><br/>

	<input id="" value="float" name="general_options[display_where]" type="radio" ' . $w_float . ' />
	<label for="">' . __ ( "Float from content top", ESSB_TEXT_DOMAIN ) . '</label><br/>
	
	<input id="" value="nowhere" name="general_options[display_where]" type="radio" ' . $w_nowhere . ' />
	<label for="">' . __ ( "Via shortcode only", ESSB_TEXT_DOMAIN ) . '</label><br /><strong>[easy-share]</strong> or <strong>[essb]</strong>';
}

function essb_radio_hide_social_name() {
	$y = $n = '';
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	if (is_array ( $options ))
		(isset ( $options ['hide_social_name'] ) and $options ['hide_social_name'] == 1) ? $y = " checked='checked'" : $n = " checked='checked'";
	
	echo '<input id="hide_name_yes" value="1" name="general_options[hide_social_name]" type="radio" ' . $y . ' />
	<label for="hide_name_yes">' . __ ( 'Yes', ESSB_TEXT_DOMAIN ) . '</label>
		
	<input id="hide_name_no" value="0" name="general_options[hide_social_name]" type="radio" ' . $n . ' />
	<label for="hide_name_no">' . __ ( 'No', ESSB_TEXT_DOMAIN ) . '</label>';
}

function essb_setting_radio_counter() {

	$y = $n = '';
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );

	if ( is_array($options) )
		(isset($options['show_counter']) AND $options['show_counter']==1) ? $y = " checked='checked'" : $n = " checked='checked'";

	echo '	<input id="" value="1" name="general_options[show_counter]" type="radio" '.$y.' />
	<label for="">'. __('Yes', ESSB_TEXT_DOMAIN) . '</label>
		
	<input id="" value="0" name="general_options[show_counter]" type="radio" '.$n.' />
	<label for="">'. __('No', ESSB_TEXT_DOMAIN) . '</label>';
}
?>

<div class="essb">
	<div class="wrap">
	
	<?php
	
	if ($msg != "") {
		echo '<div class="success_message">' . $msg . '</div>';
	}
	
	?>
	
		<form name="general_form" method="post"
			action="admin.php?page=essb_settings&tab=display"
			enctype="multipart/form-data">
			<input type="hidden" id="cmd" name="cmd" value="update" />
			<table border="0" cellpadding="5" cellspacing="0" width="790">
				<col width="40%" />
				<col width="60%" />
				<tr>
					<td colspan="2" class="sub"><?php _e('Display Settings', ESSB_TEXT_DOMAIN); ?></td>
				</tr>

				<tr class="">
					<td valign="top" class="bold"><?php _e('Where to display buttons:', ESSB_TEXT_DOMAIN); ?></td>
					<td class="essb_general_options"><?php essb_select_content_type(); ?></td>
				</tr>
				<tr class="odd">
					<td valign="top" class="bold"><?php _e('Position of buttons:', ESSB_TEXT_DOMAIN); ?></td>
					<td class="essb_general_options"><?php essb_setting_radio_where(); ?></td>
				</tr>
				<tr>
					<td colspan="2" class="sub"><?php _e('Advanced Settings', ESSB_TEXT_DOMAIN); ?></td>
				</tr>

				<tr>
					<td valign="top"><strong><?php _e('Hide Social Network Names:', ESSB_TEXT_DOMAIN); ?></strong><br/>
					<span class="small"><?php _e('This will display only social network icon.', ESSB_TEXT_DOMAIN); ?></span></td>
					<td class="essb_general_options"><?php essb_radio_hide_social_name(); ?>
					<br />
					<img src="<?php echo ESSB_PLUGIN_URL; ?>/assets/images/demo-image1.png"/></td>
				</tr>
				<tr class="odd">
					<td valign="top"><strong><?php _e('Display counter of sharing', ESSB_TEXT_DOMAIN); ?></strong><br/>
					<span class="small"><?php _e('This may slow down page loading.', ESSB_TEXT_DOMAIN); ?></span></td>
					<td class="essb_general_options"><?php essb_setting_radio_counter(); ?><br />
					<img src="<?php echo ESSB_PLUGIN_URL; ?>/assets/images/demo-image2.png"/></td>
				</tr>
				<tr class="">
					<td colspan="2">
			<?php echo '<input type="Submit" name="Submit" value="' . __ ( 'Update Settings', ESSB_TEXT_DOMAIN ) . '" class="button-primary" />'; ?>
			</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type="text/jquery">
</script>