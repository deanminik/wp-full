<?php
get_header();
while (have_posts()) {
    # code...
    the_post();
    pageBanner(); ?>

    <div class="container container--narrow page section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <!-- <a class="metabox__blog-home-link" href="#"><i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a> <span class="metabox__main">Our History</span> -->
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog home </a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>
        </div>
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