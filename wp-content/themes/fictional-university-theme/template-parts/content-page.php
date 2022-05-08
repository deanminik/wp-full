<div class="post-item">
    <h2><a class="headline headline--medium headline--post-litle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

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