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

if (!empty(trim($_GET['tech_id']))) {
    $conditions[] = "tech_id = ?";
    $params[] = $_GET['tech_id'];
    $types .= 'i'; 
}

if (!empty(trim($_GET['tech_certnum']))) {
    $conditions[] = "tech_certnum = ?";
    $params[] = $_GET['tech_certnum'];
    $types .= 'i'; 
}

$sql = "SELECT employee.emp_fname, employee.emp_mname, employee.emp_lname, 
        employee.emp_address, employee.emp_phonenumber, pharmtech.tech_id, pharmtech.tech_certnum
        FROM pharmtech
        JOIN employee ON pharmtech.tech_id = employee.emp_id";

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
        echo "ID - " . $row["tech_id"]. " | Certification Number: " . $row["tech_certnum"]. "<br>";
        echo "First Name - " . $row["emp_fname"]. " | Last Name - " . $row["emp_lname"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
