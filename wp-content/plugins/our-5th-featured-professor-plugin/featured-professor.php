<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Your Name Here
  Author URI: https://www.udemy.com
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'inc/generateProfessorHTML.php';

class FeaturedProfessor
{
  function __construct()
  {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'profHTML']);
  }

  function onInit()
  {
    register_meta('post', 'featuredProfessor', array(
      'show_in_rest' => true,
      'type' => 'number',
      'single' => false
    ));

    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-professor', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle'
    ));
  }
  function profHTML()
  {
    /*arguments
    1- name and version of the url 
    2- specific name for the route
    3- array of options
    */
    register_rest_route('featuredProfessor/v1', 'getHTML', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => [$this, 'getProfHTML']

    ));
  }
  function getProfHTML($data)
  {
    //http://localhost:10003/wp-json/featuredProfessor/v1/getHTML
    // return '<h4>Hello from our endpoint</h4>';

    return generateProfessorHTML($data['profId']);
    // http://localhost:10003/wp-json/featuredProfessor/v1/getHTML?profId=73
    // that 73 is from this post http://localhost:10003/professor/dr-barksalot/ 
    //
  }
  //This function is put on frontend with the option option from the page editor 
  function renderCallback($attributes)
  {
    if ($attributes['profId']) {
      wp_enqueue_style('featuredProfessorStyle');
      return generateProfessorHTML($attributes['profId']);
    } else {
      return NULL;
    }
  }
}

$featuredProfessor = new FeaturedProfessor();
