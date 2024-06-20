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

if (!empty(trim($_GET['cust_id']))) {
    $conditions[] = "cust_id = ?";
    $params[] = $_GET['cust_id'];
    $types .= 'i'; 
}

if (!empty(trim($_GET['cust_fname']))) {
    $conditions[] = "cust_fname LIKE ?";
    $params[] = "%" . trim($_GET['cust_fname']) . "%";
    $types .= 's';
}

if (!empty(trim($_GET['cust_lname']))) {
    $conditions[] = "cust_lname LIKE ?";
    $params[] = "%" . trim($_GET['cust_lname']) . "%";
    $types .= 's';
}

$sql = "SELECT * FROM customer";

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
        echo "Customer ID - " . $row["cust_id"]. " | First Name - " . $row["cust_fname"]. " | Last Name - " . $row["cust_lname"]. " | Date of Birth - " . $row["cust_dob"]. "<br>";
        echo "Address - " . $row["cust_address"]. "<br>";
        echo "Phone Number - " . $row["cust_phonenumber"]. "<br>";
        echo "Insurance Number - " . $row["cust_insurancenum"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
