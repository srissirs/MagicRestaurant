<?php

declare(strict_types=1);

session_start();


require_once(__DIR__.'/../database/connection.database.php');

require_once(__DIR__.'/../database/customerOrders.class.php');


$db = getDatabaseConnection();
$json = file_get_contents('php://input');
$info = json_decode($json);

CustomerOrder::addDishOrder($db, intval($info->dishId),intval($info->quantity), intval($info->cartId));