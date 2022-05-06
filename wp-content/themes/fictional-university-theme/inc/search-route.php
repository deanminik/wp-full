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
    return 'Congratulations, you created a route.';
}
