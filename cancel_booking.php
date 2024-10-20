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

if (isset($_POST['cancel'])) {
    // Cancel the booking
    $booking_id = $_POST['booking_id'];

    // Delete the booking from the database
    $cancel_query = "DELETE FROM bookings WHERE booking_id='$booking_id'";
    if (mysqli_query($dbconnect, $cancel_query)) {
        echo "<script>alert('Booking canceled successfully'); window.location.href = 'userbooking.php';</script>";
    } else {
        echo "<script>alert('Error canceling booking'); window.location.href = 'userbooking.php';</script>";
    }
}
?>
