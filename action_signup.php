<?php
include_once('database/customer.class.php');
  require_once('init.php');


  require_once('database/connection.database.php');

  $db = getDatabaseConnection();
 

if(Customer::duplicateUsername($db,$_POST['username'])){
		$_SESSION['ERROR'] = 'Duplicated Username';
		header("Location:".$_SERVER['HTTP_REFERER']."");
		//header("Location: mainPage.php");	
	}
	else if(Customer::duplicateEmail($db,$_POST['email'])){
		$_SESSION['ERROR'] = 'Duplicated Email';
		header("Location:".$_SERVER['HTTP_REFERER']."");
		//header("Location: mainPage.php");	
	}
 	else if (Customer::createUser($db, $_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['postalcode'],$_POST['phone'],$_POST['email'],$_POST['password'], $_POST['restaurantowner'])) {
  		echo 'User Registered successfully';
 		setCurrentUser($userId, $_POST['username']);
 		header("Location: mainPage.php");	
 	}
 	else{
  		$_SESSION['ERROR'] = 'ERROR';
  		header("Location:".$_SERVER['HTTP_REFERER']."");
		  //header("Location: mainPage.php");	
 	}
 ?>