<?php

declare(strict_types=1); ?>

<?php function drawHeader()
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>Fake Food</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="layout.css" rel="stylesheet">
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
          <a href="mainPage.php">Logout
            <i class="fa-solid fa-arrow-right-from-bracket" id="logoutIcon"></i>
          </a>
        </div>
      </div>
      <h1> Magic Restaurant</h1>
      <div class="searchBar">
        <input type="text" placeholder="Search for a restaurant...">
      </div>
      <i class="fa-solid fa-cart-shopping"></i>
      <div class="profile">
        <?php
        if (isset($_SESSION['id'])) drawLogoutForm($_SESSION['name']);
        else drawLoginForm();
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

<?php function drawLoginForm()
{ ?>
  <form action="action_login.php" method="post" class="login">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <a href="register.php">Register</a>
    <button type="submit">Login</button>
  </form>
<?php } ?>

<?php function drawLogoutForm(string $name)
{ ?>
  <form action="action_logout.php" method="post" class="logout">
    <a href="profile.php"><?= $name ?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>