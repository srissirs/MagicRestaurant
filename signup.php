<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Magic Restaurant</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
  </head>
  <body id="loginPage">
    <signUp>
      <?php include_once('session.php');?>
      <form action="action_signup.php" method="post" class="register_form">
        <input type="text" id="firstname" name="firstname" placeholder="First Name" required="required"><br>
        <input type="text" id="lastname" name="lastname" placeholder="Last Name" required="required"><br>
        <input type="text" id="username" name="username" placeholder="Username" required="required"><br>
        <input type="text" id="address" name="address" placeholder="Address" required="required"><br>
        <input type="text" id="city" name="city" placeholder="City" required="required"><br>
        <input type="text" id="country" name="country" placeholder="Country" required="required"><br>
        <input type="text" id="postalcode" name="postalcode" placeholder="Postal Code" required="required"><br>
        <input type="number" id="phone" name="phone" placeholder="Phone Number" required="required"><br>
        <input type="email" id="email" name="email" placeholder="Email" required="required"><br>
        <input id="password" name="password" type="password" placeholder="Password" required="required"><br>
        <div>  
        <label for="ImRestaurant">I'm a restaurant owner</label>
        <input type="checkbox" id="restaurantowner" name="restaurantowner" value=1>
        </div>
        <button type="submit"> Register </button><br>
      </form>
        <p id="error_messages" style="color: black"> 
        
           <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
        </p>
    </signUp>
  </body>
    