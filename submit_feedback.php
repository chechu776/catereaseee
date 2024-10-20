<?php
session_start();

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");
$role = $_SESSION['usertype'];
if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the feedback details from the form
$name = $_POST['name'];
$message = $_POST['message'];

// Prepare and execute the SQL statement to insert feedback
$query = "INSERT INTO feedback (name, message, role) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($dbconnect, $query);
mysqli_stmt_bind_param($stmt, 'sss', $name, $message, $role);
$result = mysqli_stmt_execute($stmt);

// Check for success or error
if ($result) {
    $_SESSION['feedback_message'] = "Feedback submitted successfully!";
} else {
    $_SESSION['feedback_message'] = "Error submitting feedback: " . mysqli_error($dbconnect);
}

// Close database connection
mysqli_close($dbconnect);

// Redirect back to the feedback page or another page as needed
header("Location: feedback.php");
exit();
?>
