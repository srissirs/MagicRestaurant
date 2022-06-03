<?php
  declare(strict_types = 1);
  require_once('session.php');
  require_once('init.php');

  require_once('database/connection.database.php');
  require_once('database/customer.class.php');

  $db = getDatabaseConnection();

  $customer = Customer::getCustomerWithPassword($db, $_POST['fname'], $_POST['lname']);

  if ($customer!=null) {
    $_SESSION['userId'] = $customer->customerId;
    header("Location:mainPage.php");
  }

  else {
    $_SESSION['ERROR'] = 'Incorrect username or password';
    header('Location: ' . $_SERVER['HTTP_REFERER']);}

?>