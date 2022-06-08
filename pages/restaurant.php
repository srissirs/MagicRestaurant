<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__.'/../database/connection.database.php');

  require_once(__DIR__.'/../database/dish.class.php');
  require_once(__DIR__.'/../database/restaurant.class.php');
  require_once(__DIR__.'/../database/review.class.php');
  require_once(__DIR__.'/../database/reviewResponse.class.php');
   

  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/restaurant.tpl.php');



  $db = getDatabaseConnection();

  $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
  $dishes = Dish::getRestaurantDishes($db, intval($_GET['id']));
  $reviews = ReviewRestaurant::getRestaurantReviews($db, intval($_GET['id']));
  $categories = Restaurant::getCategories($db,intval($_GET['id']));
  $isOwner =Restaurant::isOwner($db,intval($_GET['id']),intval($_SESSION['userId']));

 
  drawHeader(2);
  drawRestaurantHeader($restaurant);
  drawRestaurant($restaurant, $dishes, $reviews,$categories,$isOwner);
  drawFooter();
?>