<?php

/**
 * REST Class
 */
class UN_EL_REST {

	// Base settings
	const BASE_PATH = 'wp-unite-elearning/v1';
	const SECRET    = '1Ld37ReJD3agJd19lQQf3vrMeV50p2um';

	// Routes
	const GENERATE_QR_ROUTE = 'generate-qr';
	const FETCH_SCHOOLS     = 'fetch-schools';

	/**
	 * Class initialization
	 */
	public static function init() {
		add_action( 'rest_api_init', [ __CLASS__, 'restApiInit' ] );
	}

	/**
	 * Init REST API
	 */
	public static function restApiInit() {

		register_rest_route( self::BASE_PATH, '/' . self::GENERATE_QR_ROUTE, [
			'methods'  => 'POST',
			'callback' => [ __CLASS__, 'generateQr' ],
		] );

		register_rest_route( self::BASE_PATH, '/' . self::FETCH_SCHOOLS, [
			'methods'  => 'POST',
			'callback' => [ __CLASS__, 'fetchSchools' ],
		] );

	}

	/**
	 * Generate QR Codes REST API Route
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public static function generateQr( WP_REST_Request $request ) {
		$params  = $request->get_params();
		$testId  = $params['test_id'];
		$classId = $params['class_id'];

		$data    = [];
		$success = true;
		$code    = '';
		$message = '';

		if ( intval( $testId ) === 0 || empty( $testId ) ) {
			$success = false;
			$code    = 'no_test_provided';
			$message = __( 'Test ID was not provided', 'wp-unite-elearning' );
		}

		if ( intval( $classId ) === 0 || empty( $classId ) ) {
			$success = false;
			$code    = 'no_class_provided';
			$message = __( 'Class ID was not provided', 'wp-unite-elearning' );
		}

		if ( $success ) {
			$code    = 'generated_successfully';
			$message = __( 'QR Codes was generated successfully', 'wp-unite-elearning' );
		}

		$noPupils = UN_EL_Class::getPupilsNumber( $classId );

		$pdfName = plugin_dir_path( UN_ELING_INDEX ) . 'pdf/' . $classId . '-' . $testId . '.pdf';

		$pdf = new FPDF();
		for ( $i = 0; $i < $noPupils; $i ++ ) {
			$executionUrl = UN_EL_Test::generateExecutionUrl( $classId, $testId, $i + 1 );
			$imageFile    = plugin_dir_path( UN_ELING_INDEX ) . 'qr/' . $classId . '-' . $testId . '-' . $i . '.png';
			QRCode::png( $executionUrl, plugin_dir_path( UN_ELING_INDEX ) . 'qr/' . $classId . '-' . $testId . '-' . $i . '.png' );
			$pdf->AddPage();
			$pdf->SetFont( 'Arial', 'B', 16 );
			$pdf->Image( $imageFile, 10, 10 );
		}
		$pdf->Output( 'F', $pdfName );

		return new WP_REST_Response( [
			'success' => $success,
			'code'    => $code,
			'data'    => $data,
			'message' => $message,
		] );
	}

	public static function fetchSchools( WP_REST_Request $request ) {
		$params = $request->get_params();

		$data    = [];
		$success = true;
		$code    = '';
		$message = '';

		$secret  = $params['secret'];
		$schools = $params['schools'];

		if ( $secret === null ) {
			$success = false;
			$code    = 'no_secret_defined';
			$message = __( 'No secret defined for request', 'wp-unite-elearning' );
		}

		if ( $secret !== self::SECRET ) {
			$success = false;
			$code    = 'wrong_secret';
			$message = __( 'Defined secret is wrong', 'wp-unite-elearning' );
		}

		if ( $schools === null ) {
			$success = false;
			$code    = 'no_schools_defined';
			$message = __( 'No schools defined for request', 'wp-unite-elearning' );
		}

		$stats   = [
			'succeed' => 0,
			'failed'  => 0,
			'errors'  => [
				'no_title' => 0,
			],
		];
		$schools = json_decode( $schools, true );

		foreach ( $schools as $school ) {
			if ( empty( $school['title'] ) ) {

			}
		}

		die;

		return new WP_REST_Response( [
			'success' => $success,
			'code'    => $code,
			'data'    => $data,
			'message' => $message,
		] );
	}

}
