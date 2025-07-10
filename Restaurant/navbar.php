<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="whatsapp/user.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Improved Navbar</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0e68c;
            /* Softer background color */
        }

        .flexbox {
            display: flex;
            position: sticky;
            width: 100%;
            box-sizing: border-box;
            height: 90px;
            margin-bottom: 50px;
            justify-content: space-between;
            /* Space items evenly */
            align-items: center;
            background-color: #3b2a2a;
            /* Darker background color for the navbar */
            padding: 20px 40px;
            /* Increased padding for a more spacious look */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            /* Enhanced shadow for depth */
            border-radius: 15px;
            /* More rounded corners for a softer look */
            top: 0px;
            z-index: 1;
        }

        .son {
            color: #FFD700;
            /* Gold color for text */
            margin: 0 20px;
            /* Increased margin for better spacing */
            padding: 10px 15px;
            /* Adjusted padding for a more balanced look */
            position: relative;
            cursor: pointer;
            font-size: 20px;
            /* Larger font size for better readability */
            transition: transform 0.3s ease, color 0.3s ease, background-color 0.3s ease;
            /* Smooth transition */
            border-radius: 8px;
            /* Rounded corners for each item */
            display: flex;
            /* Flexbox for icon and text alignment */
            align-items: center;
            /* Center the icon vertically */
        }

        .son:hover {
            transform: scale(1.1);
            /* Scale up on hover */
            background-color: rgba(255, 215, 0, 0.3);
            /* Light gold background on hover */
            color: #fff;
            /* Change text color to white on hover */
        }

        .son::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -5px;
            /* Adjusted position for better alignment */
            width: 0;
            height: 3px;
            background: #FFD700;
            /* Underline color */
            transition: width 0.3s ease, left 0.3s ease;
            /* Smooth transition */
        }

        .son:hover::after {
            width: 100%;
            /* Full width on hover */
            left: 0;
            /* Move to the left */
        }

        img {
            height: 70px;
            /* Consistent image height */
            transition: transform 0.3s ease;
            /* Smooth transition for image */
        }

        img:hover {
            transform: scale(1.1);
            /* Scale up image on hover */
        }

        .login {
            display: flex;
            /* Flexbox for icon and text alignment */
            align-items: center;
            /* Center the icon vertically */
        }

        .login a,
        .login p {
            color: #FFD700;
            /* Gold color for the link */
            text-decoration: none;
            /* Remove underline from link */
            transition: color 0.3s ease;
            /* Smooth transition for color */
        }

        .login a:hover,
        p:hover {
            color: #fff;
            /* Change link color to white on hover */
        }

        .login i {
            margin-left: 5px;
            /* Space between text and icon */
            font-size: 20px;
            /* Icon size */
            transition: color 0.3s ease;
            /* Smooth transition for icon color */
        }

        .login a:hover i {
            color: #fff;
            /* Change icon color to white on hover */
        }

        /* Star Animation */
        .star-container {
            position: relative;
            /* Position relative to allow absolute positioning of stars */
            width: 70px;
            /* Match the image width */
            height: 70px;
            /* Match the image height */
        }

        .star {
            position: absolute;
            width: 10px;
            /* Size of the stars */
            height: 10px;
            /* Size of the stars */
            background: radial-gradient(circle, white, lightblue);
            /* Star appearance */
            border-radius: 50%;
            /* Make stars circular */
            animation: rotate 5s linear infinite;
            /* Rotate animation */
        }

        button p {

            width: 100%;
            height: 100%;
        }

        button {
            width: 100%;
            height: 100%;
            font-size: 20px;
            background-color: transparent;
            border: none;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>
    <div class="flexbox">
        <div class="son login">

            <form action="user.php" method="POST">
                <button onclick="submit()">
                    <p> HOME <i class="fa-solid fa-house"></i></p>
                    <input type="text" hidden name="category" value="most popular" id="">
            </form>



        </div>
        <div class="son login">
            <a href="category.php"> CATEGORY </a>
        </div>
        <div class="son login">
            <a href="<?php if (isset($_SESSION["username"])) echo 'card.php'; ?>">
                <i class="fa-solid fa-basket-shopping"></i></a>
        </div>
        <div class="son login">
            <a href='<?php if (isset($_SESSION["username"])) echo "offers.php";?>'>
                <div class="star-container">
                    <img src="whatsapp/discount.png" alt="Discount" style='height:70px'>

                </div>
            </a>
        </div>
        <div class="son login">
            <a href="about us/aboutus.php"> About Us </a>
        </div>
        <?php
        if(isset($_SESSION['username'])){
        
        ?>
        <div class="son login">
            <a href="profile.php"> Profile <i class="fa-solid fa-user"></i></a>
        </div>
        
        <?php
        }else{
        ?>
        <div class="son login">
            <a href="login.php"> LOGIN <i class="fa-solid fa-right-to-bracket"></i></a>
        </div>
        <?php
        }
        ?>
    </div>
</body>

</html>