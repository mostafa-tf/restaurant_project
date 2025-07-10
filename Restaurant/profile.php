<?php
include 'connectdb.php';
session_start();

if(isset($_SESSION['username'])){
    $user_id = $_SESSION['username'];
} else {
    header('location:login.php');
    exit(); 
}


$query = "SELECT * FROM person WHERE username = '$user_id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    $pos = mysqli_fetch_assoc($result);
} else {
    $pos = [
        'username' => 'Guest',
        'firstname' => '',
        'lastname' => '',
        'phone' => '',
        'email' => '',
        'location' => ''
    ];
}
if (isset($_POST['change'])) {
   
    $firstname =($_POST['firstname']);
    $lastname =($_POST['lastname']);
    $phone =($_POST['phone']);
    $email =($_POST['email']);
    $location =($_POST['location']);

    $updateQuery = "UPDATE person SET 
        firstname = '$firstname', 
        lastname = '$lastname', 
        phone = '$phone', 
        email = '$email', 
        location = '$location' 
        WHERE username = '$user_id'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<het="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</het=>
<body>

<div class="profile-container">
    <div class="profile-image">
        <img src="user_icon.jpg"  alt="User Icon">
    </div>
    <h2><?= $pos['username'] ?></h2>

    <form action="" method="POST" class="profile-form">
        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" value="<?= $pos['firstname'] ?>">

        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" value="<?= $pos['lastname'] ?>">

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= $pos['phone'] ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= $pos['email'] ?>">

        <label for="location">Address</label>
        <input type="text" id="location" name="location" value="<?= $pos['location'] ?>">

        <div class="profile-buttons">
            <button type="submit" class="btn" name="change">Save Changes</button>
            <a href="tracing.php" class="btn">Show Orders</a>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </form>
</div>

</body>
</html>
