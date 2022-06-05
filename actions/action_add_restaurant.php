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

if($customer->restaurantOwner){
    Restaurant::addRestaurant($db, $_SESSION['userId'], $_POST['restaurantName'], $_POST['restaurantAddress'],  $_POST['restaurantCity'],  $_POST['restaurantCountry'], $_POST['restaurantPostalCode'], intval($_POST['restaurantPhone']),0);
}

header('Location:../pages/profile.php');
