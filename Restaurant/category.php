<?php
$con = mysqli_connect("localhost", "root", "");
include("navbar.php");

if (!$con) {
    die("failed to connect");
}
if (!mysqli_select_db($con, "restaurant")) {
    die("failed to select database");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap');

        :root {
            --primary-color: #3b2a2a;
            --secondary-color: #333;
            --background-light: #f4f4f4;
            --text-light: #333;
            --text-dark: #fff;
            --background-dark: #1a1a1a;
            --card-bg-light: #fff;
            --card-bg-dark: #2a2a2a;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }



        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: var(--text-light);
            transition: background-color 0.3s ease, color 0.3s ease;
            line-height: 1.6;
            margin: 20px;
            /* margin-bottom: 0px; */
        }


        header {
            background: linear-gradient(135deg, var(--primary-color), #ff8c61);
            color: #fff;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 0.5rem;
            animation: fadeInDown 1s ease;
        }

        header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }


        .search-container {
            position: relative;
            max-width: 500px;
            margin: 2rem auto;
            animation: fadeInUp 1s ease;
        }

        .search-input {
            width: 100%;
            padding: 12px 12px 12px 48px;
            font-size: 1rem;
            border: 2px solid var(--primary-color);
            border-radius: 30px;
            outline: none;
            background-color: var(--card-bg-light);
            color: var(--text-light);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .search-input:focus {
            border-color: #ff8c61;
            box-shadow: 0 0 8px rgba(255, 111, 97, 0.5);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
            pointer-events: none;
        }


        main {
            padding: 2rem;
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(3, minmax(300px, 1fr));
            gap: 2rem;
            margin: 70px;
            animation: fadeIn 1.5s ease;
        }

        .category {

            background-color: var(--card-bg-light);
            border-radius: 15px;
            /* padding: 1.5rem; */
            height: 200px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.6);
            background-blend-mode: lighten;
        }

        .category:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .category h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .category ul {
            list-style: none;
        }

        .category ul li {
            padding: 0.5rem 0;
            font-size: 1rem;
            border-bottom: 1px solid #eee;
        }

        .category ul li:last-child {
            border-bottom: none;
        }


        a {
            text-decoration: none;
        }

        footer {
            background-color: var(--secondary-color);
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        button {
            width: 100%;
            height: 100%;
            background-color: transparent;
            border: none;
        }




        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.5rem;
            }

            .categories {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));

            }
        }
    </style>
</head>

<body>

    <div class="categories">
        <?php
        $sql = "SELECT * FROM category";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die("Failed to execute query: " . mysqli_error($con));
        }
        while ($row = mysqli_fetch_array($result)) {
            echo '<form action="user.php" method="POST"><div class="category btn" style="background-image: url(' . $row[2] . ');">
                <button  onclick="submit()">
                <input type="text" hidden name="category" value="' . $row[0] . '" id="">
                    ';
            echo '<h2>' . $row[1] . '</h2>';

            echo '</div></button></form>';
        }
        ?>
    </div>
</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Footer */
        footer {
            font-size: 14px;
            color: var(--light-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .item {
                flex-direction: column;
                align-items: center;
            }

            .item div {
                width: 100%;
            }
        }

        footer {
            position: relative;
            bottom: 0px;
            background-color: #3b2a2a;
            /* Dark blue background */
            color: white;
            /* White text color */
            padding: 40px 0;
            width: 99%;
            /* Padding for top and bottom */
            text-align: center;
            /* Center align text */
            margin: 10px;
            margin-top: 50px;
            /* Push footer to the bottom */

            padding: 20px 0px;
            /* Increased padding for a more spacious look */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            /* Enhanced shadow for depth */
            border-radius: 15px;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            /* Space between sections */
            flex-wrap: wrap;
            /* Wrap sections on smaller screens */
            padding: 0 20px;
            /* Padding on sides */
            color: #FFD700;
        }

        footer .footer-section {
            flex: 1;
            /* Equal width for all sections */
            margin: 10px;
            /* Margin around sections */
        }

        footer .footer-section h3 {
            margin-bottom: 15px;
            /* Space below headings */
            font-size: 18px;
            /* Font size for headings */
            text-transform: uppercase;
            /* Uppercase headings */
        }

        footer .footer-section ul {
            list-style: none;
            /* Remove list bullets */
            padding: 0;
            /* Remove padding */
        }

        footer .footer-section ul li {
            margin-bottom: 10px;
            /* Space below list items */
        }

        footer .footer-section ul li a {
            color: white;
            /* White text color for links */
            text-decoration: none;
            /* Remove underline from links */
            transition: color 0.3s, background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
        }

        footer .footer-section ul li a:hover {
            color: #FFD700;
            /* Gold color on hover */
            background-color: rgba(255, 215, 0, 0.2);
            /* Light gold background on hover */
            transform: scale(1.1);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
            padding: 5px;
            border-radius: 5px;
        }

        footer .contact-info p {
            margin: 5px 0;
            /* Margin around contact info */
        }

        footer .contact-info p i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        footer .contact-info a {
            color: white;
            /* White text color for links */
            text-decoration: none;
            /* Remove underline from links */
            transition: color 0.3s, background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
        }

        footer .contact-info a:hover {
            color: #FFD700;
            /* Gold color on hover */
            background-color: rgba(255, 215, 0, 0.2);
            /* Light gold background on hover */
            transform: scale(1.1);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
            padding: 5px;
            border-radius: 5px;
        }

        footer .social-icons {
            display: flex;
            flex-direction: column;
            /* Arrange icons vertically */
            align-items: center;
            /* Align icons to the center */
        }

        footer .social-icons p {
            margin: 10px 0;
            /* Space above and below text */
        }

        footer .social-icons a {
            color: white;
            /* White text color for social icons */
            text-decoration: none;
            /* Remove underline from social icons */
            font-size: 24px;
            /* Font size for social icons */
            transition: color 0.3s, transform 0.3s, box-shadow 0.3s;
            /* Smooth transition */
            display: flex;
            /* Flex container for icon and text */
            align-items: center;
            /* Align icon and text vertically */
            margin-bottom: 10px;
            /* Space below each icon */
        }

        footer .social-icons a i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        footer .social-icons a span {
            font-size: 14px;
            /* Smaller text size */
        }

        footer .social-icons a:hover {
            color: #FFD700;
            /* Gold color on hover */
            transform: scale(1.3);
            /* Scale effect on hover */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            /* Glow effect on hover */
        }
    </style>

</head>

<body>
    <footer>
        <div class="container">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#idd">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="package.php">Package</a></li>
                    <li><a href="book.php">Book</a></li>
                </ul>
            </div>

            <div class="footer-section contact-info">
                <h3>Contact Us</h3>
                <a href="https://wa.me/96181683963">
                    <p><i class="fas fa-phone"></i> +96181683963</p>
                </a>
                <a href="https://wa.me/96103674712">
                    <p><i class="fas fa-phone"></i> +96103674712</p>
                </a>
                <a href="https://wa.me/96171104464/?text=<?php echo $a ?>">
                    <p><i class="fas fa-phone"></i> +96171104464</p>
                </a>
                <a href="https://wa.me/96181180758">
                    <p><i class="fas fa-phone"></i> +96181180758</p>
                </a>
                <a href="https://wa.me/96103036691">
                    <p><i class="fas fa-phone"></i> +96103036691</p>
                </a>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i><span> Facebook</span></a>
                    <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i><span> Twitter</span></a>
                    <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i><span> Instagram</span></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>