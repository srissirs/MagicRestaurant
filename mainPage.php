<?php

declare(strict_types=1);

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
  <div class="mainPageHeader">
    <a href="mainpage.php" id="brandMain">Magic Restaurant</a>
    <a href="signin.php" id="signIn">Sign in</a>
    <a href="signup.php" id="signUp">Sign up</a>
  </div>
  </header>
  <div class="mainPage">
    <img src="images/main.jpg" alt="Dish Photo">
    <p style="font-size:65px"> We give food to the hungry</p>
  </div>
</body>

</html>

<?php
drawFooter();
?>