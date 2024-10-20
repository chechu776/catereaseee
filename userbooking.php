<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['userid']; // Get the logged-in user ID

// Fetch bookings for the logged-in user
$booking_query = "SELECT * FROM bookings WHERE user_id = '$userid'";
$booking_result = mysqli_query($dbconnect, $booking_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
        button, a.invoice-btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin: 5px;
        }

        .actions {
            display: flex;
            align-items: center;
        }

        button[name="cancel"] {
            background-color: #f44336; /* Red background for cancel button */
            color: white;
            border: 1px solid transparent;
        }

        button[name="cancel"]:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }

        button[name="cancel"]:active {
            background-color: #c62828; /* Even darker red on click */
        }

        a.invoice-btn {
            background-color: #009879; /* Teal background for invoice button */
            color: white !important;
            text-decoration: none;
        }

        a.invoice-btn:hover {
            background-color: #007a61; /* Darker teal on hover */
        }

        a.invoice-btn:active {
            background-color: #005a43; /* Even darker teal on click */
        }
    </style>
</head>
<body>
<header>
    <section class="wrapper">
        <div class="left">
            <a href="/index.html">CaterEase</a>
        </div>
        <div class="right">
            <div>
                <a href="home.php"><img src="images/home-icon-silhouette (1).png" alt="">  Home</a>
            </div>
            <div>
                <a href=""><img src="images/booking.png" alt="">  Booking</a>
            </div>
            <a href="" class="button">Log Out</a>
        </div>
    </section>
</header>

<div class="maincontent">
    <div class="vuser1">
        <div class="head">
            <h1>Your Bookings</h1>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Booked CSP</th>
                <th>Menu ID</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Actions</th> <!-- Actions column for canceling or downloading invoice -->
            </tr>
            <?php
            if (mysqli_num_rows($booking_result) > 0) {
                while ($booking_data = mysqli_fetch_assoc($booking_result)) {
                    // Fetch CSP name for the current booking
                    $csp_id = $booking_data['csp_id']; // Get the CSP ID from booking data
                    $csp_query = "SELECT csp_name FROM csp_table WHERE csp_id='$csp_id'";
                    $csp_result = mysqli_query($dbconnect, $csp_query);
                    $csp_data = mysqli_fetch_assoc($csp_result);
                    $csp_name = htmlspecialchars($csp_data['csp_name']); // Get CSP name

                    echo "<tr class='hover'>";
                    echo "<td>" . htmlspecialchars($booking_data['booking_id']) . "</td>";
                    echo "<td>" . $csp_name . "</td>";
                    echo "<td>" . htmlspecialchars($booking_data['menu_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking_data['event_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking_data['venue']) . "</td>";
                    echo "<td>₹" . htmlspecialchars($booking_data['total_price']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking_data['quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking_data['status']) . "</td>";

                    echo "<td>";
                    echo "<div class='actions'>"; // Wrapping both buttons inside a flexbox container

                    // Cancel booking option
                    echo "<form method='POST' action='cancel_booking.php' style='display:inline;'>
                            <input type='hidden' name='booking_id' value='" . htmlspecialchars($booking_data['booking_id']) . "'>
                            <button type='submit' name='cancel' onclick='return confirm(\"Are you sure you want to cancel this booking?\")'>Cancel</button>
                        </form>";

                    // Check if the status is "Confirmed" (case-insensitive comparison)
                    if (strcasecmp($booking_data['status'], 'Confirmed') == 0) {
                        echo " <a href='download_invoice.php?booking_id=" . htmlspecialchars($booking_data['booking_id']) . "&menu_id=" . htmlspecialchars($booking_data['menu_id']) . "' class='invoice-btn'>Invoice</a>";
                    }

                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No bookings found.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<footer id="footer">
    <div class="foot">
        <div class="contact">
            <a href=""><img src="images/phone-call.png" alt=""> 9876543210</a>
            <a href=""><img src="images/email (1).png" alt=""> caterease@gmail.com</a>
        </div>
        <p>Copyright&copy;;Designed by SHAMSUDHEEN</p>
    </div>
</footer>
</body>
</html> 
