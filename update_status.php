<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the CSP is logged in
if (!isset($_SESSION['cspid'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Validate input
    if (in_array($status, ['confirmed', 'pending', 'rejected'])) {
        // Update the booking status in the database
        $update_query = "UPDATE bookings SET status='$status' WHERE booking_id='$booking_id'";
        if (mysqli_query($dbconnect, $update_query)) {
            // Redirect back to CSP dashboard with success message
            header("Location: cspdashboard.php?status_update=success");
            exit();
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($dbconnect);
        }
    } else {
        // Handle invalid status input
        echo "Invalid status value.";
    }
}
?>
