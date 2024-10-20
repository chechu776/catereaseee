<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['cspid'])) {
    header("Location: login.php");
    exit();
}

$csp_id = $_SESSION['cspid'];

// Fetch CSP information
$csp_query = "SELECT * FROM csp_table WHERE csp_id='$csp_id'";
$csp_result = mysqli_query($dbconnect, $csp_query);
$csp_data = mysqli_fetch_assoc($csp_result);

// Check if the CSP is approved
if ($csp_data['status'] !== 'approved') {
    echo "<script>alert('Your account is not approved yet. Please contact the admin.');</script>";
    header("Location: login.php");
    exit();
}

// Fetch bookings for the logged-in CSP
$booking_query = "SELECT * FROM bookings WHERE csp_id = '$csp_id'";
$booking_result = mysqli_query($dbconnect, $booking_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body class="adm">
    <div class="sidebar">
        <div class="logo">
        </div>
        <ul class="menu">
            <li>
                <a href="managebooking.php">
                    <img src="images/booking.png" alt="">
                    <span>View Bookings</span>
                </a>
            </li>
            <li>
                <a href="uploadmenu.php">
                    <img src="images/food-service.png" alt="">
                    <span>Upload Menu</span>
                </a>
            </li>
            <li>
                <a href="manageprofile.php">
                    <img src="images/user.png" alt="">
                    <span>Manage Profile</span>
                </a>
            </li>
            <li>
                <a href="feedback.php">
                    <img src="images/feedback.png" alt="">
                    <span>Add Feedback</span>
                </a>
            </li>
            <li class="logout">
                <a href="login.php">
                    <img src="images/logout.png" alt="">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="maincontent">
        <div class="wrapper">
            <div class="title">
                <h1>CSP Dashboard</h1>
            </div>
            <div class="info">
                <img src="images/guest-user-250x250.jpg" alt="">
            </div>
        </div>
        <div class="vuser">
            <div class="head">
                <h1>Bookings</h1>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Menu id</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Amount</th>
                    <th>Quantity</th> <!-- Added quantity header -->
                    <th>Status</th>
                </tr>
                <?php
                if (mysqli_num_rows($booking_result) > 0) {
                    while ($booking_data = mysqli_fetch_assoc($booking_result)) {
                        // Fetch username for the current booking
                        $user_id = $booking_data['user_id']; // Get the user ID from booking data
                        $user_query = "SELECT name FROM user WHERE userid='$user_id'";
                        $user_result = mysqli_query($dbconnect, $user_query);
                        $user_data = mysqli_fetch_assoc($user_result);
                        $username = htmlspecialchars($user_data['name']); // Get username

                        echo "<tr class='hover'>";
                        echo "<td>" . htmlspecialchars($booking_data['booking_id']) . "</td>";
                        echo "<td>" . $username . "</td>";
                        echo "<td>" . htmlspecialchars($booking_data['menu_id']) . "</td>";  // Added menu id column to the table header
                        echo "<td>" . htmlspecialchars($booking_data['event_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($booking_data['venue']) . "</td>";
                        echo "<td>₹" . htmlspecialchars($booking_data['total_price']) . "</td>";
                        echo "<td>" . htmlspecialchars($booking_data['quantity']) . "</td>"; 
                        echo "<td><p>" . htmlspecialchars($booking_data['status']) . "</p></td>"; // Display status
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
