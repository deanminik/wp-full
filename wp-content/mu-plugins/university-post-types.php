<?php
function university_post_types()
{
    register_post_type('event', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,//add a space in the dashboard call posts but the url will be called event
        'labels' => array(
            'name' => 'Events', //to change post to event in the dashboard 
            'add_new_item' => 'Add a new event',
            'edit_item' => 'Edit event', 
            'all_items' => 'All Events',
            'singular_name' =>'Event'
        ),
        'menu_icon' => 'dashicons-calendar' //https://developer.wordpress.org/resource/dashicons/#location
         
    ));
    // To see more paremeters of register_post_type visit this web site 
    // https://developer.wordpress.org/reference/functions/register_post_type/ 
    
    //IMPORTANT: Remember if you add a new parameter inside the array you need to go to the
    // setting-permalink and save 
}
add_action('init', 'university_post_types');
?>