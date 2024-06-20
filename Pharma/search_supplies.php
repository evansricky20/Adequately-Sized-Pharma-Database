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

if (!empty(trim($_GET['supps_id']))) {
    $conditions[] = "supps_id = ?";
    $params[] = $_GET['supps_id'];
    $types .= 'i';
}

if (!empty(trim($_GET['supps_pres_id']))) {
    $conditions[] = "supps_pres_id = ?";
    $params[] = $_GET['supps_pres_id'];
    $types .= 'i';
}

$sql = "SELECT supplier.supp_name, prescription.pres_name, supplies.supps_id, supplies.supps_count, prescription.pres_id
        FROM supplies
        JOIN supplier ON supplies.supps_id = supplier.supp_id
        JOIN prescription ON supplies.supps_pres_id = prescription.pres_id";

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
        echo "Supplier ID - " . $row["supps_id"]. " | Supplier Name: " . $row["supp_name"]. "<br>";
        echo "Prescription ID - " . $row["pres_id"]. " | Prescription Name: " . $row["pres_name"]. "<br>";
        echo "Supply Count - " . $row["supps_count"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
