<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['assignment'])) {
    $student_id = $_SESSION['user_id'];
    $filename = $_FILES['assignment']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);

    if (move_uploaded_file($_FILES['assignment']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO assignments (student_id, filename) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $student_id, $filename);

        if ($stmt->execute()) {
            echo "File uploaded successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
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

        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            width: 100%;
            background-color: #3a3a3a;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            margin-bottom: 5px;
        }

        input, button {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #4a4a4a;
            color: #f0f0f0;
        }

        button {
            cursor: pointer;
            background-color: #00aaff;
            border: none;
        }

        button:hover {
            background-color: #0088cc;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            color: #00aaff;
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 20px;
            border: 1px solid #00aaff;
            border-radius: 10px;
        }

        .links a:hover {
            background-color: #00aaff;
            color: #2c2c2c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Assignment</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="assignment">Select file:</label>
            <input type="file" id="assignment" name="assignment" accept=".pdf, .docx" required><br>
            <button type="submit">Upload</button>
        </form>
        <div class="links">
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
