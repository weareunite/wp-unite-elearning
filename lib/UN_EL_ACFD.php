<?php

/**
 * ACF Dev wrapper and bootstrap
 *
 * @since 1.0.0
 */
class UN_EL_ACFD {

	// Test CPT custom fields keys
	const TEST_QUESTIONS_REPEATER_NAME = 'test_questions';
	const TEST_QUESTION_TITLE          = 'test_question_title';
	const TEST_QUESTION_DESC           = 'test_question_description';
	const TEST_QUESTION_ANSWERS        = 'test_question_answers';
	const TEST_QUESTION_ANSWER_TITLE   = 'test_question_answer_title';
	const TEST_QUESTION_ANSWER_RIGHT   = 'test_question_answer_right';
	const TEST_WRAPPER_CLASSES         = 'test_wrapper_classes';

	// Class CPT custom fields key
	const CLASS_SCHOOL_ID      = 'class_school_id';
	const CLASS_TEACHER_PERSON = 'class_teacher_person';
	const CLASS_TEACHER_PHONE  = 'class_teacher_phone';
	const CLASS_TEACHER_EMAIL  = 'class_teacher_email';
	const CLASS_PUPILS_NO      = 'class_pupils_no';

	// School CPT custom fields key
	const SCHOOL_ADDRESS        = 'school_address';
	const SCHOOL_CONTACT_PERSON = 'school_person';
	const SCHOOL_CONTACT_PHONE  = 'school_phone';
	const SCHOOL_CONTACT_EMAIL  = 'school_email';

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
		self::createClassCustomFields();
		self::createSchoolCustomFields();
	}

	/**
	 * Create custom fields for test CPT
	 */
	public static function createTestCustomFields() {

		$wrapper = new CustomGroup( __( 'Test Settings', 'wp-unite-elearning' ), 'post_type == ' . UN_EL_Core::TEST_CPT_NAME );

		$wrapper->addField( self::TEST_WRAPPER_CLASSES, __( 'Wrapper classes (space separated)', 'wp-unite-elearning' ), 'text' );
		$repeater = $wrapper->addContainer( self::TEST_QUESTIONS_REPEATER_NAME, __( 'Test questions', 'wp-unite-elearning' ), 'repeater' );

		$repeater->addField( self::TEST_QUESTION_TITLE, __( 'Question title', 'wp-unite-elearning' ), 'text' );
		$repeater->addField( self::TEST_QUESTION_DESC, __( 'Question description', 'wp-unite-elearning' ), 'text' );

		$answers = $repeater->addContainer( self::TEST_QUESTION_ANSWERS, __( 'Answers', 'wp-unite-elearning' ), 'repeater' );

		$answers->addField( self::TEST_QUESTION_ANSWER_TITLE, __( 'Answer title', 'wp-unite-elearning' ), 'wysiwyg' );
		$answers->addField( self::TEST_QUESTION_ANSWER_RIGHT, __( 'Is right', 'wp-unite-elearning' ), 'true_false' );
	}

	/**
	 * Create custom fields for class CPT
	 */
	public static function createClassCustomFields() {

		$wrapper = new CustomGroup( __( 'Class Settings', 'wp-unite-elearning' ), 'post_type == ' . UN_EL_Core::CLASS_CPT_NAME );

		$wrapper->addField( self::CLASS_SCHOOL_ID, __( 'School', 'wp-unite-elearning' ), 'post_object' )
		        ->set( 'post_type', [ UN_EL_Core::SCHOOL_CPT_NAME ] )
		        ->set( 'taxonomy', [] )
		        ->set( 'allow_null', 1 )
		        ->set( 'multiple', 0 )
		        ->set( 'return_format', 'id' )
		        ->setRequired( true );

		$wrapper->addField( self::CLASS_TEACHER_PERSON, __( 'Class contact person', 'wp-unite-elearning' ), 'text' );
		$wrapper->addField( self::CLASS_TEACHER_PHONE, __( 'Class contact phone', 'wp-unite-elearning' ), 'text' );
		$wrapper->addField( self::CLASS_TEACHER_EMAIL, __( 'Class contact email', 'wp-unite-elearning' ), 'email' );
		$wrapper->addField( self::CLASS_PUPILS_NO, __( 'Number of pupils', 'wp-unite-elearning' ), 'number' )->setRequired( true );

	}

	/**
	 * Create custom fields for school CPT
	 */
	public static function createSchoolCustomFields() {

		$wrapper = new CustomGroup( __( 'School Settings', 'wp-unite-elearning' ), 'post_type == ' . UN_EL_Core::SCHOOL_CPT_NAME );

		$wrapper->addField( self::SCHOOL_ADDRESS, __( 'Address', 'wp-unite-elearning' ), 'text' );
		$wrapper->addField( self::SCHOOL_CONTACT_PERSON, __( 'Contact person', 'wp-unite-elearning' ), 'text' );
		$wrapper->addField( self::SCHOOL_CONTACT_PHONE, __( 'Contact phone', 'wp-unite-elearning' ), 'text' );
		$wrapper->addField( self::SCHOOL_CONTACT_EMAIL, __( 'Contact email', 'wp-unite-elearning' ), 'email' )->setRequired( true );
	}

}
