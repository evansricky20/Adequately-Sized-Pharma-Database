<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asp";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conditions = [];
$params = [];
$types = '';

if (!empty(trim($_GET['emp_id']))) {
    $conditions[] = "emp_id = ?";
    $params[] = $_GET['emp_id'];
    $types .= 'i';
}

if (!empty(trim($_GET['emp_fname']))) {
    $conditions[] = "emp_fname LIKE ?";
    $params[] = "%" . trim($_GET['emp_fname']) . "%";
    $types .= 's'; 
}

if (!empty(trim($_GET['emp_lname']))) {
    $conditions[] = "emp_lname LIKE ?";
    $params[] = "%" . trim($_GET['emp_lname']) . "%";
    $types .= 's';
}

$sql = "SELECT * FROM employee";

if (!empty($conditions)) {
    $sql .= " WHERE " . join(" AND ", $conditions);
} else {
    echo "No input given. Enter at least one field to search.";
    exit; 
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Employee ID - " . $row["emp_id"]. " | First Name - " . $row["emp_fname"]. " | Last Name - " . $row["emp_lname"]. "<br>";
        echo "Address - " . $row["emp_address"]. "<br>";
        echo "Phone Number - " . $row["emp_phonenumber"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
