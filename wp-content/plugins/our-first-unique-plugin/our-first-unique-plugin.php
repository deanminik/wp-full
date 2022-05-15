<?php

/*
 Plugin Name: Our Test Plugins
 Description: A truly amazing plugin
 Version: 1.0
 AUthor: Dean 
 Author URI: http://localhost:10003/
  
 */

add_filter('the_content', 'addToEndOfPost');

//the_content -> to use all content post from all post type
//$content -> all data from post 
function addToEndOfPost($content)
{

    if (is_single() && is_main_query()) {
        return $content . '<p>My name is Dean</p>';
    }

    return $content;
}
