<?php
  declare(strict_types = 1);

  session_start();


  require_once('database/connection.database.php');


  require_once('database/dish.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/customer.class.php');
   
  require_once('templates/common.tpl.php');
  require_once('templates/favorited.tpl.php');


  $db = getDatabaseConnection();
  
  $restaurant = Customer::getFavoriteRestaurants($db, intval(1));

  $dishes=Customer::getFavoriteDishes($db,1);
 
  drawHeader();
  drawFavoritedHeader();
  drawFavorited($restaurant,$dishes);
  drawFooter();
?>