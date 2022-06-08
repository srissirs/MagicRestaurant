<?php
  declare(strict_types = 1);
  require_once(__DIR__.'/../session.php');
  require_once(__DIR__.'/../init.php');

  require_once(__DIR__.'/../database/connection.database.php');
  require_once(__DIR__.'/../database/customer.class.php');

  $db = getDatabaseConnection();

  $customer = Customer::getCustomerWithPassword($db, $_POST['fname'], $_POST['lname']);

  if ($customer!=null) {
    $_SESSION['userId'] = $customer->customerId;
    header("Location:../pages/mainPage.php");
  }

  else {
    $_SESSION['ERROR'] = 'Incorrect username or password';
    header('Location: ' . $_SERVER['HTTP_REFERER']);}

?>