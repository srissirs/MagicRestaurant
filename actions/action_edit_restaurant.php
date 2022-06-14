<?php
  declare(strict_types = 1);
  require_once(__DIR__.'/../session.php');
  require_once(__DIR__.'/../init.php');

  require_once(__DIR__.'/../database/connection.database.php');
  require_once(__DIR__.'/../database/customer.class.php');
  require_once(__DIR__.'/../database/restaurant.class.php');

  session_start();

  if (!isset($_SESSION['userId'])) die(header('Location: ../pages/signin.php'));


  $db = getDatabaseConnection();
  
  $restaurant = Customer::getCustomerRestaurant($db, $_SESSION['userId'], intval($_POST['id']));
  Restaurant::addCategory($db, $restaurant->restaurantId, $_POST['restaurant_category']);

  if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['restaurant_name'])) {
    $_SESSION['ERROR_REST'] = 'Restaurant name cannot contain special simbols';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   
   if (!preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['restaurant_address'])) {
    $_SESSION['ERROR_REST'] = 'Restaurant address cannot contain special simbols';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
  
  if ($restaurant && !isset($_SESSION['ERROR_REST'])) {
    $restaurant->restaurantName = $_POST['restaurant_name'];
    $restaurant->restaurantAddress = $_POST['restaurant_address'];
    $restaurant->saveRestaurant($db);
  }

  header('Location: ../pages/profile.php');
?>