<?php
session_start(); // Start the session

$dbcon = mysqli_connect("localhost", "root", "", "caterease");
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($dbcon, $_POST['mail']);
    $paswrd = mysqli_real_escape_string($dbcon, $_POST['pswd']);
    
    $sql = "SELECT * FROM `login` WHERE email='$email' AND password='$paswrd'";
    $data = mysqli_query($dbcon, $sql);
    
    $sql2 = "SELECT * FROM user WHERE email='$email'";
    $data2 = mysqli_query($dbcon, $sql2);
    
    if ($data && $data2) {
        if (mysqli_num_rows($data) > 0 && mysqli_num_rows($data2) > 0) {
            $row = mysqli_fetch_assoc($data);
            $row1 = mysqli_fetch_assoc($data2);
            if ($row1['status'] === 'active') {
                // Store user ID and name in session
                $_SESSION['userid'] = $row1['userid'];
                $_SESSION['usertype'] = $row1['usertype'];
                // Store the user's name

                if ($row1['usertype'] == 'User') {
                    header('Location: home.php?id=' . $row1['userid']);
                    $_SESSION['username'] = $row1['name']; 
                    exit();
                } elseif ($row1['usertype'] == 'CSP') {
                    // Check CSP approval status
                    $sql3 = "SELECT * FROM csp_table WHERE userid=" . $row1['userid'];
                    $data3 = mysqli_query($dbcon, $sql3);
                    
                    if ($data3) {
                        $row2 = mysqli_fetch_assoc($data3);
                        if ($row2['status'] === 'approved') {
                            $_SESSION['cspid'] = $row2['csp_id'];
                            header("Location: cspdashboard.php?id=" . $row2["csp_id"]);
                            exit();
                        } else {
                            echo "<script>alert('Your account is not approved yet. Please contact the admin.');</script>";
                        }
                    } else {
                        echo "<script>alert('Error fetching CSP details.');</script>";
                    }
                } else{
                    header('Location: admindashboard.php');
                    exit();
                }
            } else {
                echo "<script>alert('User is blocked');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
    } else {
        echo "<script>alert('Incorrect email or password');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Service Management System</title>
    <link rel="stylesheet" href="style/style.css" type="text/css">
    <style>
        .btn2 {
            border: 1px solid #008080;
            border-radius: 20px;
            padding: 8px 20px;
            justify-content: center;
            display: flex;
            color: white;
            text-decoration: none;
            margin-top: 10px !important;
            margin-bottom: 30px;
            background-color: #008080;
        }
        .btn2:hover {
            background-color: white;
            color: #009879;
            border: 2px solid #009879 !important;
            transition: all 0.2s linear;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <header>
        <section class="wrapper">
            <div class="left">
                <a href="homeintex.php">CaterEase</a>
            </div>
        </section>
    </header>
    <section class="login">
        <div class="login">
            <div class="head">
                <p></p>
                <h1>Login</h1>
                <p></p>
            </div>
            <hr>
            <form action="login.php" method="POST">
                <div>
                    <input type="email" name="mail" placeholder="Email" required>
                    <hr>
                    <input type="password" name="pswd" placeholder="Password" required>
                    <hr>
                    <br>
                    <input class="btn2" type="submit" name="submit" value="Log In">
                    <p>Not a Member? <a href="signup.php">Sign Up</a></p>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
