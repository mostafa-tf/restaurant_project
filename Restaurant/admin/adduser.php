<!DOCTYPE html>


<html>

<head>


<link rel="stylesheet" href="adduser.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">


</head>


<body>




<div style='margin-bottom:20px;' class="navbar" >
<a href="admin.php" style="text-decoration:none;"><div class="arrow-left-div">
<i style='color:cyan;' class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div style='color:cyan; '  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>









<div class="container">
<h1 style='color:darkblue;'>ADD A USER</h1>

<div class="adduser-form">
<form name="user-form" method="post" action="">
    

<label class="user-name">UserName</label><input type="text" class="input" name="user-name"required><br>
<label class="pass-word">Password </label><input type="password" class="input" name="pass-word"required><br>
<label class="first-name">FirstName</label><input type="text" class="input" name="first-name"required><br>
<label class="last-name">LastName</label><input type="text" class="input" name="last-name"required><br>
<label class="email-name">Email</label><input type="email" class="input" name="email-name"required><br>
<label class="phone-number">Phone</label><input type="number" class="input" name="phone-number"required ><br>
<label class="user-location">Location</label><input type="text" class="input" name="user-location"required><br>
<label class="user-position">Position</label><select name="user-position">
<option value="0">user</option>
<option value="1">admin</option>
<option value="2">cashier</option>
<option value="3">delivery</option>
</select><br>
<input type="submit" value="ADD" name="sub" class="submit-user">

</form>

</div>

</div>
<?php
include("connectdb.php");
if(isset($_POST["sub"])){

$searchuser="SELECT username from person where username='".$_POST['user-name']."'";
$finduser=mysqli_query($conn,$searchuser);

if(mysqli_num_rows($finduser)>0){
echo "<div style='text-align:center;'><p style='color:red;font-size:20px;'>INSERTED Failed/Duplicate username</p></div>";

}
else{
$insertuser="INSERT into person(username,password,firstname,lastname,email,phone,location,position)
VALUES('".$_POST['user-name']."','".$_POST['pass-word']."','".$_POST['first-name']."',
'".$_POST['last-name']."','".$_POST['email-name']."','".$_POST['phone-number']."','".$_POST['user-location']."','".$_POST['user-position']."')";
$execinsertuser=mysqli_query($conn,$insertuser);
echo "<div style='text-align:center;'><p style='color:green;font-size:20px;'>INSERTED SUCESSFULLY</p></div>";
header("Location:viewusers.php");
}
}


?>

</body>




    </html>