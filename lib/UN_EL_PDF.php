<?php

require plugin_dir_path( UN_ELING_INDEX ) . 'vendor/fpdf181/fpdf.php';

/**
 * QR Generator Class wrapper
 */
class UN_EL_PDF {

	public static function createPDF() {
		return new FPDF();
	}

}
