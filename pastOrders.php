<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.database.php');

  require_once('database/dish.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/customerOrders.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/restaurant.tpl.php');
   require_once('templates/customerOrders.tpl.php');

  $db = getDatabaseConnection();

  $pastOrders = CustomerOrder::getCustomerOrders($db, $_SESSION['userId']);

  drawHeader(0);
  drawCustomerOrders($pastOrders);
  drawFooter();
?>