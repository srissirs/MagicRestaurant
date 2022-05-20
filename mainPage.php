<?php
  declare(strict_types = 1);

  session_start();

  require_once('templates/common.tpl.php');
?>


<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Magic Restaurant</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <mainPageHeader>
        <a href="mainPage.php" id="brandMain">Magic Restaurant</a>
        <a href="login.html" id="signIn">Sign in</a>
        <a href="signUp.html" id="signUp">Sign up</a> 
    </mainPageHeader> 
    </header>
    <mainPage>
        <img src="images/main.jpg" alt="Dish Photo">
        <p> We give food to the hungry</p>
    </mainPage>
  </body>
</html>

<?php
  drawFooter();
?>


