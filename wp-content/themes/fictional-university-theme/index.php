<?php get_header(); ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Welcome to our blog</h1>
        <div class="page-banner__intro">
            <p>Keep up with our latest news</p>
        </div>
    </div>
</div>
<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post(); ?>
        <div class="post-item">
            <h2><a class="headline headline--medium headline--post-litle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?></p>
                <!-- the_time('F') -> F for months -->
                <!-- the_time('Y') -> for years  -->
                <!-- Reference  -->
                <!-- https://www.lockedownseo.com/dates-and-times-in-wordpress/ -->

                <!-- Detail: -->
                <!-- with get use echo beacuse it just return it  -->
            </div>
            <div class="generic-content">
                <!-- <?php the_content() ?>  -->
                <!-- To show the all content of the blog  -->

                <!-- <?php the_excerpt() ?> -->
                <!-- to show a little bit  -->

                <?php
                $excerpt = get_the_excerpt();
                $excerpt = substr($excerpt, 0, 160); // Only display first 260 characters of excerpt
                $result = substr($excerpt, 0, strrpos($excerpt, ' '));
                echo $result . " ...";
                // to show only 260 characters 
                ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading</a></p>

            </div>
        </div>

    <?php }
    //ADDING PAGINATION
    echo paginate_links();
    
    ?>

</div>
<?php get_footer(); ?>