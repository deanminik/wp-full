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
        //wp-element -> to re force the load of the wp.element from your js file previous 
        //wp_enqueue_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
        // wp-editor -> To avoid an error message when load the page editor 
        wp_register_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
        wp_register_style('quizeditcss', plugin_dir_url(__FILE__) . 'build/index.css');
        //ourplugin/are-you-paying-attention -> this came from src/index.js 
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'ourNewBlockType',
            'editor_style' => 'quizeditcss',
            'render_callback' => array($this, 'theHTML')
        ));
    }
    function theHTML($attributes)
    {
        //The end of this line, here array('wp-element') is call dependencies 
        if (!is_admin()) {
            //This condition is to do not load those file in the admin page 
            wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
            wp_enqueue_style('attentionFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
        }
        //return'<h1>Today the sky is'. $attributes['skyColor'].' and the grass is x'.$attributes['grassColor'] .'. !!!</h1>';
        ob_start(); ?>
        <div class="paying-attention-update-me">
            <pre style="display:none;"><?php echo wp_json_encode($attributes) ?></pre>
        </div>
<?php return ob_get_clean();
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
