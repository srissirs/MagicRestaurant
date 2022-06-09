<?php
include_once(__DIR__ . '/../database/customer.class.php');
require_once(__DIR__ . '/../init.php');


require_once(__DIR__ . '/../database/connection.database.php');


$db = getDatabaseConnection();
$json = file_get_contents('php://input');
$info = json_decode($json);

if (intval($info->dish)) {
    if (intval($info->unfavorite)) {
        Customer::deleteFavDish($db, $_SESSION['userId'], intval($info->id));
    } else {
        Customer::createFavDish($db, $_SESSION['userId'], intval($info->id));
    }
} else {
    if (intval($info->unfavorite)) {
        Customer::deleteFavRestaurant($db, $_SESSION['userId'], intval($info->id));
    } else {
        Customer::createFavRestaurant($db, $_SESSION['userId'], intval($info->id));
    }
}
