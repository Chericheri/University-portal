<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: lecturer_login.php");
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

$sql_students = "SELECT * FROM students";
$result_students = $conn->query($sql_students);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Lecturer Dashboard</h2>
        <h3>Students Information</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Registration Number</th>
                <th>Year</th>
                <th>Semester</th>
            </tr>
            <?php while($row = $result_students->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['registrationNumber']; ?></td>
                <td><?php echo $row['year']; ?></td>
                <td><?php echo $row['semester']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>
