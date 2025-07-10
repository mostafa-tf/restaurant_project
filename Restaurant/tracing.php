<?php

session_start();
include("connectdb.php");
$username = $_SESSION['username'];
$sql = "SELECT * FROM orderr WHERE username='$username' and payed != 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result);

if(!empty($row))
{
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Progress</title>
    <style>
        .progress-container {
            width: 80%;
            margin: 50px auto;
            background-color: #f0f0f0;
            border-radius: 5px;
            overflow: hidden;
            /* Prevents progress bar from overflowing */
        }

        .progress-bar {
            height: 20px;
            background-color: #4CAF50;
            /* Green */
            width: 0%;
            /* Initial width */
            border-radius: 5px;
            transition: width 1s ease-in-out;
            /* Smooth animation */
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .step {
            position: relative;
            text-align: center;
        }

        .step-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #ddd;
            /* Light gray */
            border: 2px solid #ddd;
            display: inline-block;
            margin-bottom: 5px;
            transition: background-color 1s ease-in-out, border-color 1s ease-in-out;
        }

        .step.active .step-circle {
            background-color: #4CAF50;
            /* Green */
            border-color: #4CAF50;
        }

        .step.active .step-text {
            color: #333;
            /* Darker text for active step */
        }

        .step-text {
            color: #aaa;
            /* Lighter text for inactive steps */
            transition: color 1s ease-in-out;
        }
    </style>
</head>

<body>

    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <div class="progress-steps">
        <!-- <div class="step" id="orderedStep">
            <div class="step-circle"></div>
            <span class="step-text">Ordered</span>
        </div> -->
        <div class="step" id="preparingStep">
            <div class="step-circle"></div>
            <span class="step-text">Preparing</span>
        </div>
        <div class="step" id="onWayStep">
            <div class="step-circle"></div>
            <span class="step-text">On the Way</span>
        </div>
        <div class="step" id="successStep">
            <div class="step-circle"></div>
            <span class="step-text">Delivered</span>
        </div>
    </div>

    <script>
        const progressBar = document.getElementById('progressBar');
        const preparingStep = document.getElementById('preparingStep');
        const onWayStep = document.getElementById('onWayStep');
        const successStep = document.getElementById('successStep');

        // Simulate progress updates (you would replace this with actual data)
        let progress = 0;
        let currentStep = 0;

        const steps = [ preparingStep, onWayStep, successStep];

        function updateProgress() {
            if (progress <= 100) {
                
                progress += 34; // Adjust increment for speed
                progressBar.style.width = progress + '%';
                if (progress === 34 && currentStep < 1) {
                    activateStep(0);
                } else if (progress === 68 && currentStep < 2) {
                    activateStep(1);
                } else if (progress === 102 && currentStep < 3) {
                    activateStep(2);
                } 


                // setTimeout(updateProgress, 2500); // Adjust delay for speed
            }
        }

        function activateStep(stepIndex) {
            steps[stepIndex].classList.add('active');
            currentStep = stepIndex + 1;
        }

            updateProgress(); // Start the progress animation
            // updateProgress(); // Start the progress animation
            // updateProgress(); // Start the progress animation
    </script>

</body>

</html>
<?php

}
if (!empty($row) && $row[count($row)-1][3] == 2) {
    echo "<script>updateProgress();</script>";
    $sql1 = "SELECT * FROM delivery where orderid=" . $row[count($row)-1][0];
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_all($result1);
    // echo "<pre>";
    // print_r ($row1);
    // echo "</pre>";
    if (!empty($row1) && $row1[count($row1)-1][2] == 1) 
    echo "<script>updateProgress();</script>";

}
?>