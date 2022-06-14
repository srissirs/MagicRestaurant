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

  if ( !preg_match ("/^[A-Za-zÀ-ȕ]+$/",$_POST['first_name'])) {
   $_SESSION['ERROR_NAME'] = 'Name can only contain letters and spaces';
   header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
  if ( !preg_match ("/^[A-Za-zÀ-ȕ]+$/",$_POST['last_name'])) {
    $_SESSION['ERROR_NAME'] = 'Last name can only contain letters and spaces';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9_]*$/",$_POST['username'])) {
    $_SESSION['ERROR_NAME'] = 'Username can only contain letters,spaces and numbers';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$_POST['email_address'])) {
    $_SESSION['ERROR_NAME'] = 'Email not valid';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

   if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['address'])) {
    $_SESSION['ERROR_NAME'] = 'Address cannot contain special simbols';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['city'])) {
    $_SESSION['ERROR_NAME'] = 'City can only contain letters and spaces';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['country'])) {
    $_SESSION['ERROR_NAME'] = 'Country can only contain letters and spaces';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^\d{4}(-\d{3})?$/",$_POST['postal_code'])) {
    $_SESSION['ERROR_NAME'] = 'Postal code invalid';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   } 
   if ( !preg_match ("/^\d{9}$/",$_POST['phone'])) {
    $_SESSION['ERROR_NAME'] = 'Phone number invalid';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   } 
   if (!preg_match ("/^[A-Za-zÀ-ȕ0-9!?().-:\s]*$/",$_POST['password'])) {
		$_SESSION['ERROR_NAME'] = 'Password invalid';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	   } 
  
     
  if ($customer && !isset($_SESSION['ERROR_NAME'])) {
    $customer->firstName = $_POST['first_name'];
    $customer->lastName = $_POST['last_name'];
    $customer->userName = $_POST['username'];
    $customer->customerEmail = $_POST['email_address'];
    $customer->customerAddress = $_POST['address'];
    $customer->customerCity = $_POST['city'];
    $customer->customerCountry = $_POST['country'];
    $customer->customerPostalCode = $_POST['postal_code'];
    $customer->customerPhone = $_POST['phone'];
    if($_POST['password']==""){
	    $old =  Customer::getCustomer($db,getUserID()) ;
      $customer->passwordHash = $old->passwordHash;
    }
    else{
      $password = $_POST['password'];
      $options = ['cost' => 12];
      $customer->passwordHash = password_hash($password,PASSWORD_DEFAULT,$options);
    }
    
   
    $customer->saveProfile($db);
  }

  header('Location: ../pages/profile.php');
?>