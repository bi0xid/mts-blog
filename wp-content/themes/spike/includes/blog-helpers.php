<?php

/**
* Blog Helpers
* @author Alejandro Orta (alejandro@mytinysecrets.com)
*/
class BlogHelpers {
	public function shuffle_assoc( $array ) {
		$keys = array_keys( $array );

		shuffle( $keys );

		foreach( $keys as $key ) {
			$new[$key] = $array[$key];
		}

		$array = $new;

		return $array;
	}
}
