<?php

/**
 * Core class
 *
 * @since 1.0.0
 */
class UN_EL_Core {

	const TEST_CPT_NAME = 'test';

	/**
	 * Plugin initialization
	 */
	public static function init() {
		UN_EL_ACFD::init();

		add_action( 'init', [ __CLASS__, 'registerCustomPostTypes', ], 10 );
		add_action( 'after_setup_theme', [ __CLASS__, 'initTranslations' ] );

	}

	/**
	 * Register CPT's
	 */
	public static function registerCustomPostTypes() {
		register_post_type( self::TEST_CPT_NAME, [
			'label'     => __( 'Tests', 'wp-unite-elearning' ),
			'public'    => true,
			'menu_icon' => 'dashicons-media-text',
			'supports'  => [
				'title',
				'editor',
				'author',
				'excerpt',
				'thumbnail',
				'custom-fields',
			],
		] );
	}

	/**
	 * Init i18n
	 */
	public static function initTranslations() {
		load_plugin_textdomain( 'wp-unite-elearning', false, dirname( plugin_basename( UN_ELING_INDEX ) ) . DIRECTORY_SEPARATOR . 'i18n' );
	}

}
