<?php

declare(strict_types=1);
require_once(__DIR__.'/../session.php');
require_once(__DIR__.'/../init.php');

require_once(__DIR__.'/../database/connection.database.php');
require_once(__DIR__.'/../database/customer.class.php');
require_once(__DIR__.'/../database/reviewResponse.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


$db = getDatabaseConnection();
header('Location:../pages/restaurant.php?id=' .intval($_POST['reviewId']) );

if ( !preg_match ("/^[A-Za-zÀ-ȕ0-9!?(),.-:\s]*$/",$_POST['responseText'])) {
    $_SESSION['ERROR_ADD_RES'] = 'Text invalid';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
   } 
if(!isset($_SESSION['ERROR_ADD_RES'])){
    ReviewResponse::addResponse($db, $_SESSION['userId'], intval($_POST['reviewId']), $_POST['responseText']);
   }
header('Location:../pages/restaurant.php?id=' . 1);
