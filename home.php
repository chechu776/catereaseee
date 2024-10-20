<?php
session_start(); // Start the session

// Database connection
$dbconnect = mysqli_connect("localhost", "root", "", "caterease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if csp_id is available in the session
$csp_id = isset($_SESSION['csp_id']) ? $_SESSION['csp_id'] : null;

// Fetch CSP data
$csp_query = "SELECT * FROM csp_table";
$csp_result = mysqli_query($dbconnect, $csp_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>CaterEase</title>
    <style>
        /* Add some general styles for cards */
        .cater {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .block {
            width: 30%;
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .block:hover {
            transform: translateY(-5px);
        }

        .block img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .block h1 {
            font-size: 22px;
            margin: 10px 0;
            color: #333;
        }

        .block .details {
            padding: 15px;
        }

        .block .details p {
            margin: 5px 0;
            color: #555;
        }

        .block .details .category {
            font-weight: bold;
            color: #009879;
        }

        .block .details .location {
            font-size: 14px;
            color: #888;
        }

        .block button {
            background-color: #008080;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .block button:hover {
            background-color: #006f6f;
        }

        /* Add styles for the filter section */
        #filter {
            margin: 20px 0;
            text-align: center;
        }

        #filter select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

    </style>
    <script>
        function filterCategory() {
            var category = document.getElementById('categoryFilter').value;
            var caterings = document.querySelectorAll('.cater .block');
            
            caterings.forEach(function(catering) {
                if (category === 'All' || catering.getAttribute('data-category') === category) {
                    catering.style.display = 'block';
                } else {
                    catering.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
<header>
    <section class="wrapper">
        <div class="left">
            <a href="home.php">CaterEase</a>
        </div>
        <div class="right">
            <div>
                <a href="home.php"><img src="./images/home-icon-silhouette (1).png" alt=""> Home</a>
            </div>
            <div>
                <a href="#about"><img src="./images/info.png" alt=""> About</a>
            </div>
            <div>
                <a href="userbooking.php"><img src="./images/booking.png" alt=""> Booking</a>
            </div>
            <div>
                <a href="#footer"><img src="./images/customer-service.png" alt=""> Contact</a>
            </div>
            <div>
                <a href="feedback.php"><img src="./images/feedback.png" alt=""> Feedback</a>
            </div>
            <div>
                <?php if (isset($_SESSION['username'])): ?>
                    <span style="color:white;font-weight:700"><?php echo htmlspecialchars($_SESSION['username']); ?>!!!</span>
                <?php else: ?>
                    <span>Guest!</span>
                <?php endif; ?>
            </div>
            <a href="homeintex.php" class="button">Log Out</a>
        </div>
    </section>
</header>


    <section id="home">
        <div class="topic">
           <h1>Looking for Catering Service for your Events <br>?</h1>
           <a href="#book">Book Now</a>
        </div>
    </section>
    <section id="filter">
        <div class="wrapper">
            <label for="categoryFilter">Filter by Category:</label>
            <select id="categoryFilter" onchange="filterCategory()">
                <option value="All">All</option>
                <option value="Veg">Veg</option>
                <option value="Non-Veg">Non-Veg</option>
            </select>
        </div>
    </section>

    <!-- Display CSPs -->
    <section class="feature" id="book">
        <div class="cater">
            <?php while ($row = mysqli_fetch_assoc($csp_result)) { ?>
                <div class="block" data-category="<?php echo $row['category']; ?>">
                    <img src="<?php echo $row['logo']; ?>" alt="Catering Service Image">
                    <div class="details">
                        <h1><?php echo $row['csp_name']; ?></h1>
                        <p class="category">Category: <?php echo $row['category']; ?></p>
                        <p class="location">Location: <?php echo $row['location']; ?></p>
                        <a href="menu.php?csp_id=<?php echo $row['csp_id']; ?>"><button>View Menus</button></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="about-us" id="about">
        <div class="container">
            <h1>About Us</h1>
            <h2>Our Story</h2>
            <p>At CaterEase, we bring your culinary visions to life. Established in 2024, our mission is to provide exceptional catering services that exceed our clients' expectations. From intimate gatherings to large corporate events, we pride ourselves on delivering unforgettable experiences with our exquisite food and impeccable service.</p>
            <h2>Our Mission</h2>
            <p>We aim to be the preferred catering service provider by offering innovative menus, fresh ingredients, and exceptional customer service. Our team of professionals is dedicated to making your event a success, ensuring every detail is taken care of.</p>
            <h2>Our Values</h2>
            <ul>
                <li><strong>Quality:</strong> We use only the freshest and highest quality ingredients.</li>
                <li><strong>Customer Focus:</strong> We listen to our clients and tailor our services to meet their unique needs.</li>
                <li><strong>Innovation:</strong> We continually explore new culinary trends and techniques to offer our clients the best.</li>
            </ul>
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