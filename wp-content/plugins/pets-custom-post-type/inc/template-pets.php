<?php

get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Pet Adoption</h1>
    <div class="page-banner__intro">
      <p>Providing forever homes one search at a time.</p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">

  <?php 
    $petArgs = array(
      'favColor' => sanitize_text_field($_GET['favcolor']),
      'species' => sanitize_text_field($_GET['species']),
      'minYear' => sanitize_text_field($_GET['minyear']),
      'maxYear' => sanitize_text_field($_GET['maxyear']),
      'minWeight' => sanitize_text_field($_GET['minweight']),
      'maxWeight' => sanitize_text_field($_GET['maxweight']),
      'favHobby' => sanitize_text_field($_GET['favhobby']),
      'favFood' => sanitize_text_field($_GET['favfood']),
    );

    $petMetaQuery = array(
      'relation' => 'AND'
    );

    if ($petArgs['species']) {
      array_push($petMetaQuery, array(
			'key' => 'species',
			'compare' => '=',
			'value' => $petArgs['species'],
			'type' => 'char'
      ));
    }

    if ($petArgs['favColor']) {
      array_push($petMetaQuery, array(
			'key' => 'favColor',
			'compare' => '=',
			'value' => $petArgs['favColor'],
			'type' => 'char'
      ));
    }

    if ($petArgs['minYear']) {
      array_push($petMetaQuery, array(
			'key' => 'birthYear',
			'compare' => '>=',
			'value' => $petArgs['minYear'],
			'type' => 'NUMERIC'
      ));
    }

    if ($petArgs['maxYear']) {
      array_push($petMetaQuery, array(
			'key' => 'birthYear',
			'compare' => '<=',
			'value' => $petArgs['maxYear'],
			'type' => 'NUMERIC'
      ));
    }

    if ($petArgs['minWeight']) {
      array_push($petMetaQuery, array(
			'key' => 'weight',
			'compare' => '>=',
			'value' => $petArgs['minWeight'],
			'type' => 'NUMERIC'
      ));
    }

    if ($petArgs['maxWeight']) {
      array_push($petMetaQuery, array(
			'key' => 'weight',
			'compare' => '<=',
			'value' => $petArgs['maxWeight'],
			'type' => 'NUMERIC'
      ));
    }

    if ($petArgs['favHobby']) {
      array_push($petMetaQuery, array(
			'key' => 'favHobby',
			'compare' => '=',
			'value' => $petArgs['favHobby'],
			'type' => 'char'
      ));
    }

    if ($petArgs['favFood']) {
      array_push($petMetaQuery, array(
			'key' => 'favFood',
			'compare' => '=',
			'value' => $petArgs['favFood'],
			'type' => 'char'
      ));
    }
  ?>

  <?php

  $allPets = new WP_Query(array(
    'post_type' => 'pet',
    'posts_per_page' => 100,
    'meta_query' => $petMetaQuery
  )); ?>
  <p>This page took <strong><?php echo timer_stop();?></strong> seconds to prepare. Found <strong><?php echo number_format($allPets->found_posts); ?></strong> results (showing the first <?php echo $allPets->post_count; ?>).</p>

  <table class="pet-adoption-table">
    <tr>
      <th>Name</th>
      <th>Species</th>
      <th>Weight</th>
      <th>Birth Year</th>
      <th>Hobby</th>
      <th>Favorite Color</th>
      <th>Favorite Food</th>
    </tr>
  <?php while($allPets->have_posts()) {
    $allPets->the_post(); ?>
    <tr>
      <td><?php the_title() ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'species', true); ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'weight', true); ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'birthYear', true); ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'favHobby', true); ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'favColor', true); ?></td>
      <td><?php echo get_post_meta(get_the_ID(), 'favFood', true); ?></td>
    </tr>
  <?php } ?>
  </table>

  <p><br>Looking for an example query link? <a href="<?php echo site_url('/pet-adoption/?species=cat&favhobby=destroying%20stuff') ?>">How about only cats whose favorite hobby is destroying stuff?</a></p>

</div>

<?php get_footer(); ?>