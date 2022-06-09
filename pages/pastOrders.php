<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__.'/../database/connection.database.php');

  require_once(__DIR__.'/../database/dish.class.php');
  require_once(__DIR__.'/../database/restaurant.class.php');
  require_once(__DIR__.'/../database/customerOrders.class.php');

  require_once(__DIR__.'/../templates/common.tpl.php');
  require_once(__DIR__.'/../templates/restaurant.tpl.php');
   require_once(__DIR__.'/../templates/customerOrders.tpl.php');

  $db = getDatabaseConnection();

  $pastOrders = CustomerOrder::getCustomerOrders($db, $_SESSION['userId']);

  drawHeader(0);
  drawCustomerOrders($pastOrders);
  drawFooter();
?>