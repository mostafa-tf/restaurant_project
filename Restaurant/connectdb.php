<?php
$conn=mysqli_connect("localhost","root","");

if(!$conn){
    die(" error in connection with server ");


}
$dbselected=mysqli_select_db($conn,"restaurant");

if(!$dbselected){
die("error in connnection with database ");

}



?>