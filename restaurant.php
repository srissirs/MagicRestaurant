<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.database.php');
  require_once('session.php');
  require_once('init.php');

  require_once('database/connection.database.php');
  require_once('database/customer.class.php');
  require_once('database/dish.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/review.class.php');
  require_once('database/reviewResponse.class.php');
   

  require_once('templates/common.tpl.php');
  require_once('templates/restaurant.tpl.php');



  $db = getDatabaseConnection();

  //$_SESSION['userId']
  $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
  $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));
  $reviews = ReviewRestaurant::getRestaurantReviews($db, intval($_GET['id']));
  $categories = Restaurant::getCategories($db,intval($_GET['id']));
  $favorites = Customer::getFavoriteDishes($db,3);
 
  drawHeader();
  drawRestaurantHeader($restaurant);
  drawRestaurant($restaurant, $dishes, $reviews,$categories,$favorites);
  drawFooter();
?>







  