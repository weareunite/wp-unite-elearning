<?php

/**
 * Class for wrapping test
 *
 * @since 1.0.0
 */
class UN_EL_Test {

	/**
	 * Get test questions and data
	 *
	 * @param int $id ID of test
	 *
	 * @return array|bool Array with questions and data, or false if ID is zero
	 */
	public static function getTestQuestions( $id = 0 ) {

		if ( $id === 0 ) {
			return false;
		}

		$testQuestionsArray = [ 'wrapper' => get_field( UN_EL_ACFD::TEST_WRAPPER_CLASSES, $id ) ];

		$id = 0;
		while ( have_rows( UN_EL_ACFD::TEST_QUESTIONS_REPEATER_NAME ) ):the_row();

			$testQuestionsArray['id'] = $id;

			$title       = get_sub_field( UN_EL_ACFD::TEST_QUESTION_TITLE );
			$description = get_sub_field( UN_EL_ACFD::TEST_QUESTION_DESC );

			$testQuestionsArray['questions'][] = [
				'title'       => $title,
				'description' => $description,
				'id'          => $id,
			];

			while ( have_rows( UN_EL_ACFD::TEST_QUESTION_ANSWERS ) ):the_row();

				$answerTitle   = get_sub_field( UN_EL_ACFD::TEST_QUESTION_ANSWER_TITLE );
				$answerIsRight = get_sub_field( UN_EL_ACFD::TEST_QUESTION_ANSWER_RIGHT );

				$testQuestionsArray['questions'][ $id ]['answers'][] = [
					'title' => $answerTitle,
					'right' => $answerIsRight,
				];


			endwhile;

			$id ++;


		endwhile;

		return $testQuestionsArray;

	}
}
