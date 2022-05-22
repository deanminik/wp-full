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
       // (__DIR__ -> this is calling the blocks.json ("editorScript": "file:./build/index.js" and "editorStyle": "file:./build/index.css" we do not longer need to call here)
       // from this version WordPress 5.8 release https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/
       register_block_type(__DIR__, array(
            'render_callback' => array($this, 'theHTML')
        ));
    }
    function theHTML($attributes)
    {
        //The end of this line, here array('wp-element') is call dependencies 
        // if (!is_admin()) {
        //     //This condition is to do not load those file in the admin page 
        //     wp_enqueue_script('attentionFrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
        //     // wp_enqueue_style('attentionFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
        // }
        // //return'<h1>Today the sky is'. $attributes['skyColor'].' and the grass is x'.$attributes['grassColor'] .'. !!!</h1>';
        ob_start(); ?>
        <div class="paying-attention-update-me">
            <pre style="display:none;"><?php echo wp_json_encode($attributes) ?></pre>
        </div>
<?php return ob_get_clean();
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
