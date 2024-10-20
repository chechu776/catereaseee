<?php
session_start();

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to retrieve feedback from the database
$role = $_SESSION['usertype'];
$query = "SELECT name, message, role, created_at FROM feedback ORDER BY created_at DESC";
$result = mysqli_query($dbconnect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Dashboard</title>
</head>
<body class="adm">
    <div class="sidebar">
        <div class="logo">
        </div>
        <ul class="menu">
            <li class="active">
                <a href="admindashboard.php">
                    <img src="images/user.png" alt="">
                    <span>Manage User</span>
                </a>
            </li>
            <li>
                <a href="managecsp.php">
                    <img src="images/food-service.png" alt="">
                    <span>Manage CSP</span>
                </a>
            </li>
            <li>
                <a href="viewbooking.php">
                    <img src="images/booking.png" alt="">
                    <span>View Bookings</span>
                </a>
            </li>
            <li>
                <a href="viewfeedback.php">
                    <img src="images/feedback.png" alt="">
                    <span>View Feedback</span>
                </a>
            </li>
            <li class="logout">
                <a href="login.png">
                    <img src="images/logout.png" alt="">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="maincontent">
        <div class="wrapper">
            <div class="title">
                <h1>Admin Dashboard</h1>
            </div>
            <div class="info">
                <img src="images/guest-user-250x250.jpg" alt="">
            </div>
        </div>
        <section class="wrapper">
            <h1>Feedbacks</h1>
            <?php
                // Check if there are any feedback entries
                if (mysqli_num_rows($result) > 0) {
                    // Output data for each feedback entry
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="feedback">';
                        echo '<h2>' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['role']) . ')</h2>'; // Displaying the role
                        echo '<p>' . htmlspecialchars(date('d/m/Y', strtotime($row['created_at']))) . '</p>';
                        echo '<div class="reply">';
                        echo '<p class="fb">' . htmlspecialchars($row['message']) . '</p>';
                        // echo '<a href="" class="button">Reply</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No feedback available.</p>';
                }
                ?>

        </section>
    </div>
</body>
</html>
