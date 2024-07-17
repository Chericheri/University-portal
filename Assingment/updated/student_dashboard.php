<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: student_login.php");
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

$username = $_SESSION['username'];
$sql = "SELECT * FROM students WHERE username='$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Student Dashboard</h2>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $user['name']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo $user['username']; ?></td>
            </tr>
            <tr>
                <th>Registration Number</th>
                <td><?php echo $user['registrationNumber']; ?></td>
            </tr>
            <tr>
                <th>Year</th>
                <td><?php echo $user['year']; ?></td>
            </tr>
            <tr>
                <th>Semester</th>
                <td><?php echo $user['semester']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
