<?php
session_start();

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if csp_id is available
$csp_id = isset($_SESSION['csp_id']) ? $_SESSION['csp_id'] : null;

// Alternatively, if you want to get it from a GET request (if you navigated here from the menu page):
if (isset($_GET['csp_id'])) {
    $csp_id = $_GET['csp_id'];
}

$cart_items = [];
$total_price = 0;

// Check if the cart exists in the session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $menu_id => $item) {
        // Fetch menu details from the database
        $query = "SELECT menu_name, price FROM menu WHERE menu_id = '$menu_id'";
        $result = mysqli_query($dbconnect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $menu_details = mysqli_fetch_assoc($result);
            $menu_details['quantity'] = $item['quantity']; // Get quantity from session cart
            $cart_items[$menu_id] = $menu_details; // Store by menu_id

            // Calculate total price
            $total_price += $menu_details['price'] * $item['quantity'];
        }
    }
} else {
    $cart_items = []; // Ensure cart items are empty
}

// Close database connection
mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>View Cart</title>
</head>
<body>
    <header>
        <section class="wrapper">
            <div class="left">
                <a href="home.php">CaterEase</a>
            </div>
            <div class="right1">
                <div>
                    <a href="home.php"><img src="images/home-icon-silhouette (1).png" alt=""> Home</a>
                </div>
                <a href="homeintex.php" class="button">Log Out</a>
            </div>
        </section>
    </header>
    
    <!-- Display any messages (optional) -->
    <?php if (isset($_SESSION['cart_message'])): ?>
        <script>
            alert('<?php echo addslashes($_SESSION['cart_message']); ?>');
        </script>
        <?php unset($_SESSION['cart_message']); // Clear the message after displaying ?>
    <?php endif; ?>
    
    <!-- If cart is empty, show alert using JavaScript -->
    <?php if (empty($cart_items)): ?>
        <script>
            alert("Your cart is empty. Please add items to your cart.");
        </script>
        <p>Your cart is empty. Please add items to your cart.</p>
    <?php else: ?>
        <div class="vuser1">
            <h1>Your Cart</h1>
            <table>
                <tr>
                    <th>Menu Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                </tr>
                <?php foreach ($cart_items as $menu_id => $cart_item): ?>
                    <tr class="hover">
                        <td><?php echo htmlspecialchars($cart_item['menu_name']); ?></td>
                        <td>₹<?php echo htmlspecialchars($cart_item['price']); ?></td>
                        <td>
                            <form action="update_cart.php" method="post" style="display:flex;justify-content:space-around;">
                                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                                <input type="number" name="quantity" value="<?php echo $cart_item['quantity']; ?>" min="1" required style="width:40px;">
                                <button type="submit" class="update">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                                <button type="submit" class="remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="proceed">
                <a href="menu.php?csp_id=<?php echo htmlspecialchars($csp_id); ?>">Add More Items</a>
                <a href="booking.php?csp_id=<?php echo $csp_id; ?>&menu_id=<?php echo $menu_id; ?>&total_price=<?php echo $total_price; ?>">proceed to booking</a>
                <h2>Total Price: ₹<?php echo htmlspecialchars($total_price); ?></h2>
            </div>
        </div>
        
       
    <?php endif; ?>
    
    
    
    <footer id="footer">
        <div class="foot">
            <div class="contact">
                <a href=""><img src="images/phone-call.png" alt=""> 9876543210</a>
                <a href=""><img src="images/email (1).png" alt=""> caterease@gmail.com</a>
            </div>
            <p>Copyright&copy; Designed by SHAMSUDHEEN</p>
        </div>
    </footer>
</body>
</html>
