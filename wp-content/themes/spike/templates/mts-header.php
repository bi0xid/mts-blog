<?php
/**
 * Header template for global use
 * Includes JS, CSS files and all WordPress stuff
 */

?>

<!DOCTYPE html>

<html class="form-signup">
	<!--[if IE 9]><html class="no-js ie9" <?php language_attributes(); ?>><![endif]-->
	<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>
		<title><?php echo get_the_title(); ?></title>
		<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
	</head>

	<body>
