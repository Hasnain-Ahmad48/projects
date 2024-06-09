<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'];
    $action = $_POST['action'];

    $status = $action == 'approve' ? 'approved' : 'denied';
    $sql = "UPDATE assignments SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $assignment_id);

    if ($stmt->execute()) {
        echo "Assignment request $status.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resubmission</title>
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

        a {
            color: #00aaff;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #00aaff;
            border-radius: 10px;
        }

        a:hover {
            background-color: #00aaff;
            color: #2c2c2c;
        }
    </style>
</head>
<body>
    <a href="students.php">Back to Student List</a>
</body>
</html>
