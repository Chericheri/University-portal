<?php
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
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($role == "student") {
        $registrationNumber = $_POST['registrationNumber'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $sql = "INSERT INTO students (name, username, password, registrationNumber, year, semester)
                VALUES ('$name', '$username', '$password', '$registrationNumber', '$year', '$semester')";
    } elseif ($role == "lecturer") {
        $recruitmentYear = $_POST['recruitmentYear'];
        $department = $_POST['department'];
        $employeeNumber = $_POST['employeeNumber'];
        $unitSpecials = $_POST['unitSpecials'];
        $sql = "INSERT INTO lecturers (name, username, password, recruitmentYear, department, employeeNumber, unitSpecials)
                VALUES ('$name', '$username', '$password', '$recruitmentYear', '$department', '$employeeNumber', '$unitSpecials')";
    } else {
        $sql = "INSERT INTO admins (name, username, password)
                VALUES ('$name', '$username', '$password')";
    }

    if ($conn->query($sql) === TRUE) {
        if ($role == "student") {
            header("Location: student_login.php");
        } elseif ($role == "lecturer") {
            header("Location: lecturer_login.php");
        } else {
            header("Location: admin_login.php");
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>