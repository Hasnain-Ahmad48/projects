<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $roll_number = $_POST['roll_number'] ?? null;

    $sql = "INSERT INTO users (username, password, role, roll_number, section, department) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $password, $role, $roll_number, $section, $department);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            width: 100%;
            background-color: #3a3a3a;
            padding: 20px;
            border-radius: 10px;
        }

        label {
            margin-bottom: 5px;
        }

        input, select, button {
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
    </style>
</head>
<body>
    <h1>Register</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required><br>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" required><br>

        <div id="student-fields" style="display:none;">
            <label for="roll_number">Roll Number:</label>
            <input type="text" id="roll_number" name="roll_number"><br>
        </div>

        <button type="submit">Register</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var roleSelect = document.getElementById('role');
            var studentFields = document.getElementById('student-fields');

            roleSelect.addEventListener('change', function() {
                if (this.value === 'student') {
                    studentFields.style.display = 'block';
                } else {
                    studentFields.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
