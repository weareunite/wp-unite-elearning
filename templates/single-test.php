<?php
/**
 * Template for single test
 *
 * @since 1.0.0
 */

// Initialization functions

$testData = UN_EL_Test::getTestQuestions( get_the_ID() );

// Template

get_header();
?>
    <div class="un-el_test-wrapper <?php echo $testData['wrapper']; ?>">
        <form>
			<?php foreach ( $testData['questions'] as $qid => $question ) : ?>
				<?php $qid = $question['id']; ?>
                <div class="un-el_question-wrapper">
                    <h1>
						<?php echo $question['title']; ?>
                    </h1>
					<?php foreach ( $question['answers'] as $aid => $answer ): ?>
                        <div class="un-el_answer_wrapper">
							<?php $answerId = 'q' . $qid . 'a' . $aid; ?>
                            <input class="un-el_answer" type="checkbox" id="<?php echo $answerId; ?>" name="<?php echo $answerId; ?>">
                            <label class="un-el_answer_label" for="<?php echo $answerId; ?>"><?php echo $answer['title']; ?></label>
                        </div>
					<?php endforeach; ?>
                </div>
			<?php endforeach; ?>
            <a class="un-el_btn un-el_btn--rounded" id="un-el_submit-button"><? echo __( 'Submit test', 'wp-unite-elearning' ); ?></a>
        </form>
    </div>
<?php
get_footer();
