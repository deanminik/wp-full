<?php
get_header();
while (have_posts()) {
    # code...
    the_post();
    pageBanner();
?>

    <div class="container container--narrow page section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <!-- <a class="metabox__blog-home-link" href="#"><i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a> <span class="metabox__main">Our History</span> -->
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home </a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>
        </div>
        <?php
        $relatedPrograms = get_field('related_programs');

        if ($relatedPrograms) { //has something yes -> true, no -> false 
            echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedPrograms as $program) { ?>
                <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
        <?php }
            echo '</ul>';
        }


        ?>
    </div>
    <!-- <h2>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2> -->
    <!-- <?php the_content() ?> -->

<?php }
get_footer();
?>