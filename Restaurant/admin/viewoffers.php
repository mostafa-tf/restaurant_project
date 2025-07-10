
<?php
session_start();

if(isset($_SESSION['offer-id'])){
unset($_SESSION['offer-id']);
}
?>

<!DOCTYPE html>
<html>
<head>



<link rel="stylesheet" href="table.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="adminheader.css">
</head>

<body>

<div style='margin-bottom:20px;' class="navbar" >
<a href="admin.php" style="text-decoration:none;"><div class="arrow-left-div">
<i style='color:green;' class="fa-solid fa-circle-arrow-left"></i>
</div></a>

<div style='color:green; '  class="admin-panel">Admin Panel</div>

<a href="../logout.php" style='text-decoration:none; color:white'><div class="logout-icon">
LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
</div></a>
</div>













<form action="updateoffers.php" method="post" name="myform">
<label for="offer-status">Filter Offers</label>
<select name='offer-status' onchange='f()'>
<option value=''<?php if(isset($_POST['offer-status'])){if($_POST['offer-status']==''){echo 'selected';}} ?>>ALL</option>
<option value='1'<?php  if(isset($_POST['offer-status'])){if($_POST['offer-status']=='1'){echo 'selected';}}?>>Active</option>
<option value='0'<?php  if(isset($_POST['offer-status'])){if($_POST['offer-status']=='0'){echo 'selected';}} ?>>Not active</option>

</select>

<?php






include("connectdb.php");

if(isset($_POST['offer-status'])){
if($_POST['offer-status']==''){
    $sql="SELECT * from offer";

$result=mysqli_query($conn,$sql);

}
else if($_POST['offer-status']=='1'){
    $sql="SELECT * from offer where enddate>=CURDATE()";

    $result=mysqli_query($conn,$sql);
}
else if($_POST['offer-status']=='0'){
    $sql="SELECT * from offer where enddate<CURDATE()";

    $result=mysqli_query($conn,$sql);
}


}
else{









$sql="SELECT * from offer";

$result=mysqli_query($conn,$sql);
}
echo "<table>";
echo "<tr><th>OfferId</th><th>ItemId</th><th>Percentage</th><th>Expiry Date</th><th>Status</th><th>Modify</th><th>Drop</th><tr>";

while($data=mysqli_fetch_array($result)){
    if(date('Y-m-d')<=$data['enddate']){
echo "<tr>
<td>".$data['offerid']."</td>
<td>".$data['itemid']."</td>
<td>".$data['percentage']."</td>
<td>".$data['enddate']."</td>
<td><i class='fa-solid fa-circle' style='color: #20f005;'></i></td>
<td><Button type='submit' style='background-color:green;' name='myupdatebtn' value='".$data['offerid']."'>Update</Button></td>
<td><Button type='submit' style='background-color:red;' name='mydeletebtn' value='".$data['offerid']."'>Delete</td>
</tr>";
    }
    else{
        echo "<tr>
        <td>".$data['offerid']."</td>
        <td>".$data['itemid']."</td>
        <td>".$data['percentage']."</td>
        <td>".$data['enddate']."</td>
        <td><i class='fa-solid fa-circle' style='color:rgb(0, 0, 0);'></i></td>
        <td><Button type='submit' style='background-color:green;' name='myupdatebtn' value='".$data['offerid']."'>Update</Button></td>
        <td><Button type='submit' style='background-color:red;' name='mydeletebtn' value='".$data['offerid']."'>Delete</td>
        </tr>";
            }


}



?>


</form>
<script>

function f(){
    document.myform.action="";
    document.myform.submit();
}


</script>
</body>













</html>