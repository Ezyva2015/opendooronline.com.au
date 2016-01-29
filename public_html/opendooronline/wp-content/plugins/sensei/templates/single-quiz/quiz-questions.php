<?php
/**
 * The Template for displaying all Quiz Questions.
 *
 * Override this template by copying it to yourtheme/sensei/single-quiz/quiz-questions.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post, $woothemes_sensei, $current_user;

//echo "This is sensie <br>";

// Get User Meta
get_currentuserinfo();

// Handle Quiz Completion
do_action( 'sensei_complete_quiz' );

// Get Frontend data
$user_quiz_grade = $woothemes_sensei->quiz->data->user_quiz_grade;
$quiz_lesson = $woothemes_sensei->quiz->data->quiz_lesson;
$quiz_grade_type = $woothemes_sensei->quiz->data->quiz_grade_type;
$user_lesson_end = $woothemes_sensei->quiz->data->user_lesson_end;
$user_lesson_complete = $woothemes_sensei->quiz->data->user_lesson_complete;
$lesson_quiz_questions = $woothemes_sensei->quiz->data->lesson_quiz_questions;

// Check if the user has started the course
$lesson_course_id = absint( get_post_meta( $quiz_lesson, '_lesson_course', true ) );
$has_user_start_the_course = WooThemes_Sensei_Utils::user_started_course( $lesson_course_id, $current_user->ID );

// Get the meta info
$quiz_passmark = absint( get_post_meta( $post->ID, '_quiz_passmark', true ) );
$quiz_passmark_float = (float) $quiz_passmark;
?>
<div class="lesson-meta">
	<?php

	// Display user's quiz status
	$status = WooThemes_Sensei_Utils::sensei_user_quiz_status_message( $quiz_lesson, $current_user->ID );
	echo '<div class="sensei-message ' . $status['box_class'] . '">' . $status['message'] . '</div>';


//	echo "Bellow message <br>";

	// Lesson Quiz Meta
	if ( 0 < count( $lesson_quiz_questions ) )  {
		$question_count = 1;
		?>
		<form method="POST" action="<?php echo esc_url( get_permalink() ); ?>" enctype="multipart/form-data">
			<ol id="sensei-quiz-list">
				<?php foreach ($lesson_quiz_questions as $question_item) {

					// Setup current Frontend Question
					$woothemes_sensei->quiz->data->question_item = $question_item;
					$woothemes_sensei->quiz->data->question_count = $question_count;

					// Question Type
					$question_type = $woothemes_sensei->question->get_question_type( $question_item->ID );

					echo '<input type="hidden" name="questions_asked[]" value="' . $question_item->ID . '" />';

					do_action( 'sensei_quiz_question_type', $question_type );

					$question_count++;


//					echo "end loop <br>";

					design($question_item->ID);

					echo "<br> ";
				} // End For Loop ?>

			</ol>
			<?php do_action( 'sensei_quiz_action_buttons' ); ?>
		</form>
	<?php } else { ?>
		<div class="sensei-message alert"><?php _e( 'There are no questions for this Quiz yet. Check back soon.', 'woothemes-sensei' ); ?></div>
	<?php } // End If Statement ?>
</div>

<?php do_action( 'sensei_quiz_back_link', $quiz_lesson  ); ?>





<?php


function design($question_id) {

	$current_user = wp_get_current_user();
	/**
	 * @example Safe usage: $current_user = wp_get_current_user();
	 * if ( !($current_user instanceof WP_User) )
	 *     return;
	 */
//	echo 'Username: ' . $current_user->user_login . '<br />';
//	echo 'User email: ' . $current_user->user_email . '<br />';
//	echo 'User first name: ' . $current_user->user_firstname . '<br />';
//	echo 'User last name: ' . $current_user->user_lastname . '<br />';
//	echo 'User display name: ' . $current_user->display_name . '<br />';
//	echo 'User ID: ' . $current_user->ID . '<br />';
//
//	echo "This is the footer design of the question <br>";
//
?>

<?php
echo "
<div>
";




								//floyd code to get the note history

								$historynotes = get_user_meta($current_user->ID,'_grading_notes_history', true);

								$historyanswers = get_user_meta($current_user->ID,'_grading_answer_history', true);

 								//echo "<pre>";

								//echo $question_id." ".$lesson_id;

								//print_r($historyanswers);

								//echo "</pre>";

								if(is_array($historynotes)){



									//print_r($historynotes[$question_id]);



									if (array_key_exists($question_id, $historynotes) || isset($historynotes[$question_id])) {

										echo "<table class='table table-striped'>";

										echo "<tr><th colspan='3'>Question History</th></tr>";

										echo "<tr>";

										echo "<th>DATE</th>";

										echo "<th>Answer</th>";

										echo "<th>Notes</th>";

										echo "</tr>";

										foreach($historynotes[$question_id] as $dateTime=>$noteentry){



											echo "<tr>";

											echo "<td>".$dateTime."</td>";

											echo "<td>".$historyanswers[$question_id][$dateTime]."</td>";

											echo "<td>".$noteentry."</td>";

											echo "</tr>";



										}

										echo "</table>";

									}





								}





echo "


</div>
";
}

?>


<style>
	table{background-color:transparent}caption{padding-top:8px;padding-bottom:8px;color:#777;text-align:left}th{text-align:left}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered{border:1px solid #ddd}.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-of-type(odd){background-color:#f9f9f9}.table-hover>tbody>tr:hover{background-color:#f5f5f5}table col[class*=col-]{position:static;display:table-column;float:none}table td[class*=col-],table th[class*=col-]{position:static;display:table-cell;float:none}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}.table-responsive{min-height:.01%;overflow-x:auto}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}
</style>