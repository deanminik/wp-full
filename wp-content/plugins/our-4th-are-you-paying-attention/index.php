<?php

/* 
 Plugin Name: Our 4th Are You Paying Attention
 Description: Give your readers a multiple choice question
 Version: 1.0
 AUthor: Dean 
 Author URI: http://localhost:10003/
*/
if (!defined('ABSPATH')) exit;


class AreYouPayingAttention
{
    function __construct()
    {
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        //wp-blocks -> to load our js in the edit page of the post
        //wp-element -> to re force the load of the wp.element from your js file 
        //wp_enqueue_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        
        wp_register_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        //ourplugin/are-you-paying-attention -> this came from src/index.js 
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'ourNewBlockType', 
            'render_callback' => array($this, 'theHTML')

        ));

    }
    function theHTML($attributes){
        //return'<h1>Today the sky is'. $attributes['skyColor'].' and the grass is x'.$attributes['grassColor'] .'. !!!</h1>';
        ob_start(); ?>
        <h3>Today the sky is <?php echo esc_html($attributes['skyColor'])?> and the grass is <?php echo esc_html($attributes['grassColor']) ?> .!!!</h3>;
        <?php return ob_get_clean(); ?>
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
