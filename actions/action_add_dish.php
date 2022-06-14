<?php

declare(strict_types=1);
require_once(__DIR__ . '/../session.php');
require_once(__DIR__ . '/../init.php');

require_once(__DIR__ . '/../database/connection.database.php');
require_once(__DIR__ . '/../database/customer.class.php');
require_once(__DIR__ . '/../database/dish.class.php');

session_start();

if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');


$db = getDatabaseConnection();

$customer = Customer::getCustomer($db, $_SESSION['userId']);

if ($customer->restaurantOwner) {
    if ($_FILES["image"]["name"] != '') {

        $filename = $_FILES["image"]["name"];

        $db = getDatabaseConnection();
        // Insert image data into database
        $stmt = $db->prepare("INSERT INTO Images VALUES(NULL, ?)");
        $stmt->execute(array($filename));
        // Get image ID
        $dishId = $db->lastInsertId();

        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "../images/" . $dishId . ".jpg";

        move_uploaded_file($tempname, $folder);

        $original = imagecreatefromjpeg($folder);
        if (!$original) $original = imagecreatefrompng($folder);
        if (!$original) $original = imagecreatefromgif($folder);
        if (!$original) die();

        $width = imagesx($original);     // width of the original image
        $height = imagesy($original);    // height of the original image
        $square = min($width, $height);  // size length of the maximum square

        // Create and save a small square thumbnail
        $small = imagecreatetruecolor(200, 200);
        imagecopyresized($small, $original, 0, 0, ($width > $square) ? intval(($width - $square) / 2) : 0, ($height > $square) ? intval(($height - $square) / 2) : 0, 200, 200, $square, $square);
        imagejpeg($small, $folder);
    }

    if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['dishName'])) {
        $_SESSION['ERROR_ADD_DISH'] = 'Name can only contain letters and spaces';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
       }

    if ( !preg_match ("/^[+]?\d+([.]\d+)?$/",$_POST['dishPrice'])) {
        $_SESSION['ERROR_ADD_DISH'] = 'Price needs to be a number';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
       }
    
    if ( !preg_match ("/^[A-Za-zÀ-ȕ\s]+$/",$_POST['dishCategory'])) {
        $_SESSION['ERROR_ADD_DISH'] = 'Category can only contain letters and spaces';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
       }

    if(!isset($_SESSION['ERROR_ADD_DISH'])){
        $categoryId = Dish::getDishCategory($db, $_POST['dishCategory']);
        if ($categoryId === (-1)) {
            $categoryId = Dish::addCategory($db, $_POST['dishCategory'], intval($_POST['restaurantId']));
        }
        Dish::addDish($db, $_POST['dishName'], floatval($_POST['dishPrice']), intval($_POST['restaurantId']),  intval($categoryId), intval($dishId));
    
    }
  }

header('Location:../pages/restaurant.php?id=' . intval($_POST['restaurantId']));
