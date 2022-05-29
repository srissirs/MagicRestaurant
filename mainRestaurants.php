<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.database.php');

  require_once('database/restaurant.class.php');

   

  require_once('templates/common.tpl.php');
  require_once('templates/mainRestaurants.tpl.php');



  $db = getDatabaseConnection();
  
  $restaurants = Restaurant::getRestaurants($db,1);

  drawHeader();
  drawMainRestaurantHeader();
  drawMainRestaurant($restaurants);
  drawFooter();
?>