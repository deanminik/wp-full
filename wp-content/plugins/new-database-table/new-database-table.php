<?php

/*
  Plugin Name: Pet Adoption (New DB Table)
  Version: 1.0
  Author: Brad
  Author URI: https://www.udemy.com/user/bradschiff/
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly
require_once plugin_dir_path(__FILE__) . 'inc/generatePet.php';

class PetAdoptionTablePlugin
{
  function __construct()
  {
    global $wpdb; //To look inside of the data base prefix and the character set
    $this->charset = $wpdb->get_charset_collate();
    // $this->charset -> Now we can accessed from anywhere with our class 
    $this->tablename = $wpdb->prefix . "pets"; //this look for the prefix by default like wp_... and add before the name of the new table 

    add_action('activate_new-database-table/new-database-table.php', array($this, 'onActivate')); // this run when the plugin is active
    //If you want to create one row in the database uncomment 
    // add_action('admin_head', array($this, 'onAdminRefresh'));
    //If you want to create multiples rows in the database uncomment 
    add_action('admin_head', array($this, 'populateFast'));

    add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
    add_filter('template_include', array($this, 'loadTemplate'), 99);
    //action to a pets
    add_action('admin_post_createpet', array($this, 'createPet'));
    add_action('admin_post_nopriv_createpet', array($this, 'createPet'));
    //admin_post is the hook action, after that whatever you want to name it 
    //nopriv -> no privileges, this is if the user is not log in at all  

    //action to delete pets
    add_action('admin_post_deletepet', array($this, 'deletePet'));
    add_action('admin_post_nopriv_deletepet', array($this, 'createPet'));
  }
  function deletePet()
  {
    //current_user_can('administrator' -> IF THE CURRENT USER HAS PERMISSIONS 
    if (current_user_can('administrator')) {

      $id = sanitize_text_field($_POST['idtodelete']);
      //Now we save this pet array in the database
      global $wpdb;
      $wpdb->delete($this->tablename, array('id' => $id));
      wp_safe_redirect(site_url('/pet-adoption')); //wp_safe -> checks if this is a local url 
    } else {
      wp_safe_redirect(site_url()); //Home page 
    }
    exit;
  }
  function createPet()
  {
    if (current_user_can('administrator')) {
      $pet = generatePet();
      $pet['petname'] = sanitize_text_field($_POST['incomingpetname']);
      // incomingpetname -> came from template-pets in the form 
      //   <input type="text" name="incomingpetname" placeholder="name...">
      //Now we save this pet array in the database
      global $wpdb;
      $wpdb->insert($this->tablename, $pet);
      wp_redirect(site_url('/pet-adoption'));
    } else {
      wp_redirect(site_url()); //Home page 
    }
  }

  //function from wordpress to work with sql server 
  //Start creating our custom table
  function onActivate()
  {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta("CREATE TABLE $this->tablename (
      id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      birthyear smallint(5) NOT NULL DEFAULT 0,
      petweight smallint(5) NOT NULL DEFAULT 0,
      favfood varchar(60) NOT NULL DEFAULT '',
      favhobby varchar(60) NOT NULL DEFAULT '',
      favcolor varchar(60) NOT NULL DEFAULT '',
      petname varchar(60) NOT NULL DEFAULT '',
      species varchar(60) NOT NULL DEFAULT '',
      PRIMARY KEY  (id)
    ) $this->charset;");
  }

  //According to the documentation it is important to add 2 spaces in the  PRIMARY KEY  (id) 
  //https://codex.wordpress.org/Creating_Tables_with_Plugins
  function onAdminRefresh()
  {
    global $wpdb;
    $wpdb->insert($this->tablename, generatePet());
  }

  function loadAssets()
  {
    if (is_page('pet-adoption')) {
      wp_enqueue_style('petadoptioncss', plugin_dir_url(__FILE__) . 'pet-adoption.css');
    }
  }

  function loadTemplate($template)
  {
    if (is_page('pet-adoption')) {
      return plugin_dir_path(__FILE__) . 'inc/template-pets.php';
    }
    return $template;
  }

  function populateFast()
  {
    $query = "INSERT INTO $this->tablename (`species`, `birthyear`, `petweight`, `favfood`, `favhobby`, `favcolor`, `petname`) VALUES ";
    $numberofpets = 100000;
    for ($i = 0; $i < $numberofpets; $i++) {
      $pet = generatePet();
      $query .= "('{$pet['species']}', {$pet['birthyear']}, {$pet['petweight']}, '{$pet['favfood']}', '{$pet['favhobby']}', '{$pet['favcolor']}', '{$pet['petname']}')";
      if ($i != $numberofpets - 1) {
        $query .= ", ";
      }
    }
    /*
    Never use query directly like this without using $wpdb->prepare in the
    real world. I'm only using it this way here because the values I'm 
    inserting are coming fromy my innocent pet generator function so I
    know they are not malicious, and I simply want this example script
    to execute as quickly as possible and not use too much memory.
    */
    global $wpdb;
    $wpdb->query($query);
  }
}

$petAdoptionTablePlugin = new PetAdoptionTablePlugin();
