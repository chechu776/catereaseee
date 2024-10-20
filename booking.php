<?php
session_start();

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");
if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if csp_id and total_price are available
$csp_id = isset($_GET['csp_id']) ? $_GET['csp_id'] : null;
$menu_id = isset($_GET['menu_id']) ? $_GET['menu_id'] : null;
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;

// Get user ID from session
$user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// Calculate 10% advance
$advance_payment = $total_price * 0.10;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the venue and date from the POST request
    $venue = mysqli_real_escape_string($dbconnect, $_POST['venue']);
    $event_date = mysqli_real_escape_string($dbconnect, $_POST['event_date']);

    // Insert the booking details into the database
    $sql = "INSERT INTO bookings (csp_id, user_id,menu_id, venue, event_date, total_price, advance_payment) VALUES ('$csp_id', '$user_id','$menu_id', '$venue', '$event_date', '$total_price', '$advance_payment')";
    
    if (mysqli_query($dbconnect, $sql)) {
        // Optionally, redirect or show a success message
        echo "<script>alert('Booking successful!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($dbconnect) . "');</script>";
    }
}

mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            padding: 10px 20px;
        }
        header .wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }
        .booking-form {
            max-width: 500px;
            height:489px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .booking-form h1 {
            text-align: center;
            color: #009879;
        }
        .booking-form label {
            display: block;
            margin: 10px 0 5px;
            color: #009879;
        }
        .booking-form input[type="text"],
        .booking-form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #009879;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .booking-form h2,
        .booking-form h3 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        .booking-form button {
            background-color: #008080;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 20px;
        }
        .booking-form button:hover {
            background-color: #007b68;
        }
    </style>
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

    <div class="booking-form">
        <h1>Booking Details</h1>
        <form action="booking.php?csp_id=<?php echo htmlspecialchars($csp_id); ?>&menu_id=<?php echo htmlspecialchars($menu_id); ?>&total_price=<?php echo htmlspecialchars($total_price); ?>" method="POST">
            <div>
                <label for="venue">Venue:</label>
                <input type="text" name="venue" required>
            </div>
            <div>
                <label for="event_date">Event Date:</label>
                <input type="date" name="event_date" required>
            </div>
            <h2>Total Price: ₹<?php echo htmlspecialchars($total_price); ?></h2>
            <h3>Advance Payment (10%): ₹<?php echo htmlspecialchars($advance_payment); ?></h3>
            <button type="submit" class="button">Pay Advance</button>
        </form>
    </div>

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
