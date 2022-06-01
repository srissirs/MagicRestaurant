<?php
  declare(strict_types = 1);

  session_start();

  require_once('init.php');

  require_once('database/connection.database.php');

  require_once('database/customer.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/profile.tpl.php');
  require_once('session.php');
  if (!isset($_SESSION['userId'])) die(header('Location: /'));

  

  $db = getDatabaseConnection();

  $customer = Customer::getCustomer($db, $_SESSION['userId']);
  $restaurants = Customer::getCustomerRestaurants($db,$_SESSION['userId']);


  drawHeader();
  drawProfile($customer);

  if($customer->restaurantOwner)
    drawProfileRestaurants($restaurants);
  drawFooter();
?>