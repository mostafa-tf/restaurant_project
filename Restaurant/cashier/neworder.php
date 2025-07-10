<?php

session_start();
include("../connectdb.php");

if(isset($_POST['table'])){
    $_SESSION['table']= $_POST['table'];
    header("location: ../category.php");
}

$sql = "SELECT DISTINCT orderr.table FROM orderr WHERE orderr.table != 0 and payed =0";
$result = mysqli_query($conn, $sql);

$reserved = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reserved[] = $row['table'];
}

echo "<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        width: 100vw;
        height: 89vh;
        position: relative;
        top:35px;
        padding: 20px;
        box-sizing: border-box;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    button {
        padding: 15px;
        font-size: 80px;
        width : 100%;
        height : 100%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        opacity: 0.5;
    }

    .reserved {
        background-color: yellow;
    }

    .available {
        background-color: green;
    }
</style>";



echo "<div class='container'>";

for ($i = 1; $i <= 20; $i++) {
    $class = in_array($i, $reserved) ? "reserved" : "available";
    echo "<form action='' method='post'><button name='table' value='$i' onclick='submit()' class='$class'>$i</button></form>";
}

echo "</div>";
?>
<html>
<head>
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