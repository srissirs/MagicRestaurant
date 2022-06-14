<?php
  declare(strict_types = 1);

  session_start();


  require_once(__DIR__.'/../database/connection.database.php');


  require_once(__DIR__.'/../database/dish.class.php');
  require_once(__DIR__.'/../database/restaurant.class.php');
  require_once(__DIR__.'/../database/customer.class.php');
   
  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/favorited.tpl.php');


  $db = getDatabaseConnection();
  
  $restaurant = Customer::getFavoriteRestaurants($db, intval(1));

  $dishes=Customer::getFavoriteDishes($db,1);
 
  drawHeader(0);
  drawFavoritedHeader();
  drawFavorited($restaurant,$dishes);
  drawFooter();
?>