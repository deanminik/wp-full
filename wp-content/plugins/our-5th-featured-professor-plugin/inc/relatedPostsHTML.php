<?php

function relatedPostsHTML($id)
{
    // return "Hello from relatedPostsHTML";
    /*
    Here inside the wp_query we say: Hi! wordpress bring us all -> ('posts_per_page' => -1)  any blog post ->   ('post_type' => 'post',)
    where they have a little piece of metadata associate with them where the name of the meta is featuredProfessor 
    and whatever id is ->  'key' => 'featuredProfessor', 'compare' => '=',  'value' => $id
    */
    $postsAboutThisProf = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'meta_query' => array(
            array(
                'key' => 'featuredProfessor',
                'compare' => '=',
                'value' => $id
            )
        )
    ));
    //Loop and we use ob_start because the function returns a string 
    ob_start();
    if ($postsAboutThisProf->found_posts) { ?>
        <p> <?php the_title(); ?> is mentioned in the following posts: </p>
        <ul>
            <?php
            while ($postsAboutThisProf->have_posts()) {
                $postsAboutThisProf->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php }
            ?>
        </ul>

<?php }
    wp_reset_postdata();
    return ob_get_clean();
}
