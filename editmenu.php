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

// Fetch menu details
if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];
    $query = "SELECT * FROM `menu` WHERE `menu_id` = '$menu_id' AND `csp_id` = '$csp_id'";
    $result = mysqli_query($dbconnect, $query);
    $menu_data = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_menu'])) {
    $menu_name = $_POST['menu_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target_dir = "images/menu/";
    $target_file = $target_dir . basename($image);

    // Update query
    $update_query = "UPDATE `menu` SET `menu_name` = '$menu_name', `description` = '$description', `price` = '$price'";

    // Check if a new image is uploaded
    if (!empty($image)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $update_query .= ", `image` = '$target_file'";
        } else {
            echo "<script>alert('Failed to upload the image.');</script>";
        }
    }

    $update_query .= " WHERE `menu_id` = '$menu_id' AND `csp_id` = '$csp_id'";

    if (mysqli_query($dbconnect, $update_query)) {
        echo "<script>alert('Menu item updated successfully!');</script>";
        header("Location: uploadmenu.php");
        exit();
    } else {
        echo "<script>alert('Error updating menu item: " . mysqli_error($dbconnect) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #008080;
}

form {
    display: flex;
    flex-direction: column;
}

input[type="text"],
input[type="number"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 10px;
}

textarea {
    resize: vertical; /* Allow vertical resizing only */
}

button {
    background-color: #008080;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #006f6f;
}

img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-top: 10px;
}

p {
    text-align: center;
    color: red; /* Color for error messages */
}

</style>
<body>
    <div class="container">
        <h1>Edit Menu Item</h1>
        <?php if ($menu_data): ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="menu_name" placeholder="Menu name" value="<?php echo $menu_data['menu_name']; ?>" required>
                <textarea name="description" placeholder="Description" required><?php echo $menu_data['description']; ?></textarea>
                <input type="number" name="price" placeholder="Price" value="<?php echo $menu_data['price']; ?>" required>
                <input type="file" name="image">
                <img src="<?php echo $menu_data['image']; ?>" alt="Current Image" style="width: 100px; height: auto; margin-top: 10px;">
                <button type="submit" name="update_menu">Update Menu Item</button>
            </form>
        <?php else: ?>
            <p>Menu item not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
