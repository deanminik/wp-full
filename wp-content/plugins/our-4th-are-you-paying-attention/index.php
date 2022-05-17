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
        add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
    }

    function adminAssets()
    {
        //wp-blocks -> to load our js in the edit page of the post
        //wp-element -> to re force the load of the wp.element from your js file 
        wp_enqueue_script('ourNewBlockType', plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element'));
    }
}

$areYouPayingAttention = new AreYouPayingAttention();
