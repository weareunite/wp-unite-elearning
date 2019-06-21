<?php

/**
 * Class for handling shortcodes
 *
 * @since 1.0.0
 */
class UN_EL_Shortcode {

	const QR_CODE_GENERATOR = 'un-el_generate-qr';

	/**
	 * Class initialization
	 */
	public static function init() {

		add_shortcode( self::QR_CODE_GENERATOR, [ __CLASS__, 'generateQrShortcode' ] );

	}

	/**
	 * Generate QR Shortcode
	 */
	public static function generateQrShortcode() {
		require plugin_dir_path( UN_ELING_INDEX ) . 'templates/qr-generator.php';
	}

}
