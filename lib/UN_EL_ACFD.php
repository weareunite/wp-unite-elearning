<?php

/**
 * ACF Dev wrapper and bootstrap
 *
 * @since 1.0.0
 */
class UN_EL_ACFD {

	const TEST_QUESTIONS_REPEATER_NAME = 'test_questions';
	const TEST_QUESTION_TITLE          = 'test_question_title';
	const TEST_QUESTION_DESC           = 'test_question_description';

	/**
	 * Class initialization
	 */
	public static function init() {
		add_action( 'after_setup_theme', [ __CLASS__, 'afterPluginsLoaded', ], 100 );
	}

	/**
	 * Hook to launch after plugins are loaded
	 */
	public static function afterPluginsLoaded() {
		if ( class_exists( 'ACFD' ) && ACFD::isActive() ) {
			self::runAcfdScript();
		}
	}

	/**
	 * Run scripts with ACF Dev library
	 */
	public static function runAcfdScript() {
		self::createTestCustomFields();
	}

	/**
	 * Create custom fields for test CPT
	 */
	public static function createTestCustomFields() {

		$wrapper = new CustomGroup( __( 'Test Settings', 'wp-unite-elearning' ), 'post_type == ' . UN_EL_Core::TEST_CPT_NAME );

		$repeater = $wrapper->addContainer( self::TEST_QUESTIONS_REPEATER_NAME, __( 'Test questions', 'wp-unite-elearning' ), 'repeater' );

		$repeater->addField( self::TEST_QUESTION_TITLE, __( 'Question title', 'wp-unite-elearning' ), 'text' );
		$repeater->addField( self::TEST_QUESTION_DESC, __( 'Question description', 'wp-unite-elearning' ), 'text' );
	}

}
