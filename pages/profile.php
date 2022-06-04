<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__.'/../init.php');

  require_once(__DIR__.'/../database/connection.database.php');

  require_once(__DIR__.'/../database/customer.class.php');

  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/profile.tpl.php');
  require_once(__DIR__.'/../session.php');
  if (!isset($_SESSION['userId'])) header('Location: signin.php');

  

  $db = getDatabaseConnection();

  $customer = Customer::getCustomer($db, $_SESSION['userId']);
  $restaurants = Customer::getCustomerRestaurants($db,$_SESSION['userId']);


  drawHeader();
  drawProfile($customer);

  if($customer->restaurantOwner)
    drawProfileRestaurants($restaurants);
  drawFooter();
?>