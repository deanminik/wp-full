<div class="post-item">
    <li class="professor-card__list-item">
        <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
            <!-- professorLandscape: this came from function university_features() to call our custom size image -->
            <span class="professor-card__name"><?php the_title(); ?></span>
        </a>
    </li>
</div>