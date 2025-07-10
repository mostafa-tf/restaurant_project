<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register & Login</title>
  <link rel="stylesheet" href="css/signup.css">
  <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
</head>

<body>

  <div class="container" id="login">

    <h1 class="form-title">Log In</h1>
    <form method="post" action="">


      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="text" name="usernamelogin" id="usernamelogin" placeholder="UserName" required>
        <label for="usernamelogin">UserName</label>
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="passwordlogin" id="passwordlogin" placeholder="Password" required>
        <label for="passwordlogin">Password</label>
      </div>

      <input type="submit" class="btn" value="Log In" name="login">
    </form>
    <p class="or">
      --------or--------
    </p>

    <div class="links">
      <p>Dont Have Account ?</p>
      <a href="signup.php"><button id="signupbutton">Sign Up</button></a>
    </div>

    <?php
    include("connectdb.php");

    if (isset($_POST["login"])) {
      $uname = $_POST["usernamelogin"];
      $password = $_POST["passwordlogin"];

      $sqlverifysignin = "SELECT username,password,position from person where username='" . $uname . "' and password='" . $password . "'";
      $execverify = mysqli_query($conn, $sqlverifysignin);
      if (mysqli_num_rows($execverify) > 0) {
        echo "<p style='color:green;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'>Email Correct </p>";
        $pos = mysqli_fetch_array($execverify);
        $_SESSION["username"]=$pos["username"];
        $sql="UPDATE person SET isactive=1 WHERE username='".$_SESSION["username"]."'";
        mysqli_query($conn,$sql);
        // session_destroy();
        if ($pos["position"] == 0) {
          header("Location:user.php");
        } elseif ($pos["position"] == 1) {
          header("Location:admin/admin.php");
        } elseif ($pos["position"] == 3) {
          header("Location: cashier/delivery.php");

        } else {
          header("Location:cashier.php");
        }
      } else if (mysqli_num_rows($execverify) == 0) {
        echo "<p style='color:red;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'>Email Not Found </p>";
      }
    }
    ?>

  </div>



</body>

</html>