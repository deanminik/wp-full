<?php
function university_post_types()
{   //EVENT POST TYPE
    register_post_type('event', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true, //add a space in the dashboard call posts but the url will be called event
        'labels' => array(
            'name' => 'Events', //to change post to event in the dashboard 
            'add_new_item' => 'Add a new event',
            'edit_item' => 'Edit event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar' //https://developer.wordpress.org/resource/dashicons/#location

    ));
    // To see more paremeters of register_post_type visit this web site 
    // https://developer.wordpress.org/reference/functions/register_post_type/ 

    //IMPORTANT: Remember if you add a new parameter inside the array you need to go to the
    // setting-permalink and save
    //****************************************************************************************************** */

    // PROGRAM POST TYPE
    register_post_type('program', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'), //always in plural 
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Programs',
            'add_new_item' => 'Add a new program',
            'edit_item' => 'Edit program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program',
        ),
        'menu_icon' => 'dashicons-awards'

    ));
     //IMPORTANT: Remember if you add a new parameter inside the array you need to go to the
    // setting-permalink and save

     //****************************************************************************************************** */

    // PROFESSOR POST TYPE
    register_post_type('professor', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor'),
        'public' => true,
        'labels' => array(
            'name' => 'Professors',
            'add_new_item' => 'Add a new Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor',
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'

    ));
     //IMPORTANT: Remember if you add a new parameter inside the array you need to go to the
    // setting-permalink and save
}
add_action('init', 'university_post_types');
