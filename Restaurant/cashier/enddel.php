<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-around;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: space-between;
            align-items: center;
        }

        form {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            font-size: 16px;
        }

        select:focus {
            outline: none;
            background: rgba(255, 255, 255, 1);
        }

        table {
            width: 50%;
            margin-top: 20px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 5px;
            overflow: hidden;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th,
        tfoot td {
            background: #4e54c8;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #4e54c8;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #373bbf;
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

    </style>
</head>

<body>


    <div class="navbar">
        <a href="../cashier.php" style="text-decoration:none;">
            <div class="arrow-left-div">
                <i style='color:yellow;' class="fa-solid fa-circle-arrow-left"></i>
            </div>
        </a>

        <div class="admin-panel">Cashier Panel</div>

        <a href="../logout.php" style='text-decoration:none; color:white'>
            <div class="logout-icon">
                LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
        </a>
    </div>
    <?php
    include("../connectdb.php");

    if (isset($_POST['end'])) {
        $delguy = $_POST['delguy'];
        $sql = "UPDATE orderr SET payed=1 WHERE orderid in(SELECT orderid from delivery where username ='$delguy') and payed =2";
        mysqli_query($conn, $sql);
    }

    $sql = "SELECT DISTINCT d.username FROM delivery d,orderr o WHERE statuss = 1 and o.orderid=d.orderid and o.payed=2";
    $result = mysqli_query($conn, $sql);
    $usernames = mysqli_fetch_all($result);

    echo "<form method='POST' action=''>";
    echo "Select the delivery guy";
    echo '<select name="delivery" id="" onchange="submit()" >';

    for ($i = 0; $i < count($usernames); $i++) {
        $selected = (isset($_POST['delivery']) && $usernames[$i][0] == $_POST['delivery']) ? 'selected' : '';
        echo "<option value='" . $usernames[$i][0] . "' $selected onclick='submit()'>" . $usernames[$i][0] . "</option>";
    }

    echo "</select>";
    echo "</form>";

    if (isset($_POST['delivery']) || count($usernames) == 1) {
        if (isset($_POST['delivery']))
            $delivery = $_POST['delivery'];
        else $delivery = $usernames[0][0];

        // Fetch order IDs and prices for the selected username
        $sql = "SELECT d.orderid, o.price FROM delivery d, orderr o WHERE d.statuss = 1 AND o.orderid = d.orderid AND d.username = '$delivery' AND o.payed=2";

        $result = mysqli_query($conn, $sql);
        $orders = mysqli_fetch_all($result);

        echo "<table>
                <tr><th>Order ID</th><th>Price</th></tr>";
        $total = 0;

        for ($i = 0; $i < count($orders); $i++) {
            $total += $orders[$i][1];
            echo "<tr><td>" . $orders[$i][0] . "</td><td>" . $orders[$i][1] . "</td></tr>";
        }

        echo "<tfoot><td>Total</td><td>$total</td></tfoot></table>";
        echo '<form action="" method="post">

              <input type="hidden" name="delguy" value="' . $delivery . '" id="">
              <input type="submit" name="end" id=""></form>';
    }
    ?>
</body>

</html>