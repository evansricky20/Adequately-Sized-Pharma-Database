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

if (!empty(trim($_GET['doc_lisc']))) {
    $conditions[] = "doc_lisc = ?";
    $params[] = $_GET['doc_lisc'];
    $types .= 'i'; 
}

if (!empty(trim($_GET['doc_name']))) {
    $conditions[] = "doc_name LIKE ?";
    $params[] = "%" . trim($_GET['doc_name']) . "%";
    $types .= 's'; 
}

if (!empty(trim($_GET['clinic_name']))) {
    $conditions[] = "clinic_name LIKE ?";
    $params[] = "%" . trim($_GET['clinic_name']) . "%";
    $types .= 's';
}

$sql = "SELECT * FROM doctor";

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
        echo "License Number - " . $row["doc_lisc"]. " | Name - " . $row["doc_name"]. "<br>";
        echo "Phone Number - " . $row["doc_phonenumber"]. "<br>";
        echo "Specialty - " . $row["doc_spec"]. "<br>";
        echo "Clinic Name - " . $row["clinic_name"] . "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
