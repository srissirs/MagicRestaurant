<?php

declare(strict_types=1);
require_once('session.php');
require_once('init.php');

require_once('database/connection.database.php');
require_once('database/customer.class.php');

session_start();
   ?>

<?php function drawHeader()
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Magic Restaurant</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="script.js" defer></script>
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>


  <body>
    <header>
      <div class="dropdown">
        <button class="dropbtn">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="dropdown-content">
          <a href="#">Favorites</a>
          <a href="pastOrders.php">Past Orders</a>
          <a href="mainRestaurants.php">Restaurants</a>
          <form action="action_logout.php" method="post" class="logout">
            <a href="action_logout.php">Logout
            <i class="fa-solid fa-arrow-right-from-bracket" id="logoutIcon"></i>
          </a>
          </form>
          
        </div>
      </div>
      <a href="mainPage.php"> <h1>Magic Restaurant</h1></a>
      <div class="searchBar">
        <input id="searchRestaurant" type="text" placeholder="Search for a restaurant...">
      </div>
      <i class="fa-solid fa-cart-shopping"></i>
      <div class="profile">
        <?php
        if (!isset($_SESSION['userId'])) header('Location: signin.php');
        else {
          $db = getDatabaseConnection();
          $customer = Customer::getCustomer($db, $_SESSION['userId']);
          drawTopInfo($customer->userName);};
        ?>
      </div>

    </header>

    <main>
    <?php } ?>

    <?php function drawFooter()
    { ?>
    </main>
    <footer>
      <div class="brand">
        <img src="logo.png" alt="logo">
        <p> Magic Restaurant</p>
    </div>
      <section class="links">
        <h4> Dishes </h4>
        <a href="favorites.php" id="favorites">Favorites</a>
        <a href="pastOrders.php" id="pastOrders">Past Orders</a>
        <p>Fake Food &copy; 2022 </p>
      </section>
    </footer>
  </body>

  </html>
<?php } ?>

<?php function drawTopInfo(string $username)
{ ?>
  <form action="action_logout.php" method="post" class="logout">
    <a href="profile.php"><?= $username ?></a>
  </form>
<?php } ?>


<?php function drawMainPageHeader(){ ?>
   <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Magic Restaurant</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="script.js" defer></script>
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>
  <div class="mainPageHeader">
    <a href="mainpage.php" id="brandMain">Magic Restaurant</a>
    <a href="signin.php" id="signIn">Sign in</a>
    <a href="signup.php" id="signUp">Sign up</a>
  </div>




<?php }?>
