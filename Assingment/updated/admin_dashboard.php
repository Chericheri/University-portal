<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

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

function getAllUsers($conn, $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

$students = getAllUsers($conn, 'students');
$lecturers = getAllUsers($conn, 'lecturers');

$conn->close();

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .welcome-message {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 20px;
            z-index: 1000;
        }
        #confetti-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 999;
        }
    </style>
</head>
<body>

    <canvas id="confetti-canvas"></canvas>
    
    <div class="welcome-message" id="welcome-message"></div>

    <div class="container">
        <nav class="navbar">
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="index.html">Register</a></li>
            </ul>
        </nav>
        <h2>Admin Dashboard</h2>
        <h3 id="students">Students Information</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Registration Number</th>
                <th>Year</th>
                <th>Semester</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= htmlspecialchars($student['username']) ?></td>
                <td><?= htmlspecialchars($student['registrationNumber']) ?></td>
                <td><?= htmlspecialchars($student['year']) ?></td>
                <td><?= htmlspecialchars($student['semester']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3 id="lecturers">Lecturers Information</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Year of Recruitment</th>
                <th>Department</th>
                <th>Employee Number</th>
                <th>Unit Specials</th>
            </tr>
            <?php foreach ($lecturers as $lecturer): ?>
            <tr>
                <td><?= htmlspecialchars($lecturer['name']) ?></td>
                <td><?= htmlspecialchars($lecturer['username']) ?></td>
                <td><?= htmlspecialchars($lecturer['recruitmentYear']) ?></td>
                <td><?= htmlspecialchars($lecturer['department']) ?></td>
                <td><?= htmlspecialchars($lecturer['employeeNumber']) ?></td>
                <td><?= htmlspecialchars($lecturer['unitSpecials']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const username = <?= json_encode($username) ?>;
            const welcomeMessage = document.getElementById('welcome-message');

            // Set the welcome message text
            welcomeMessage.textContent = `Welcome to the Admin Dashboard, ${username}!`;

            // Show the welcome message and remove it after 5 seconds
            welcomeMessage.style.display = 'block';
            setTimeout(() => {
                welcomeMessage.style.display = 'none';
            }, 5000);

            // Confetti animation
            const canvas = document.getElementById('confetti-canvas');
            const confetti = window.confetti.create(canvas, { resize: true });
            confetti({ particleCount: 100, spread: 160, origin: { y: 0.5 } });

            // Remove confetti canvas after 5 seconds
            setTimeout(() => {
                canvas.style.display = 'none';
            }, 5000);
        });
    </script>

</body>
</html>
