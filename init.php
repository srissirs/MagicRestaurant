<?php
  include_once(__DIR__.'/session.php');
  require_once(__DIR__ . '/database/connection.database.php');

  if(isset($_SESSION['ERROR'])){
    $error = $_SESSION['ERROR'];
  	unset($_SESSION['ERROR']);
    
  } else {
  	$error = "";
  }


?>