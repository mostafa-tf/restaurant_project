<?php
include "connectdb.php";
session_start();

if (!isset($_SESSION["username"])) {
    die("You must be logged in to add items to the cart.");
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

$sql = "SELECT o.percentage, o.enddate, o.itemid, i.name, i.price, i.photo 
        FROM offer AS o 
        JOIN items AS i ON o.itemid = i.itemid 
        WHERE o.enddate >= '" . date('Y-m-d') . "' ";


$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$offers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $offers[] = $row;
}

//tets

if (isset($_GET["itemid"])) {

    $itemid = mysqli_real_escape_string($conn, $_GET["itemid"]);

    if (isset($_SESSION["card"])) {
        $_SESSION["card"][count($_SESSION["card"])] = $itemid;
    } else $_SESSION["card"] = [$itemid];

    
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="whatsapp/offer.css">
    <title>Offers</title>

    <style>
        /* Positioning the discount ribbon on the image */
        .image {
            position: relative;
            display: inline-block;
        }

        .discount-ribbon {
            position: absolute;
            top: 10px;
            left: -10px;
            background: linear-gradient(45deg, #ff0000, #ff6a00);
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            transform: rotate(-20deg);
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* Price Styles */
        .discount-price {
            font-size: 24px;
            color: green;
            font-weight: bold;
        }

        .original-price {
            font-size: 20px;
            text-decoration: line-through;
            color: #888;
        }

        /* Offer Card */
        .swiper-slide {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 4px 10px rgba(245, 238, 238, 0.2);
        }

        /* Button Styling */
        .btn {
            background: #ff6a00;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ff4500;
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <section class="hero">
        <div class="hero-slider">
            <div class="swiper-wrapper">
                <?php
                if (!empty($offers)) {
                    foreach ($offers as $offer) {
                        $discounted_price = $offer["price"] - ($offer["price"] * $offer["percentage"] / 100);
                        echo '
                    <div class="swiper-slide slide">
                        <div class="content">
                            <h3>' . ($offer["name"]) . '</h3>
                            <p><span class="original-price">' . $offer["price"] . '</span></p>
                            <p><span class="discount-price">' . $discounted_price . '</span></p>
                            <a href="?itemid=' . $offer["itemid"] . '" class="btn">Add to Cart</a>
                        </div>
                        <div class="image">
                            <span class="discount-ribbon">' . $offer["percentage"] . '% OFF</span>
                            <img src="' . ($offer["photo"]) . '" alt="' . ($offer["name"]) . '">
                        </div>
                    </div>';
                    }
                } else {
                    echo '<div class="swiper-slide slide">
                        <div class="content">
                            <span>No Offers Available</span>
                            <h3>Check Back Later</h3>
                        </div>
                    </div>';
                }
                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".hero-slider", {
            loop: true,
            grabCursor: true,
            effect: "flip",
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>

</body>

</html>