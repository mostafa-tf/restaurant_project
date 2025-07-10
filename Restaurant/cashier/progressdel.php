<?php
// if (!$conn = mysqli_connect("localhost", "root", "")) {
//   echo "failed to connect to the server.";
// }
// if (!mysqli_select_db($conn, "restaurant")) {
//   echo "failed to select database";
// }
session_start();
include("../connectdb.php");

if (isset($_POST['confirm'])) {
  if(isset($_POST['delivery'])){

    $_SESSION['orderid']=$_POST['orderId'];
    $_SESSION['delivery']=$_POST['delivery'];
   
    header("location: ../bill.php");
  }
    
}

if (isset($_POST['delete'])) {
  $sql1 = "DELETE FROM orderitem WHERE orderId=" . $_POST['orderId'];
  mysqli_query($conn, $sql1);
  $sql2 = "delete from orderr where orderId=" . $_POST['orderId'];
  if (mysqli_query($conn, $sql2)) {
    echo '<div class="alert success">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                Deletion done!
              </div>';
  } else {
    echo '<div class="alert error">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                Deletion failed!
              </div>';
  }
}




$sql1 = "select username  from person p where p.position=3 and not exists(select * from delivery d where p.username=d.username and d.statuss=0)";
$query1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_all($query1);
$sql = "select * from orderr o where o.payed=0 and o.table=0";
$query = mysqli_query($conn, $sql);
echo "<!DOCTYPE html>
  <html>
  <head>
    <link rel='stylesheet' type='text/css' href='../css/progressdel1.css'>
  </head>
  <body>
  <table id='orderTable'>
  <tr>
  <th>orderID</th>
  <th>username</th>
  <th>price</th>
  <th>confirm_order</th>
  <th>delete</th>
  </tr>";
while ($row = mysqli_fetch_array($query)) {
  echo "
      <tr id='row{$row[0]}'>
      <td>$row[0]</td>
      <td>$row[1]</td>
      <td>$row[2]</td>
      <td>
        <form method='POST' action=''>
          <input type='hidden' name='orderId' value='$row[0]'>
          <button type='submit' name='confirm'>Confirm</button>";
          echo '<select name="delivery" id="">';
for($i=0;$i<count($row1);$i++) {
  echo "<option value='".$row1[$i][0]."'>".$row1[$i][0]."</option>";
}
echo "</select>
        </form>
      </td>
      <td>
        <form method='POST' action=''>
          <input type='hidden' name='orderId' value='$row[0]'>
          <button type='submit' name='delete'>Cancel</button>
        </form>
      </td>
      </tr>";
}
echo "</table>
  </body>
  </html>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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

</body>

</html>
