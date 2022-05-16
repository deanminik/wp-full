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

        add_filter('the_content', array($this, 'ifWrap'));
    }
    //$content -> the_content
    //1 or 0 -> true or false
    function ifWrap($content)
    {
        if ((is_main_query() and is_single()) and
            (get_option('wcp_wordCount', '1') or get_option('wcp_characterCount', '1') or get_option('wcp_timeCount', '1'))
        ) {
            // return $this->createHTML($content) . 'Hello from the statement there is at least one true'; 
            return $this->createHTML($content);
        }
        // return $content . 'Hello from the statement there are only false';
        return $content;
    }

    function createHTML($content)
    {
        $html = '<h3>' . esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3><p>';
        //Get word count once because both wordCount and read time will need it; 
        if (get_option('wcp_wordCount', '1') or get_option('wcp_readTime', '1')) {

            $wordCount = str_word_count(strip_tags($content));
        }
        if (get_option('wcp_wordCount', '1')) {
            $html .= 'This post has ' . $wordCount . ' words.<br>';
        }
        if (get_option('wcp_characterCount', '1')) {
            //strlen -> php function, len of a string 
            $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
        }

        if (get_option('wcp_readTime', '1')) {
            //strlen -> php function, len of a string 
            $html .= 'This post will take about ' . round($wordCount / 225) . ' minute(s) to read<br>';
        }

        $html .= '</p>';

        if (get_option('wcp_location', '0') == '0') {
            //up there
            return $html . $content;
        }
        //Down there
        return $content . $html;
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

        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));

        //********************************************************* */
        add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');

        register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

        //********************************************************* */
        add_settings_field('wcp_wordCount', 'Word Count', array($this, 'wordCountHTML'), 'word-count-settings-page', 'wcp_first_section');

        register_setting('wordcountplugin', 'wcp_wordCount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        //********************************************************* */
        add_settings_field('wcp_characterCount', 'Character Count', array($this, 'characterCountHTML'), 'word-count-settings-page', 'wcp_first_section');

        register_setting('wordcountplugin', 'wcp_characterCount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        //********************************************************* */
        add_settings_field('wcp_readTime', 'Read Time', array($this, 'readTimeHTML'), 'word-count-settings-page', 'wcp_first_section');

        register_setting('wordcountplugin', 'wcp_readTime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }

    function sanitizeLocation($input)
    {
        if ($input != '0' and $input != '1') {
            add_settings_error('wcp_location', 'wcp_location_error', 'Display location must be either beginning or ending');
            // this is in case the user opens inspect elements end change the value. Useful to do not inject wrong selection 
            return get_option('wcp_location');
        }
        return $input;
    }

    function  readTimeHTML()
    { ?>
        <input type="checkbox" name="wcp_readTime" value="1" <?php checked(get_option('wcp_readTime'), '1') ?>>
    <?php }

    function  characterCountHTML()
    { ?>
        <input type="checkbox" name="wcp_characterCount" value="1" <?php checked(get_option('wcp_characterCount'), '1') ?>>
    <?php }

    function  wordCountHTML()
    { ?>
        <input type="checkbox" name="wcp_wordCount" value="1" <?php checked(get_option('wcp_wordCount'), '1') ?>>
    <?php }

    function headlineHTML()
    { ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')) ?>">
    <?php }

    function locationHTML()
    { ?>
        <select name="wcp_location">
            <!-- get_option -> ask to the database just one time, so do not worry for requests 
    also this when you refresh the setting you will get the data from database 
    -->
            <option value="0" <?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1') ?>>End of post</option>
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
