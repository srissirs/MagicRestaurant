<?php
  declare(strict_types = 1);

  session_start();


  require_once(__DIR__.'/../database/connection.database.php');


  require_once(__DIR__.'/../database/dish.class.php');
  require_once(__DIR__.'/../database/restaurant.class.php');
  require_once(__DIR__.'/../database/customer.class.php');
   
  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/favorited.tpl.php');
   if (!isset($_SESSION['userId'])) header('Location: signin.php');


  $db = getDatabaseConnection();
  
  $restaurant = Customer::getFavoriteRestaurants($db, $_SESSION['userId']);

  $dishes=Customer::getFavoriteDishes($db,$_SESSION['userId']);
 
  drawHeader(0);
  drawFavoritedHeader();
  drawFavorited($restaurant,$dishes);
  drawFooter();
?>