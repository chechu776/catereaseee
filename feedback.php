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
            width:100%;
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
                <a href="home.php">CaterEase</a>
            </div>
        </section>
    </header>
    <section class="login">
        <div class="login">
            <div class="head">
                <a href="cspdashboard.php"><img src="images/back.png" alt=""></a>
                <h1>Feedback</h1>
                <p></p>
            </div>
            <hr>
            <form action="submit_feedback.php" method="POST">
                <div class="form">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <hr>
                    <textarea name="message" placeholder="Message" required></textarea>
                    <hr>
                    <input type="hidden" name="role" value="<?php echo isset($_SESSION['usertype']) ? $_SESSION['usertype'] : 'unknown'; ?>">
                    <br>
                    <button type="submit" class="btn2">Add</button>
                </div>
            </form> 
        </div>
    </section>
</body>
</html>
