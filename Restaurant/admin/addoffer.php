<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="addoffer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">

</head>
<body>


<div class="navbar" >
    <a href="admin.php" style="text-decoration:none;"><div class="arrow-left-div">
<i  style='color:yellow;'class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>


<div class="container">

<h1>ADD OFFER</h1>

<div class="addoffer-form">
    <form name="offer-form" method="post" action="">

  <label class='item-name'>Item Name</label> <input type="text" style='margin-left:38px;' name='item-offer-name'><br>
    <label class="percentage">Offer Percentage<label><input type="number" name="percentage"><br>
    <label class="exp-date">Expiry Date<label><input type="date" style='margin-left:38px;width:193px;'  class="expiry-date" name="expiry-date"><br>
   <input type="submit" name="sub" value="ADD OFFER"  class="submit-offer">
   <?php
include("connectdb.php");
if(isset($_POST['sub'])){
$sql="SELECT itemID from items where name='".$_POST['item-offer-name']."'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0){
  echo "<p style='color:red;font-size:29px;'>No Item Founded </p>";
}
else{
  $data=mysqli_fetch_array($result);

$insertoffer="INSERT into offer(itemid,percentage,enddate)VALUES(".$data['itemID'].",".$_POST['percentage'].",'".$_POST['expiry-date']."')";
$execinsert=mysqli_query($conn,$insertoffer);
  echo "<p style='color:green;font-size:29px;'>Offer Inserted SUcessfully </p>";
  header("Location:viewoffers.php");
}

}

?>
    </form>
</div>


</div>




</body>


</html>