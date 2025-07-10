
<head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">
<link rel="stylesheet" href="addoffer.css">
</head>
<div class="navbar" >
   <a href="viewoffers.php" style='text-decoration:green;' ><div class="arrow-left-div">
<i  style='color:green;'class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>

<?php

include("connectdb.php");
if(isset($_POST['mydeletebtn'])){


    $deleteoffer="DELETE FROM offer where offerid=".$_POST['mydeletebtn'];
    $execdelete=mysqli_query($conn,$deleteoffer);
    header("Location:viewoffers.php");
}



?>
<?php
session_start();
if(!isset($_SESSION['offer-id'])){
$_SESSION['offer-id']=$_POST['myupdatebtn'];
}
include("connectdb.php");
$sql="SELECT itemid,percentage,enddate from offer where offerid=".$_SESSION['offer-id'];
$execsql=mysqli_query($conn,$sql);
$data=mysqli_fetch_array($execsql);

?>
<body>
<div class="container">

<h1>Update OFFER</h1>

<div class="addoffer-form">
    <form name="offer-form" method="post" action="">

  <label class='item-name'>Item Id</label> <input type="text" style='margin-left:38px;' value='<?php echo $data['itemid'];  ?>' name='item-offer-id'><br>
    <label class="percentage">Offer Percentage<label><input type="number" value='<?php echo $data['percentage'];  ?>' name="percentage"><br>
    <label class="exp-date">Expiry Date<label><input type="date" style='margin-left:38px;width:193px;' value='<?php echo $data['enddate'];  ?>'  class="expiry-date" name="expiry-date"><br>
   <input type="submit" name="sub" value="Update OFFER"  class="submit-offer">

</form>
</div>
</div>
<?php
if(isset($_POST['sub'])){

$updateoffer="Update offer set itemid=".$_POST['item-offer-id'].",percentage=".$_POST['percentage'].",enddate='".$_POST['expiry-date']."' where offerid=".$_SESSION['offer-id'];
$execupd=mysqli_query($conn,$updateoffer);

header("Location:viewoffers.php");
}


?>
</body>


