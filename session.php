<?php
   session_start();

   function setCurrentUser($userID, $username) {
    	$_SESSION['username'] = $username;
    	$_SESSION['userId'] = $userID;
   }

   function getUserID() {
       if(isset($_SESSION['userId'])) {
            return $_SESSION['userId'];
       } else {
           return null;
       }

   }

   function getUsername() {
    if(isset($_SESSION['username'])) {
         return $_SESSION['username'];
    } else {
        return null;
    }

}
?>