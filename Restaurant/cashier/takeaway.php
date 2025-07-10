<?php

    session_start();
    $_SESSION["payed"]=1;
    header("location:../category.php");

?>