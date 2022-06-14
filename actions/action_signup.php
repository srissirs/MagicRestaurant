<?php
include_once(__DIR__.'/../database/customer.class.php');
  require_once(__DIR__.'/../init.php');
   require_once(__DIR__.'/../session.php');


require_once(__DIR__.'/../database/connection.database.php');

  $db = getDatabaseConnection();
 
  if ( !preg_match ("/^[A-Za-zÀ-ȕ]+$/",$_POST['firstname'])) {
	$_SESSION['ERROR'] = 'Name can only contain letters and spaces';
	header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   if ( !preg_match ("/^[A-Za-zÀ-ȕ]+$/",$_POST['lastname'])) {
	 $_SESSION['ERROR'] = 'Last name can only contain letters and spaces';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9_]*$/",$_POST['username'])) {
	 $_SESSION['ERROR'] = 'Username can only contain letters,spaces and numbers';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if ( !preg_match ("/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$_POST['email'])) {
	 $_SESSION['ERROR'] = 'Email not valid';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
 
	if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['address'])) {
	 $_SESSION['ERROR'] = 'Address cannot contain special simbols';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['city'])) {
	 $_SESSION['ERROR'] = 'City can only contain letters and spaces';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['country'])) {
	 $_SESSION['ERROR'] = 'Country can only contain letters and spaces';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	if ( !preg_match ("/^\d{4}(-\d{3})?$/",$_POST['postalcode'])) {
	 $_SESSION['ERROR'] = 'Postal code invalid';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	} 
	if ( !preg_match ("/^\d{9}$/",$_POST['phone'])) {
	 $_SESSION['ERROR'] = 'Phone number invalid';
	 header('Location: ' . $_SERVER['HTTP_REFERER']);
	} 
	if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9!?().-:\s]*$/",$_POST['password'])) {
		$_SESSION['ERROR'] = 'Password invalid';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	   } 
	   
if(Customer::duplicateUsername($db,$_POST['username'])){
		$_SESSION['ERROR'] = 'Duplicated Username';
		printf('%s sss',$_SESSION['ERROR']);
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
	else if(Customer::duplicateEmail($db,$_POST['email'])){
		$_SESSION['ERROR'] = 'Duplicated Email';
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
 	else if (!isset($_SESSION['ERROR'])) {
		if($userId=Customer::createUser($db, $_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['postalcode'],$_POST['phone'],$_POST['email'],$_POST['password'], $_POST['restaurantowner'])){
			echo 'User Registered successfully';
 		setCurrentUser($userId, $_POST['username']);
 		header("Location: ../pages/mainPage.php");	
		}else{
  		$_SESSION['ERROR'] = 'ERROR';
  		header("Location:".$_SERVER['HTTP_REFERER']."");	
 	}
  		
 	}
 	
 ?>