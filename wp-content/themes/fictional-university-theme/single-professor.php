<?php
get_header();
while (have_posts()) {
    # code...
    the_post();
    pageBanner();

?>

    <div class="container container--narrow page section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third"> <?php the_post_thumbnail('professorPortrait'); ?></div>
                <!-- professorPortrait: this came from function university_features() to call our custom size image -->
                <div class="two-thirds"> <?php the_content(); ?></div>
            </div>
        </div>
        <?php
        $relatedPrograms = get_field('related_programs');

        if ($relatedPrograms) { //has something yes -> true, no -> false 
            echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedPrograms as $program) { ?>
                <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
        <?php }
            echo '</ul>';
        }


        ?>
    </div>

    <!-- Use this code to read better inside of an array object  -->
    <!-- <?php var_dump($pageBannerImage); ?> -->
<?php }
get_footer();
?>