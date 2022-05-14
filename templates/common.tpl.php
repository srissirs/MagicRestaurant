<?php declare(strict_types = 1); ?>

<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
   <head>
        <title>Fake Food</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet">
        <link href="layout.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
    </head>


  <body>
    <header>
      <searchBar>
              <input type="text" placeholder="Search for a restaurant...">
          </searchBar>
          <profile>
            <?php 
              if (isset($_SESSION['id'])) drawLogoutForm($_SESSION['name']);
              else drawLoginForm();
            ?>
          </profile>   
      
    </header>
  
    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    <footer>
      <brand>
        <img src="logo.png" alt="logo">
        <p> Magic Restaurant</p>
      </brand>
      <links>
        <h4> Dishes </h4>
        <a href="favorites.php" id="favorites">Favorites</a>
        <a href="pastOrders.php" id="pastOrders">Past Orders</a>
        <p>Fake Food &copy; 2022 </p>
      </links>
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm() { ?>
  <form action="action_login.php" method="post" class="login">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <a href="register.php">Register</a>
    <button type="submit">Login</button>
  </form>
<?php } ?>

<?php function drawLogoutForm(string $name) { ?>
  <form action="action_logout.php" method="post" class="logout">
    <a href="profile.php"><?=$name?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>