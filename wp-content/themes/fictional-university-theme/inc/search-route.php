<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{

    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResult'
    ));
}

function universitySearchResult($data)
{
    //Get the collections of posts 
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
        's' => sanitize_text_field($data['term']) // (s) means search  | (sanitize_text_field) to avoid sql injection in the url    
    ));
    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()

    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post(); //the_post() gets the related data of the posts, title, content etc
        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )); //So in the second parameter we add the data we need to display 
        }

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'event') {
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
    }
    return $results;
    //    return $professors->posts; this displays everything 
}
