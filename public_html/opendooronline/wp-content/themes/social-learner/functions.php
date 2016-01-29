<?php

/**

 * @package Social Learner

 * The parent theme functions are located at /boss/buddyboss-inc/theme-functions.php

 * Add your own functions in this file.

 */



/**

 * Sets up theme defaults

 *

 * @since Social Learner 1.0.0

 */

function boss_child_theme_setup()

{

  /**

   * Makes child theme available for translation.

   * Translations can be added into the /languages/ directory.

   * Read more at: http://www.buddyboss.com/tutorials/language-translations/

   */



  // Translate text from the CHILD theme only.

  load_child_theme_textdomain( 'social-learner', get_stylesheet_directory() . '/languages' );



}

add_action( 'after_setup_theme', 'boss_child_theme_setup' );



/**

 * Add body class

 * @param  array $classes

 * @return array $classes

 */

function social_learner_body_class( $classes ) {



    $classes[] = 'social-learner';

	return array_unique( $classes );

}



add_filter( 'body_class', 'social_learner_body_class' );



/**

* Set global orientation variable

*/

global $rtl;



$rtl = false;



if(is_rtl()){

    $rtl = true;

}





/**

 * Setup Social Learner's textdomain.

 *

 * Declare textdomain for this child theme.

 * Translations can be filed in the /languages/ directory.

 */

function boss_child_theme_languages() {

    load_child_theme_textdomain( 'social-learner',  get_stylesheet_directory() . '/languages' );

}

add_action( 'after_setup_theme', 'boss_child_theme_languages' );



/**

 * Enqueues scripts and styles for child theme front-end.

 *

 * @since Social Learner  1.0.0

 */

add_action( 'wp_enqueue_scripts', 'boss_child_enqueue_styles', 9998 );

function boss_child_enqueue_styles() {

    global $rtl;

    wp_enqueue_script( 'child-js', get_stylesheet_directory_uri() . '/js/action.js', false, '1.0.4', false );

    if($rtl){

        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/css/main.rtl.css', false, '1.0.4', 'all' );

    } else {

        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/css/main.css', false, '1.0.4', 'all' );

    }

}



add_action( 'wp_enqueue_scripts', 'boss_child_enqueue_user_styles', 9999 );

function boss_child_enqueue_user_styles() {

    wp_enqueue_style( 'user-style', get_stylesheet_directory_uri() . '/css/custom.css');

}



/**

 * Add color sheme to customizer

 *

 */



add_filter( 'buddyboss_customizer_themes_preset', 'boss_edu_add_color_scheme' );

function boss_edu_add_color_scheme($default_themes) {

    $education = array(

        'education' => array(

            'alt'		 => 'Social Learner',

            'img'		 => get_stylesheet_directory_uri() . '/images/social_learner.png',

            'presets'	 => array(

                'boss_title_color'						 => '#ffffff',

                'boss_cover_color'						 => '#012243',

                'boss_panel_logo_color'					 => '#545454',

                'boss_panel_color'						 => '#012243',

                'boss_panel_title_color'				 => '#ffffff',

                'boss_panel_icons_color'				 => '#0e4362',

                'boss_panel_open_icons_color'			 => '#0e4362',

                'boss_layout_titlebar_bgcolor'			 => '#fff',

                'boss_layout_titlebar_color'			 => '#8091a1',

                'boss_layout_mobiletitlebar_bgcolor'	 => '#012243',

                'boss_layout_mobiletitlebar_color'		 => '#fff',

                'boss_layout_nobp_titlebar_bgcolor'		 => '#545454',

                'boss_layout_nobp_titlebar_color'		 => '#fff',

                'boss_layout_nobp_titlebar_hover_color'	 => '#ea6645',

                'boss_layout_body_color'				 => '#e3e9f0',

                'boss_layout_footer_top_color'			 => '#fff',

                'boss_layout_footer_bottom_bgcolor'		 => '#fff',

                'boss_layout_footer_bottom_color'		 => '#8091a1',

                'boss_links_pr_color'					 => '#012243',

                'boss_links_color'						 => '#00a6dc',

                'boss_slideshow_font_color'				 => '#ffffff',

                'boss_heading_font_color'				 => '#012243',

                'boss_body_font_color'					 => '#012243',

                'boss_admin_screen_background_color'	 => '#012243',

                'boss_admin_screen_text_color'			 => '#ffffff',

                'boss_admin_screen_button_color'		 => '#00a6dc',

            )

        )

    );



    return array_merge($education, $default_themes);



}





/**

 * Additional css for customizer

 *

 */

add_filter( 'boss_customizer_css', 'boss_edu_customizer_css' );



function boss_edu_customizer_css($css) {

    global $rtl;



    $big_logo_h		 = boss_logo_height( 'big' );

    $small_logo_h	 = boss_logo_height( 'small' );



    $header_admin_class = '.right-col';

    $header_menu_class = '.left-col';

    if($rtl){

        $header_admin_class = '.left-col';

        $header_menu_class = '.right-col';

    }

      $sidebar_color = esc_attr( boss_get_option( 'boss_edu_sidebar_bg' ) );

      $active_link_color = esc_attr( boss_get_option( 'boss_edu_active_link_color' ) );



      $css .= "

            #certificates_user_settings input[type=\"checkbox\"] +strong,

            .quiz form ol#sensei-quiz-list li ul li input[type='checkbox'] + label,

            .quiz form ol#sensei-quiz-list li ul li input[type='radio'] + label,

            #buddypress div#group-create-tabs ul > li span,

            .tax-module .course-container .archive-header h1,

            .widget_course_progress footer a.btn,

            .widget .my-account .button, .widget_course_teacher footer a.btn,

            .widget-area .widget_course_teacher header span a,

            .widget_course_progress .module header h2 a,

            #main .widget_course_progress .course header h4 a,

            .widget-area .widget li.fix > a:first-child,

            .widget-area .widget li.fix > a:nth-child(2),

            #main .course-container .module-lessons .lesson header h2, .module .module-lessons ul li.completed a, .module .module-lessons ul li a, #main .course .course-lessons-inner header h2 a,

            #post-entries a,

            .comments-area article header cite a,

            .course-inner h2 a,

            .header-inner {$header_menu_class} .header-navigation ul li a,

            h1, h2, h3, h4, h5, h6, body, p {

                color: ". esc_attr( boss_get_option( 'boss_heading_font_color' ) ) .";

            }

            .widget_course_progress footer a.btn,

            .widget .my-account .button, .widget_course_teacher footer a.btn {

                border-color: ". esc_attr( boss_get_option( 'boss_heading_font_color' ) ) .";

            }

            body #main-wrap {

                background-color: ". esc_attr( boss_get_option( 'boss_layout_body_color' ) ) .";

            }

            .bp-avatar-nav ul.avatar-nav-items li.current {

                border-bottom-color: ". esc_attr( boss_get_option( 'boss_layout_body_color' ) ) .";

            }

            #secondary {

                background-color: {$sidebar_color};

            }

            .page-right-sidebar {

                background-color: {$sidebar_color};

            }

            .is-mobile.single-item.groups .page-right-sidebar,

            #primary {

                background-color: ". esc_attr( boss_get_option( 'boss_layout_body_color' ) ) .";

            }

            .tablet .menu-panel #nav-menu > ul > li.dropdown > a:before, .tablet .menu-panel .bp_components ul li ul li.menupop.dropdown > a:before, body:not(.tablet) .menu-panel .screen-reader-shortcut:hover:before, body:not(.tablet) .menu-panel #nav-menu > ul > li:hover > a:before, body:not(.tablet) .menu-panel .bp_components ul li ul li.menupop:hover > a:before {

                color: #fff;

            }

            .course-buttons .status.in-progress,

            .course-container a.button, .course-container a.button:visited, .course-container a.comment-reply-link, .course-container #commentform #submit, .course-container .submit, .course-container input[type=submit], .course-container input.button, .course-container button.button, .course a.button, .course a.button:visited, .course a.comment-reply-link, .course #commentform #submit, .course .submit, .course input[type=submit], .course input.button, .course button.button, .lesson a.button, .lesson a.button:visited, .lesson a.comment-reply-link, .lesson #commentform #submit, .lesson .submit, .lesson input[type=submit], .lesson input.button, .lesson button.button, .quiz a.button, .quiz a.button:visited, .quiz a.comment-reply-link, .quiz #commentform #submit, .quiz .submit, .quiz input[type=submit], .quiz input.button, .quiz button.button {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

                background-color: transparent;

            }

            .sensei-content .item-list-tabs ul li:hover, .sensei-content .item-list-tabs ul li.current,

            #learner-info #my-courses.ui-tabs .ui-tabs-nav li:hover a,

            #learner-info #my-courses.ui-tabs .ui-tabs-nav li.ui-state-active a,

            #buddypress div#group-create-tabs ul > li,

            #buddypress div#group-create-tabs ul > li:first-child:not(:last-child),

            .quiz form ol#sensei-quiz-list li ul li.selected {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .sensei-content .item-list-tabs ul li span,

            body:not(.tablet) .menu-panel #nav-menu > ul > li:hover, body:not(.tablet) .menu-panel ul li .menupop:hover,

            .menu-panel ul li a span,

            #course-video #hide-video,

            .quiz form ol#sensei-quiz-list li ul li input[type='checkbox']:checked + label:after,

            .widget_sensei_course_progress header,

            #my-courses .meter > span,

            .widget_course_progress .widgettitle,

            .widget-area .widget.widget_course_progress .course-lessons-widgets > header,

            .course-header,

            #search-open {

                background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            body:not(.tablet) .menu-panel #nav-menu > ul > li:hover a span, body:not(.tablet) .menu-panel ul li .menupop:hover a span {

                background-color: #fff;

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            nav.navigation.post-navigation .nav-links .nav-previous:before,

            nav.navigation.post-navigation .nav-links .nav-next:after,

            .bp-learndash-activity h4 i.fa-spinner,

            .bp-sensei-activity h4 i.fa-spinner,

            .bp-user.achievements #item-body > #subnav li.current a,

            #content .woocommerce-message .wc-forward,

            .widget_sensei_course_progress .course-progress-lessons .course-progress-lesson a:before,

            #learner-info .my-messages-link:before,

            .post-type-archive-lesson #module_stats span,

            .sensei-course-participants,

            .nav-previous .meta-nav:before,

            .nav-prev .meta-nav:before, .nav-next .meta-nav:before,

            #my-courses .meter-bottom > span > span,

            #my-courses section.entry span.course-lesson-progress,

            .quiz form ol#sensei-quiz-list li>span span,

            .module-archive #module_stats span,

            .widget_course_progress .module header h2 a:hover,

            #main .widget_course_progress .course header h4 a:hover,

            .course-statistic,

            #post-entries a:hover,

            #main .course-container .sensei-course-meta .course-author a,

            #main .course .sensei-course-meta .course-author a,

            .course-inner h2 a:hover,

            .menu-toggle i {

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .site-header {$header_admin_class},

            #search-open {

                color: #fff;

            }

            body.is-desktop,

            .site-header {$header_admin_class},

            .menu-panel, .menu-panel #nav-menu .sub-menu-wrap,

            .bp_components ul li ul li.menupop .ab-sub-wrapper,

            .is-desktop #mastlogo,

            #mastlogo {

                background-color: ". esc_attr( boss_get_option( 'boss_panel_color' ) ) .";

            }

            .header-account-login a .name {

                color: rgba(255,255,255,0.9);

            }

            .single-badgeos article .badgeos-item-points,

            .widget-area .widget:not(.widget_buddyboss_recent_post) .widget-achievements-listing li.has-thumb .widget-badgeos-item-title,

            .badgeos-achievements-list-item .badgeos-item-description .badgeos-item-points,

            .widget-area .widget_course_teacher header span p,

            .header-account-login .user-link span.name:after,

            .header-notifications a.notification-link {

                color: ". esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ) .";

            }

            .mobile-site-title .colored,

            .site-title a .colored,

            section.entry span.course-lesson-count,

            .widget_course_progress .module.current header h2 a,

.module .module-lessons ul li.current a,

            .header-inner {$header_menu_class} .header-navigation ul li > a:hover,

            .header-inner {$header_menu_class} .header-navigation ul li.current-menu-item > a,

            .header-inner {$header_menu_class} .header-navigation ul li.current-page-item > a {

                color: {$active_link_color};

            }

            #main .course .module-status,

            .module-archive #main .status,

            #main .course .module-status:before,

            .module-archive #main .status:before,

            .lesson-status.in-progress, .lesson-status.not-started,

            .module .module-lessons ul li a:before,

            .module .module-lessons ul li a:hover:before,

            .widget_course_progress .module.current header h2 a:hover,

            .module .module-lessons ul li a:hover,

            #main .course .course-lessons-inner header h2 a:hover {

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .lesson-status.complete,

            .module .module-lessons ul li.completed a:before {

                color: #61a92c;

            }

            #profile-nav span,

            .widget_categories .cat-item i,

            #wp-admin-bar-shortcode-secondary .alert,

            .header-notifications a.notification-link span,

            .header-navigation ul li > a:hover:after,

            .header-navigation ul li.current-menu-item > a:after,

            .header-navigation ul li.current-page-item > a:after {

                background-color: {$active_link_color};

            }

            .widget_categories .cat-item i {

                background-color: {$active_link_color};

            }

            .page-template-page-no-buddypanel .header-account-login > a,

            .page-template-page-no-buddypanel .site-header #wp-admin-bar-shortcode-secondary .ab-icon:before,

            .page-template-page-no-buddypanel #wp-admin-bar-shortcode-secondary .thread-from a,

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li a,

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} a {

                color: " .esc_attr( boss_get_option( 'boss_layout_nobp_titlebar_color' ) ) .";

            }

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li a:hover,

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li.current-menu-item a,

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li.current-page-item a {

                color: {$active_link_color};

            }

            .page-template-page-no-buddypanel .header-notifications a.notification-link {

                color: ". esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ) .";

            }

            .page-template-page-no-buddypanel #masthead #searchsubmit {

                color: ". esc_attr( boss_get_option( 'boss_heading_font_color' ) ) .";

            }

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li.hideshow li a {

                color: ". esc_attr( boss_get_option( 'boss_layout_titlebar_color' ) ) .";

            }

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li.hideshow li a:hover,

            .course-inner .course-price del,

            .widget_sensei_course_progress .course-progress-lessons .course-progress-lesson.current span,

            .page-template-page-no-buddypanel .header-account-login a:hover,

            .page-template-page-no-buddypanel .header-notifications .pop a:hover,

            .page-template-page-no-buddypanel .header-inner {$header_menu_class} .header-navigation ul li a:hover {

                color: {$active_link_color};

            }

            .header-account-login .pop .logout a,

            .is-mobile #buddypress div#subnav.item-list-tabs ul li.current a {

                color: #fff;

            }



            .wpProQuiz_questionList input[type=\"checkbox\"] + strong,

            .wpProQuiz_questionList input[type=\"radio\"] + strong {

                color: ". esc_attr( boss_get_option( 'boss_heading_font_color' ) ) .";

            }

            .single-sfwd-lessons u + table td .button-primary,

            .wpProQuiz_button2,

            input[type=\"button\"]:not(.button-small).wpProQuiz_button,

            #sfwd-mark-complete input[type=\"submit\"],

            .sfwd-courses a.button {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .wpb_row .woocommerce ul.products li.product a img:hover {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .header-account-login .pop .logout a,

            body .wpb_gallery .wpb_flexslider .flex-control-paging .flex-active {

                background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            body .entry-content #students .vc_col-sm-3 a,

            body .entry-content #counters h3 {

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .wpProQuiz_formFields input[type=\"radio\"]:checked+strong,

            .courses-quizes-results .percent,

            .wpProQuiz_forms table td:nth-child(2) div,

            .quiz_title a,

            .learndash_profile_quizzes .failed .scores,

            #learndash_profile .list_arrow:before,

            .learndash_profile_heading .ld_profile_status,

            .profile_edit_profile a,

            #course_navigation .learndash_topic_widget_list .topic-notcompleted:before,

            .wpProQuiz_question_page,

            .learndash .in-progress:before,

            .learndash .notcompleted:before {

                color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .wpProQuiz_quiz_time,

            #learndash_profile dd.course_progress div.course_progress_blue,

            .widget_ldcourseprogress,

            .lms-post-content dd.course_progress div.course_progress_blue,

            .type-sfwd-courses .item-list-tabs ul li span,

            .single-sfwd-quiz dd.course_progress div.course_progress_blue,

            .wpProQuiz_time_limit .wpProQuiz_progress {

                background-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .type-sfwd-courses .item-list-tabs ul li:hover, .type-sfwd-courses .item-list-tabs ul li.current {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .wpProQuiz_questionList .wpProQuiz_questionListItem label.selected {

                border-color: ". esc_attr( boss_get_option( 'boss_links_color' ) ) .";

            }

            .quiz_title a:hover,

            #learndash_profile .learndash_profile_details b,

            .profile_edit_profile a:hover {

                color: ". esc_attr( boss_get_option( 'boss_heading_font_color' ) ) .";

            }

            .wpProQuiz_catName,

            span.wpProQuiz_catPercent {

                background-color: ". esc_attr( boss_get_option( 'boss_layout_body_color' ) ) .";

            }

            #course_navigation .topic_item a.current,

            #course_navigation .active .lesson a {

                color: {$active_link_color};

            }

            #learndash_profile .learndash_profile_heading.course_overview_heading {

                background-color: {$sidebar_color};

            }

            .header-navigation li.hideshow > ul, .header-navigation .sub-menu, body.activity:not(.bp-user) .item-list-tabs ul li, .logged-in .dir-form .item-list-tabs ul li, .dir-form .item-list-tabs ul li:last-child {

                border-top: 2px solid ". esc_attr( boss_get_option( 'boss_links_color' ) ) ." !important;

            }

            ";



           if ( boss_get_option( 'mini_logo_switch' ) && boss_get_option( 'boss_small_logo', 'id' ) ) {

                $css .= "

                /* .header-navigation > div > ul {

                    line-height: ".$small_logo_h."px;

                    height: ".$small_logo_h."px;

                } */

                #header-menu > ul > li {

                    height: ".$small_logo_h."px;

                    line-height: ".$small_logo_h."px;

                }

                ";

           }



           if ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) {

                $css .= "

                /* .left-menu-open .header-navigation > div > ul {

                    line-height: ".$big_logo_h."px;

                    height: ".$big_logo_h."px;

                } */

                .left-menu-open #header-menu > ul > li {

                    height: ".$big_logo_h."px;

                    line-height: ".$big_logo_h."px;

                }

                ";

           }



    return $css;

}



add_filter('boss_default_color_sheme', 'boss_edu_default_color_scheme');

/**

 * Default color sheme

 */

function boss_edu_default_color_scheme($default){

    return 'eductaion';

}



/**

 * Additional fields to customizer

 *

 */

add_filter('boss_filter_color_options', 'boss_edu_customize_register');



function boss_edu_customize_register( $array ) {

    $additional = array(

        array( 'slug' => 'boss_edu_color_section', 'desc' => 'Social Learner Options', 'type' => 'info' ),

        array( 'slug' => 'boss_edu_active_link_color', 'title' => 'Active link color', 'subtitle' => 'Set the color for active links.', 'desc' => '', 'type' => 'color', 'default' => '#ea6645' ),

        array( 'slug' => 'boss_edu_sidebar_bg', 'title' => 'Sidebar Background', 'subtitle' => 'Set the color for sidebar.', 'desc' => '', 'type' => 'color', 'default' => '#cdd7e2' )

    );



    return array_merge($array, $additional);

}



/**

 * Output badges on profile

 *

 */

function boss_edu_profile_achievements (){

    global $user_ID;



    //user must be logged in to view earned badges and points



    if ( is_user_logged_in() && function_exists('badgeos_get_user_achievements')) {



        $achievements = badgeos_get_user_achievements(array( 'user_id' => bp_displayed_user_id()));



        if ( is_array( $achievements ) && ! empty( $achievements ) ) {



            $number_to_show = 5;

            $thecount = 0;



            wp_enqueue_script( 'badgeos-achievements' );

            wp_enqueue_style( 'badgeos-widget' );



            //load widget setting for achievement types to display

            $set_achievements = ( isset( $instance['set_achievements'] ) ) ? $instance['set_achievements'] : '';



            //show most recently earned achievement first

            $achievements = array_reverse( $achievements );



            echo '<ul class="profile-achievements-listing">';



            foreach ( $achievements as $achievement ) {



                //verify achievement type is set to display in the widget settings

                //if $set_achievements is not an array it means nothing is set so show all achievements

                if ( ! is_array( $set_achievements ) || in_array( $achievement->post_type, $set_achievements ) ) {



                    //exclude step CPT entries from displaying in the widget

                    if ( get_post_type( $achievement->ID ) != 'step' ) {



                        $permalink  = get_permalink( $achievement->ID );

                        $title      = get_the_title( $achievement->ID );

                        $img        = badgeos_get_achievement_post_thumbnail( $achievement->ID, array( 50, 50 ), 'wp-post-image' );

                        $thumb      = $img ? '<a style="margin-top: -25px;" class="badgeos-item-thumb" href="'. esc_url( $permalink ) .'">' . $img .'</a>' : '';

                        $class      = 'widget-badgeos-item-title';

                        $item_class = $thumb ? ' has-thumb' : '';



                        // Setup credly data if giveable

                        $giveable   = credly_is_achievement_giveable( $achievement->ID, $user_ID );

                        $item_class .= $giveable ? ' share-credly addCredly' : '';

                        $credly_ID  = $giveable ? 'data-credlyid="'. absint( $achievement->ID ) .'"' : '';



                        echo '<li id="widget-achievements-listing-item-'. absint( $achievement->ID ) .'" '. $credly_ID .' class="widget-achievements-listing-item'. esc_attr( $item_class ) .'">';

                        echo $thumb;

                        echo '<a class="widget-badgeos-item-title '. esc_attr( $class ) .'" href="'. esc_url( $permalink ) .'">'. esc_html( $title ) .'</a>';

                        echo '</li>';



                        $thecount++;



                        if ( $thecount == $number_to_show && $number_to_show != 0 ) {

                            echo '<li id="widget-achievements-listing-item-more" class="widget-achievements-listing-item">';

                            echo '<a class="badgeos-item-thumb" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/"><span class="fa fa-ellipsis-h"></span></a>';

                            echo '<a class="widget-badgeos-item-title '. esc_attr( $class ) .'" href="' . bp_core_get_user_domain( get_current_user_id() ) . '/achievements/">'. __('See All', 'social-learner') .'</a>';

                            echo '</li>';

                            break;

                        }



                    }



                }

            }



            echo '</ul><!-- widget-achievements-listing -->';



        }



    }

}



/**

* Filter cover sizes

*

**/

add_filter( 'boss_profile_cover_sizes', 'boss_edu_profile_cover_sizes' );



function boss_edu_profile_cover_sizes () {

    if($GLOBALS['badgeos']) {

        return array('322'=>'Big', 'none' => 'No photo');

    }

    return array('322'=>'Big', '200'=>'Small', 'none' => 'No photo');

}



/**

 * Cart icon html

 */



function boss_edu_cart_icon_html() {



	global $woocommerce;

	if ( $woocommerce ) {

		$cart_items = $woocommerce->cart->cart_contents_count; ?>



		<div class="header-notifications cart">

			<a class="cart-notification notification-link fa fa-shopping-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">

				<?php if ( $cart_items ) { ?>

							<span><?php echo $cart_items; ?></span>

				<?php } ?>

			</a>

		</div>

		<?php

	}

}









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

				<th>Module</th>

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

				<td>

				<?php



				$terms = get_the_terms( $quizdata['lesson_id'], 'module' );

				echo $terms[0]->name;

				//print_r($terms);



				?>

				</td>

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



									//echo "<pre>";

									//echo "<h1>".$user->user_email.$lesson_item->post_title."</h1>";

									//print_r($course_status );

									//echo $course_status->comment_approved;

									//echo $modulequestion_asked."------".$moduleanswered_quiz;

									//echo "</pre>";





											if($course_status->comment_approved=="complete"){



												$attempted = '<span style="color:green;">(100%)</span>';



											}else{



												if($lesson_status->comment_approved=="passed" || $lesson_status->comment_approved=="graded"){



													$attempted = '<span style="color:green;">(100%)</span>';



												}else{



													$attempted = "";



												}

											}













										//echo "<pre>";

										//echo "Attempted:".$attempted."<br />";

										//echo $user->user_email."<br />";

										//echo $modulequizdata['grade'][0]."<br />";

										//echo $modulequizdata['quiz_answers'][0]."<br />";





										//print_r($lesson_status);

										//echo "</pre>";









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

							$lessonquestion_asked =  count(explode(",",$quizdata['questions_asked'][0]));

							$lessonanswered_quiz = count(unserialize($quizdata['quiz_answers'][0]));







											if($course_status->comment_approved=="complete"){



												echo $attempted = '<span style="color:green;">(100%)</span>';



											}else{



												if($lesson_status->comment_approved=="passed" || $lesson_status->comment_approved=="graded"){



													echo $attempted = '<span style="color:green;">(100%)</span>';



												}else{



													echo $attempted = "";



												}

											}



								/*if($quizdata ['grade'][0]==""){



									if($lesson_status->comment_approved=="passed"){



										 echo  $attempted = 'P/Q';



									}else{



										if($lessonquestion_asked>=$lessonanswered_quiz){



											 if($modulequizdata['quiz_answers'][0]==""){



												$attempted = "";



											 }else{



												 echo $attempted =  "( ". get_percentage($lessonquestion_asked, $lessonanswered_quiz)."% ) <span style='color:red;'>Saved</span>";



											 }



										}



									}







								}else{



									if($lesson_status->comment_approved=="passed"){



										 echo  $attempted = '100%  <span style="color:red;">complete button</span>';



									}else{



										$percentage = get_percentage($lessonquestion_asked, $lessonanswered_quiz);



										if((int)$lessonquestion_asked>1){



										}



									}



								}*/





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



			$completionpermonth = $_POST['completionpermonth'];

			$courseid = $_POST['course'];

			$group_id = $_POST['group'];

			$course_name = get_the_title($courseid);

			$array_to_csv = Array(

				Array('Student Name',

					'Course Name',

					'Module(s)'

				)



			);





			$userincourse = BuddyPress_Sensei_Groups::bp_sensei_get_course_members( $courseid );



			//groups_get_groupmeta



			//echo $group_attached = groups_get_groupmeta( $group_id, 'bp_course_attached', true)."<br />---";



			if($completionpermonth==""){

				$completionpermonth = groups_get_groupmeta( $group_id, 'sensei_threshold', true);

			}



			/* echo "<pre>";

			print_r($userincourse);

			echo "</pre>";

			echo "<pre>";

			print_r($user_in_groups);

			echo "</pre>";	 */



			$user_in_groups = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM wp_bp_groups_members WHERE group_id = %d", $group_id ) );



			//user loop ----- loop user get the groups and course the course they take

			foreach($user_in_groups as $user){



					//echo "user_id ".$user->user_id."<br />";



					$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->user_id );

					$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->user_id );

					$course_status_info = get_comment_meta( $user_course_status->comment_ID );

					$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->user_id );

					$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->user_id );

					$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );



					$modules = Sensei()->modules->get_course_modules(  $courseid  );

					//$modules_content = Sensei()->modules->course_module_content(  $courseid );



					foreach( $modules as $module ) {



						$module_id = $module->term_id;

						$args = array(

							'post_type' => 'lesson',

							'post_status' => 'publish',

							'posts_per_page' => -1,

							'tax_query' => array(

								array(

									'taxonomy' => 'module',

									'field' => 'id',

									'terms' => $module_id

								)

							),

							'meta_query' => array(

								array(

									'key' => '_lesson_course',

									'value' => $courseid

								)

							),

							'fields' => 'ids'

						);

						$lessons = get_posts($args);

						$completed = false;

						$lesson_count = 0;

						$completed_count = 0;

						foreach ($lessons as $lesson_id) {

							$completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson_id, $user->user_id);

							++$lesson_count;

							if ($completed) {

								++$completed_count;

							}

						}

						$module_progress = ($completed_count / $lesson_count) * 100;



						if($module_progress==100){

							$module_passed[] = 1;

							$module_name[] = $module->name;

						}











						/* 	echo "<pre>";

						echo $module_progress;

						echo "---<br />";

						//print_r($modules_content);

						echo "</pre>"; */









					}



					$course_status_info['start'][0];

					$datenow = date('Y-m-d h:i:s');



					$date1=date_create($course_status_info['start'][0]);

					$date2=date_create($datenow);

					$diff=date_diff($date1,$date2);

					$diftime = $diff->format("%m");



					if($diftime<1){



						$diftime = 1;



					}



					$num_of_module_x_difftime = $completionpermonth*$diftime;



					//echo "<br />num_of_module_x_difftime:".$num_of_module_x_difftime;



					//echo count($module_passed)." module passed<br />";



					if(count($module_passed)>=$num_of_module_x_difftime){



						$user_info = get_userdata($user->user_id);

						$array_to_csv[] = array($user_info->display_name,$course_name,join("|",$module_name));

						//$userid_within_group[$user->user_email] = $user->ID;



					}



					unset($module_name);

					unset($module_passed);



			}



			/* echo "<pre>";

			print_r($array_to_csv);

			echo "</pre>"; */



			convert_to_csv($array_to_csv, 'report-'.md5(date('Y-m-d h:i:s')).'.csv', ',');

		}





?>		<div class="form-wrap" style="padding:20px;">

			<form action="" method="post">



				<div>

					<label>

						Group:

					</label>

						<?php



							$groups = $wpdb->get_results( 'SELECT * FROM `wp_bp_groups`');



						?>

					<select name="group">

						<?php



						foreach($groups as $group){



							echo "<option value='".$group->id."'>";

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

			$courseid = $_POST['course'];

			$group_id = $_POST['group'];

			$course_name = get_the_title($courseid);

			$array_to_csv = Array(

				Array('Student Name',

					'Course Name',

					'Percentage Completed',

					'Percentage Competent',

					'Email'

				)



			);



			$userincourse = BuddyPress_Sensei_Groups::bp_sensei_get_course_members( $courseid );



			$user_in_groups = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM wp_bp_groups_members WHERE group_id = %d", $group_id ) );



			//user loop ----- loop user get the groups and course the course they take

			foreach($user_in_groups as $user){



					//echo "user_id ".$user->user_id."<br />";



					$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->user_id );

					$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->user_id );

					$course_status_info = get_comment_meta( $user_course_status->comment_ID );

					$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->user_id );

					$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->user_id );

					$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );

					$modules = Sensei()->modules->get_course_modules(  $courseid  );

					//$modules_content = Sensei()->modules->course_module_content(  $courseid );



					foreach( $modules as $module ) {

						$module_id = $module->term_id;

						$args = array(

							'post_type' => 'lesson',

							'post_status' => 'publish',

							'posts_per_page' => -1,

							'tax_query' => array(

								array(

									'taxonomy' => 'module',

									'field' => 'id',

									'terms' => $module_id

								)

							),

							'meta_query' => array(

								array(

									'key' => '_lesson_course',

									'value' => $courseid

								)

							),

							'fields' => 'ids'

						);

						$lessons = get_posts($args);

						$completed = false;

						$lesson_count = 0;

						$completed_count = 0;

						foreach ($lessons as $lesson_id) {

							$completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson_id, $user->user_id);

							++$lesson_count;

							if ($completed) {

								++$completed_count;

							}

						}

						$module_progress = ($completed_count / $lesson_count) * 100;



						if($module_progress==100){

							$module_passed[] = 1;

						}







						/* 	echo "<pre>";

						echo $module_progress;

						echo "---<br />";

						//print_r($modules_content);

						echo "</pre>"; */









					}





					if($course_status_info['percent'][0]!=0){

						/* echo $user_course_status->comment_date."dsaddas"."<br />"; */



						$date1 = strtotime($_POST['date1']);

						$date2 = strtotime($_POST['date2']);



						$lesson_completion_date_str = strtotime($user_course_status->comment_date);





						if($lesson_completion_date_str>$date1 && $lesson_completion_date_str<$date2){



							//echo "lesson is completed:".$is_lesson_completed."<br />";



							//echo "user ".$user->display_name." pass this". $lesson_completion_date;



							$user_info = get_userdata($user->user_id);



							$array_to_csv[] = array($user_info->display_name,$course_name,$course_status_info['percent'][0].'%',$course_user_grade.'%',$user_info->user_email);



							//$user_id_onrange[$user->ID] = $lesson_item->post_title;







						}



					}





					unset($module_passed);



			}









						/* echo "<pre>";

						print_r($array_to_csv);

						echo "</pre>";  */







			$daterange1 = $_POST['date1'];

			$daterange2 = $_POST['date2'];



			convert_to_csv($array_to_csv, 'report-inc-progress_'.$daterange1.'_'.$daterange2.'_group_'.$groupname.'_courseID_'.$courseid.'.csv', $headers);

		}





?>		<div class="form-wrap" style="padding:20px;">

			<form action="" method="post" id="incrementalval">



				<div>

					<label>

						Group:

					</label>

						<?php



							$groups = $wpdb->get_results( 'SELECT * FROM `wp_bp_groups`');



						?>

					<select name="group">

						<?php



						foreach($groups as $group){



							echo "<option value='".$group->id."'>";

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

					From<input type="text" id="date1" name="date1" required /> to <input type="text" id="date2" name="date2" required />

				</div><br /><br />

				<input type="submit" class="button button-primary" name="submitincrenmental" value="submit"  />

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

			$courseid = $_POST['course'];

			$group_id = $_POST['group'];

			$course_name = get_the_title($courseid);

			$array_to_csv = Array(

				Array('Student Name',

					'Course Name',

					'Percentage Completed',

					'Percentage Competent',

					'Email'

				)



			);



			$userincourse = BuddyPress_Sensei_Groups::bp_sensei_get_course_members( $courseid );



			$user_in_groups = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM wp_bp_groups_members WHERE group_id = %d", $group_id ) );



			//user loop ----- loop user get the groups and course the course they take

			foreach($user_in_groups as $user){



					//echo "user_id ".$user->user_id."<br />";



					$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->user_id );

					$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->user_id );

					$course_status_info = get_comment_meta( $user_course_status->comment_ID );

					$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->user_id );

					$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->user_id );

					$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );

					$modules = Sensei()->modules->get_course_modules(  $courseid  );

					//$modules_content = Sensei()->modules->course_module_content(  $courseid );



					foreach( $modules as $module ) {

						$module_id = $module->term_id;

						$args = array(

							'post_type' => 'lesson',

							'post_status' => 'publish',

							'posts_per_page' => -1,

							'tax_query' => array(

								array(

									'taxonomy' => 'module',

									'field' => 'id',

									'terms' => $module_id

								)

							),

							'meta_query' => array(

								array(

									'key' => '_lesson_course',

									'value' => $courseid

								)

							),

							'fields' => 'ids'

						);

						$lessons = get_posts($args);

						$completed = false;

						$lesson_count = 0;

						$completed_count = 0;

						foreach ($lessons as $lesson_id) {

							$completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson_id, $user->user_id);

							++$lesson_count;

							if ($completed) {

								++$completed_count;

							}

						}

						$module_progress = ($completed_count / $lesson_count) * 100;



						if($module_progress==100){

							$module_passed[] = 1;

						}





					}



					$user_info = get_userdata($user->user_id);

					if($user->user_id!=1){



						$percentcomplete = $course_status_info['percent'][0];



						if($percentcomplete==""){



							$percentcomplete = '0';



						}



						$array_to_csv[] = array($user_info->display_name,$course_name,$percentcomplete.'%',$course_user_grade.'%',$user_info->user_email);

					}





			}



			convert_to_csv($array_to_csv, 'report-total-progress_'.date('Y-m-d').'_group_'.$groupname.'_courseID_'.$courseid.'.csv', ',');

		}





?>		<div class="form-wrap" style="padding:20px;">

			<form action="" method="post">



				<div>

					<label>

						Group:

					</label>

						<?php



							$groups = $wpdb->get_results( 'SELECT * FROM `wp_bp_groups`');



						?>

					<select name="group">

						<?php



						foreach($groups as $group){



							echo "<option value='".$group->id."'>";

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



	}elseif($tab=="master-report"){

		//declare the wpdb for custom query

		global $wpdb;



		global $woothemes_sensei, $post, $current_user, $wp_query, $learner_user;





		//check for submitted data

		if(isset($_POST['master-report']) && $_POST['master-report']="submit"){

			// declare users and variables

			$courseid = $_POST['course'];

			$group_id = $_POST['group'];

			$course_name = get_the_title($courseid);

			$array_to_csv = Array(

				Array('Student Name',

					'Course Name',

					'Percentage Completed',

					'Percentage Competent',

					'Email'

				)



			);



			$userincourse = BuddyPress_Sensei_Groups::bp_sensei_get_course_members( $courseid );



			$user_in_groups = $wpdb->get_results( $wpdb->prepare( "SELECT user_id FROM wp_bp_groups_members WHERE group_id = %d", $group_id ) );



			//user loop ----- loop user get the groups and course the course they take



			$maincontent = "";

			$countloop_user = 0;

			$lesson_title = "<th align='center'>User</th>";

			foreach($user_in_groups as $user){

					$maincontent .= "<tr>";

					$user_info = get_userdata($user->user_id);

					$maincontent .= "<td>".$user_info->display_name."</td>";



					$course_user_grade = WooThemes_Sensei_Utils::sensei_course_user_grade( $courseid, $user->user_id );

					$user_course_status = WooThemes_Sensei_Utils::user_course_status( $courseid, $user->user_id );

					$course_status_info = get_comment_meta( $user_course_status->comment_ID );

					$started_course = WooThemes_Sensei_Utils::user_started_course( $courseid, $user->user_id );

					$course_status = WooThemes_Sensei_Utils::sensei_user_course_status_message( $courseid, $user->user_id );

					$completed_course = WooThemes_Sensei_Utils::user_completed_course( $user_course_status );

					$modules = Sensei()->modules->get_course_modules(  $courseid  );

					//$modules_content = Sensei()->modules->course_module_content(  $courseid );



					foreach( $modules as $module ) {

						$module_id = $module->term_id;

						$args = array(

							'post_type' => 'lesson',

							'post_status' => 'publish',

							'posts_per_page' => -1,

							'tax_query' => array(

								array(

									'taxonomy' => 'module',

									'field' => 'id',

									'terms' => $module_id

								)

							),

							'meta_query' => array(

								array(

									'key' => '_lesson_course',

									'value' => $courseid

								)

							),

							'fields' => 'ids',

							'order' => 'ASC'



						);

						$lessons = get_posts($args);

						$completed = false;

						$lesson_count = 0;

						$completed_count = 0;

						foreach ($lessons as $lesson_id) {



							if($countloop_user != 1){

								$lesson_title .= "<th style=\"font-size:10px;\">";

								$lesson_title .= get_the_title($lesson_id);

								$lesson_title .= "</th>";

							}



							// Get quiz pass setting

							$pass_required = get_post_meta( $lesson_id, '_pass_required', true );



							// Get quiz pass mark

							$quiz_passmark = abs( round( doubleval( get_post_meta( $lesson_id, '_quiz_passmark', true ) ), 2 ) );



							// Get latest quiz answers and grades

							//$lesson_id = $woothemes_sensei->quiz->get_lesson_id( $lesson_id );



							$user_quizzes = $woothemes_sensei->quiz->get_user_answers( $lesson_id, $user->user_id  );

							$user_lesson_status = WooThemes_Sensei_Utils::user_lesson_status( $lesson_id, $user->user_id );

							$user_quiz_grade = 0;

							if( isset( $user_lesson_status->comment_ID ) ) {

								$user_quiz_grade = get_comment_meta( $user_lesson_status->comment_ID, 'grade', true );

							}



							// Check again that the lesson is complete

							$user_lesson_end = WooThemes_Sensei_Utils::user_completed_lesson( $user_lesson_status );







							$completed = WooThemes_Sensei_Utils::user_completed_lesson($lesson_id, $user->user_id);



/* 							echo "<pre>";

							echo get_the_title($lesson_id);

							echo 'pass_required:'."<br />";

							print_r($pass_required);



							echo 'quiz_passmark:<br />';

							print_r($quiz_passmark);



							echo 'user_quizzes:<br />';

							print_r($user_quizzes);



							echo 'user_lesson_status:<br />';

							print_r($user_lesson_status);



							echo 'Percent Competent:<br />';

							print_r($user_quiz_grade);



							echo 'completed--:'.$completed."<br />";

							echo 'user_lesson_end--:'.$user_lesson_end."<br />";





							echo "_quiz_has_questions:".get_post_meta( $lesson_id, '_quiz_has_questions', true )."<br /><br />";

							echo "this is the lersson info-----------------:";

							 print_r(get_comment_meta( $user_lesson_status->comment_ID ));

							$lessonquizdata = get_comment_meta( $user_lesson_status->comment_ID );

							echo "lessonquizdata---:";

								print_r(unserialize($lessonquizdata['quiz_answers'][0]));

							echo "</pre>";	 */







							$maincontent .= "<td>";



							if($completed==1){



								$percentcompleted = '100%';



							}else{



								$lessonquizdata = get_comment_meta( $user_lesson_status->comment_ID );

								$lessonquizdata_asked =  count(explode(",",$lessonquizdata['questions_asked'][0]));

								$lessonquizdataanswered_quiz = count(unserialize($lessonquizdata['quiz_answers'][0]));



								$lquizcounter = 0;

								foreach($lessonquizdataanswered_quiz as $lquiz){



									if($lquiz!=""){



										$lquizcounter++;



									}



								}



								/* echo "<pre>";

								echo $lessonquizdata_asked."<br />";

								print_r($lessonquizdata);

								print_r(unserialize($lessonquizdata['quiz_answers'][0]));

								echo "</pre>"; */



								if($user_lesson_status->comment_approved=="passed" || $user_lesson_status->comment_approved=="graded"){



									$percentcompleted = '100%';



								}else{



									$percentcompleted = get_percentage($lessonquizdata_asked, $lquizcounter).'%';



								}





							}



							$maincontent .=  '%S: '.$percentcompleted."<br />";



							$maincontent .=  '%C: '.$user_quiz_grade."%";



							$maincontent .=  "</td>";







							++$lesson_count;

							if ($completed) {

								++$completed_count;

							}





						}





						$module_progress = ($completed_count / $lesson_count) * 100;



						if($module_progress==100){

							$module_passed[] = 1;

						}





					}



					$countloop_user = 1;

					$user_info = get_userdata($user->user_id);



					$completionpermonth = groups_get_groupmeta( $group_id, 'sensei_threshold', true);



					if(count($module_passed)>=$completionpermonth){



						$ontract = "yes";



					}else{



						$ontract = "no";



					}









					$maincontent .= "<td>".$ontract."</td>";





					if($completed_course==1){



						$completed_course = $user_course_status->comment_date;



					}else{



						$completed_course = "No";



					}

					$maincontent .= "<td>".$completed_course."</td>";



					$maincontent .=  "</tr>";



					unset($module_passed);

			}









			echo '<table  class="wp-list-table widefat fixed striped pages" style="width:500%; border-spacing: 0; text-align:center;" >';

			echo "<tr>";

			echo $lesson_title;

			echo "<td>On Track Or Not</td>";

			echo "<td>Course Completed</td>";

			echo "</tr>";

			echo $maincontent;

			echo "</table>";





						/* echo "<pre>";

						print_r($array_to_csv);

						echo "</pre>"; */









			//convert_to_csv($array_to_csv, 'report-total-progress_'.date('Y-m-d').'_group_'.$groupname.'_courseID_'.$courseid.'.csv', ',');



	}



?>		<div class="form-wrap" style="padding:20px;">

			<form action="" method="post">



				<div>

					<label>

						Group:

					</label>

						<?php



							$groups = $wpdb->get_results( 'SELECT * FROM `wp_bp_groups`');



						?>

					<select name="group" required>

						<option value="">- Select One -</option>

						<?php



						foreach($groups as $group){



							echo "<option value='".$group->id."'>";

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



					<select name="course" required>

						<option value="">- Select One -</option>

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

				<input type="submit" class="button button-primary" name="master-report" value="submit" />

			</form>

		</div>





<?php





	} //end master-report



	echo '</div>';



}





add_action( 'wp_head', 'sensei_quiz_questions2', 10 );



function sensei_quiz_questions2($datus){

}


function saved_admin_tab( $current = 'homepage' ) {

    $tabs = array( 'quiztaken' => 'Quiz Taken By User', /*'timesession' => 'User Logs',*/ 'timequizecompleted' => 'Course Info','threshold'=>'Students below Theshold','incremental-progress'=>'Incremental Progress','total-progress'=>'Total Progress','master-report'=>'Master Report' );

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







add_filter( 'sensei_lessons_text', 'sensei_custom_new_lessons_text', 99 );



function sensei_custom_new_lessons_text () {

	$text = "Chapters";

	return $text;

}



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





//generate a csv file



function convert_to_csv($input_array, $output_file_name, $delimiter){



	if(count($input_array)>1){



		$filetxt = TEMPLATEPATH.'/csv/';

		$csvfile = $filetxt.$output_file_name;

		$myfile = fopen($csvfile, "w");

		foreach ($input_array as $row){

			fputcsv($myfile , $row);

		}



		echo '<div class="updated notice">

		<p>Awesome you can download the file now.</p>

		</div>';



		echo "<p style='padding: 20px;'><a class='button button-primary' href='".get_template_directory_uri()."/csv/".$output_file_name."'>Download Csv File</a></p>";



	}else{



		echo '<div class="error notice">

		<p>There is no student on this list. Please Try Again</p>

		</div>';





	}



}





require_once "BP_group_extra_field.class.php";





// Name for the column

function sensei_course_add_column( $columns = array() ) {

	$columns['sensei_course'] = 'Sensei Course';

	return $columns;

}



add_filter( 'bp_groups_list_table_get_columns', 'sensei_course_add_column', 10, 1 );



//Content for each group

function sensei_course_fill_group_row( $data = '', $column_name = '', $item = array() ) {

	$group_id = $item['id'];

	$course_id = groups_get_groupmeta( $item['id'], 'sensei_course' );

	$course = get_the_title( $course_id );

	if( 'sensei_course' == $column_name )

		$data = $course;



	return $data;

}



add_filter( 'bp_groups_admin_get_group_custom_column', 'sensei_course_fill_group_row', 10, 3 );



function fwp_quiz_shortcode( $atts ) {





	if($atts['buttontext']!=""){



		$buttontext = $atts['buttontext'];



	}else{



		$buttontext = "take this quiz";



	}



	$perma = "<a class='btn' style='font-weight:bold;' href='".get_permalink($atts['id'])."'>".$buttontext."</a>";



	if($atts['id']!=""){

		if(get_permalink($atts['id'])!=""){

			return $perma;

		}



	}else{



		return "";



	}

}

add_shortcode( 'odc_quiz', 'fwp_quiz_shortcode' );









add_action( 'wp_loaded', 'wpse_19240_change_place_labels', 20 );



function wpse_19240_change_place_labels()

{

    global $wp_post_types;

    $p = 'lesson';









    // Someone has changed this post type, always check for that!

    if ( empty ( $wp_post_types[ $p ] )

        or ! is_object( $wp_post_types[ $p ] )

        or empty ( $wp_post_types[ $p ]->labels )

        )

        return;



    // see get_post_type_labels()

    $wp_post_types[ $p ]->labels->name               = 'Chapters';

    $wp_post_types[ $p ]->labels->singular_name      = 'Chapter';

    $wp_post_types[ $p ]->labels->add_new            = 'Add chapter';

    $wp_post_types[ $p ]->labels->add_new_item       = 'Add new chapter';

    $wp_post_types[ $p ]->labels->all_items          = 'All chapters';

    $wp_post_types[ $p ]->labels->edit_item          = 'Edit chapters';

    $wp_post_types[ $p ]->labels->name_admin_bar     = 'Chapters';

    $wp_post_types[ $p ]->labels->menu_name          = 'Chapters';

    $wp_post_types[ $p ]->labels->new_item           = 'New chapter';

    $wp_post_types[ $p ]->labels->not_found          = 'No chapter found';

    $wp_post_types[ $p ]->labels->not_found_in_trash = 'No chapter found in trash';

    $wp_post_types[ $p ]->labels->search_items       = 'Search chapters';

    $wp_post_types[ $p ]->labels->view_item          = 'View chapter';

	$wp_post_types[ $p ]->label				         = 'Chapters';







}







function my_sensei_strings( $translated_text, $text, $domain ) {

	switch ( $translated_text ) {

		case 'Order Lessons' :

		$translated_text = "Order Chapters";

		break;

		case 'Lesson Tags' :

		$translated_text = "Chapter Tags";

		break;

		case 'Lessons Archive' :

		$translated_text = "Chapters Archive";

		break;

		case 'Lesson Title' :

		$translated_text = "Chapter Title";

		break;

		case 'Pre-requisite Lesson' :

		$translated_text = "Pre-requisite Chapter";

		break;



	}

	return $translated_text;

}

add_filter( 'gettext', 'my_sensei_strings', 20, 3 );









add_action( 'wp_ajax_get_module_ajax', 'prefix_get_module_ajax' );

add_action( 'wp_ajax_nopriv_get_module_ajax', 'prefix_get_module_ajax' );



function prefix_get_module_ajax() {





	if(isset($_POST['course_id'])){

		$modules = get_the_terms( $_POST['course_id'], 'module' );



		foreach($modules as $module){



			echo "<option value='".$module->term_id."'>".$module->name."</option>";



		}





	}



 exit;

}





function call_infusion($cid,$module_id){

	require_once TEMPLATEPATH.'/Services/Infusionsoft/isdk.enhanced.php';

	require_once TEMPLATEPATH.'/Services/Logger/Logger.php';

	Logger::$path = TEMPLATEPATH.'/Services/Logger/log.txt';





	$infusionsoft = new iSDK_enhanced($cid);

	if ($infusionsoft->connect('cl978'))

	{

			Logger::write('Running - Connected to Infusionsoft. Module: '.$module_id.' Contact: '.$cid);

		$infusionsoft->achieveGoal("cl978", "make".$module_id."online", $cid);





	} else {

		Logger::write('Running - Failed to connected to Infusionsoft. ');

	}







}







function call_infusion_complet_module($cid,$module_id){

	require_once TEMPLATEPATH.'/Services/Infusionsoft/isdk.enhanced.php';

	require_once TEMPLATEPATH.'/Services/Logger/Logger.php';

	Logger::$path = TEMPLATEPATH.'/Services/Logger/log.txt';





	$infusionsoft = new iSDK_enhanced($cid);

	if ($infusionsoft->connect('cl978'))

	{

			Logger::write('Running - Connected to Infusionsoft. Module: '.$module_id.' Contact: '.$cid);

		$infusionsoft->achieveGoal("cl978", "finishedModule".$module_id, $cid);





	} else {

		Logger::write('Running - Failed to connected to Infusionsoft. ');

	}







}







function myplugin_lesson_custom_columns_sortable( $columns ) {



    // Add our columns to $columns array

    $columns['lesson-modules'] = 'lesson-modules';



    return $columns;

}



// Let WordPress know to use our filter

add_filter( 'manage_edit-lesson_sortable_columns', 'myplugin_lesson_custom_columns_sortable' );

?>