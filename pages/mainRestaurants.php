<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__.'/../database/connection.database.php');

  require_once(__DIR__.'/../database/restaurant.class.php');

   

  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/mainRestaurants.tpl.php');

 if (!isset($_SESSION['userId'])) header('Location: signin.php');

  $db = getDatabaseConnection();
  
  $restaurants = Restaurant::getRestaurants($db,1);

  drawHeader(1);
  drawMainRestaurantHeader();
  drawMainRestaurant($restaurants);
  drawFooter();
?>