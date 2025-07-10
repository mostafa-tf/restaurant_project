<?php
include "../connectdb.php";
session_start();

// Ensure the user is logged in
if (!isset($_SESSION["username"])) {
    die("You must be logged in to add items to the cart.");
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);


$sql = "SELECT o.percentage, o.enddate, o.itemid, i.name, i.price, i.photo 
        FROM offer AS o 
        INNER JOIN items AS i ON o.itemid = i.itemid 
        WHERE o.enddate >= CURDATE() 
        ORDER BY o.percentage DESC 
        LIMIT 3";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$offers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $offers[] = $row; 
}


if (isset($_GET["itemid"])) {
    $itemid = mysqli_real_escape_string($conn, $_GET["itemid"]);

   
    $checkQuery = "SELECT * FROM card WHERE username = '$username' AND itemid = '$itemid'";
    $result = mysqli_query($conn, $checkQuery);

    
    if (!$result) {
        die("Error checking cart: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "UPDATE card SET quantity = quantity + 1 WHERE username = '$username' AND itemid = '$itemid'";
        if (!mysqli_query($conn, $updateQuery)) {
            die("Error updating cart: " . mysqli_error($conn));
        }
    } else {
        $insertQuery = "INSERT INTO card (username, itemid, quantity) VALUES ('$username', '$itemid', 1)";
        if (!mysqli_query($conn, $insertQuery)) {
            die("Error adding to cart: " . mysqli_error($conn));
        }
    }
    header("Location: home.php");
    exit;
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        .image { position: relative; display: inline-block; }
        .discount-ribbon {
            position: absolute; top: 10px; left: -10px;
            background: linear-gradient(45deg, #ff0000, #ff6a00);
            color: white; padding: 10px 20px; font-weight: bold; font-size: 14px;
            border-radius: 5px; transform: rotate(-20deg);
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }
        .discount-price { font-size: 24px; color: green; font-weight: bold; }
        .original-price { font-size: 20px; text-decoration: line-through; color: #888; }
        .swiper-slide {
            background: white; padding: 20px; border-radius: 10px;
            box-shadow: 2px 4px 10px rgba(245, 239, 239, 0.2);
        }
        .btn {
            background: #ff6a00; color: white; padding: 10px 20px;
            border-radius: 5px; font-weight: bold; transition: 0.3s;
        }
        .btn:hover { background: #ff4500; transform: scale(1.1); }
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
                            <h3>' . htmlspecialchars($offer["name"]) . '</h3>
                            <p><span class="original-price">' . $offer["price"] . '</span></p>
                            <p><span class="discount-price">' . $discounted_price . '</span></p>
                            <a href="?itemid=' . $offer["itemid"] . '" class="btn">Add to Cart</a>
                        </div>
                        <div class="image">
                            <span class="discount-ribbon">' . $offer["percentage"] . '% OFF</span>
                            <img src="' . htmlspecialchars($offer["photo"]) . '" alt="' . htmlspecialchars($offer["name"]) . '">
                        </div>
                        <div class="more-offers">
                            <a href="offers.php" class="btn">For More Offers</a>
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
   pagination: { el: ".swiper-pagination", clickable: true },
});
</script>

</body>
</html>
