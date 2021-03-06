<?php

/*********************************************************************************************************************** */
//ADDING CSS AND JAVASCRIPT FILES

function university_files()
{
    /*adding css file */
    //wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // is there a directory of your css replace get_stylesheet_uri()
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true); // If your javascript does not depens with jquery jus add NULL insted jquery
    // also TRUE Means load the javascript file a the bottom before the body close instead the head section 

    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key= ADD THE KEY FROM GOOGLE CONSOLE', NULL, '1.0', true);
    //NULL means it does not depend on other js files 

    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts', 'university_files');
// The first argument means, we are indicating to WordPress what kind of instructions we are giving it. WordPress will work at different times 
// It is important to the name of the first argument.

// In the second parameter we give the name of the function to run it   


/*********************************************************************************************************************** */
//ADDING TTILE DINAMICALLY 

function university_features()
{
    add_theme_support('title-tag'); //title-tag is not the only one.
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true); // professorLandscape just a nickname, true is just force those size 400, 260  
    add_image_size('professorPortrait', 480, 650, true);

    add_image_size('pageBanner', 1500, 350, true);


    //REGISTER NAV MENU
    //headerMenuLocation -> to call it in the header file 
    //Header Menu Location-> to see it en check it in wodpress section menu 
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    //REGISTER NAV MENU FOOTER
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
}
add_action('after_setup_theme', 'university_features'); //after_setup_theme -> this is our hook 


/*********************************************************************************************************************** */
//ADDING POST TYPE

// function university_post_types(){
//     register_post_type('event',array(
//         'public' => true,//add a space in the dashboard call posts but the url will be called event
//         'labels' => array(
//         'name' => 'Events'//to change post to event in the dashboard 
//         ),
//         'menu_icon' => 'dashicons-calendar'//https://developer.wordpress.org/resource/dashicons/#location

//     ));

// }
// add_action('init', 'university_post_types');


/*********************************************************************************************************************** */
//


//GENERARTE A BANNER FUNCTION 
function university_adjust_queries($query)
{
    //This is to custom your archive program page 
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        // $query->set('posts_per_page', '1');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}
add_action('pre_get_posts', 'university_adjust_queries');

//NULL  is if someone wont add arguments, so the parameter won't be requered
function pageBanner($args = NULL)
{
    //Apply this only is there not a title, this is if the user does not add a title 
    if (!$args['title']) {
        // set this title 
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = 'http://localhost:10003/wp-content/uploads/2022/05/field-scaled.jpg';
        }
    }
    /*      
    The AND !is_archive() AND !is_home() is the new addition / fix.

     Our Page Banner function works well in many situations, however, 
     when used on an archive page (for example the All Events page/query)
     if the first event in the list of events has a background image our 
     code can get confused and try to use it as the banner for the entire Archive page.

     To fix this and avoid potential errors in the next lesson, I want you to make a 
     modification to your page banner function code right now. Essentially, inside the 
     if condition where we check to see if the current post has a banner image custom 
     field value or not... we want to add two more conditions to make sure the current 
     query is not an archive or a blog listing. Below is the entire updated code for our 
     pageBanner function:*/


?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">

                <p><?php echo $args['subtitle'] ?></p>
                <!-- Calling the custom field page_banner_subtitle -->
            </div>
        </div>
    </div>
<?php }


function universityMapKey($api)
{
    //This is the google map key https://console.cloud.google.com/google/maps-apis/credentials?project=wordpress-theme-349004
    $api['key'] = 'AIzaSyDMXyqP49IWhyCVxjBl-32Q9LKBJCh1tfI';
    return $api;
    //If in your page editor does not loaling correctly the map is beacuse you should add a credit card 
}
add_filter('acf/fields/google_map/api', 'universityMapKey');


function university_custom_rest()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));

    register_rest_field('note', 'userNoteCount', array(
        'get_callback' => function () {
            return count_user_posts(get_current_user_id(), 'note');
        }
    ));

    // register_rest_field('post','perfectlyCroppedImageURL',array(
    //     'get_callback' => function (){return }
    // ));
}

add_action('rest_api_init', 'university_custom_rest');

require get_theme_file_path('/inc/search-route.php');


//REDIRECT SUBSCRIBERS ACCOUNTS OUT OF ADMIN AND ONTO HOMEPAGE 
function redirectSubsToFrontEnd()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit; // tel to wp stop whit that user 
    }
}
add_action('admin_init', 'redirectSubsToFrontEnd');

function noSubsAdminBar()
{
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}
add_action('wp_loaded', 'noSubsAdminBar');



//CUSTOMIZE LOGIN SCREEN

function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'ourHeaderUrl');

//ADD CSS TO THE LOGIN PAGE
function ourLoginCSS()
{
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}
add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginTitle()
{
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'ourLoginTitle');


//FORCE NOTE POSTS TO BE PRIVATE 

function makeNotePrivate($data, $postarr)
{
    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_id(), 'note') > 4 and !$postarr['ID']) {
            die("You have reached your note limit"); // this will be the answer in the console in your response 

        }
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }
    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }

    return $data;
}
//Filter-> the example of this is if you have a dirty water and want to clean it just put throw a filter to ge clean water 
// so our water will be our $data
//wp_insert_post_data -> put in our database
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

// 2 -> represents two parameters $data, $postarr 
// 10 -> default order priority add_filter() so if you have many add_filter, just add the priority 





//REST API FOR LIKES 
require get_theme_file_path('/inc/like-route.php');


//EXPORT TO HOSTING -> ignore some files
add_filter('ai1wm_exclude_content_from_export', 'ignoreCertainFiles');

function ignoreCertainFiles($exlude_filters)
{
    $exlude_filters[] = 'themes/fictional-university-theme/node_modules';
    return $exlude_filters;
}
