<?php
    declare(strict_types = 1);
    session_start();

    $page = $_GET['page'];
    if($page == NULL) include('pages/mainPage.php');
    if($page == "signin") include('pages/signin.php');
    if($page == "signup") include('pages/signup.php');
    if($page == "favorited") include('pages/favorited.php');
    if($page == "mainRestaurants") include('pages/mainRestaurants.php');
    if($page == "pastOrders") include('pages/pastOrders.php');
    if($page == "profile") include('pages/profile.php');
    if($page == "restaurant") include('pages/restaurant.php');

?>