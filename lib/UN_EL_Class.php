<?php

/**
 * Class for wrapping class
 *
 * @since 1.0.0
 */
class UN_EL_Class {

	/**
	 * Class initialization
	 */
	public static function init() {
		add_filter( 'manage_class_posts_columns', [ __CLASS__, 'alterCustomColumns' ] );
		add_action( 'manage_class_posts_custom_column', [ __CLASS__, 'alterCustomColumnsFunctions' ], 10, 2 );
	}

	public static function alterCustomColumns( $columns ) {
		$columns['generate_qr'] = __( 'Generate QR', 'wp-unite-elearning' );

		return $columns;
	}

	public static function alterCustomColumnsFunctions( $column, $postId ) {

		switch ( $column ) {
			case 'generate_qr':

				$tests = UN_EL_Test::getTests();
				?>
                <div class="qr-generator-wrapper">
                    <select id="test-selector">
                        <option value="0"><?php _e( 'Choose test', 'wp-unite-elearning' ); ?></option>
						<?php foreach ( $tests as $test ): ?>
                            <option value="<?php echo $test->ID; ?>"><?php echo $test->post_title; ?></option>
						<?php endforeach; ?>
                    </select>
                    <a class="button button-primary un-el_generate-qr-button" data-class-id="<?php echo $postId; ?>"><?php echo __( 'Generate QR', 'wp-unite-elearning' ); ?></a>
                </div>
				<?php
				break;
		}

	}

	/**
	 * Number of pupils in class
	 *
	 * @param int $classId Class ID
	 *
	 * @return mixed Number of pupils
	 */
	public static function getPupilsNumber( $classId = 0 ) {

		return get_post_meta( $classId, UN_EL_ACFD::CLASS_PUPILS_NO, true );

	}

}
