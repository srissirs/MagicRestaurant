<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.database.php');

  require_once('database/restaurant.class.php');
  require_once('database/review.class.php');
  require_once('database/reviewResponse.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/restaurantReview.tpl.php');

  $db = getDatabaseConnection();

  $restaurant = Restaurant::getRestaurant($db, intval($_GET['id']));
  $reviews = ReviewRestaurant::getRestaurantReviews($db, intval($_GET['id']));

  drawHeader();
  drawRestaurantReview($restaurant, $reviews);
  drawFooter();
?>