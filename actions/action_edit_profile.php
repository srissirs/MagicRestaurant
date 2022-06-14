<?php
  declare(strict_types = 1);
  require_once(__DIR__.'/../session.php');
  require_once(__DIR__.'/../init.php');

  require_once(__DIR__.'/../database/connection.database.php');
  require_once(__DIR__.'/../database/customer.class.php');

  session_start();

  if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


  $db = getDatabaseConnection();

  
  $customer = Customer::getCustomer($db, $_SESSION['userId']);



  if ($customer) {
    $customer->firstName = $_POST['first_name'];
    $customer->lastName = $_POST['last_name'];
    $customer->userName = $_POST['username'];
    $customer->customerEmail = $_POST['email_address'];
    $customer->customerAddress = $_POST['address'];
    $customer->customerCity = $_POST['city'];
    $customer->customerCountry = $_POST['country'];
    $customer->customerPostalCode = $_POST['postal_code'];
    $customer->customerPhone = $_POST['phone'];
    $customer->saveProfile($db);
  }

  header('Location: ../pages/profile.php');
?>