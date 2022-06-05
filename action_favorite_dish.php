<?php
include_once('database/customer.class.php');
  require_once('init.php');


  require_once('database/connection.database.php');

  $db = getDatabaseConnection();
 

if(Customer::isFavorited($db,$_POST['customerId'],$_POST['dishId'])){
		Customer::deleteFav($db,$_POST['customerId'],$_POST['dishId']);
	}else{
        Customer::createFav($db,$_POST['customerId'],$_POST['dishId']);
    }
    header('Location:restaurant.php?id=1#');
 ?>