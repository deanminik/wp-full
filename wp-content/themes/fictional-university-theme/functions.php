<?php
/*********************************************************************************************************************** */
//ADDING CSS AND JAVASCRIPT FILES

function university_files()
{
    /*adding css file */
    //wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // is there a directory of your css replace get_stylesheet_uri()
    wp_enqueue_script('main-university-js',get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true); // If your javascript does not depens with jquery jus add NULL insted jquery
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

function university_features(){
    add_theme_support('title-tag'); //title-tag is not the only one.

    //REGISTER NAV MENU
    //headerMenuLocation -> to call it in the header file 
    //Header Menu Location-> to see it en check it in wodpress section menu 
    register_nav_menu('headerMenuLocation','Header Menu Location');
}
add_action('after_setup_theme','university_features'); //after_setup_theme -> this is our hook 
