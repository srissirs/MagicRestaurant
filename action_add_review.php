<?php

declare(strict_types=1);
require_once('session.php');
require_once('init.php');

require_once('database/connection.database.php');
require_once('database/customer.class.php');
require_once('database/review.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: signin.php');


$db = getDatabaseConnection();


ReviewRestaurant::addReview($db, $_SESSION['userId'], intval($_POST['restaurantId']), strval($_POST['reviewText']), intval($_POST['reviewRating']));

  header('Location:pastOrders.php');
