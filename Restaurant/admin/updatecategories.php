<head>
    <link rel="stylesheet" href="addcategorie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="adminheader.css">
</head>
<div class="navbar">
    <a href="viewcategories.php" style='text-decoration:none;'>
        <div class="arrow-left-div">
            <i style='color:red' class="fa-solid fa-circle-arrow-left"></i>
        </div>
    </a>

    <div class="admin-panel">Admin Panel</div>

    <a href="../logout.php" style='text-decoration:none; color:white'>
        <div class="logout-icon">
            LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
    </a>
</div>


<?php
include("connectdb.php");
if (isset($_POST["mydeletebtn"])) {

    $deletecateg = "DELETE FROM category where categoryId=" . $_POST["mydeletebtn"];
    $execdelete = mysqli_query($conn, $deletecateg);
    header("Location:viewcategories.php");
}


?>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['categoryid'])) {

        $_SESSION['categoryid'] = $_POST['myupdatebtn'];
    }
    include("connectdb.php");
    $sql = "select name from category where categoryId=" . $_SESSION['categoryid'];
    $execsql = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($execsql);
    ?>

    <div class="container">
        <h1 style='font-size:30px;' title="addcategroie-title">UPDATE YOUR CATEGORIE</title>

            <div class="addcategorie-form">
                <form method="post" name="categorie-form" action="">

                    <label name="category-label">CATERGORY NAME </label>
                    <input type="text" value="<?php if (isset($_POST['category-name'])) {
                                                    echo $_POST['category-name'];
                                                } else {
                                                    echo $data['name'];
                                                }    ?>" name="categorie-name"><br>
                    <input type="submit" value='Update' name="sub" class="submit-categorie">
                </form>
                <?php
                if (isset($_POST['sub'])) {

                    $searchcateg = "SELECT name from category where name='" . $_POST['categorie-name'] . "'";
                    $findcateg = mysqli_query($conn, $searchcateg);

                    if (mysqli_num_rows($findcateg) > 0) {
                        echo "<div style='text-align:center;'><p style='color:red;font-size:20px;'>INSERTED Failed/Duplicate categorie</p></div>";
                    } else {
                        if ($_POST['categorie-name'] == "") {
                            echo "<div style='text-align:center;'><p style='color:red;font-size:20px;'>INSERTED FAILED / Empty name</p></div>";
                        } else {

                            $updatecate = "update category set name='" . $_POST['categorie-name'] . "' where categoryId=" . $_SESSION['categoryid'];
                            $execupd = mysqli_query($conn, $updatecate);


                            header("Location:viewcategories.php");
                        }
                    }
                }




                ?>
            </div>


</body>