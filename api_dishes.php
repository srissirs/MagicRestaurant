<?php

declare(strict_types=1);

session_start();


require_once('database/connection.database.php');

require_once('database/dish.class.php');

$db = getDatabaseConnection();

$dishes = Dish::searchDishes($db, $_GET['search']);

echo json_encode($dishes);
