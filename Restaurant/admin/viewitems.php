<?php

session_start();
if(isset($_SESSION['item-id-update'])){
    
    unset($_SESSION['item-id-update']);
}

?>
<!DOCTYPE html>
<html>
    <head>
<link rel="stylesheet" href="table.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">
</head>
<body>

<div style='margin-bottom:20px;' class="navbar" >
<a href="admin.php" style='text-decoration:none;'>  <div class="arrow-left-div">
<i style='color:blue;'class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div style='color:blue;'  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>









<form action="updateitems.php" method="post">
<label>Search Your Item</label><input type='text' style='height:25px;'name='search-item'>
<input type='submit' value='filter'   name='sub-item'style='background-color:green;width:80px;height:30px;border-radius:5px;' >
<input type='submit' value='reset'   name='reset-item'style='background-color:red;width:80px;height:30px;border-radius:5px;' >
 
<?php

include("connectdb.php");

if(isset($_SESSION['name-item'])){
   $sql="SELECT * from items where name LIKE '".$_SESSION['name-item']."%'";
   $result=mysqli_query($conn,$sql);
   unset($_SESSION['name-item']);
   }


else{
$sql="SELECT * from items";
$result=mysqli_query($conn,$sql);
}
echo "<table>
<tr><th>Item ID</th><th>Item Name</th><th>Category ID</th><th>Price</th><th>Remain Quantity</th><th>MODIFY</th><th>DROP</th>
</tr>
";

while($data=mysqli_fetch_array($result)){
echo "<tr>
<td>".$data['itemID']."</td>
<td>".$data['name']."</td>
<td>".$data['categoryID']."</td>
<td>".$data['price']."</td>
<td>".$data['remainQuantity']."</td>
<td><Button type='submit' style='background-color:green;' name='myupdatebtn' value='".$data['itemID']."'>Update</Button></td>
<td><Button type='submit' style='background-color:red;' name='mydeletebtn' value='".$data['itemID']."'>Delete</Button></td>
</tr>";



}
echo "</table>";






?>

</form>
</body>

</html>