<?php
session_start();
include("connectdb.php");
$order_id = $_SESSION['orderid'];
$sql = "SELECT * FROM orderr o join orderitem oi join items i where o.orderid=$order_id and oi.itemid=i.itemid and o.orderid=oi.orderid";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result);

$orderid = $row[0][0];
$username = $row[0][1];
$itemprice = $row[0][13];
$itemname = $row[0][11];
$subprice = $row[0][8];
$totalprice = $row[0][2];
$quantity = $row[0][8];


$sql1 = "SELECT * FROM person where username='$username'";
$result1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_row($result1);


$position = $row1[7];
$phone = $row1[5];
$location = $row1[6];

if (isset($_POST['print'])) {
    if ($position == 0)
        $sql = "update orderr set payed=2 where orderId= $order_id";
    else
        $sql = "update orderr set payed=1 where orderId= $order_id";
    mysqli_query($conn, $sql);


    if (isset($_SESSION['delivery']) && $_SESSION['delivery'] != null) {
        $delivery = $_SESSION['delivery'];
        $sql3 = "insert into delivery value('$delivery','$order_id','0')";
        mysqli_query($conn, $sql3);

        $_SESSION['delivery'] = null;
    }

    header("location: cashier.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 100px;
        }

        .bill-container {
            border: 1px solid #ddd;
            padding: 10px;
            max-width: 350px;
            margin: auto;

        }

        .bill-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .bill-header h2 {
            margin: 20px;
            font-size: 24px;
        }

        .bill-item {
            display: flex;
            justify-content: space-between;
            padding: 20px 0px;
            border-bottom: 1px solid #eee;
        }

        .bill-item:last-child {
            margin: 30px;
            border-bottom: none;
        }

        .bill-total {
            text-align: right;
            margin-top: 50px;
            font-size: 18px;
            font-weight: bold;
        }

        h4,
        h5 {
            margin: 7px;
            padding: 0;
        }

        .b {
            max-width: fit-content;
            margin: auto;
            margin-top: 20px;
        }

        .btn {
            position: relative;
            background-color: #06ff06;
            width: fit-content;
            height: 30px;
            border: 0;
            font-size: x-large;
        }

        .btn:hover {
            background-color: rgb(67, 255, 67);
            /* border: 1px solid black; */

            cursor: pointer;

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
            left: 0;
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <div class="navbar">
        <a href="cashier.php" style="text-decoration:none;">
            <div class="arrow-left-div">
                <i style='color:yellow;' class="fa-solid fa-circle-arrow-left"></i>
            </div>
        </a>

        <div class="admin-panel">Cashier Panel</div>

        <a href="logout.php" style='text-decoration:none; color:white'>
            <div class="logout-icon">
                LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
        </a>
    </div>


    <div class="bill-container">
        <div class="bill-header">
            <h2>LU RESTO</h2>
            <h4><?php echo "NO: " . $orderid; ?></h4>
            <?php
            if ($position == 0) {
                echo " <h4>  $username </h4>";
                echo "<h5>$phone</h5>";
                echo "<h5>$location</h5>";
            }
            ?>
        </div>
        <?php for ($i = 0; $i < count($row); $i++) {
            $subprice = $row[$i][9];
            $quantity = $row[$i][8];
            $itemname = $row[$i][11];
            $itemprice = $subprice/$quantity;


            echo "
        <div class='bill-item'>
            <span>$itemname: " . number_format($itemprice) . "× $quantity</span>
            <span>" . number_format($subprice) . " L.L</span>
        </div>";
        
        } 
        if ($position == 0) {
            echo "
        <div class='bill-item'>
            <span>Delivery : </span>
            <span> 100,000  L.L</span>
        </div>";
        $totalprice+=100000;
        }
        ?>

        <div class="bill-total">
            <?php echo "Total: " . number_format($totalprice) . " L.L"; ?>
        </div>
    </div>
    <form action="" method="POST">

        <div class="b">

            <input type="submit" name="print" value="End&Print" class="btn" id="">
        </div>
    </form>
</body>

</html>