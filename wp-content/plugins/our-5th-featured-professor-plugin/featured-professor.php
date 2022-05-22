<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Your Name Here
  Author URI: https://www.udemy.com
  Text Domain: featured-professor
  Domain Path: /languages
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . 'inc/generateProfessorHTML.php';
require_once plugin_dir_path(__FILE__) . 'inc/relatedPostsHTML.php';

class FeaturedProfessor
{
  function __construct()
  {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'profHTML']);

    add_filter('the_content', [$this, 'addRelatedPosts']);
  }

  function onInit()
  {
    //With this, wordpress will support the translation in our js files 
    load_plugin_textdomain('featured-professor', false, dirname(plugin_basename(__FILE__)) . '/languages');

    register_meta('post', 'featuredProfessor', array(
      'show_in_rest' => true,
      'type' => 'number',
      'single' => false
    ));

    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');
    
    //Register the translation
    wp_set_script_translations('featuredProfessorScript', 'featured-professor', plugin_dir_path(__FILE__) . '/languages');

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
  // $content -> wordpress will give us the content in the filter, line 21 
  function addRelatedPosts($content)
  {
    if (is_singular('professor') && in_the_loop() && is_main_query()) {
      return $content . relatedPostsHTML(get_the_id());
    }
    return $content;
  }
}

$featuredProfessor = new FeaturedProfessor();
