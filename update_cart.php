<?php
session_start();

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");
if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if csp_id is available
$csp_id = isset($_SESSION['csp_id']) ? $_SESSION['csp_id'] : null;

// Get menu_id and quantity from POST request
$menu_id = $_POST['menu_id'];
$quantity = $_POST['quantity'];

// Validate inputs
if (!empty($menu_id) && is_numeric($quantity) && $quantity > 0) {
    // Update the cart in the session
    $_SESSION['cart'][$menu_id]['quantity'] = $quantity;

    // Update the quantity in the database
    $query = "UPDATE cart SET quantity = '$quantity' WHERE menu_id = '$menu_id' AND csp_id = '$csp_id'";
    $result = mysqli_query($dbconnect, $query);

    // Check for errors
    if ($result) {
        // Set a session message and show an alert box using JavaScript
        $_SESSION['cart_message'] = "<script>alert('Cart updated successfully.');</script>";
    } else {
        // Set an error message and show an alert box using JavaScript
        $_SESSION['cart_message'] = "<script>alert('Error updating cart: " . addslashes(mysqli_error($dbconnect)) . "');</script>";
    }
} else {
    // Set an error message for invalid input and show an alert
    $_SESSION['cart_message'] = "<script>alert('Invalid menu ID or quantity.');</script>";
}

// Close database connection
mysqli_close($dbconnect);

// Redirect to the cart page
header("Location: view_cart.php");
exit();
?>
