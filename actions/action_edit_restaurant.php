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


  if ($restaurant) {
    $restaurant->restaurantName = $_POST['restaurant_name'];
    $restaurant->restaurantAddress = $_POST['restaurant_address']; 
    $restaurant->saveRestaurant($db);
  }

  header('Location: ../pages/profile.php');
?>