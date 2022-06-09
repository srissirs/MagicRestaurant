<?php

declare(strict_types=1);

session_start();


require_once(__DIR__.'/../database/connection.database.php');

require_once(__DIR__.'/../database/restaurant.class.php');

$db = getDatabaseConnection();

$restaurants = Restaurant::searchRestaurants($db, $_GET['search']);

echo json_encode($restaurants);
