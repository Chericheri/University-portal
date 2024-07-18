<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $redirects = [
        'admin' => 'admin_dashboard.php',
        'lecturer' => 'lecturer_dashboard.php',
        'student' => 'student_dashboard.php'
    ];

    if (in_array($role, array_keys($redirects))) {
        $sql = "SELECT * FROM ${role}s WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: " . $redirects[$role]);
                exit();
            } else {
                echo "<div class='error'>Invalid password.</div>";
            }
        } else {
            echo "<div class='error'>No user found with that username.</div>";
        }
    } else {
        echo "<div class='error'>Invalid role selected.</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <nav class="navbar">
        <ul>
            <li><a href="index.html">Register</a></li>
        </ul>
    </nav>
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="role-buttons">
                <input type="radio" id="admin" name="role" value="admin" required>
                <label for="admin">Admin</label>
                <input type="radio" id="lecturer" name="role" value="lecturer" required>
                <label for="lecturer">Lecturer</label>
                <input type="radio" id="student" name="role" value="student" required>
                <label for="student">Student</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
