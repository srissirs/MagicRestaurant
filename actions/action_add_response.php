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
ReviewResponse::addResponse($db, $_SESSION['userId'], intval($_POST['reviewId']), $_POST['responseText']);

header('Location:../pages/restaurant.php?id=' . 1);
