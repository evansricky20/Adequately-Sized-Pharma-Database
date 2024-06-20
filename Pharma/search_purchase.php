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

if (!empty(trim($_GET['buys_cust_id']))) {
    $conditions[] = "buys_cust_id = ?";
    $params[] = $_GET['buys_cust_id'];
    $types .= 'i'; 
}

if (!empty(trim($_GET['buys_pres_id']))) {
    $conditions[] = "buys_pres_id LIKE ?";
    $params[] = "%" . trim($_GET['buys_pres_id']) . "%";
    $types .= 'i'; 
}

$sql = "SELECT customer.cust_fname, customer.cust_lname, prescription.pres_name, buys.buys_cust_id, buys.buys_pres_id, buys.buys_date
        FROM buys
        JOIN customer ON buys.buys_cust_id = customer.cust_id
        JOIN prescription ON buys.buys_pres_id = prescription.pres_id";

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
        echo "Customer ID - " . $row["buys_cust_id"]. " | Customer Name - " . $row["cust_fname"]. " " . $row["cust_lname"]. "<br>";
        echo "Prescription Name - " . $row["pres_name"]. " | Prescription ID - " . $row["buys_pres_id"]. "<br>";
        echo "Date - " . $row["buys_date"]. "<br>";

    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
