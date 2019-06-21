<?php

require plugin_dir_path( UN_ELING_INDEX ) . 'vendor/phpqrcode/qrlib.php';

/**
 * QR Generator Class wrapper
 */
class UN_EL_QR {

	public static function generateText( $string = '' ) {
		return QRcode::text( $string );
	}

}
