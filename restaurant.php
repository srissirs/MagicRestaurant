<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.database.php');

  require_once('database/dish.class.php');
  require_once('database/restaurant.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/restaurant.tpl.php');

  $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
  $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));



  drawHeader();
  drawRestaurant($restaurant, $dishes);
  drawFooter();
?>