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

// Handle brand logo upload
if (isset($_POST['upload_logo'])) {
    $logo_image = $_FILES['logo_image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($logo_image);

    if (move_uploaded_file($_FILES["logo_image"]["tmp_name"], $target_file)) {
        $update_logo_query = "UPDATE csp_table SET logo='$target_file' WHERE csp_id='$csp_id'";
        mysqli_query($dbconnect, $update_logo_query);
        echo "<script>alert('Logo uploaded successfully!');</script>";
    } else {
        echo "<script>alert('Failed to upload the logo.');</script>";
    }
}

// Handle category submission
if (isset($_POST['set_category']) || isset($_POST['edit_category'])) {
    $category = $_POST['csp_category'];
    $update_category_query = "UPDATE csp_table SET category='$category' WHERE csp_id='$csp_id'";

    if (mysqli_query($dbconnect, $update_category_query)) {
        echo "<script>alert('Category updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update category.');</script>";
    }
}
// Handle location update
if (isset($_POST['update_location'])) {
    $location = mysqli_real_escape_string($dbconnect, $_POST['csp_location']);
    $update_location_query = "UPDATE csp_table SET location='$location' WHERE csp_id='$csp_id'";

    if (mysqli_query($dbconnect, $update_location_query)) {
        echo "<script>alert('Location updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update location.');</script>";
    }
}

?>
<?php
// ... (rest of your existing code)

// Handle menu item deletion
if (isset($_POST['delete'])) {
    $menu_id = $_POST['menu_id'];
    $delete_query = "DELETE FROM `menu` WHERE `menu_id` = '$menu_id' AND `csp_id` = '$csp_id'";

    if (mysqli_query($dbconnect, $delete_query)) {
        echo "<script>alert('Menu item deleted successfully!');</script>";
        // Optional: Redirect to the same page to refresh the menu list
        echo "<script>window.location.href = 'manageprofile.php';</script>";
    } else {
        echo "<script>alert('Failed to delete menu item.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
    div.sidebar {
    position: sticky;
    top: 0;
    left: 0;
    bottom: 0;
    width: 80px; /* Default width */
    height: 100vh;
    padding: 0 1.7rem;
    color: #fff;
    transition: all 0.5s linear;
    background-color: #009879;
    overflow: hidden;
    display: flex; /* Use flexbox */
    flex-direction: column; /* Stack items vertically */
}

div.sidebar:hover {
    width: 250px; /* Expanded width on hover */
}

div.sidebar div.logo {
    height: 80px;
    padding: 16px;
    display: flex; /* Center logo */
    justify-content: center;
    align-items: center;
}

div.sidebar ul.menu {
    flex-grow: 1; /* Allow the menu to grow */
    list-style: none;
    padding: 0;
}

div.sidebar ul.menu li {
    padding: 25px;
    padding-left: 0;
    margin: 6px 0;
    border-radius: 8px;
    transition: all 0.5s linear;
    display: flex; /* Use flex for alignment */
    align-items: center; /* Center items vertically */
}

div.sidebar ul.menu li:hover {
    background-color: #e0e0e058;
}

div.sidebar ul.menu li a {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
    display: flex; /* Flex layout for icon and text */
    align-items: center; /* Center items vertically */
}

div.sidebar ul.menu li a span {
    overflow: hidden; /* Prevent text wrapping */
    transition: opacity 0.5s; /* Smooth transition for text */
    opacity: 0; /* Hide text by default */
}

div.sidebar:hover ul.menu li a span {
    opacity: 1; /* Show text on hover */
}

div.sidebar ul.menu li a img {
    width: 20px;
}

div.sidebar ul.menu li.logout {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #008080;
}

h2 {
    color: #333;
    border-bottom: 2px solid #008080;
    padding-bottom: 10px;
}

.logo-section,
.menu-section {
    margin: 20px 0;
}

.logo-section input[type="file"],
.menu-section input[type="text"],
.menu-section input[type="number"],
.menu-section textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 10px;
}

button {
    background-color: #008080;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #006f6f;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #008080;
    color: white;
}

table tr:hover {
    background-color: #f1f1f1;
}

img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-top: 10px;
}

a {
    text-decoration: none;
    color: #008080;
    transition: color 0.3s;
}

a:hover {
    color: #006f6f;
}
</style>
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
            </li>
                <li class="logout">
                    <a href="login.php">
                        <img src="images/logout.png" alt="">
                        <span>logout</span>
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
                <!-- <div class="searchbox">
                    <img src="images/search-interface-symbol.png" alt="">
                    <input type="text" placeholder="Search" />
                </div> -->
                <img src="images/guest-user-250x250.jpg" alt="">
            </div>
        </div>
        <div class="container">
    <h1>Manage Your Profile</h1>

    <!-- Brand Logo Section -->
    <div class="logo-section">
        <h2>Upload Brand Logo</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="logo_image" <?php if (!empty($csp_data['logo'])) echo 'style="display:none;"'; ?> required>
            <?php if (!empty($csp_data['logo'])): ?>
                <button type="submit" name="edit_logo">Edit Logo</button>
                <img src="<?php echo $csp_data['logo']; ?>" alt="Brand Logo" style="width: 100px; height: auto;">
            <?php else: ?>
                <button type="submit" name="upload_logo">Upload Logo</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- Category Selection Section -->
    <div class="category-section">
        <h2>Select Your Service Category</h2>
        <form action="" method="POST">
            <select name="csp_category" required>
                <option value="">Select Category</option>
                <option value="Veg" <?php if ($csp_data['category'] == 'Veg') echo 'selected'; ?>>Veg</option>
                <option value="Non-Veg" <?php if ($csp_data['category'] == 'Non-Veg') echo 'selected'; ?>>Non-Veg</option>
                <option value="Both" <?php if ($csp_data['category'] == 'Both') echo 'selected'; ?>>Veg/Non-Veg</option>
            </select>
            <?php if (!empty($csp_data['category'])): ?>
                <button type="submit" name="edit_category">Edit Category</button>
            <?php else: ?>
                <button type="submit" name="set_category">Set Category</button>
            <?php endif; ?>
        </form>
    </div>
    <!-- Location Section -->
    <div class="location-section">
        <h2>Update Your Location</h2>
        <form action="" method="POST">
            <input type="text" name="csp_location" value="<?php echo htmlspecialchars($csp_data['location']); ?>" required placeholder="Enter Your Location">
            <button type="submit" name="update_location">Update Location</button>
        </form>
    </div>

        <div class="menu-section">
            <h2>Your Menus</h2>
            <a href="uploadmenu.php">Add New Menu</a>
            <table>
    <tr>
        <th>ID</th>
        <th>Menu Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Image</th>
        <th>Actions</th> <!-- Actions column -->
    </tr>
            </div>
    <?php
    // Fetch and display menu items
    $query = "SELECT * FROM `menu` WHERE `csp_id` = '$csp_id'";
    $result = mysqli_query($dbconnect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['menu_id']}</td>
                <td>{$row['menu_name']}</td>
                <td>{$row['description']}</td>
                <td>{$row['price']}</td>
                <td><img src='{$row['image']}' alt='Menu Image' style='width:50px;height:auto;'></td>
                <td>
                    <form action='' method='post' style='display:inline;'>
                        <input type='hidden' name='menu_id' value='{$row['menu_id']}'>
                        <button type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this menu item?\");'>Delete</button>
                    </form>
                    <a href='editmenu.php?menu_id={$row['menu_id']}' style='margin-left: 5px;'>
                        <button>Edit</button>
                    </a>
                </td>
              </tr>";
    }
    ?>
</table>

        </div>
    </div>
    </div>
</body>
</html>
