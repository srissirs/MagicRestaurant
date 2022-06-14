<?php

declare(strict_types=1);

session_start();

require_once(__DIR__.'/../templates/common.tpl.php');
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Magic Restaurant</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
</head>

      <?php if (!isset($_SESSION['userId'])) { drawMainPageHeader();
      }else drawHeader(0);?>
<body>
  
  <div class="mainPage">
   
    <div class="mainPageText">
        <p style="font-size:62px">We give food to the hungry</p>
      </div>
  </div>
</body>

</html>

<?php
drawFooter();
?>