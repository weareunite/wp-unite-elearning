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
		add_action( 'after_setup_theme', [ __CLASS__, 'initTranslations' ], 10 );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'loadScriptsAndStyles' ] );
		add_filter( 'single_template', [ __CLASS__, 'renderTemplatesFromPlugin' ], 10, 1 );

	}

	/**
	 * Register CPT's
	 */
	public static function registerCustomPostTypes() {
		register_post_type( self::TEST_CPT_NAME, [
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
		] );
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

	/**
	 * Load scripts and styles
	 */
	public static function loadScriptsAndStyles() {
		wp_enqueue_style( 'core-css', plugins_url( '/css/core.min.css', UN_ELING_INDEX ), [], '1.0.0' );
		wp_enqueue_script( 'core-js', plugins_url( '/js/core.min.js', UN_ELING_INDEX ), [ 'jquery' ], '1.0.0', true );
	}

}
