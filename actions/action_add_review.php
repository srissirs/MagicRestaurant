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


ReviewRestaurant::addReview($db, $_SESSION['userId'], intval($_POST['restaurantId']), strval($_POST['reviewText']), intval($_POST['reviewRating']));

  header('Location:../pages/pastOrders.php');
