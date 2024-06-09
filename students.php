<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit;
}

$sql = "SELECT u.id, u.roll_number, u.section, u.username, u.department, a.id AS assignment_id, a.filename, a.grade, a.status
        FROM users u
        LEFT JOIN assignments a ON u.id = a.student_id
        WHERE u.role = 'student' AND u.department = (SELECT department FROM users WHERE id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
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

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #3a3a3a;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 10px;
            border: 1px solid #555;
            text-align: left;
            background-color: #4a4a4a;
        }

        th {
            background-color: #555;
        }

        a {
            color: #00aaff;
        }

        form {
            display: inline;
        }

        input[type="text"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #4a4a4a;
            color: #f0f0f0;
        }

        button {
            cursor: pointer;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #00aaff;
            color: #f0f0f0;
        }

        button:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>
    <h1>Student Assignments</h1>
    <table>
        <tr>
            <th>Roll Number</th>
            <th>Section</th>
            <th>Username</th>
            <th>Department</th>
            <th>Assignment</th>
            <th>Grade</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['roll_number'] ?></td>
                <td><?= $row['section'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['department'] ?></td>
                <td><a href="uploads/<?= $row['filename'] ?>"><?= $row['filename'] ?></a></td>
                <td><?= $row['grade'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <form action="grade.php" method="post">
                        <input type="hidden" name="assignment_id" value="<?= $row['assignment_id'] ?>">
                        <input type="text" name="grade" placeholder="Grade">
                        <button type="submit">Submit</button>
                    </form>
                    <form action="resubmission.php" method="post">
                        <input type="hidden" name="assignment_id" value="<?= $row['assignment_id'] ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                        <button type="submit" name="action" value="deny">Deny</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
