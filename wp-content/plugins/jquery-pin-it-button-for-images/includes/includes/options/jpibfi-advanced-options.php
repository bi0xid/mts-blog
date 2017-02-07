<?php

class JPIBFI_Advanced_Options extends JPIBFI_Options {

	function get_default_options() {
		$defaults = array(
			'filter_the_content_on'               => true,
			'filter_the_content_priority'         => 10,
			'filter_the_excerpt_on'               => true,
			'filter_the_excerpt_priority'         => 10,
			'filter_post_thumbnail_html_on'       => true,
			'filter_post_thumbnail_html_priority' => 10,
		);

		return $defaults;
	}

	function get_option_name() {
		return 'jpibfi_advanced_options';
	}

	function get_types() {
		return array(
			'filter_the_content_on'               => 'boolean',
			'filter_the_content_priority'         => 'int',
			'filter_the_excerpt_on'               => 'boolean',
			'filter_the_excerpt_priority'         => 'int',
			'filter_post_thumbnail_html_on'       => 'boolean',
			'filter_post_thumbnail_html_priority' => 'int',
		);
	}
}