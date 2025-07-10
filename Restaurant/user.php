<?php
session_start();
include("connectdb.php");
include("navbar.php");
// session_destroy();  
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // echo $username;
}

if (!isset($_SESSION['category'])) {
    $_SESSION['category'] = "most popular";
}

if (isset($_POST['category'])) {
    $_SESSION['category'] = $_POST['category'];
}

if (isset($_POST["id"])) {
    if (isset($_SESSION["card"])) {
        $_SESSION["card"][count($_SESSION["card"])] = $_POST["id"];
    } else $_SESSION["card"] = [$_POST["id"]];
    $id = $_POST['id'];
}

if (isset($_SESSION["card"]) && isset($_SESSION['username'])) {
    $sql = "DELETE FROM card WHERE  username='" . $_SESSION['username'] . "'";
    mysqli_query($conn, $sql);
    foreach ($_SESSION["card"] as $itid) {
        $sql = "SELECT * FROM card where itemid=" . $itid . " AND username='" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $quantity = $row['quantity'];
            $quantity++;
            $sql1 = "update card set quantity=$quantity where itemid=" . $itid . " AND username='" . $_SESSION['username'] . "'";
            mysqli_query($conn, $sql1);
        } else {
            // echo"test<br>";
            $sql1 = "insert into card value('$username',$itid,1) ";
            mysqli_query($conn, $sql1);
        }
    }
}


// if (isset($_SESSION["card"])) {
//     $sql = "SELECT * FROM items ";
//     $result = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_all($result);
//     echo "<div class='item'>";
//     $i = 0;

//     // $sql = "INSERT INTO category VALUES('ASD'); ";
//     // mysqli_query($conn, $sql);
//     for ($i; $i < 18; $i++)
//         foreach ($_SESSION["card"] as $card)
//             if ($card == $row[$i][0])
//                 echo "<div id=" . $row[$i][0] . " style='text-align:center '>
// <img src='" . $row[$i][5] . "'  style='overflow: hidden;' alt='' >
// <br> " . $row[$i][1] . "  
// <br> " . $row[$i][3] . " L.L
// <br><br></div>";

//     echo "</div>";

//     echo '
// <input type="button" name="Cancel" id="">
// ';
// }

?>

<!DOCTYPE html>

<div>

</div>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/user1.css">
    <style>
        .pric {
            text-decoration: line-through;
        }


        .price {
            font-size: 18px;
            color: var(--main-color);
            font-weight: 600;
        }
    </style>
    <title>Document</title>
</head>

<body>

</body>

</html>



<?php
$x = 8;
if ($_SESSION['category'] == "most popular") {

    $sql = "SELECT i.* ,sum(quantity) FROM items i,orderitem oi  
WHERE i.itemid = oi.itemid  
GROUP BY oi.itemid  
order by sum(oi.quantity) desc";
    echo '<h1 id="idd">MOST POPULAR</h1>';
} else {
    $x = 10000;
    $sql = "SELECT i.*  FROM items i where categoryid='" . $_SESSION['category'] . "' ";
    $sql1 = "SELECT name  FROM category where categoryid='" . $_SESSION['category'] . "' ";
    $result = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_all($result);

    echo '<h1 id="idd">' . $row[0][0] . '</h1>';
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result);

// echo "<pre>";
// print_r($row);
// echo "</pre>";
$offersql = "SELECT * FROM offer WHERE enddate >= '" . date('Y-m-d') . "' ";
$resultoffer = mysqli_query($conn, $offersql);
$offers = mysqli_fetch_all($resultoffer);



echo "
<form action='' name='fm' method='POST'>

<div class='item'>";
echo '<input type="text" name="id" id="iddd" hidden value="';
if (isset($_POST['id'])) echo $_POST['id'];
echo '">';
$i = 0;

mysqli_query($conn, $sql);
for ($i; $i < count($row) && $i < $x; $i++) {

    $k = 0;
    for ($k = 0; $k < count($offers); $k++) {
        if ($row[$i][0] == $offers[$k][1]) {
            $offprice = $row[$i][3] - $row[$i][3] * $offers[$k][2] / 100;
            break;
        }
    }


    echo "<div id=" . $row[$i][0] . " style='text-align:center '>";

    if ($k < count($offers))
        echo "<span class='discount-ribbon'>" . $offers[$k][2] . " %</span>";

    echo "<img src='" . $row[$i][5] . "'  style='overflow: hidden;' alt='' >
    <br> " . $row[$i][1] . "  ";

    if ($k < count($offers)) {
        echo "<br><span class='pric'> " . $row[$i][3] . " L.L</span> ";
        echo "<br><span class='price'> " . $offprice . " L.L</span> ";
    } else
        echo "<br> " . $row[$i][3] . " L.L
     ";
    echo '<br>
    
    <input type="button" name="" onclick="f(' . $row[$i][0] . ')" ';
    if (!isset($_SESSION["username"]))
        echo "disabled";

    echo ' value="add to cart">
    ';

    echo "<br><br></div>";
}
echo "<br><br></div>";
?>

<script>
    window.onload = function() {
        var x = document.getElementById('iddd').value;
        document.getElementById(x).scrollIntoView();
    }

    function f(id) {
        document.fm.id.value = id;
        document.fm.submit();
    }
</script>

<!-- <a href="#idd"></a> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Footer */
        footer {
            font-size: 14px;
            color: var(--light-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .item {
                flex-direction: column;
                align-items: center;
            }

            .item div {
                width: 100%;
            }
        }

        footer {
            /* position: fixed; */
            bottom: 0px;
            background-color: #3b2a2a;
            /* Dark blue background */
            color: white;
            /* White text color */
            padding: 40px 0;
            /* Padding for top and bottom */
            text-align: center;
            /* Center align text */
            margin: 10px;
            margin-top: 50px;
            /* Push footer to the bottom */

            padding: 20px 40px;
            /* Increased padding for a more spacious look */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            /* Enhanced shadow for depth */
            border-radius: 15px;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            /* Space between sections */
            flex-wrap: wrap;
            /* Wrap sections on smaller screens */
            padding: 0 20px;
            /* Padding on sides */
            color: #FFD700;
        }

        footer .footer-section {
            flex: 1;
            /* Equal width for all sections */
            margin: 10px;
            /* Margin around sections */
        }

        footer .footer-section h3 {
            margin-bottom: 15px;
            /* Space below headings */
            font-size: 18px;
            /* Font size for headings */
            text-transform: uppercase;
            /* Uppercase headings */
        }

        footer .footer-section ul {
            list-style: none;
            /* Remove list bullets */
            padding: 0;
            /* Remove padding */
        }

        footer .footer-section ul li {
            margin-bottom: 10px;
            /* Space below list items */
        }

        footer .footer-section ul li a {
            color: white;
            /* White text color for links */
            text-decoration: none;
            /* Remove underline from links */
            transition: color 0.3s, background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
        }

        footer .footer-section ul li a:hover {
            color: #FFD700;
            /* Gold color on hover */
            background-color: rgba(255, 215, 0, 0.2);
            /* Light gold background on hover */
            transform: scale(1.1);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
            padding: 5px;
            border-radius: 5px;
        }

        footer .contact-info p {
            margin: 5px 0;
            /* Margin around contact info */
        }

        footer .contact-info p i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        footer .contact-info a {
            color: white;
            /* White text color for links */
            text-decoration: none;
            /* Remove underline from links */
            transition: color 0.3s, background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
        }

        footer .contact-info a:hover {
            color: #FFD700;
            /* Gold color on hover */
            background-color: rgba(255, 215, 0, 0.2);
            /* Light gold background on hover */
            transform: scale(1.1);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
            padding: 5px;
            border-radius: 5px;
        }

        footer .social-icons {
            display: flex;
            flex-direction: column;
            /* Arrange icons vertically */
            align-items: center;
            /* Align icons to the center */
        }

        footer .social-icons p {
            margin: 10px 0;
            /* Space above and below text */
        }

        footer .social-icons a {
            color: white;
            /* White text color for social icons */
            text-decoration: none;
            /* Remove underline from social icons */
            font-size: 24px;
            /* Font size for social icons */
            transition: color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
            display: flex;
            /* Flex container for icon and text */
            align-items: center;
            /* Align icon and text vertically */
            margin-bottom: 10px;
            /* Space below each icon */
        }

        footer .social-icons a i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        footer .social-icons a span {
            font-size: 14px;
            /* Smaller text size */
        }

        footer .social-icons a:hover {
            color: #FFD700;
            /* Gold color on hover */
            transform: scale(1.3);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
        }
    </style>

</head>

<body>
    <footer>
        <div class="container">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#idd">Home</a></li> <!-- Update href to actual page URLs -->
                    <li><a href="about.php">About</a></li>
                    <li><a href="package.php">Package</a></li>
                    <li><a href="book.php">Book</a></li>
                </ul>
            </div>
            <div class="footer-section contact-info">
                <h3>Contact Us</h3>
                <a href="https://wa.me/96181683963">
                    <p><i class="fas fa-phone"></i> +96103036691</p>
                </a> <!-- Update href to WhatsApp links -->
              
                <!-- <a href="mailto:example@example.com">
                    <p><i class="fas fa-envelope"></i> wassemabouarab49@gmail.com</p>
                </a>
                <p><i class="fas fa-map-marker-alt"></i> Hwsh-aloumara-Zahle, Lebanon</p> -->
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i><span> Facebook</span></a>
                    <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i><span> Twitter</span></a>
                    <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i><span> Instagram</span></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>