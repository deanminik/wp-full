<?php

/* 
 Plugin Name: Our 3rd Filter Plugin
 Description: A truly amazing plugin
 Version: 1.0
 AUthor: Dean 
 Author URI: http://localhost:10003/
*/

if (!defined('ABSPATH')) exit;
/*
if( ! defined('ABSPATH')) exit; ->

Exit if accessed directly | This is for security 

If this file is accessed directly in the URL, 
do not load the rest of the file's content in the browser.  
If file is accessed within the WordPress Environment, 
continue to load the file's content.
*/

class OurWordFilterPlugin
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'ourMenu'));
    }

    function ourMenu()
    {
        /* 
        Arguments
        1- Document title (tab)
        2- Text for the admin side bar
        3- Capabilities for the user to see the page
        4- slug parameter
        5- Display the html
        6- Icon for the admin menu
        7- Where our filter appears top or bottom
        */

        // data:image/svg+xml;base64, -> we can use the data using btoa(``) using the console of inspect element from the svg for icons 
        // wordpress with that format can modifiy the color of the icon like the hover function 
        $mainPageHook =  add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+', 100);


        /*
        1- Current slug parameter
        2- Name of the tab
        3- Name of the submenu button
        4- Capabilities for the user to see the page
        5- end url 
        6- call the html 
        */
        add_submenu_page('ourwordfilter', 'Words To Filter', 'Word List', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'));
        add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }

    function mainPageAssets()
    {
        wp_enqueue_style('filterAdminCss', plugin_dir_url(__FILE__) . 'styles.css');
    }

    function wordFilterPage()
    { ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <form method="POST">
                <label for="plugin_words_to_filter">
                    <p>Enter a <strong>comma-separated</strong> list of words to filter from
                        your site's content.
                    </p>
                </label>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="Enter a list of words to filter"></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save changes">
            </form>
        </div>
    <?php }

    function optionsSubPage()
    { ?>
        Hello word from options page
<?php }
}
//We use variable to do not have conflict with another plugin
$ourWordFilterPlugin = new OurWordFilterPlugin();
