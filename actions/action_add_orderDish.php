<?php

declare(strict_types=1);
require_once(__DIR__ . '/../session.php');
require_once(__DIR__ . '/../init.php');

require_once(__DIR__ . '/../database/connection.database.php');
require_once(__DIR__ . '/../database/customer.class.php');
require_once(__DIR__ . '/../database/customerOrders.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


$db = getDatabaseConnection();

$orderId = CustomerOrder::addOrder($db, $_SESSION['userId'], intval($_POST['restaurantId']), "Preparing", date("Y-m-d"));

header('Location:../pages/restaurant.php?id=' . intval($_POST['restaurantId']));
