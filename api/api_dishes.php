<?php

declare(strict_types=1);

session_start();


require_once(__DIR__.'/../database/connection.database.php');

require_once(__DIR__.'/../database/dish.class.php');

$db = getDatabaseConnection();


$dishes = Dish::searchDishes($db, $_GET['search'], intval($_GET['id']) );

echo json_encode($dishes);
