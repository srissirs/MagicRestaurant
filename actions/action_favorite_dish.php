<?php
include_once(__DIR__.'/../database/customer.class.php');
  require_once(__DIR__.'/../init.php');


  require_once(__DIR__.'/../database/connection.database.php');

  $db = getDatabaseConnection();
 

if(Customer::isFavorited($db,$_POST['customerId'],$_POST['dishId'])){
		Customer::deleteFav($db,$_POST['customerId'],$_POST['dishId']);
	}else{
        Customer::createFav($db,$_POST['customerId'],$_POST['dishId']);
    }
  
 ?>