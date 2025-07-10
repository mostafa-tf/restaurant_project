<?php
include "connectdb.php";
session_start();

$updateIsActive = "UPDATE person SET isactive = 0 WHERE username='" . $_SESSION["username"] . "'";
mysqli_query($conn, $updateIsActive);

session_destroy();

header("Location: user.php");
exit();


?>