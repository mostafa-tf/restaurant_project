<?php
session_start();
include "../connectdb.php";

if (!isset($_SESSION['username'])) {
    $message = "You must be logged in to rate.";
    $userHasRated = true;
} else {
    $username = $_SESSION['username'];


    $checkQuery = "SELECT * FROM rating WHERE username = '$username'";
    $result = mysqli_query($conn, $checkQuery);
    $userHasRated = (mysqli_num_rows($result) > 0);

    if (isset($_POST['submit_rating'])&&$_POST['stars']>0) {
        $stars = $_POST['stars'];
        $feedback=$_POST['feedback'];
        $insertQuery = "INSERT INTO rating (username, stars,feedback) VALUES ('$username', '$stars','$feedback')";
        if (mysqli_query($conn, $insertQuery)) {
            $message = "Thank you for your rating!";
            $userHasRated = true;
        } else {
            $message = "Error saving rating.";
        }
    }
}


$avgQuery = "SELECT AVG(stars) as avg_rating FROM rating";
$avgResult = mysqli_query($conn, $avgQuery);
$avgRow = mysqli_fetch_assoc($avgResult);
$averageRating = round($avgRow['avg_rating'], 1);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | LU RESTO</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="aboutus1.css">

</head>

<body>
    <header>
        <h1>LU RESTO</h1>
    </header>

    <section id="about" class="s1">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to <b>LU RESTO</b>, where culinary excellence meets warm hospitality. Our story is one of passion, dedication, and a commitment to delivering an exceptional dining experience.</p>
        </div>
    </section>

    <section id="mission" class="s2">
        <div class="container">
            <h2>Our Mission</h2>
            <p>Our journey began in 1986 with a vision to create a haven for food lovers. From farm-fresh ingredients to impeccable service, we strive to make every meal memorable.</p>
        </div>
    </section>

    <h2 style="text-align: center; margin-top: 30px;">Our Restaurant Design</h2>


    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="th.jpg" alt="Restaurant Design 1"></div>
            <div class="swiper-slide"><img src="th (1).jpg" alt="Restaurant Design 2"></div>
            <div class="swiper-slide"><img src="th (2).jpg" alt="Restaurant Design 3"></div>
            <div class="swiper-slide"><img src="th (3).jpg" alt="Restaurant Design 4"></div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <section id="values" class="s3">
        <div class="container">
            <h2>Our Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <h3>Integrity</h3>
                    <p>We are transparent, honest, and always do the right thing.</p>
                </div>
                <div class="value-card">
                    <h3>Innovation</h3>
                    <p>We challenge ourselves to evolve our restaurant to perfection.</p>
                </div>
                <div class="value-card">
                    <h3>Collaboration</h3>
                    <p>We believe in the power of teamwork and problem-solving.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="s4">
        <div class="container">
            <h2>Meet Our Team</h2>
           
                <div class="team-member">
                    <img src="hsein.jpg" alt="Hussien Dika">
                    <h3>Hussien Dika</h3>
                    <p>Css Expert</p>
                </div>
                <div class="team-member">
                    <img src="mostafa.jpg" alt="Mostafa Tfaily">
                    <h3>Mostafa Tfaily</h3>
                    <p>Chief Technical Officer</p>
                </div>
              
              
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
        });
    </script>

    <section id="rating" class="s4">
        <div class="container">
            <?php if (!$userHasRated) { ?>
                <h2>Rate Our Restaurant</h2>
                <p>We value your feedback! Please rate your experience:</p>

                <div class="rating-star">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <form action="" method="post" id="ratingForm">
                    <input type="hidden" name="stars" id="selectedStars" required>
                    <textarea name="feedback" placeholder="Write your review..." rows="4"></textarea>
                    <button type="submit" name="submit_rating" id="submitBtn">Submit Rating</button>
                </form>
            <?php } ?>


        </div>
    </section>

    <section id="average-rating" class="s4">
        <div class="container">
            <h2>Overall Rating</h2>

            <p>Average Rating: <strong><?php echo $averageRating; ?></strong> / 5</p>

            <div class="rating-stars">
                <?php
                $fullStars = floor($averageRating);
                $halfStar = ($averageRating - $fullStars >= 0.5) ? 1 : 0;
                $emptyStars = 5 - ($fullStars + $halfStar);


                for ($i = 0; $i < $fullStars; $i++) {
                    echo '<span class="star filled">&#9733;</span>';
                }

                if ($halfStar) {
                    echo '<span class="star half">&#9733;</span>';
                }


                for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<span class="star">&#9733;</span>';
                }
                ?>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll(".star");
            const selectedStarsInput = document.getElementById("selectedStars");
            const submitBtn = document.getElementById("submitBtn");
            const form = document.getElementById("ratingForm");

            stars.forEach(star => {
                star.addEventListener("click", function() {
                    let rating = this.getAttribute("data-value");
                    selectedStarsInput.value = rating;


                    stars.forEach(s => {
                        s.style.color = s.getAttribute("data-value") <= rating ? "gold" : "gray";
                    });
                });
            });


            form.addEventListener("submit", function(event) {
                submitBtn.style.display = "none";
            });
        });
    </script>

    <footer>
        <p>&copy; 2025 LU RESTO. All rights reserved.</p>
    </footer>
</body>

</html>