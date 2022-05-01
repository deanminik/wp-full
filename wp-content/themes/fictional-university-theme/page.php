<?php get_header(); ?>

<?php
while (have_posts()) {
    the_post(); 
    
    // pageBanner(array(
    //     'title' => 'Hello there this is the title',
    //     'subtitle' => 'Hi, this is the subtitle',
    //     'photo' => 'http://localhost:10003/wp-content/uploads/2022/05/field-scaled.jpg'
    // ));

    pageBanner();
    
    ?>
 

    <div class="container container--narrow page-section">
        <?php
        $theParent = wp_get_post_parent_id(get_the_ID());
        if ($theParent) { ?>
            <!-- echo "I am a child page"; -->
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <!-- <a class="metabox__blog-home-link" href="#"><i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a> <span class="metabox__main">Our History</span> -->
                    <a class="metabox__blog-home-link" href="<?php the_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php echo the_title(); ?></span>
                </p>
            </div>
        <?php } ?>


        <?php 
        // so get pages gets cero, null, false from de get the Id, It means that currently page does not have children pages 
        $testArray = get_pages(array(
            'child_of' => get_the_ID()
        ));
        
        if($theParent or $testArray ){?>

            <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
            <ul class="min-list">
                <?php
                if($theParent){
                    $findChildrenOf = $theParent;
                }else{
                    $findChildrenOf = get_the_ID();
                }
                wp_list_pages(array(
                    'title_li' => NULL,
                    'child_of' => $findChildrenOf,
                    'sort_column' => 'menu_order'
                ));
                ?>
                <!-- <li class="current_page_item"><a href="#">Our History</a></li>
                <li><a href="#">Our Goals</a></li> -->
            </ul>
        </div>

       <?php } ?>    
       

        <div class="generic-content">
            <?php the_content(); ?>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p> -->
        </div>
    </div>
<?php } ?>
<?php get_footer(); ?>







<!-- while (have_posts()) { -->
<!-- # code... -->

<!-- the_post(); ?> -->
<!-- <h1>This is a page, not a post</h1> -->
<!-- <h2> -->
<!-- <a href="<?php the_permalink(); ?>"> -->
<!-- <?php the_title(); ?> -->
<!-- </a> -->
<!-- </h2> -->
<!-- <?php the_content() ?> -->
<!-- <hr> -->
<!-- <?php   ?>-->