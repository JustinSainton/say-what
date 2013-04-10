<?php



if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly


/**
 * The frontend class, responsible for performing the actual replacements
 */
class say_what_frontend {



	private $replacements;



    /**
     * Read the settings in and put them into a format optimised for the final filter
     */
	function __construct($settings) {

		foreach ( $settings->replacements as $key => $value ) {

			if ( empty ( $value['domain'] ) )
				$value['domain'] = 'default';

			$this->replacements[$value['domain']][$value['orig_string']] = $value['replacement_string'];
		}

		add_filter ( 'gettext', array ( $this, 'gettext' ), 10, 3 );
		add_filter ( 'gettext_with_context', array ( $this, 'gettext_with_context' ), 10, 4 );
		add_filter ( 'ngettext', array ( $this, 'ngettext' ), 10, 5 );
		add_filter ( 'ngettext_with_context', array ( $this, 'ngettext_with_context' ), 10, 6 );

	}



    /**
     * The main function - optionally perform a string replacement
     */
	function gettext( $translated, $original, $domain ) {

		if ( isset ( $this->replacements[$domain][$original] ) ) {
			return $this->replacements[$domain][$original];
		} else {
			return $translated;
		}

	}
	
	function gettext_with_context( $translated, $original, $context, $domain ) {

		if ( isset ( $this->replacements[$domain][$original] ) ) {
			return $this->replacements[$domain][$original];
		} else {
			return $translated;
		}
	}
	
	function ngettext( $translated, $single, $plural, $number, $domain ) {

		if ( isset ( $this->replacements[$domain][$single] ) ) {
			return $this->replacements[$domain][$single];
		} else {
			return $translated;
		}
	}

	function ngettext_with_context( $translated, $single, $plural, $number, $context, $domain ) {

		if ( isset ( $this->replacements[$domain][$single] ) ) {
			return $this->replacements[$domain][$single];
		} else {
			return $translated;
		}
	}



}
