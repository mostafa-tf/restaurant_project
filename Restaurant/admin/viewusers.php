<?php
session_start();
if(isset($_SESSION['username'])){

unset($_SESSION['username']);
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
<a href="admin.php" style="text-decoration:none;">  <div class="arrow-left-div">
<i  style='color:purple;'class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div style='color:purple; '  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>





<form action="updateusers.php" name="myform" method="post">
<label>Search Your Member</label><input type='text' style='height:25px;'name='search-member'>
<input type='submit' value='filter'   name='sub-member'style='background-color:green;width:80px;height:30px;border-radius:5px;' >
<input type='submit' value='reset'   name='reset-member'style='background-color:red;width:80px;height:30px;border-radius:5px;' >
<?php

include("connectdb.php");
if(isset($_SESSION['name-member'])){
$sql="SELECT * from person where username LIKE '".$_SESSION['name-member']."%'";
$result=mysqli_query($conn,$sql);
unset($_SESSION['name-member']);
}
else{

$sql="SELECT * from person";
$result=mysqli_query($conn,$sql);
}

echo "<table>
<tr><th>Username</th><th>Password</th><th>FirstName</th><th>LastName</th><th>Email</th>
<th>Phone</th><th>Location</th><th>Position</th>
<th>MODIFY</th><th>DROP</th>
</tr>
";

while($data=mysqli_fetch_array($result)){
echo "<tr>
<td>".$data['username']."</td>
<td>".$data['password']."</td>
<td>".$data['firstname']."</td>
<td>".$data['lastname']."</td>
<td>".$data['email']."</td>
<td>".$data['phone']."</td>
<td>".$data['location']."</td>
<td>".$data['position']."</td>
<td><Button type='submit' style='background-color:green;' name='myupdatebtn' value='".$data['username']."'>Update</Button></td>
<td><Button type='submit' style='background-color:red;' name='mydeletebtn' value='".$data['username']."'>Delete</Button></td>
</tr>";



}
echo "</table>";






?>
<script>
function f(){
document.myform.action="";
document.myform.submit();


}

</script>
</form>
</body>

</html>