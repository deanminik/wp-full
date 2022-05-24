<?php

require_once plugin_dir_path(__FILE__) . 'GetPets.php';
$getPets = new GetPets();


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

  <p>This page took <strong><?php echo timer_stop(); ?></strong> seconds to prepare. Found <strong><?php echo number_format($getPets->count) ?></strong> results (showing the first <?php echo count($getPets->pets) ?>).</p>

  <table class="pet-adoption-table">
    <tr>
      <th>Name</th>
      <th>Species</th>
      <th>Weight</th>
      <th>Birth Year</th>
      <th>Hobby</th>
      <th>Favorite Color</th>
      <th>Favorite Food</th>
      <?php if (current_user_can('administrator')) { ?>
        <th>Delete</th>
      <?php } ?>
    </tr>
    <?php

    foreach ($getPets->pets as $pet) { ?>
      <tr>
        <td><?php echo $pet->petname; ?></td>
        <td><?php echo $pet->species; ?></td>
        <td><?php echo $pet->petweight; ?></td>
        <td><?php echo $pet->birthyear; ?></td>
        <td><?php echo $pet->favhobby; ?></td>
        <td><?php echo $pet->favcolor; ?></td>
        <td><?php echo $pet->favfood; ?></td>
        <?php if (current_user_can('administrator')) { ?>
          <td style="text-align:center;">
            <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST">
              <input type="hidden" name="action" value="deletepet">
              <input type="hidden" name="idtodelete" value="<?php echo $pet->id; ?>">
              <button class="delete-pet-button">x</button>
            </form>
          </td>
        <?php } ?>
      </tr>
    <?php }
    ?>
  </table>
  <!-- echo esc_url(admin_url('admin-post.php')) 
     admin-post.php -> this is a flexible way to have server side code run when the specific events happens 
     we put the function in the index file call new-database-table.php to connect it we added
     name="action" this action will be loaded in the main file as a real action hook with this value: createpet

     Like this: 
     add_action('admin_post_createpet', array($this, 'createPet'));
     
-->
  <?php
  //CHECK if this user is admin or not to show the form 
  if (current_user_can('administrator')) { ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" class="create-pet-form" method="POST">
      <P>Enter just the name for a new pet. Its species, weight, and other details with be randomly generated</P>
      <input type="hidden" name="action" value="createpet">
      <input type="text" name="incomingpetname" placeholder="name...">
      <button>Add pet</button>
    </form>
  <?php }

  ?>

</div>

<?php get_footer(); ?>