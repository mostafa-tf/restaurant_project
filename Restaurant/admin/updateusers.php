

<head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">
</head>
<div class="navbar" >
<a href="viewusers.php" style='text-decoration:none;'>    <div class="arrow-left-div">
<i style='color:cyan;' class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>
<head>
<link rel="stylesheet" href="adduser.css">
</head>


<?php
include("connectdb.php");
session_start();
if(isset($_POST['sub-member'])){

$_SESSION['name-member']=$_POST['search-member'];
header("Location:viewusers.php");

}if(isset($_POST['reset-member'])){
   session_destroy();
   header("Location:viewusers.php");
    
    }

if(isset($_POST["mydeletebtn"])){

$deleteuser="DELETE FROM person where username='".$_POST["mydeletebtn"]."'";
$execdelete=mysqli_query($conn,$deleteuser);
header("Location:viewusers.php");

}

?>
<?php
    if(!isset($_SESSION['username'])){
        $_SESSION['username']=$_POST['myupdatebtn'];
      

    }
    $sql="SELECT * from person where username='".$_SESSION['username']."'";
    $result=mysqli_query($conn,$sql);
    $data=mysqli_fetch_array($result);
   $uname=$data['username'];
   $passw=$data['password'];
   $fname=$data['firstname'];
   $lname=$data['lastname'];
   $email=$data['email'];
   $phone=$data['phone'];
   $loc=$data['location'];
   $pos=$data['position'];
     
    ?>
    <body>

<div class="container">
<h1 style="color:cyan;">Update  USER</h1>

<div class="adduser-form">
<form name="user-form" method="post" action="">
    

<label class="user-name">UserName</label><input type="text" class="input" value="<?php if(isset($_POST['user-name'])){echo $_POST['user-name'];} else{echo $uname; } ?>" name="user-name"required><br>
<label class="pass-word">Password </label><input type="password" class="input" value="<?php if(isset($_POST['pass-word'])){echo $_POST['pass-word'];} else{echo $passw; }  ?>" name="pass-word"required><br>
<label class="first-name">FirstName</label><input type="text" class="input"  value="<?php if(isset($_POST['first-name'])){echo $_POST['first-name'];} else{echo $fname; }  ?>" name="first-name"required><br>
<label class="last-name">LastName</label><input type="text" class="input"value="<?php if(isset($_POST['last-name'])){echo $_POST['last-name'];} else{echo $lname; }?>" name="last-name"required><br>
<label class="email-name">Email</label><input type="email" class="input" value="<?php if(isset($_POST['email-name'])){echo $_POST['email-name'];} else{echo $email; }  ?>" name="email-name"required><br>
<label class="phone-number">Phone</label><input type="number" class="input"value="<?php if(isset($_POST['phone-number'])){echo $_POST['phone-number'];} else{echo $phone; }  ?>" name="phone-number"required ><br>
<label class="user-location">Location</label><input type="text" class="input"value="<?php  if(isset($_POST['user-location'])){echo $_POST['user-location'];} else{echo $loc; }  ?>"name="user-location"required><br>

<label class="user-position">Position</label>
<select name="user-position">


<option value="0" <?php if($pos==0){echo "selected";}     ?> >user</option>
<option value="1" <?php if($pos==1){echo "selected";}     ?> >admin</option>
<option value="2" <?php if($pos==2){echo "selected";}     ?>>cashier</option>


</select>

<input type="submit" value="ADD" name="sub" class="submit-user">

</form>

</div>

</div>

<?php
if(isset($_POST['sub'])){

$updateperson="UPDATE person set username='".$_POST['user-name']."',
password='".$_POST['pass-word']."',
firstname='".$_POST['first-name']."',
lastname='".$_POST['last-name']."',
email='".$_POST['email-name']."',
phone=".$_POST['phone-number'].",
location='".$_POST['user-location']."',
position=".$_POST['user-position']." where username='".$_SESSION['username']."'";
$execupdat=mysqli_query($conn,$updateperson);

header('Location:viewusers.php');




}


?>
</body>
