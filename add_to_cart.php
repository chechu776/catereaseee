<?php
// Start session
session_start();

// Check if the user is logged in (This line can be updated or removed based on how you want to handle logged-in users)
// if (!isset($_SESSION['logged_in'])) { // If you only need a general logged-in check
//     die("You need to log in to add items to your cart.");
// }
$csp_id = isset($_SESSION['csp_id']) ? $_SESSION['csp_id'] : null;

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if menu_id and quantity are set
if (isset($_POST['menu_id']) && isset($_POST['quantity'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Add to session cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add menu_id and quantity to the session cart
    $_SESSION['cart'][$menu_id] = [
        'quantity' => $quantity,
    ];

    // Optionally, you can store the cart items in the database without user ID
    $query = "INSERT INTO cart (menu_id, quantity,csp_id) VALUES ('$menu_id', '$quantity','$csp_id')";
    mysqli_query($dbconnect, $query);

    // Redirect to the cart page
    header("Location: view_cart.php");
    exit();
} else {
    die("Menu ID or Quantity is missing.");
}

// Close the database connection
mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Menu</title>
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
                <div>
                    <a href="view_cart.php">Cart (<span id="cart-count">0</span>)</a>
                </div>
                <a href="homeintex.php" class="button">Log Out</a>
            </div>
        </section>
    </header>

    <section class="menu-hero">
        <div class="hero-content">
            <h1>Our Menu</h1>
            <p>Explore our diverse selection of delicious dishes</p>
        </div>
    </section>

    <section class="menu1">
        <div class="container">
            <?php while ($menu_item = mysqli_fetch_assoc($result)): ?>
                <div class="menu-item">
                    <img src="<?php echo $menu_item['image']; ?>" alt="Menu Image">
                    <h3><?php echo $menu_item['menu_name']; ?></h3>
                    <p><?php echo $menu_item['description']; ?></p>
                    <div class="order">
                        <span class="price">₹<?php echo $menu_item['price']; ?>/person</span>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="menu_id" value="<?php echo $menu_item['menu_id']; ?>">
                            <input type="hidden" name="csp_id" value="<?php echo $csp_id; ?>"> <!-- Include CSP ID -->
                            <input type="number" name="quantity" min="1" value="1" required>
                            <button type="submit" class="add-to-cart">Order Now</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

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

<?php
// Close database connection
mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Your Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <table>
        <tr>
            <th>Menu Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        <?php while ($cart_item = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $cart_item['menu_name']; ?></td>
                <td>₹<?php echo $cart_item['price']; ?></td>
                <td><?php echo $cart_item['quantity']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
mysqli_close($dbconnect);
?>
