<?php

/**
 * Core class
 *
 * @since 1.0.0
 */
class UN_EL_Core {

	const TEST_CPT_NAME   = 'test';
	const CLASS_CPT_NAME  = 'class';
	const SCHOOL_CPT_NAME = 'school';

	/**
	 * Plugin initialization
	 */
	public static function init() {
		UN_EL_ACFD::init();
		UN_EL_Shortcode::init();
		UN_EL_Class::init();
		UN_EL_REST::init();

		add_action( 'init', [ __CLASS__, 'registerCustomPostTypes', ], 10 );
		add_action( 'after_setup_theme', [ __CLASS__, 'initTranslations' ], 10 );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'loadScriptsAndStyles' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'loadAdminScriptsAndStyles' ] );
		add_filter( 'single_template', [ __CLASS__, 'renderTemplatesFromPlugin' ], 10, 1 );

	}

	/**
	 * Register CPT's
	 */
	public static function registerCustomPostTypes() {

		$cpts = self::getCPTsToRegister();

		foreach ( $cpts as $cptName => $cptArgs ) {
			register_post_type( $cptName, [
				'label'     => $cptArgs['label'],
				'public'    => $cptArgs['public'],
				'menu_icon' => $cptArgs['menu_icon'],
				'rewrite'   => $cptArgs['rewrite'],
				'supports'  => $cptArgs['supports'],
			] );
		}
	}

	/**
	 * Init i18n
	 */
	public static function initTranslations() {
		load_plugin_textdomain( 'wp-unite-elearning', false, dirname( plugin_basename( UN_ELING_INDEX ) ) . DIRECTORY_SEPARATOR . 'i18n' );
	}

	/**
	 * Load templates from plugin based on post type
	 *
	 * @param string $single Path to template
	 *
	 * @return string Path to template
	 *
	 */
	public static function renderTemplatesFromPlugin( $single = '' ) {
		global $post;

		if ( $post->post_type == UN_EL_Core::TEST_CPT_NAME ) {
			if ( file_exists( UN_ELING_PATH . '/templates/single-' . $post->post_type . '.php' ) ) {
				return UN_ELING_PATH . '/templates/single-' . $post->post_type . '.php';
			}
		}

		return $single;


	}

	public static function getCPTsToRegister() {

		$cpts = [
			self::TEST_CPT_NAME   => [
				'label'     => __( 'Tests', 'wp-unite-elearning' ),
				'public'    => true,
				'menu_icon' => 'dashicons-media-text',
				'rewrite'   => [
					'slug' => 'quiz_test',
				],
				'supports'  => [
					'title',
					'editor',
					'author',
					'excerpt',
					'thumbnail',
					'custom-fields',
				],
			],
			self::CLASS_CPT_NAME  => [
				'label'     => __( 'Classes', 'wp-unite-elearning' ),
				'public'    => true,
				'menu_icon' => 'dashicons-welcome-learn-more',
				'rewrite'   => [
					'slug' => 'class',
				],
				'supports'  => [
					'title',
					'editor',
					'author',
					'excerpt',
					'thumbnail',
					'custom-fields',
				],
			],
			self::SCHOOL_CPT_NAME => [
				'label'     => __( 'Schools', 'wp-unite-elearning' ),
				'public'    => true,
				'menu_icon' => 'dashicons-admin-multisite',
				'rewrite'   => [
					'slug' => 'school',
				],
				'supports'  => [
					'title',
					'editor',
					'author',
					'excerpt',
					'thumbnail',
					'custom-fields',
				],
			],
		];

		return $cpts;

	}

	/**
	 * Load scripts and styles
	 */
	public static function loadScriptsAndStyles() {
		wp_enqueue_style( 'core-css', plugins_url( '/css/core.min.css', UN_ELING_INDEX ), [], '1.0.0' );
		wp_enqueue_script( 'core-js', plugins_url( '/js/core.min.js', UN_ELING_INDEX ), [ 'jquery' ], '1.0.0', true );
	}

	public static function loadAdminScriptsAndStyles() {

		wp_enqueue_style( 'toastr-css', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css', [], '1.0.0' );

		wp_enqueue_script( 'admin-core-js', plugins_url( '/js/admin-core.min.js', UN_ELING_INDEX ), [ 'jquery' ], '1.0.0', true );
		wp_enqueue_script( 'toastr-js', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', [
			'jquery',
			'admin-core-js',
		], '1.0.0', true );

		wp_localize_script( 'admin-core-js', 'Core', [
			'rest_url' => rest_url(),
			'routes'   => [
				'generate_qr' => UN_EL_REST::BASE_PATH . '/' . UN_EL_REST::GENERATE_QR_ROUTE,
			],
		] );
	}

}
