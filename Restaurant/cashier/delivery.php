<?php
session_start(); ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
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
            width: 90%;
            top: 0;
            justify-content: space-between;
            align-items: center;
            background-color: #343a40;
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



        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: #fff0f5;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        div {
            margin: 10px 0;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #ff6f91;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #ff467e;
        }

        .cute-btn {
            background: #ff6f91;
            border-radius: 50px;
            color: #fff;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .cute-btn:hover {
            background: #ff467e;
        }
    </style>
</head>

<body>



    <div class="navbar">
       

        <div class="admin-panel">Delivery Panel</div>

        <a href="../logout.php" style='text-decoration:none; color:white'>
            <div class="logout-icon">
                LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
        </a>
    </div>

    <?php
    $username = $_SESSION['username'];
    include("../connectdb.php");

    if (isset($_POST['done'])) {
        $sql = "UPDATE delivery SET statuss = 1 WHERE username = '$username'";
        mysqli_query($conn, $sql);
    }

    $sql = "SELECT orderid FROM delivery WHERE username = '$username' AND statuss = 0";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_row($result)) {
        $orderid = $row[0];

        $sql = "SELECT * FROM orderr o JOIN person p ON p.username = o.username WHERE o.orderid = $orderid";
        $result = mysqli_query($conn, $sql);
        $orderDetails = mysqli_fetch_all($result);

        // echo "<pre>";
        // print_r($orderDetails);
        // echo "</pre>";

        echo '
        <form action="" method="post">
            <div>Order ID: ' . htmlspecialchars($orderDetails[0][0]) . '</div>
            <div>Client Name: ' . htmlspecialchars($orderDetails[0][8]) . ' ' . htmlspecialchars($orderDetails[0][9]) . '</div>
            <div>Location: ' . htmlspecialchars($orderDetails[0][12]) . '</div>
            <div>Phone: ' . htmlspecialchars($orderDetails[0][11]) . '</div>
            <div>
                <input type="submit" name="done" value="Done" class="cute-btn">
            </div>
        </form>
        ';
    } else {
        echo "<div>You are not assigned to any orders.</div>";
    }
    ?>
</body>

</html>