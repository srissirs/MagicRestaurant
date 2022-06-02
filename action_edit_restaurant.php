<?php
  declare(strict_types = 1);
  require_once('session.php');
  require_once('init.php');

  require_once('database/connection.database.php');
  require_once('database/customer.class.php');

  session_start();

  if (!isset($_SESSION['userId'])) die(header('Location: /'));


  $db = getDatabaseConnection();
  
  $restaurant = Customer::getCustomerRestaurant($db, $_SESSION['userId'], intval($_POST['id']));


  if ($restaurant) {

    $restaurant->restaurantName = $_POST['restaurant_name'];
    $restaurant->restaurantAddress = $_POST['restaurant_address']; 
    $restaurant->saveRestaurant($db);
    //header('Location:mainPage.php?id='. intval($_POST['idee']));
  }

  header('Location:profile.php');
?>