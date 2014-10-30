<?php

function essb_register_settings_metabox() {
	global $post;
	
	$essb_off = "false";
	$essb_position = "";
	$essb_names = "";
	$essb_counter = "";
	$essb_theme = "";
	$essb_hidefb = "no";
	$essb_hideplusone = "no";
	$essb_hidevk = "no";
	
	if (isset ( $_GET ['action'] )) {
		$custom = get_post_custom ( $post->ID );
		
		// print_r($custom);
		
		$essb_off = isset ( $custom ["essb_off"] ) ? $custom ["essb_off"] [0] : "false";
		$essb_position = isset ( $custom ["essb_position"] ) ? $custom ["essb_position"] [0] : "";
		$essb_theme = isset ( $custom ["essb_theme"] ) ? $custom ["essb_theme"] [0] : "";
		$essb_names = isset ( $custom ["essb_names"] ) ? $custom ["essb_names"] [0] : "";
		$essb_counter = isset ( $custom ["essb_counter"] ) ? $custom ["essb_counter"] [0] : "";
		$essb_hidefb = isset ( $custom ["essb_hidefb"] ) ? $custom ["essb_hidefb"] [0] : "no";
		$essb_hideplusone = isset ( $custom ["essb_hideplusone"] ) ? $custom ["essb_hideplusone"] [0] : "no";
		$essb_hidevk = isset ( $custom ["essb_hidevk"] ) ? $custom ["essb_hidevk"] [0] : "no";
	}
	
	wp_nonce_field ( 'essb_metabox_handler', 'essb_nonce' );
	
	?>

<div class="essb">

	<table border="0" cellpadding="5" cellspacing="0" width="100%">
		<col width="60%" />
		<col width="40%" />
		<tr>
			<td>Turn Easy Social Sharing Buttons off for current post:</td>
			<td><select class="input-element stretched" id="essb_off"
				name="essb_off">
					<option value="true"
						<?php echo (($essb_off == "true") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="false"
						<?php echo (($essb_off == "false") ? " selected=\"selected\"": ""); ?>>No</option>
			</select></td>
		</tr>
		<tr class="even">
			<td>Template:</td>
			<td><select class="input-element stretched" id="essb_theme"
				name="essb_theme">
					<option value="">From Settings</option>
					<option value="1"
						<?php echo (($essb_theme == "1") ? " selected=\"selected\"": ""); ?>>Default</option>
					<option value="2"
						<?php echo (($essb_theme == "2") ? " selected=\"selected\"": ""); ?>>Metro</option>
					<option value="3"
						<?php echo (($essb_theme == "3") ? " selected=\"selected\"": ""); ?>>Modern</option>
					<option value="4"
						<?php echo (($essb_theme == "4") ? " selected=\"selected\"": ""); ?>>Round</option>
						
			</select></td>
		</tr>
		<tr class="">
			<td>Hide Network Names:</td>
			<td><select class="input-element stretched" id="essb_names"
				name="essb_names">
					<option value="">From Settings</option>
					<option value="1"
						<?php echo (($essb_names == "1") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="0"
						<?php echo (($essb_names == "0") ? " selected=\"selected\"": ""); ?>>No</option>

			</select></td>
		</tr>
		<tr class="even">
			<td>Position of buttons:</td>
			<td><select class="input-element stretched" id="essb_position"
				name="essb_position">
					<option value="">From Settings</option> 
					</option>
					
					
					
					<option value="bottom"
						<?php echo (($essb_position == "bottom") ? " selected=\"selected\"": ""); ?>>Bottom</option>
					
					<option value="top"
						<?php echo (($essb_position == "top") ? " selected=\"selected\"": ""); ?>>Top</option>
					<option value="both"
						<?php echo (($essb_position == "both") ? " selected=\"selected\"": ""); ?>>Both</option>
					<option value="float"
						<?php echo (($essb_position == "float") ? " selected=\"selected\"": ""); ?>>Float</option>
						</select></td>
		</tr>
		<tr class="">
			<td>Display Counters Of Sharing:</td>
			<td><select class="input-element stretched" id="essb_counter"
				name="essb_counter">
					<option value="">From Settings</option>
					<option value="1"
						<?php echo (($essb_counter == "1") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="0"
						<?php echo (($essb_counter == "0") ? " selected=\"selected\"": ""); ?>>No</option>

			</select></td>
		</tr>
		
		<tr class="even">
			<td>Hide Facebook Like Button:</td>
			<td><select class="input-element stretched" id="essb_hidefb"
				name="essb_hidefb">
					<option value="yes"
						<?php echo (($essb_hidefb == "yes") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="no"
						<?php echo (($essb_hidefb == "no") ? " selected=\"selected\"": ""); ?>>No</option>

			</select></td>
		</tr>
		<tr class="">
			<td>Hide Google Plus One Button:</td>
			<td><select class="input-element stretched" id="essb_hideplusone"
				name="essb_hideplusone">
					<option value="yes"
						<?php echo (($essb_hideplusone == "yes") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="no"
						<?php echo (($essb_hideplusone == "no") ? " selected=\"selected\"": ""); ?>>No</option>

			</select></td>
		</tr>
		<tr class="even">
			<td>Hide VKontakte Like Button:</td>
			<td><select class="input-element stretched" id="essb_hidevk"
				name="essb_hidevk">
					<option value="yes"
						<?php echo (($essb_hidevk == "yes") ? " selected=\"selected\"": ""); ?>>Yes</option>
					<option value="no"
						<?php echo (($essb_hidevk == "no") ? " selected=\"selected\"": ""); ?>>No</option>

			</select></td>
		</tr>
		</table>

</div>
	
	
	<?php
}

?>