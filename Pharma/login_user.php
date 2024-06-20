<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asp";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lastName = $_POST['login_lname'];
$employeeID = $_POST['login_ID'];

$sql = "SELECT e.emp_id, p.pharm_id, t.tech_id
        FROM employee e
        LEFT JOIN pharmacist p ON e.emp_id = p.pharm_id
        LEFT JOIN pharmtech t ON e.emp_id = t.tech_id
        WHERE e.emp_lname = ? AND e.emp_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $lastName, $employeeID);
$stmt->execute();

$stmt->bind_result($empId, $pharmId, $techId);

if ($stmt->fetch()) {
    if ($pharmId != null) {
        header("Location: pharm.html");
    } elseif ($techId != null) {
        header("Location: pharmtech.html");
    } else {
        header("Location: login.html");
    }
} else {
    header("Location: login.html");
    
}

$stmt->close();
$conn->close();
?>
