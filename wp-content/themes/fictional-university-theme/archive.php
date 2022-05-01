<?php get_header();
// In this case we just need the value no to print it thas the reason we aren using echo 
pageBanner(array(
    'title' => get_the_archive_title(),
    'subtitle' => get_the_archive_description()

));

 ?>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="post-item">
            <h2><a class="headline headline--medium headline--post-litle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?></p>

            </div>
            <div class="generic-content">

                <?php
                $excerpt = get_the_excerpt();
                $excerpt = substr($excerpt, 0, 160);
                $result = substr($excerpt, 0, strrpos($excerpt, ' '));
                echo $result . " ...";

                ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading</a></p>

            </div>
        </div>

    <?php }

    echo paginate_links();

    ?>

</div>
<?php get_footer(); ?>