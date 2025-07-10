<!DOCTYPE html>

<html>


<head>

<link rel="stylesheet" href="additem.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">

</head>

<body>



<div class="navbar" >
<a href="admin.php" style='text-decoration:none;'><div class="arrow-left-div">
<i  style='color:green;'class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div style='color:green;'  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>







    <div class="container">
    <h1 name="additem-title">ADD YOUR ITEM </h1>
    <div class="additem-form">
    <form name="item-form" method="post" action="" enctype="multipart/form-data">
      <label  class="item-name-title">Item Name</label><input type="text" name="item-name" required> <br>
      <label  class="categorie-id-title">Category</label><select name="categories" class="categories" > 
   <?php
   include("connectdb.php");
   $sql="SELECT categoryId,name from category";
   $result=mysqli_query($conn,$sql);
   while($data=mysqli_fetch_array($result)){
   echo "<option value='".$data['categoryId']."'>".$data['name']."</option>";

}

   ?>


</select><br>
<label  class="item-price-title">Item Price</label><input type="number" name="item-price" required> <br>
<label  class="item-quantity-title">Item Quantity</label><input type="number" name="item-quantity" required> <br> 
<label  class="item-photo-title">Item Photo</label><input type="file" name="item-photo" required> <br> 

<input type="submit" name="sub" value="save" class="submit-item">

    </form>

     </div>
     <?php
     include("connectdb.php");
if(isset($_POST["sub"])){

if(isset($_FILES['item-photo'])&&$_FILES['item-photo']['error']==0){
$sql="SELECT name from category where categoryId=".$_POST['categories'];
$result=mysqli_query($conn,$sql);
$foldername=mysqli_fetch_array($result);

$photo=$foldername['name'].'/'.$_FILES['item-photo']['name'];
$insertitem="INSERT INTO items(name,categoryID,price,remainQuantity,photo)VALUES('".$_POST['item-name']."',".$_POST['categories'].",
".$_POST['item-price'].",".$_POST['item-quantity'].",'".$photo."')";
$exec=mysqli_query($conn,$insertitem);
echo "<p style='color:green;font-size:30px;'>Inserted Successfully</p>";
header("Location:viewitems.php");


}
else{
 echo "<p style='color:red;font-size:30px;'>Image Not uploaded or error in image</p>";
}


}



      ?>

    </div>
</body>



</html>