<!DOCTYPE html>

<html>

<head>

    <link rel="stylesheet" href="addcategorie1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="adminheader.css">

</head>

<body>


    <div class="navbar">
        <a href="admin.php" style='text-decoration:none;'>
            <div class="arrow-left-div">
                <i class="fa-solid fa-circle-arrow-left" style='color:red'></i>
            </div>
        </a>

        <div style='color:red;' class="admin-panel">Admin Panel</div>

        <a href="../logout.php" style='text-decoration:none; color:white'>
            <div class="logout-icon">
                LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
        </a>
    </div>







    <div class="container">
        <h1 title="addcategroie-title">ADD YOUR CATEGORIE</h1>

        <div class="addcategorie-form">

            <form method="post" name="categorie-form" action="" enctype="multipart/form-data">

                <label name="category-label">CATERGORY NAME </label> <input type="text" name="categorie-name"><br>
                <label class="item-photo-title">Category Photo</label><input type="file" name="category-photo" required> <br>

                <input type="submit" name="sub" class="submit-categorie">
            </form>

        </div>

        <?php

        include("connectdb.php");
        if (isset($_POST["sub"])) {

            if (isset($_FILES['category-photo']) && $_FILES['category-photo']['error'] == 0) {
                echo "test1";

                $photo = 'CategoryPhoto/' . $_FILES['category-photo']['name'];

                $searchcateg = "SELECT name from category where name='" . $_POST['categorie-name'] . "'";
                $findcateg = mysqli_query($conn, $searchcateg);

                if (mysqli_num_rows($findcateg) > 0) {
                    echo "<div style='text-align:center;'><p style='color:red;font-size:20px;'>INSERTED Failed/Duplicate categorie</p></div>";
                } else {
                    if ($_POST["categorie-name"] == "") {
                        echo "<div style='text-align:center;'><p style='color:red;font-size:20px;'>INSERTED FAILED / Empty name</p></div>";
                    } else {
                        $insertcateg = "INSERT into category(name,photo)
                                        VALUES('" . $_POST['categorie-name'] . "','$photo')";
                        $execinsertcateg = mysqli_query($conn, $insertcateg);
                        echo "<p style='color:green;font-size:20px;'>INSERTED SUCESSFULLY</p>";

                        $dirName = 'C:/xampp/htdocs/restaurant/'.$_POST["categorie-name"];

                        if (!is_dir($dirName))
                            mkdir($dirName, 0755);

                        header("Location:viewcategories.php");
                    }
                }
            }
        }


        ?>

    </div>


</body>

</html>