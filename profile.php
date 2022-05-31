<?php
  declare(strict_types = 1);

  session_start();

  if (!isset($_SESSION['id'])) die(header('Location: /'));

  require_once('database/connection.database.php');

  require_once('database/customer.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/profile.tpl.php');
  require_once('session.php');

  

  $db = getDatabaseConnection();

  $customer = Customer::getCustomer($db, $_SESSION['id']);
  $restaurants = Customer::getCustomerRestaurants($db,$_SESSION['id']);


  drawHeader();
  drawProfile($customer);

  if($customer->restaurantOwner)
    drawProfileRestaurants($restaurants);
  drawFooter();
?>