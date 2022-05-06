<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{

    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResult'
    ));
}

function universitySearchResult()
{
    //Get the collections of posts 
    $professors = new WP_Query(array(
        'post_type' => 'professor'
    ));
    $professorResults = array();

    while ($professors->have_posts()) {
        $professors->the_post(); //the_post() gets the related data of the posts, title, content etc
        array_push($professorResults, array(
            'title' => get_the_title(), 
            'permalink' => get_the_permalink()
        ));//So in the second parameter we add the data we need to display 
    }
    return $professorResults;
    //    return $professors->posts; this displays everything 
}
