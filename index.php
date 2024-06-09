<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2c2c2c;
            color: #f0f0f0;
        }

        .container {
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            color: #00aaff;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #00aaff;
            border-radius: 10px;
            margin: 5px;
        }

        a:hover {
            background-color: #00aaff;
            color: #2c2c2c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Assignment Portal</h1>
        <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo '<a href="change_password.php">Change Password</a>';
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo '<a href="register.php">Register</a>';
            echo '<a href="login.php">Login</a>';
        }
        ?>
    </div>
</body>
</html>
