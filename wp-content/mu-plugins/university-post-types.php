<?php
function university_post_types()
{   //EVENT POST TYPE
    register_post_type('event', array(
        'capability_type' => 'event',
        'map_meta_cap' => true,
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
        'supports' => array('title'),
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
        'show_in_rest' => true, //This is to use the new editor of wordpress 
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'Professors',
            'add_new_item' => 'Add a new Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor',
        ),
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_rest' => true

    ));
    //IMPORTANT: Remember if you add a new parameter inside the array you need to go to the
    // setting-permalink and save

    //*********************************************************************************************************** */
    //CAMPUS POST TYPES
    register_post_type('campus', array(
        'capability_type' => 'campus',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'campuses'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Campuses',
            'add_new_item' => 'Add a new Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
        ),
        'menu_icon' => 'dashicons-location-alt'

    ));


    //****************************************************************************************************** */

    // NOTE POST TYPE
    register_post_type('note', array(
        'show_in_rest' => true, //This is to use the new editor of wordpress 
        'supports' => array('title', 'editor'),
        'public' => false, //hide from people on the web site
        'show_ui' => true, // show on the logged users 
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => 'Add a new Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note',
        ),
        'menu_icon' => 'dashicons-welcome-write-blog',
        'capability_type' => 'note',
        'map_meta_cap' => true


    ));

    // LIKE POST TYPE
    register_post_type('like', array(
        'show_in_rest' => false, //This is to use the new editor of wordpress 
        'supports' => array('title'),
        'public' => false, //hide from people on the web site
        'show_ui' => true, // show on the logged users 
        'labels' => array(
            'name' => 'Likes',
            'add_new_item' => 'Add a new Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like',
        ),
        'menu_icon' => 'dashicons-heart'
        
    ));
}
add_action('init', 'university_post_types');
