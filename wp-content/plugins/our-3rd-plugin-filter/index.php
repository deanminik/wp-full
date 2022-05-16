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
        add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPage'), 'dashicons-smiley', 100);
        /*
        1- Current slug parameter
        2- Name of the tab
        3- Name of the submenu button
        4- Capabilities for the user to see the page
        5- end url 
        6- call the html 
        */
        add_submenu_page('ourwordfilter', 'Words To Filter', 'Word List','manage_options', 'ourwordfilter', array($this, 'wordFilterPage'));
        add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options','manage_options', 'word-filter-options', array($this, 'optionsSubPage'));
    }

    function wordFilterPage()
    { ?>
        Hellor word
    <?php }

    function optionsSubPage()
    { ?>
        Hello word from options page
<?php }
}
//We use variable to do not have conflict with another plugin
$ourWordFilterPlugin = new OurWordFilterPlugin();
