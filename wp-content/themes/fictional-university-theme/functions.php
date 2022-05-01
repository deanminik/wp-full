<?php

/*********************************************************************************************************************** */
//ADDING CSS AND JAVASCRIPT FILES

function university_files()
{
    /*adding css file */
    //wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // is there a directory of your css replace get_stylesheet_uri()
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true); // If your javascript does not depens with jquery jus add NULL insted jquery
    // also TRUE Means load the javascript file a the bottom before the body close instead the head section 

    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts', 'university_files');
// The first argument means, we are indicating to WordPress what kind of instructions we are giving it. WordPress will work at different times 
// It is important to the name of the first argument.

// In the second parameter we give the name of the function to run it   


/*********************************************************************************************************************** */
//ADDING TTILE DINAMICALLY 

function university_features()
{
    add_theme_support('title-tag'); //title-tag is not the only one.
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true); // professorLandscape just a nickname, true is just force those size 400, 260  
    add_image_size('professorPortrait', 480, 650, true);

    //REGISTER NAV MENU
    //headerMenuLocation -> to call it in the header file 
    //Header Menu Location-> to see it en check it in wodpress section menu 
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    //REGISTER NAV MENU FOOTER
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
}
add_action('after_setup_theme', 'university_features'); //after_setup_theme -> this is our hook 


/*********************************************************************************************************************** */
//ADDING POST TYPE

// function university_post_types(){
//     register_post_type('event',array(
//         'public' => true,//add a space in the dashboard call posts but the url will be called event
//         'labels' => array(
//         'name' => 'Events'//to change post to event in the dashboard 
//         ),
//         'menu_icon' => 'dashicons-calendar'//https://developer.wordpress.org/resource/dashicons/#location

//     ));

// }
// add_action('init', 'university_post_types');


/*********************************************************************************************************************** */
//

function university_adjust_queries($query)
{   
    //This is to custom your archive program page 
    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);


    }
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        // $query->set('posts_per_page', '1');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}
add_action('pre_get_posts', 'university_adjust_queries');
