<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize as an empty array if not set
}

// Check if the menu_id is set in the POST request
if (isset($_POST['menu_id'])) {
    $menu_id = $_POST['menu_id'];

    // Check if the item exists in the cart
    if (isset($_SESSION['cart'][$menu_id])) {
        // Remove the item from the cart
        unset($_SESSION['cart'][$menu_id]);

        // Set a success message with a JavaScript alert
        $_SESSION['cart_message'] = "<script>alert('Item removed from cart successfully!');</script>";
    } else {
        // Set an error message with a JavaScript alert if the item wasn't found
        $_SESSION['cart_message'] = "<script>alert('Item not found in the cart.');</script>";
    }
} else {
    // Set an error message if the menu_id is missing
    $_SESSION['cart_message'] = "<script>alert('Menu ID is missing.');</script>";
}

// Redirect back to the cart view
header("Location: view_cart.php");
exit();
?>
