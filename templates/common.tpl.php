<?php

declare(strict_types=1);
require_once(__DIR__ . '/../session.php');
require_once(__DIR__ . '/../init.php');


require_once(__DIR__ .'/../database/connection.database.php');
require_once(__DIR__ .'/../database/customer.class.php');

session_start();
   ?>


<?php function drawHeader($search)
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Magic Restaurant</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <script src="../script.js" defer></script>
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>


  <body>
    <header>
      <div class="dropdown">
        <button class="dropbtn">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="dropdown-content">
          <a href="../pages/favorited.php">Favorites</a>
          <a href="../pages/pastOrders.php">Past Orders</a>
          <a href="../pages/mainRestaurants.php">Restaurants</a>
          <form action="../actions/action_logout.php" method="post" class="logout">
            <a href="../actions/action_logout.php">Logout
            <i class="fa-solid fa-arrow-right-from-bracket" id="logoutIcon"></i>
          </a>
          </form>
          
        </div>
      </div>
      <a href="mainPage.php"> <h1>Magic Restaurant</h1></a>
      <div class="searchBar">
        <?php if($search==1) {?>
          <input id="searchRestaurant" type="text" placeholder="Search here for a restaurant...">
        <?php }?>
        <?php if($search==2) {?>
          <input id="searchDish" type="text" placeholder="Search here for a dish...">
        <?php }?>

      </div>
      <div class="profile">
        <?php
        if (!isset($_SESSION['userId'])) header('Location: ../pages/signin.php');
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
      
      <section class="links">
        <a href="../restaurants.php" id="restaurants">Restaurants</a>
        <a href="../pages/favorites.php" id="favorites">Favorites</a>
        <a href="../pages/pastOrders.php" id="pastOrders">Past Orders</a>
      </section>
      <p>Magic Restaurant &copy; 2022 </p>
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
    <link href="../style.css" rel="stylesheet">
    <script src="../script.js" defer></script>
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>
  <div class="mainPageHeader">
    <a href="mainpage.php" id="brandMain">Magic Restaurant</a>
    <a href="signin.php" id="signIn">Sign in</a>
    <a href="signup.php" id="signUp">Sign up</a>
  </div>




<?php }?>
