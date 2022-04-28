<?php
function university_post_types()
{
    register_post_type('event', array(
        'public' => true, //add a space in the dashboard call posts but the url will be called event
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
}
add_action('init', 'university_post_types');
?>