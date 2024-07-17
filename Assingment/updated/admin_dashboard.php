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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h2>Admin Dashboard</h2>
        
        <!-- Navigation bar -->
        <nav class="navbar">
            <ul>
                <li><a href="lecturer_login.php">Students</a></li>
                <li><a href="student_login.php">Lecturers</a></li>
                <!-- Add more links as needed -->
            </ul>
        </nav>

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
                <td><?= $student['name'] ?></td>
                <td><?= $student['username'] ?></td>
                <td><?= $student['registrationNumber'] ?></td>
                <td><?= $student['year'] ?></td>
                <td><?= $student['semester'] ?></td>
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
                <td><?= $lecturer['name'] ?></td>
                <td><?= $lecturer['username'] ?></td>
                <td><?= $lecturer['recruitmentYear'] ?></td>
                <td><?= $lecturer['department'] ?></td>
                <td><?= $lecturer['employeeNumber'] ?></td>
                <td><?= $lecturer['unitSpecials'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
