<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Magic Restaurant</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../style.css">
  <script src="https://kit.fontawesome.com/e93bc86ff0.js" crossorigin="anonymous"></script>
</head>

<body id="login">
  <section id="SignIn">
    <?php include_once('../session.php'); ?>
    <form action="../actions/action_login.php" method="post" class="register_form">
      <input type="text" id="fname" name="fname" placeholder="Email"><br>
      <input id="lname" name="lname" type="password" placeholder="Password"><br>
      <button type="submit"> Sign In</button><br>
      <a href="signup.php">Sign up</a> <br>
      <p id="error_messages" style="color: #946B6B">
        <?php if (isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']);
        unset($_SESSION['ERROR']) ?>
      </p>
    </form>
  </section>
  </login>
</body>

<!DOCTYPE html>
<html>