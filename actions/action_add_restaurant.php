<?php

declare(strict_types=1);
require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../init.php');

require_once(__DIR__.'/../database/connection.database.php');
require_once(__DIR__.'/../database/customer.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


$db = getDatabaseConnection();

$customer = Customer::getCustomer($db, $_SESSION['userId']);

if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['restaurantName'])) {
    $_SESSION['ERROR_ADD_REST'] = 'Restaurant name cannot contain special simbols';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   
if (!preg_match ("/^[A-Za-zÀ-ȕ0-9\s]*$/",$_POST['restaurantAddress'])) {
    $_SESSION['ERROR_ADD_REST'] = 'Restaurant address cannot contain special simbols';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['restaurantCity'])) {
    $_SESSION['ERROR_ADD_REST'] = 'City can only contain letters and spaces';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['restaurantCountry'])) {
    $_SESSION['ERROR_ADD_REST'] = 'Country can only contain letters and spaces';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

if ( !preg_match ("/^\d{4}(-\d{3})?$/",$_POST['restaurantPostalCode'])) {
    $_SESSION['ERROR_ADD_REST'] = 'Postal code invalid';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   } 

if ( !preg_match ("/^\d{9}$/",$_POST['restaurantPhone'])) {
       $_SESSION['ERROR_ADD_REST'] = 'Phone Invalid';
       header('Location: ' . $_SERVER['HTTP_REFERER']);
      }

if($customer->restaurantOwner && !isset($_SESSION['ERROR_ADD_REST']) ){
    Restaurant::addRestaurant($db, $_SESSION['userId'], $_POST['restaurantName'], $_POST['restaurantAddress'],  $_POST['restaurantCity'],  $_POST['restaurantCountry'], $_POST['restaurantPostalCode'], intval($_POST['restaurantPhone']),0);
}

header('Location:../pages/profile.php');
