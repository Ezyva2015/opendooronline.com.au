<?php 

add_action( 'wp_head', 'process_post' );

//process post from course/lesson and quiz

function process_post() {
	global $post;
	global $current_user;
	
     if( isset( $_POST['quiz_save'] ) ) {

		get_currentuserinfo();		
		
		$number_ofquestions = count($_POST['questions_asked']);
		$question_answered = count($_POST['sensei_question']);
		$remaining_question = $number_ofquestions-$question_answered;
		$blogtime = current_time( 'mysql' ); 

		
		$array_savequiz['total_questtion'] = $number_ofquestions;
		$array_savequiz['question_answered'] = $question_answered;
		$array_savequiz['remaining_question'] = $remaining_question;
		$array_savequiz['DATETIME'] = $blogtime;
		$array_savequiz['lesson_id'] = $post->ID;
		$array_savequiz['lesson_title'] = get_the_title();
		$array_savequiz['user_id'] = $current_user->ID;
		$array_savequiz['fullname'] = $current_user->display_name;
		

		$svequiz = get_option( 'savequiz_list' );
		
	
		
		if(empty($svequiz)){
				
			$svequiz[]=$array_savequiz;		
			
		}else{
			
			$svequiz[]=$array_savequiz;
			
		}
		/*
		echo "<pre>";
		print_r($svequiz);
		echo "</pre>";
		*/
		update_option( 'savequiz_list', $svequiz);

			
          // process $_POST data here
     }
	 
	 if( isset( $_POST['course_start'] ) ) {
		 
		

		$user_course_data =  get_user_meta( $current_user->ID, 'user_course_data', true);
		
		if(!empty($user_course_data)){
		$user_course_data[$post->ID]['course_title'] = $post->post_title;
		$user_course_data[$post->ID]['start_date'] = current_time( 'mysql' );
		update_user_meta( $current_user->ID, 'user_course_data', $usermeta_course_value);
		}else{
			
		$usermeta_course_value[$post->ID]['course_title'] = $post->post_title;
		$usermeta_course_value[$post->ID]['start_date'] = current_time( 'mysql' );			
		update_user_meta( $current_user->ID, 'user_course_data', $usermeta_course_value);	
			
		}
	
		 
		 
	 }	 
	 
	 
	 
	 
	 
	 
}



add_action( 'admin_menu', 'savedquest_function' );

function savedquest_function() {
	add_options_page( 'Saved Quest Options', 'Saved Quiz', 'manage_options', 'saved-quiz-data', 'savedquest_options' );
}

function get_percentage($total, $number){
  if ( $total > 0 ) {
   return round($number / ($total / 100),2);
  } else {
    return 0;
  }
}


function gettime_st($date){

if($date!=""){
$date = new DateTime($date);
return $result = $date->format('F d Y, l H:i:s');
}

}

function savedquest_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	
	echo '<div class="wrap" style="background:#fff;">';
	
	if(isset($_GET['tab'])){
		
		$tab = $_GET['tab'];
	}else{
		$tab = "";
	}
	
	saved_admin_tab($tab);
	
	
	
	if($tab=="quiztaken" or $tab==""){
	?>
		<table  class="wp-list-table widefat fixed striped pages" width="100%" style="border-spacing: 0; text-align:center;" >
			<tr>
				<th>Lesson ID</th>
				<th>Lesson Title</th>
				<th>Number Of Questions</th>
				<th>Question Answered</th>
				<th>Unanswered Question</th>
				<th>User</th>
				<th>User Id</th>
				<th>DATE And Time</th>
			</tr>
			<?php $svequiz = get_option( 'savequiz_list' ); ?>
			<?php foreach($svequiz as $quizdata){?>
			<tr>
				<td><?php echo $quizdata['lesson_id']; ?></td> 	
				<td><?php echo $quizdata['lesson_title']; ?></td> 
				<td><?php echo $quizdata['total_questtion']; ?></td> 
				<td><?php echo $quizdata['question_answered']; ?>(<?php echo get_percentage($quizdata['total_questtion'], $quizdata['question_answered'])."%"; ?>)</td> 
				<td><?php echo $quizdata['remaining_question']; ?>(<?php echo 100-get_percentage($quizdata['total_questtion'], $quizdata['question_answered'])."%"; ?>)</td> 
				<td><?php echo $quizdata['fullname']; ?></td>		
				<td><?php echo $quizdata['user_id']; ?> </td>				
				<td><?php echo $quizdata['DATETIME']; ?></td> 				
			</tr>
			<?php }  ?>
		</table>
		
	<?php
	}elseif($tab=="timesession"){
		
		$user_last_login_logout = get_option( 'user_last_login_logout' );
		
		
	?>
	<br /><br/>
		<table  class="wp-list-table widefat fixed striped pages" width="100%" style="border-spacing: 0; text-align:center;" >
			<tr>
				<th>User ID</th>
				<th>Full Name</th>
				<th>Last Login</th>
				<th>Last Logout</th>
				<th>Amout of Time Spent</th>
				<th>Role</th>

			</tr>
			<?php $svequiz = get_option( 'savequiz_list' ); ?>
			<?php foreach($user_last_login_logout as $last_login_logout){?>
			<?php 	if($last_login_logout['user_id']!=""):?>
			<?php 	$user_info = get_userdata($last_login_logout['user_id']); ?>
			<tr>
				<td><?php echo $last_login_logout['user_id']; ?></td> 
				<td><?php echo $user_info->display_name; ?></td> 					
				<td><?php echo gettime_st($last_login_logout['logintime']); ?></td> 
				<td><?php echo gettime_st($last_login_logout['logouttime']); ?></td> 
				<?php 
				if($last_login_logout['logouttime']!=""){
					
					$date1=date_create($last_login_logout['logintime']);
					$date2=date_create($last_login_logout['logouttime']);
					$diff=date_diff($date1,$date2);
					$diftime = $diff->format("%h Hours %i Minute %s Seconds");
					
				}else{
				
					$diftime="";
					
				}
				
				
				?>
				
				<th><?php echo $diftime; ?></th>
				<td><?php echo implode(', ', $user_info->roles); ?></td>
		
			</tr>
			<?php endif; ?>
			<?php }  ?>
		</table><br /><br />


	<?php	
		
		
		
		
	}elseif($tab=="timequizecompleted"){
		
		
		global $woothemes_sensei, $post, $current_user, $wp_query, $learner_user;
		
		echo  "<table class='wp-list-table widefat fixed striped pages'>";
		
		$allUsers = get_users();
		echo "<tr>
				<th>User</th>
				<th>Courses</th>
				<th>Percentage Incomplete</th>
				<th>Percentage Complete</th>
				<th>Percentage Competent</th>
				<th>Percentage Attempted</th>
				<th>Length of time Course Completed</th>
			  </tr>";			
		foreach($allUsers as $user){
			
			$args = array(
				 'post_type' => 'course'
			);
			
			$courses = get_posts( $args );

					

			$i = 1;
			foreach($courses as $course){

				
				$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $course->ID, $user->ID );
				$course_status = WooThemes_Sensei_Utils::user_course_status( $course->ID, $user->ID );	
				$course_status_update = get_comment_meta( $course_status->comment_ID );
				

				if(!empty($course_status)){
				
					$displayed_lessons = array();

					$modules = Sensei()->modules->get_course_modules( intval( $course->ID ) );

					foreach( $modules as $module ) {

						$args = array(
							'post_type' => 'lesson',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => '_lesson_course',
									'value' => intval( $course->ID ),
									'compare' => '='
								)
							),
							'tax_query' => array(
								array(
									'taxonomy' => Sensei()->modules->taxonomy,
									'field' => 'id',
									'terms' => intval( $module->term_id )
								)
							),
							'meta_key' => '_order_module_' . $module->term_id,
							'orderby' => 'meta_value_num date',
							'order' => 'ASC',
							'suppress_filters' => 0
						);

						$lessons = get_posts( $args );

						if( count( $lessons ) > 0 ) {
							$html .= '<h3>' . $module->name . '</h3>' . "\n";

							$count = 0;
							foreach( $lessons as $lesson_item ) {

								$lesson_grade = ' n/a';
								$has_questions = get_post_meta( $lesson_item->ID, '_quiz_has_questions', true );
								if ( $has_questions ) {
									$lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $lesson_item->ID, $user->ID );
									// Get user quiz grade
									$lesson_grade = get_comment_meta( $lesson_status->comment_ID, 'grade', true );
									if ( $lesson_grade ) {
										$lesson_grade .= '%';
									}
									
									
									$modulequizdata = get_comment_meta( $lesson_status->comment_ID );									
									
									//echo "<a href='".get_post_permalink($lesson_item->ID)."'>".$lesson_item->post_title."</a><br />"; 									
									$modulequestion_asked =  count(explode(",",$modulequizdata['questions_asked'][0]));
									$moduleanswered_quiz = count(unserialize($modulequizdata['quiz_answers'][0]));												
									//echo "number of questions:".$modulequestion_asked."<br />";
									//echo "number of Answered:".$moduleanswered_quiz."<br />";
									
									
									if($course_status->comment_approved=="complete"){
										
										$attempted =  "(100%)";
										
									}else{
										if($modulequizdata['grade'][0]==""){
											
											if($lesson_status->comment_approved=="passed"){
													
												$attempted = 'P/Q';

											}else{
										
												if($modulequestion_asked>=$moduleanswered_quiz){

													 if($modulequizdata['quiz_answers'][0]==""){		
								
														$attempted = "";
													
													 }else{
														 
														 $attempted =  "( ". get_percentage($modulequestion_asked, $moduleanswered_quiz)."% ) Saved";
														 
													 }		
													
												}												
												
											}	
											

											
										}else{

												$attempted =  "( ". get_percentage($modulequestion_asked, $moduleanswered_quiz)."% )";
											
											
										}	

										//echo "<pre>";
										//echo "Attempted:".$attempted."<br />";
										//echo $user->user_email."<br />";
										//echo $modulequizdata['grade'][0]."<br />";
										//echo $modulequizdata['quiz_answers'][0]."<br />";
										
										
										//print_r($lesson_status);	
										//echo "</pre>";
									}	
									
									
									
								}
								$html .= '<a href="' . esc_url( get_permalink( $lesson_item->ID ) ) . '" title="' . esc_attr( sprintf( __( 'Start %s', 'woothemes-sensei' ), $lesson_item->post_title ) ) . '">' . esc_html( sprintf( __( '%s', 'woothemes-sensei' ), $lesson_item->post_title ) ) . '</a> ' . $attempted . '<br />';

								$displayed_lessons[] = $lesson_item->ID;
							}
						}
					}

					$args = array(
						'post_type' => 'lesson',
						'posts_per_page' => -1,
						'suppress_filters' => 0,
						'meta_key' => '_order_' . $course->ID,
						'orderby' => 'meta_value_num date',
						'order' => 'ASC',
						'meta_query' => array(
							array(
								'key' => '_lesson_course',
								'value' => intval( $course->ID ),
							),
						),
						'post__not_in' => $displayed_lessons,
					);

					$lessons = get_posts( $args );

					//echo "Number of lesson in a course: ".count($lessons);	

					if(  0 < count( $lessons ) ) {
						 $html .= '<h3>' . __( 'Other Lessons', 'woothemes-sensei' ) . '</h3>' . "\n";
					}
				
				if($course_status_update['percent'][0]==100){													
					$date1=date_create($course_status_update['start'][0]);
					$date2=date_create($course_status->comment_date);
					$diff=date_diff($date1,$date2);
					$diftime = $diff->format("%h Hours %i Minute %s Seconds");
					
				}else{
					
					$diftime = "course not completed yet.";
					
				}
				
				
				$allcourseid[]=$course->ID;
				$incomplete = 100 - $course_status_update['percent'][0];
				
					
					echo "<tr><td>";
					echo $user->user_email;
					echo "</td>";
					echo "<td>";
					echo "<a href='".get_post_permalink($course->ID)."'>".$course->post_title."</a>";
					echo "</td>";	
					echo "<td>";
					echo $incomplete."%";
					echo "</td>";	
					echo "<td>";
					echo $course_status_update['percent'][0]."%";
					echo "</td>";										
					echo "<td>";
					echo $course_user_grade."%";
					echo "</td>";					
					echo "<td>";
						echo $html;
						$html = "";
						foreach ( $lessons as $lesson_item ) {

							$lesson_grade = 'n/a';
							$has_questions = get_post_meta( $lesson_item->ID, '_quiz_has_questions', true );
							if ( $has_questions ) {
								$lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $lesson_item->ID, $user->ID );
								// Get user quiz grade
								$lesson_grade = get_comment_meta( $lesson_status->comment_ID, 'grade', true );
								if ( $lesson_grade ) {
									$lesson_grade .= '%';
								}
							}
							
							$quizdata = get_comment_meta( $lesson_status->comment_ID );
							

							//echo "<h1>Comment</h1>";
							//print_r(get_comment_meta( $lesson_status->comment_ID ));
							//echo "<h1>LESSON STATUS</h1>";
							//print_r($lesson_status);	
							
							echo "<a href='".get_post_permalink($lesson_item->ID)."'>".$lesson_item->post_title."</a> "; 
							//print_r($quizdata);

							$question_asked =  count(explode(",",$quizdata ['questions_asked'][0]));
							$answered_quiz = count(unserialize($quizdata ['quiz_answers'][0]));
		
							
							
							if($quizdata ['grade'][0]==""){
							
								if($question_asked>$answered_quiz){								
									echo "( ". get_percentage($question_asked, $answered_quiz)."% )";
								}
								
							}else{
								
								echo "(100%)";
								
							}	
							echo '<br />';

						} // End For Loop	
						
					echo "</td>";
					echo "<td>";
					echo $diftime;					
					echo "</td>";

					
					echo "</tr>";
					//echo $course->post_title." (".$course_status_update['percent'][0]."% Complete) (". $incomplete . "% incomplete) (". $course_user_grade . "% Competent)<br />";
					$i++;
				}
				
				
			}	
				
				



			
		}
		echo  "</table>";		


		

	}elseif($tab=="threshold"){
		//declare the wpdb for custom query
		global $wpdb;
		
		//check for submitted data
		if(isset($_POST['submittreshold']) && $_POST['submittreshold']="submit"){
			
			// declare users and variables		
			$allUsers = get_users();
			$modules_completed = $_POST['completionpermonth'];
			$courseid = $_POST['course'];
			$course_name = get_the_title($courseid);
			$array_to_csv = Array(
				Array('Student Name',
					'Course Name '
				)

			);

			
			//user loop ----- loop user get the groups and course the course they take
			foreach($allUsers as $user){
	
				//declare course function calls
				
				$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->ID );
				$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->ID );	
				$course_status_info = get_comment_meta( $user_course_status->comment_ID );		
				$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->ID );
				$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->ID );
				$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );	

					 //get the user groups
					$useringroup = new Groups_User( $user->ID );
					$user_groups = $useringroup->__get( 'groups' );
					
					$displayed_lessons = array();
					//declare and get module values
					$modules = Sensei()->modules->get_course_modules( intval( $courseid ) );
					$modules_content = Sensei()->modules->course_module_content( intval( $courseid ) );


					//echo "<pre>";
					//echo $user->user_email."<br />";
					//echo "sensei_user_course_status_message: ";
					//print_r($course_status);
					//echo "<br />";
					//echo "started_course: "."<br />";
					
					$course_status_info['start'][0];
					$datenow = date('Y-m-d h:i:s');
					
					$date1=date_create($course_status_info['start'][0]);
					$date2=date_create($datenow);
					$diff=date_diff($date1,$date2);					
					$diftime = $diff->format("%m");
					
					if($diftime<1){
						
						$diftime = 1;
						
					}
					//echo "</pre>";

					//module loop per user	
					foreach( $modules as $module ) {

						$args = array(
							'post_type' => 'lesson',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => '_lesson_course',
									'value' => intval( $courseid ),
									'compare' => '='
								)
							),
							'tax_query' => array(
								array(
									'taxonomy' => Sensei()->modules->taxonomy,
									'field' => 'id',
									'terms' => intval( $module->term_id )
								)
							),
							'meta_key' => '_order_module_' . $module->term_id,
							'orderby' => 'meta_value_num date',
							'order' => 'ASC',
							'suppress_filters' => 0
						);

						$lessons = get_posts( $args );
						$num_of_lesson = count($lessons);
						
						//lessson loop per user
						
						foreach( $lessons as $lesson_item ) {
							
							$is_lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_item->ID, $user->ID );
							
							
							if($is_lesson_completed==1){
								
								$lesson_completed[] = $is_lesson_completed;
								
							}
							
							
						}
						
						//echo "lesson completed:". count($lesson_completed)."<br />";
						
						
						if(count($lesson_completed)>0){
						
							if($num_of_lesson == count($lesson_completed)){
								
								$completed_modules_per_user[] = 1;
								$total_module_passed[] = 1;
								
								
								//echo "---Module completed <br />";
								
								
							}else{
								
								//echo "---Module not completed <br />";
								
							}	
						}else{
							
							
							//echo "---Module not completed <br />";
							
							
						}		
						unset($lesson_completed);
						unset($completed_modules_per_user);
	
					}
					
					 $overaalltotal_module_passed = count($total_module_passed);

					 //echo $overaalltotal_module_passed . " module being passed";
					 
					 //loop throughout the user group under a user
					if(is_array($user_groups)){				
						foreach($user_groups as $user_group){
							if($user_group->group_id==$_POST['group']){								
								if(!empty($user_course_status)){
									
									$modules_completed_from_groups = $user_group->description;
									
									if($modules_completed==""){										
										$modules_completed = $modules_completed_from_groups;																	
									}									
								
									$num_of_module_x_difftime = $modules_completed*$diftime;
									
									//echo "<br />num_of_module_x_difftime:".$num_of_module_x_difftime;
										
									if($overaalltotal_module_passed>=$num_of_module_x_difftime){
										
										
										$array_to_csv[] = array($user->display_name,$course_name);
										//$userid_within_group[$user->user_email] = $user->ID;								
									
									}
									
									
								}								
								
							}				
							//echo $user_group->group_id."<br />";

						}
					}
										
				unset($total_module_passed);
			}
			

				
			
			//echo "<pre>";
			//echo $modules_completed;
			//print_r($array_to_csv);
			//echo "</pre>";
			
			convert_to_csv($array_to_csv, 'report-'.md5(date('Y-m-d h:i:s')).'.csv', ',');
		}
		
		
?>		<div class="form-wrap" style="padding:20px;">
			<form action="" method="post">
				
				<div>
					<label>
						Group:
					</label>
						<?php
							
							$groups = $wpdb->get_results( 'SELECT * FROM `wp_groups_group`');		

						?>					
					<select name="group">
						<?php 
						
						foreach($groups as $group){
													
							echo "<option value='".$group->group_id."'>";
							echo $group->name;	
							echo "</option>";
							
							
						}
						
						?>
					</select>				
				</div>
				<div>
					<label>
						Course:
					</label>
					
					<?php $course = new WP_Query( array( 'post_type' => 'course' ) ); ?>
					
					<select name="course">
						<?php 

						// The Loop
						if ( $course->have_posts() ) {

							while ( $course->have_posts() ) {
								$course->the_post();
								echo '<option value="'.$course->post->ID.'">' . get_the_title() . '</option>';
							}
							
						}
						
						/* Restore original Post Data */

						?>																
					</select>
					<?php wp_reset_postdata(); ?>
				</div>
				<div>				
					<label>
						How many modules should be completed by now?
					</label>	
					<input type="text" name="completionpermonth" />
				</div><br /><br />			
				<input type="submit" class="button button-primary" name="submittreshold" value="submit" />										
			</form>
		</div>	
		
		
<?php		
		
	}elseif($tab=="incremental-progress"){
		

		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

		
		//declare the wpdb for custom query
		global $wpdb;
		
		//check for submitted data
		if(isset($_POST['submitincrenmental']) && $_POST['submitincrenmental']="submit"){
			
			// declare users and variables		
			$allUsers = get_users();
			$modules_completed = $_POST['completionpermonth'];
			$courseid = $_POST['course'];
			$course_name = get_the_title($courseid);
			$array_to_csv = Array(
				Array('Student Name',
					'Course Name ',
					'Lesson Title'
				)

			);

			
			//user loop ----- loop user get the groups and course the course they take
			foreach($allUsers as $user){
	
				//declare course function calls
				
				$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->ID );
				$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->ID );	
				$course_status_info = get_comment_meta( $user_course_status->comment_ID );		
				$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->ID );
				$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->ID );
				$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );	

					 //get the user groups
					$useringroup = new Groups_User( $user->ID );
					$user_groups = $useringroup->__get( 'groups' );
					
					$displayed_lessons = array();
					//declare and get module values
					$modules = Sensei()->modules->get_course_modules( intval( $courseid ) );
					$modules_content = Sensei()->modules->course_module_content( intval( $courseid ) );

					$course_status_info['start'][0];
					$datenow = date('Y-m-d h:i:s');
					
					$date1=date_create($course_status_info['start'][0]);
					$date2=date_create($datenow);
					$diff=date_diff($date1,$date2);					
					$diftime = $diff->format("%m");
					
					if($diftime<1){
						
						$diftime = 1;
						
					}
					//echo "</pre>";

					//module loop per user	
					foreach( $modules as $module ) {

						$args = array(
							'post_type' => 'lesson',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => '_lesson_course',
									'value' => intval( $courseid ),
									'compare' => '='
								)
							),
							'tax_query' => array(
								array(
									'taxonomy' => Sensei()->modules->taxonomy,
									'field' => 'id',
									'terms' => intval( $module->term_id )
								)
							),
							'meta_key' => '_order_module_' . $module->term_id,
							'orderby' => 'meta_value_num date',
							'order' => 'ASC',
							'suppress_filters' => 0
						);

						$lessons = get_posts( $args );
						$num_of_lesson = count($lessons);
						
						//lessson loop per user
						
						foreach( $lessons as $lesson_item ) {
							
							$is_lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_item->ID, $user->ID );
							$lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $lesson_item->ID, $user->ID );
							
							
							$modulequizdata = get_comment_meta( $lesson_status->comment_ID );
							
							
							if(!empty($lesson_status->comment_date)){
							echo "<pre>";
							//echo $lesson_status->comment_date."<br />";
							//echo $_POST['date1']."<br />";
							$lesson_completion_date = date("Y-m-d",strtotime($lesson_status->comment_date));
							//echo "<br />";
							//echo $_POST['date2']."<br />";
							//echo "lesson is completed:".$is_lesson_completed."<br />";
							//print_r($lesson_item);
							echo "</pre>";
							}
							
							if($is_lesson_completed==1){
								
								
								$date1 = strtotime($_POST['date1']);
								$date2 = strtotime($_POST['date2']);
								$lesson_completion_date_str = strtotime($lesson_completion_date);
								
		
								if($lesson_completion_date_str>$date1 && $lesson_completion_date_str<$date2){
									
									//echo "lesson is completed:".$is_lesson_completed."<br />";
									
									//echo "user ".$user->display_name." pass this". $lesson_completion_date;
									
									
									$user_id_onrange[$user->ID] = $lesson_item->post_title;
									
									
									
								}							
								
							}
							
							
						}
						
						//echo "lesson completed:". count($lesson_completed)."<br />";
						
						
	
					}
					
					
					 
					 //loop throughout the user group under a user
					if(is_array($user_groups)){				
						foreach($user_groups as $user_group){
							if($user_group->group_id==$_POST['group']){								
								if(!empty($user_course_status)){
									
										if(array_key_exists($user->ID,$user_id_onrange)){
											$array_to_csv[] = array($user->display_name,$course_name,$user_id_onrange[$user->ID]);
										}
						
									
									
								}								
								
							}				
							//echo $user_group->group_id."<br />";

						}
					}

			}
			

				//print_r($user_id_onrange);
			
			//echo "<pre>";
			//echo $modules_completed;
			//print_r($array_to_csv);
			//echo "</pre>";
			
			convert_to_csv($array_to_csv, 'report-incremental-progress'.md5(date('Y-m-d h:i:s')).'.csv', $headers);
		}
		
		
?>		<div class="form-wrap" style="padding:20px;">
			<form action="" method="post">
				
				<div>
					<label>
						Group:
					</label>
						<?php
							
							$groups = $wpdb->get_results( 'SELECT * FROM `wp_groups_group`');		

						?>					
					<select name="group">
						<?php 
						
						foreach($groups as $group){
													
							echo "<option value='".$group->group_id."'>";
							echo $group->name;	
							echo "</option>";
							
							
						}
						
						?>
					</select>				
				</div><br />
				<div>
					<label>
						Course:
					</label>
					
					<?php $course = new WP_Query( array( 'post_type' => 'course' ) ); ?>
					
					<select name="course">
						<?php 

						// The Loop
						if ( $course->have_posts() ) {

							while ( $course->have_posts() ) {
								$course->the_post();
								echo '<option value="'.$course->post->ID.'">' . get_the_title() . '</option>';
							}
							
						}
						
						/* Restore original Post Data */

						?>																
					</select>
					<?php wp_reset_postdata(); ?>
				</div><br />
				<div>				
					<label>
						Date:
					</label>	
					From<input type="text" id="date1" name="date1" /> to <input type="text" id="date2" name="date2" />
				</div><br /><br />			
				<input type="submit" class="button button-primary" name="submitincrenmental" value="submit" />										
			</form>
		</div>	
		<script>
			jQuery(document).ready(function() {
				jQuery('#date1').datepicker({
					dateFormat : 'yy-mm-dd'
				});
				jQuery('#date2').datepicker({
					dateFormat : 'yy-mm-dd'
				});				
				
				
			});
		</script>
		
<?php		
		
	}elseif($tab=="total-progress"){
		//declare the wpdb for custom query
		global $wpdb;
		
		//check for submitted data
		if(isset($_POST['submittotalprogress']) && $_POST['submittotalprogress']="submit"){
			
			// declare users and variables		
			$allUsers = get_users();
			$modules_completed = $_POST['completionpermonth'];
			$courseid = $_POST['course'];
			$course_name = get_the_title($courseid);
			$array_to_csv = Array(
				Array('Student Name',
					'Course Name',
					'Lesson Title'
				)

			);

			
			//user loop ----- loop user get the groups and course the course they take
			foreach($allUsers as $user){
	
				//declare course function calls
				
				$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->ID );
				$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->ID );	
				$course_status_info = get_comment_meta( $user_course_status->comment_ID );		
				$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->ID );
				$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->ID );
				$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );	

					 //get the user groups
					$useringroup = new Groups_User( $user->ID );
					$user_groups = $useringroup->__get( 'groups' );
					
					$displayed_lessons = array();
					//declare and get module values
					$modules = Sensei()->modules->get_course_modules( intval( $courseid ) );
					$modules_content = Sensei()->modules->course_module_content( intval( $courseid ) );


					//echo "<pre>";
					//echo $user->user_email."<br />";
					//echo "sensei_user_course_status_message: ";
					//print_r($course_status);
					//echo "<br />";
					//echo "started_course: "."<br />";
					
					$course_status_info['start'][0];
					$datenow = date('Y-m-d h:i:s');
					
					$date1=date_create($course_status_info['start'][0]);
					$date2=date_create($datenow);
					$diff=date_diff($date1,$date2);					
					$diftime = $diff->format("%m");
					
					if($diftime<1){
						
						$diftime = 1;
						
					}
					//echo "</pre>";

					//module loop per user	
					foreach( $modules as $module ) {

						$args = array(
							'post_type' => 'lesson',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_query' => array(
								array(
									'key' => '_lesson_course',
									'value' => intval( $courseid ),
									'compare' => '='
								)
							),
							'tax_query' => array(
								array(
									'taxonomy' => Sensei()->modules->taxonomy,
									'field' => 'id',
									'terms' => intval( $module->term_id )
								)
							),
							'meta_key' => '_order_module_' . $module->term_id,
							'orderby' => 'meta_value_num date',
							'order' => 'ASC',
							'suppress_filters' => 0
						);

						$lessons = get_posts( $args );
						$num_of_lesson = count($lessons);
						
						//lessson loop per user
						
						foreach( $lessons as $lesson_item ) {
							
							$is_lesson_completed = WooThemes_Sensei_Utils::user_completed_lesson( $lesson_item->ID, $user->ID );
							
							
							if($is_lesson_completed==1){
								
								$lesson_taken[$user->ID][] = $lesson_item->post_title;	
								
							}																					
						
							
						}

					}
					
					 $overaalltotal_module_passed = count($total_module_passed);

					 //echo $overaalltotal_module_passed . " module being passed";
					 
					 //loop throughout the user group under a user
					if(is_array($user_groups)){				
						foreach($user_groups as $user_group){
							if($user_group->group_id==$_POST['group']){								
								if(!empty($user_course_status)){
											
										$array_to_csv[] = array($user->display_name,$course_name,join("|",$lesson_taken[$user->ID]) );
										//$userid_within_group[$user->user_email] = $user->ID;								

								}								
								
							}				
							//echo $user_group->group_id."<br />";

						}
					}
					//echo "<pre>";
					//print_r($lesson_taken);					
					//echo "<pre>";
					
				unset($total_module_passed);
				unset($lesson_taken);
			}
			

				
			
			//echo "<pre>";
			//echo $modules_completed;
			//print_r($array_to_csv);
			//echo "</pre>";
			
			convert_to_csv($array_to_csv, 'report-total-progress'.md5(date('Y-m-d h:i:s')).'.csv', ',');
		}
		
		
?>		<div class="form-wrap" style="padding:20px;">
			<form action="" method="post">
				
				<div>
					<label>
						Group:
					</label>
						<?php
							
							$groups = $wpdb->get_results( 'SELECT * FROM `wp_groups_group`');		

						?>					
					<select name="group">
						<?php 
						
						foreach($groups as $group){
													
							echo "<option value='".$group->group_id."'>";
							echo $group->name;	
							echo "</option>";
							
							
						}
						
						?>
					</select>				
				</div>
				<div>
					<label>
						Course:
					</label>
					
					<?php $course = new WP_Query( array( 'post_type' => 'course' ) ); ?>
					
					<select name="course">
						<?php 

						// The Loop
						if ( $course->have_posts() ) {

							while ( $course->have_posts() ) {
								$course->the_post();
								echo '<option value="'.$course->post->ID.'">' . get_the_title() . '</option>';
							}
							
						}
						
						/* Restore original Post Data */

						?>																
					</select>
					<?php wp_reset_postdata(); ?>
				</div>
				<br /><br />			
				<input type="submit" class="button button-primary" name="submittotalprogress" value="submit" />										
			</form>
		</div>	
		
		
<?php		
		
	}
	
	echo '</div>';
	
}


add_action( 'wp_head', 'sensei_quiz_questions2', 10 );

function sensei_quiz_questions2($datus) {
	
global $wp_query;
	
	$vargvty = do_shortcode('[gravityform id="2" title="false" description="false"]');
	echo "<style>.gform_hidden{ display:none; }</style>";
	echo "<div class='gvityform' style='display:none;'><div class='gvity-inside'>".$vargvty."</div></div>";

	?>
		<script type="text/javascript">
			var senseijQ = jQuery.noConflict();
			senseijQ(document).ready(function(){
				
			<?php if($wp_query->query_vars['post_type']=="quiz"): ?>				
											
				<?php if(isset($_POST['sensei_question'])){ ?>
				
					senseijQ('.lesson-meta form').show(100);
				
				<?php }else{ ?>				
							
					senseijQ('.lesson-meta form').css('display','none');
							
				<?php } ?>

											
				<?php if(isset($_POST['gform_submit'])){ ?>
				
					senseijQ('.lesson-meta form').before(senseijQ('.gvityform').html());
				
				<?php } ?>
				
				
								
					senseijQ('.sensei-message').after('<p>How would you like to take this module?</p><input id="onlineform" type="button" value="Online" class="complete">&nbsp;<input id="offlineform" type="button" value="Offline" class="quiz-submit reset"><br /><br />')
					
					
					senseijQ('#onlineform').click(function(){
						
						senseijQ('.lesson-meta form').show(100);
						senseijQ('.lesson-meta .gvity-inside').remove();
						
						
					})

					senseijQ('#offlineform').click(function(){
						senseijQ('.lesson-meta .gvity-inside').remove();
						senseijQ('.lesson-meta form').hide(100);
						senseijQ('.lesson-meta form').before(senseijQ('.gvityform').html());	
					
					})
					
			<?php endif; ?>	
				

								
				
			})
			
		</script>
	<?php
}

function saved_admin_tab( $current = 'homepage' ) {
    $tabs = array( 'quiztaken' => 'Quiz Taken By User', 'timesession' => 'User Logs', 'timequizecompleted' => 'Course Info','threshold'=>'Students below Theshold','incremental-progress'=>'Incremental Progress','total-progress'=>'Total Progress','master-report'=>'Master Report' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=saved-quiz-data&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}
/*function call if user loggedout*/

function logout_badge( $data ) {
		
		$current_user = get_current_user_id(); 
		$user_session = get_user_meta( $current_user, 'fpuser_session', true ); 
		

		if($user_session!=""){						
		
			$user_last_login_logout_prev = get_option( 'user_last_login_logout' );	
			$user_last_login_logout_prev[$user_session]['logouttime'] = current_time( 'mysql' );

			
			update_option( 'user_last_login_logout', $user_last_login_logout_prev);			
			update_user_meta( $current_user, 'fpuser_session', "");
		}	
		
}

add_action( 'wp_logout', 'logout_badge');

/*function call if user login*/
function login_badge( $login ) {
		
		$current_user = get_current_user_id(); 
	
		$user_session = get_user_meta( $current_user, 'fpuser_session', true ); 
		
		$user_session_val = $current_user."_".md5(current_time( 'mysql' ));
		$user_last_login_logout[$user_session_val]['logintime'] = current_time( 'mysql' ); 
		$user_last_login_logout[$user_session_val]['user_id'] = $current_user;
		
		if($user_session==""){		
		
			update_user_meta( $current_user, 'fpuser_session', $user_session_val);			
			
			
			$user_last_login_logout_prev = get_option( 'user_last_login_logout' );

			if(empty($user_last_login_logout_prev)){
					
				$user_last_login_logout_prev=$user_last_login_logout;		
				
			}else{
				
				$user_last_login_logout_prev[$user_session_val]['logintime']=current_time( 'mysql' );
				$user_last_login_logout_prev[$user_session_val]['user_id'] = $current_user;
			}
			
			update_option( 'user_last_login_logout', $user_last_login_logout_prev);
		}

		
}

add_action( 'admin_init', 'login_badge');



add_filter( 'sensei_lessons_text', 'sensei_custom_new_lessons_text', 10 );



function sensei_custom_new_courses_text () {
	$text = "Topics";
	return $text;
}

add_filter( 'sensei_complete_lesson_text', 'sensei_custom_new_complete_lesson_text', 10 );

function sensei_custom_new_complete_lesson_text () {
	$text = "Complete Topic";
	return $text;
}

add_filter( 'sensei_view_lesson_quiz_text', 'sensei_custom_new_view_lesson_quiz_text', 10 );

function sensei_custom_new_view_lesson_quiz_text () {
	$text = "View the Topic Quiz";
	return $text;
}

add_filter( 'sensei_lesson_reset_text', 'sensei_custom_new_sensei_lesson_reset_text', 10 );

function sensei_custom_new_sensei_lesson_reset_text () {
	$text = "Topic Reset Successfully";
	return $text;
}

add_filter( 'sensei_back_to_lesson_text', 'sensei_custom_new_sensei_back_to_lesson_text', 10 );

function sensei_custom_new_sensei_back_to_lesson_text () {
	$text = "Back to the Topic";
	return $text;
}
?>
