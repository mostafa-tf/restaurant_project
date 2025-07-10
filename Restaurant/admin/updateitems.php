

<head>


<link rel="stylesheet" href="additem.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">

</head>
<div class="navbar" >
    <a href='viewitems.php' style='text-decoration:none;'><div class="arrow-left-div">
<i style='color:green;' class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>

<?php
include("connectdb.php");
session_start();
if(isset($_POST['sub-item'])){

$_SESSION['name-item']=$_POST['search-item'];
header("Location:viewitems.php");

}if(isset($_POST['reset-item'])){
   unset($_SESSION['name-item']);
   header("Location:viewitems.php");
    
    }
if(isset($_POST["mydeletebtn"])){

$deleteitem="DELETE FROM items where itemID=".$_POST["mydeletebtn"];
$execdelete=mysqli_query($conn,$deleteitem);
header("Location:viewitems.php");

}


?>
<?php
include("connectdb.php");
if(!isset($_SESSION['item-id-update'])){
$_SESSION['item-id-update']=$_POST['myupdatebtn'];
}

$sql="SELECT name,categoryID,price,remainQuantity,photo from items where itemID=".$_SESSION['item-id-update'];
$execsql=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($execsql);


?>
<body>

 <div class="container">
    <h1 name="additem-title">UPDATE YOUR ITEM </h1>
    <div class="additem-form">
     <form name="item-form" method="post" action="" enctype="multipart/form-data">
      <label  class="item-name-title">Item Name</label><input type="text" value='<?php echo $row['name'];  ?>' name="item-name" required> <br>
      <label  class="categorie-id-title">Category</label>
         <select name="categories" class="categories"> 
         <?php
           $sql="SELECT categoryId,name from category";
           $execute=mysqli_query($conn,$sql);
           while($data=mysqli_fetch_array($execute)){
            if($data['categoryId']==$row['categoryID']){
          echo "<option value='".$data['categoryId']."' selected>".$data['name']."</option>";
            }
            else{
                echo "<option value='".$data['categoryId']."'>".$data['name']."</option>"; 
            }

           }
         ?>



         </select> 
       
         <label  class="item-price-title">Item Price</label><input type="number" value='<?php echo $row['price'] ?>' name="item-price" required> <br>
         <label  class="item-quantity-title">Item Quantity</label><input type="number" value='<?php echo $row['remainQuantity'] ?>' name="item-quantity" required> <br>
         
       
<input type="submit" name="sub" value="Update" class="submit-item">
<?php

if(isset($_POST['sub'])){

  $updateitem="UPDATE items set name='".$_POST['item-name']."',
  categoryID=".$_POST['categories'].",
  price=".$_POST['item-price'].",
  remainQuantity=".$_POST['item-quantity']." where itemID=".$_SESSION['item-id-update'];
 
  $execupdat=mysqli_query($conn,$updateitem);
  
  header('Location:viewitems.php');
  
  
  
  
  }

?>





</form>
</div>
</div>
</body>