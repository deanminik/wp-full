<!DOCTYPE html>
<!-- <html lang="en"> -->
<html <?php language_attributes(); ?>>

<head>
    <!-- To use a responsive dimension of every device use meta viewport, without this the web page will be seem 
exactly from the desktop to mobile  -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- For English and spanish will be appear utf-8 -->
    <meta charset="<?php bloginfo('charset'); ?>" />
    <?php wp_head(); ?>
    <!-- <title>Fictional University</title> -->
</head>

<!-- body class gives all these classes (home blog logged-in admin-bar customize-support ) -->

<body <?php body_class(); ?>>

    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
            </h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <!-- <ul> -->
                    <!-- <li><a href="#">About Us</a></li> -->
                    <!-- <li><a href="<?php echo site_url('/about-us/') ?>">About Us</a></li> -->
                    <!-- <li><a href="#">Programs</a></li> -->
                    <!-- <li><a href="#">Events</a></li> -->
                    <!-- <li><a href="#">Campuses</a></li> -->
                    <!-- <li><a href="#">Blog</a></li> -->
                    <!-- </ul> -->

                    <!-- DNAMIC MENU  -->
                    <!-- <?php
                            wp_nav_menu(array(
                                'theme_location' => 'headerMenuLocation'
                            ));

                            ?> -->

                    <ul>

                        <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 13) echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us/') ?>">About Us</a></li>
                        <li><a href="#">Programs</a></li>
                        <li <?php if (get_post_type() == 'event' OR is_page('past-events')) echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
                        <li><a href="#">Campuses</a></li>
                        <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/blog') ?>">Blog</a></li>
                    </ul>



                </nav>
                <div class="site-header__util">
                    <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </header>