<?php
session_start();
if(isset($_SESSION['categoryid'])){
unset($_SESSION['categoryid']);
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



<div class="navbar" >
<a href="admin.php" style='text-decoration:none;'><div class="arrow-left-div">
<i class="fa-solid fa-circle-arrow-left" style='color:blue;'></i>
</div></a>

<div style='color:blue;'  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>






<form action="updatecategories.php" method="post">
  
<?php

include("connectdb.php");

$sql="SELECT * from category";
$result=mysqli_query($conn,$sql);
echo "<table>
<tr><th>Category ID</th><th>Category Name</th><th>MODIFY</th><th>DROP</th>
</tr>
";

while($data=mysqli_fetch_array($result)){
echo "<tr>
<td>".$data['categoryId']."</td>
<td>".$data['name']."</td>
<td><Button type='submit' style='background-color:green;' name='myupdatebtn' value='".$data['categoryId']."'>Update</Button></td>
<td><Button type='submit' style='background-color:red;' name='mydeletebtn' value='".$data['categoryId']."'>Delete</Button></td>
</tr>";



}
echo "</table>";






?>

</form>
</body>

</html>