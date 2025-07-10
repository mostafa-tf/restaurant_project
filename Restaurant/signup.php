<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    
    <div class="container" id="signup">
        
      <h1 class="form-title">Register</h1>
      <form method="post" action="">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fname" id="fname" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lname" id="lname" placeholder="Last Name" required>
            <label for="lname">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="usernamesignup" id="usernamesignup" placeholder="User Name" required>
            <label for="usernamesignup">User Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
 
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="passwordsignup" id="passwordsignup" placeholder="Password" required>
            <label for="passwordsignup">Password</label>
        </div>
        <div class="input-group">
            <i class="fas fa-phone"></i>
            <input type="integer" name="phone" id="phone" placeholder="phone" required>
            <label for="phone">Phone</label>
        </div>
        <div class="input-group">
            <i class="fas fa-location"></i>
            <input type="text" name="location" id="location" placeholder="location" required>
            <label for="location">Location</label>
        </div>
         <input type="submit" class="btn" value="Sign Up" name="signup">
      </form>
      <p class="or">
        --------or--------
      </p>
      <div class="icons">
      <a href="https://accounts.google.com/signup" target="_blank"> <i class="fab fa-google"></i></a>
       <a href="https://www.facebook.com/reg" target="_blank"> <i class="fab fa-facebook"></i></a>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <a href="login.php"><button id="signinbutton">Log In</button></a>
      </div>
    

 <?php
include("connectdb.php");
if(isset($_POST["signup"])){
if(preg_match("/^[a-zA-Z'-]{2,30}$/",$_POST["fname"])){
    if(preg_match("/^[a-zA-Z'-]{2,30}$/",$_POST["lname"])){
        if(preg_match("/^[a-zA-Z'-@]{2,60}$/",$_POST["location"])){

       if(preg_match("/^[0-9]{7,8}$/",$_POST["phone"])){

            if(preg_match("/^[a-zA-Z0-9_-]{3,15}$/",$_POST["usernamesignup"])){

     $sql="SELECT username FROM person where username='".$_POST['usernamesignup']."'";
     $result=mysqli_query($conn,$sql);
     if(mysqli_num_rows($result)>0){
        echo "<p style='color:red;font-size:20px;font-weight:bold;font-style:oblic;font-family:Sans-Serif; margin-left:100px; '>UserName Already Exist </p>";
     }
     else{
       
       $insert="INSERT INTO person(username,password,firstname,lastname,email,phone,location) VALUES('".$_POST['usernamesignup']."','".$_POST['passwordsignup']."',
'".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['location']."')";
$insertexec=mysqli_query($conn,$insert);
echo "<p style='color:green;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'>Sign Up Succesfully</p>";
     }


            }
            else{
                echo "<p style='color:red;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'>Username Invalid</p>";
            }
        }
        else{
            echo "<p style='color:red;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'>Phone Invalid(must between 7-8 digits)</p>";  
        }

    }
    else{
        echo "<p style='color:red;font-size:20px;font-style:oblic;font-weight:bold;font-family:Sans-Serif; margin-left:100px;'> Error in Location </p>";
    }
   

}
else{
    echo "<p style='color:red;font-size:20px;font-weight:bold;font-style:oblic;font-family:Sans-Serif;margin-left:100px; '> Error in LastName</p>";
}

}
else{
    echo "<p style='color:red;font-size:20px;font-weight:bold;font-style:oblic;font-family:Sans-Serif; margin-left:100px;'> Error in FirstName</p>";
}


}


?>
    </div> 
</body>
</html>