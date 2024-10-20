    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body class="adm">
        <div class="sidebar">
            <div class="logo">
            </div>
            <ul class="menu">
                <li class="active">
                    <a href="">
                        <img src="images/user.png" alt="">
                        <span>Manage User</span>
                    </a>
                </li>
                <li>
                    <a href="managecsp.php">
                        <img src="images/food-service.png" alt="">
                        <span>Manage CSP</span>
                    </a>
                </li>
                <li>
                    <a href="viewbooking.php">
                        <img src="images/booking.png" alt="">
                        <span>View Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="viewfeedback.php">
                        <img src="images/feedback.png" alt="">
                        <span>View Feedback</span>
                    </a>
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
                    <h1>Admin Dashboard</h1>
                </div>
                <div class="info">
                    <!-- <div class="searchbox">
                        <img src="images/search-interface-symbol.png" alt="">
                        <input type="text" placeholder="Search" />
                    </div> -->
                    <img src="images/guest-user-250x250.jpg" alt="">
                </div>
            </div>
            <div class="vuser">
                <div class="head">
                    <h1>Users</h1>
                </div>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone no</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $dbcon = mysqli_connect("localhost", "root", "", "caterease");
                        if (!$dbcon) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql = "SELECT * FROM `user` WHERE `usertype` = 'User'";
                        $data = mysqli_query($dbcon, $sql);
                        if (mysqli_num_rows($data) > 0) {  
                            while ($row = mysqli_fetch_assoc($data)) {
                                $id = $row["userid"];
                                echo "<tr class='hover'>";
                                echo "<td>" . htmlspecialchars($row['userid']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($row['phno']) . "</td>"; 
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>"; 
                                echo "<td>";
                                
                                if ($row['status'] == "active") {
                                    echo "<form method='post'><button name='blockuser' value='{$id}' type='submit' class='block'><img src='images/block-user.png'> Block</button></form>";
                                } else {
                                    echo "<form method='post'><button name='unblockuser' value='{$id}' type='submit' class='unblock'><img src='images/unlock.png'> UnBlock</button></form>";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found.</td></tr>";
                        }
                        if (isset($_POST['blockuser']) || isset($_POST['unblockuser'])) {
                            $user_id = isset($_POST['blockuser']) ? $_POST['blockuser'] : $_POST['unblockuser'];
                            $new_status = isset($_POST['blockuser']) ? 'inactive' : 'active';

                            $sql1 = "UPDATE user SET status = '$new_status' WHERE userid = $user_id";
                            $result1 = mysqli_query($dbcon, $sql1);

                            if ($result1) {
                                header("Location: admindashboard.php");
                                exit(); 
                            } else {
                                echo "Error updating status: " . mysqli_error($dbcon);
                            }
                        }
                        mysqli_close($dbcon);
                        ?>
                </table>
            </div>
        </div>
    </body>
    </html>