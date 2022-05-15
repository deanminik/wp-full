<?php

/*
 Plugin Name: Our 2nd Plugin
 Description: A truly amazing plugin
 Version: 1.0
 AUthor: Dean 
 Author URI: http://localhost:10003/
  
 */
class WordCountAndTimePlugin
{
    function __construct()
    {
        //$this -> to use the class WordCountAndTimePlugin
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings()
    {
        // wcp_first_section -> calling that section 
        //The 2nd argument (null) is just to add a title in the section, but in this case we do not want a title.
        //The 3rd argument (null) is just to add a paragraph  in the section, but in this case we do not want a paragraph.
        //word-count-settings-page -> our slug  
        add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

        //wcp_location -> Name of our setting section
        //Display Location -> html label text
        //array -> get a function 
        //word-count-settings-page -> slug 
        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
        //register_setting -> this is to store values in our database 

        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));
    }
    function locationHTML()
    { ?>
        <select name="wcp_location">
            <option value="0">Beginning of post</option>
            <option value="1">End of post</option>
        </select>
    <?php }

    function adminPage()
    {
        //Add a new page for settings 

        //Word Count Settings -> tab title 
        //Word Count-> name inside the menu
        //manage_options -> Those are the capabilities allowed for the user 
        //word-count-settings-page -> End of the url 
        //ourSettingsPageHTML -> The page with settings 
        add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'ourHTML'));
    }

    function ourHTML()
    { ?>
        <div class="wrap">
            <!-- wrap is a default class css from wordpress  -->
            <h1> Word Count Settings</h1>
            <!-- options.php -> wordpress will know what to do with this -->
            <form action="options.php" method="POST">
                <?php
                settings_fields('wordcountplugin'); //this is when you press submit it gets all stuff to work, security header etc
                do_settings_sections('word-count-settings-page'); //wordpress automatically generate a form from locationHTML function
                submit_button();
                ?>
            </form>
        </div>

<?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
