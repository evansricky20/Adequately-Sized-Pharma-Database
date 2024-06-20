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

if (!empty(trim($_GET['supp_id']))) {
    $conditions[] = "supp_id = ?";
    $params[] = $_GET['supp_id'];
    $types .= 'i';
}

if (!empty(trim($_GET['supp_name']))) {
    $conditions[] = "supp_name LIKE ?";
    $params[] = "%" . trim($_GET['supp_name']) . "%";
    $types .= 's'; 
}

$sql = "SELECT * FROM supplier";

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
        echo "Supplier ID - " . $row["supp_id"]. " | Supplier Name: " . $row["supp_name"]. "<br>";
        echo "Suppplier Address: " . $row["supp_address"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
