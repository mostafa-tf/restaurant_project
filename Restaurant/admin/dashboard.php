<?php
include "connectdb.php";

$sql = "SELECT COUNT(*) as user_count FROM person WHERE position=0 AND isactive=1";
$result = mysqli_query($conn, $sql);
$users_online = mysqli_fetch_array($result);

$sql = "SELECT COUNT(*) as admin_count FROM person WHERE position=1 AND isactive=1";
$result = mysqli_query($conn, $sql);
$admins_online =  mysqli_fetch_array($result);

$sql = "SELECT SUM(price) AS total_income FROM orderr  WHERE datee >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND datee <= CURDATE()";
$result = mysqli_query($conn, $sql);
$sum = mysqli_fetch_array($result);


$sql = "SELECT SUM(price) AS total_income FROM orderr  WHERE datee >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND datee <= CURDATE()";
$result = mysqli_query($conn, $sql);
$sum1 = mysqli_fetch_array($result);

$exchange_rate = 90000;
$sum_dollar = $sum['total_income'] / $exchange_rate;
$sum1_dollar = $sum1['total_income'] / $exchange_rate;

$avgQuery = "SELECT AVG(stars) as avg_rating FROM rating";
$avgResult = mysqli_query($conn, $avgQuery);
$avgRow = mysqli_fetch_assoc($avgResult);
$averageRating = round($avgRow['avg_rating'], 1);

$sql = "SELECT COUNT(feedback) as count_feedback FROM rating";
$result = mysqli_query($conn, $sql);
$feedback = mysqli_fetch_array($result);

$ratings = [];
$feedbacks = [];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["view_ratings"])) {
    $sql = "SELECT username, stars FROM rating ORDER BY stars DESC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $ratings[] = $row;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["view_feedbacks"])) {
    $sql = "SELECT username, feedback FROM rating WHERE feedback IS NOT NULL AND feedback != '' ORDER BY username ASC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $feedbacks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="dashboard1.css">

    <link rel="stylesheet" href="adminheader.css">
</head>


<body>
    <div style='margin-bottom:20px;' class="navbar">
        <a href="admin.php" style="text-decoration:none;">
            <div class="arrow-left-div">
                <i style='color:white;' class="fa-solid fa-circle-arrow-left"></i>
            </div>
        </a>
        
        <div style='color:green; ' class="admin-panel">Admin Panel</div>
        
        <a href="../logout.php" style="text-decoration:none;color:white;">
        <div class="logout-icon">
            LOGOUT<i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
        </a>
        
    </div>



    <div class="dashboard">
        <h1 class="heading">Restaurant Dashboard</h1>

        <div class="stats-container">
            <div class="stat-box">
                <i class="fas fa-users"></i>
                <h2>Users Online</h2>
                <p><?php echo $users_online['user_count']; ?></p>
            </div>

            <div class="stat-box">
                <i class="fas fa-user-shield"></i>
                <h2>Admins Online</h2>
                <p><?php echo $admins_online['admin_count']; ?></p>
            </div>

            <div class="stat-box">
                <i class="fas fa-money-bill-wave"></i>
                <h2>Income (Week)</h2>
                <p><i class="fas fa-money-bill"></i> <?php echo number_format($sum['total_income'], 2); ?> LBP</p>
                <p><i class="fas fa-dollar-sign"></i> <?php echo number_format($sum_dollar, 0); ?></p>
            </div>

            <div class="stat-box">
                <i class="fas fa-calendar-alt"></i>
                <h2>Income (Year)</h2>
                <p><i class="fas fa-money-bill"></i> <?php echo number_format($sum['total_income'], 2); ?> LBP</p>
                <p><i class="fas fa-dollar-sign"></i> <?php echo number_format($sum1_dollar, 0); ?></p>
            </div>


            <form method="post">
                <button type="submit" name="view_ratings" class="stat-box">
                    <div >
                        <i class="fas fa-star"></i>
                        <h2>View Ratings</h2>
                        <p><?php //echo $averageRating; ?></p>
                    </div>
                </button>
            </form>


            <form method="post">
                <button type="submit" name="view_feedbacks" class="stat-box">
                    <div >
                        <i class="fas fa-comments"></i>
                        <h2>View Feedbacks</h2>
                        <p><?php //echo $feedback['count_feedback']; ?></p>
                    </div>
                </button>
            </form>

        </div>


        <?php if (!empty($ratings)) { ?>
            <div class="ratings-section">
                <h2>User Ratings</h2>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Rating</th>
                    </tr>
                    <?php foreach ($ratings as $rating) { ?>
                        <tr>
                            <td><?php echo ($rating['username']); ?></td>
                            <td><?php echo str_repeat("⭐", $rating['stars']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>


        <?php if (!empty($feedbacks)) { ?>
            <div class="feedback-section">
                <h2>User Feedbacks</h2>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Feedback</th>
                    </tr>
                    <?php foreach ($feedbacks as $feedback) { ?>
                        <tr>
                            <td><?php echo $feedback['username']; ?></td>
                            <td><?php echo ($feedback['feedback']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </div>

</body>

</html>