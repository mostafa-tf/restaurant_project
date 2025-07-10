<?php
session_start();
// include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <!-- <link rel="stylesheet" href="whatsapp/user.css"> -->

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 10px;
            background-color:rgb(247, 240, 213);
            color: #333;
        }



        .containerr {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            margin: 20px;
            padding: 20px;
            width: 90%;
            /* max-width: 1200px; */
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            border-radius: 10px;
        }

        .containerr a {
            text-decoration: none;
            color: #FFD700;
            font-size: 2.5em;
            margin: 10px;
            margin-top: 100px;
        }

        .containerr div {
            background-color: #3b2a2a;
            padding: 20px;
            border-radius: 10px;
            height: 100px;
            min-width: 200px;
            margin:30px ;
            align-content: center;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease, outline 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .containerr div:hover {
            background-color:rgba(102, 107, 8, 0.94);
            /* outline: 1px solid #FFD700; */
            color: white;
            transform: translateY(-5px);

        }

        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            /* Light gray background */
        }

        /* Navbar styles */
        .navbar {
            display: flex;
            position: fixed;
            z-index: 1;
            width: 100%;
            top: 0;
            left: 0;

            justify-content: space-between;
            align-items: center;
            background-color: #3b2a2a;
            /* Dark background color */
            color: white;
            padding: 20px 40px;
            /* Increased padding for height */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);

        }

        /* Icon styles */
        .arrow-left-div {
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 36px;
            /* Increased icon size for back button */
            position: relative;
            /* Position relative for the underline effect */
            transition: color 0.3s ease, transform 0.3s ease;
            /* Smooth transition for color and movement */
        }

        .logout-icon {
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 30px;
            /* Slightly smaller icon size for logout */
            position: relative;
            /* Position relative for the underline effect */
            transition: color 0.3s ease, transform 0.3s ease;
            /* Smooth transition for color and movement */
        }

        /* Underline effect */
        .arrow-left-div::after,
        .logout-icon::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -5px;
            /* Position the underline below the text */
            height: 3px;
            /* Height of the underline */
            background-color: transparent;
            /* Initial state */
            transition: background-color 0.3s ease;
            /* Smooth transition for underline */
        }

        /* Hover effects */
        .arrow-left-div:hover,
        .logout-icon:hover {
            color: #ffc107;
            /* Change color on hover */
        }

        .arrow-left-div:hover::after,
        .logout-icon:hover::after {
            background-color: #ffc107;
            /* Yellow underline on hover */
        }

        /* Move icons up on hover */
        .arrow-left-div:hover,
        .logout-icon:hover {
            transform: translateY(-5px);
            /* Move up by 5px on hover */
        }

        /* Admin Panel title styles */
        .admin-panel {
            font-size: 32px;
            /* Larger font size */
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
            /* Allow this div to take up available space */
            color: #ffc107;
            /* Gold color for the title */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            /* Text shadow for depth */
        }

        /* Icon spacing */
        i {
            margin-left: 8px;
            /* Space between text and icon */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-panel {
                margin: 10px 0;
            }
        }
    </style>


</head>

<body>
<div class="navbar">
       

       <div class="admin-panel">Delivery Panel</div>

       <a href="logout.php" style='text-decoration:none; color:white'>
           <div class="logout-icon">
               LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
           </div>
       </a>
   </div>
    <div class="containerr">

        <a href="cashier/neworder.php">
            <div>
                DineIn
            </div>
        </a>
        <a href="cashier/takeaway.php">
            <div>
                TakeAway
            </div>
        </a>
        <a href="cashier/closetable.php">
            <div>
                Close Table
            </div>
        </a>
        <a href="cashier/progressdel.php">
            <div>
                Progress Delivery
            </div>
        </a>
        <a href="cashier/enddel.php">
            <div>
                End Delivery
            </div>
        </a>
    </div>
</body>

</html>