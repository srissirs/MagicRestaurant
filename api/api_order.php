<?php

declare(strict_types=1);

session_start();


require_once(__DIR__.'/../database/connection.database.php');

require_once(__DIR__.'/../database/customerOrders.class.php');


$db = getDatabaseConnection();



$orderId = CustomerOrder::addOrder($db, $_SESSION['userId'], intval($_GET['id']), "Preparing", date("Y-m-d"));

echo json_encode($orderId);