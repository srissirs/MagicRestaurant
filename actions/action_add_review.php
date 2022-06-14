<?php

declare(strict_types=1);
require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../init.php');

require_once(__DIR__.'/../database/connection.database.php');
require_once(__DIR__.'/../database/customer.class.php');
require_once(__DIR__.'/../database/review.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


$db = getDatabaseConnection();

if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9!?(),.-:\s]*$/",$_POST['reviewText'])) {
  $_SESSION['ERROR_ADD_REV'] = 'Text invalid';
  header('Location: ' . $_SERVER['HTTP_REFERER']);
 } 
if($_POST['reviewRating']>5 || $_POST['reviewRating']<1){
  $_SESSION['ERROR_ADD_REV'] = 'Rating invalid (1 to 5)';
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
 if(!isset($_SESSION['ERROR_ADD_REV'])){
  ReviewRestaurant::addReview($db, $_SESSION['userId'], intval($_POST['restaurantId']), strval($_POST['reviewText']), intval($_POST['reviewRating']));
 }

  header('Location:../pages/pastOrders.php');
