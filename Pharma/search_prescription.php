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

if (!empty(trim($_GET['pres_id']))) {
    $conditions[] = "pres_id = ?";
    $params[] = $_GET['pres_id'];
    $types .= 'i'; 
}

if (!empty(trim($_GET['pres_name']))) {
    $conditions[] = "pres_name LIKE ?";
    $params[] = "%" . trim($_GET['pres_name']) . "%";
    $types .= 's'; 
}

$sql = "SELECT prescription.pres_id, prescription.pres_name, pharmacist.pharm_id,
        emp_pharm.emp_lname AS pharm_lname, pharmtech.tech_id, 
        emp_pharmtech.emp_lname AS tech_lname, doctor.doc_name
        FROM prescription 
        JOIN employee AS emp_pharm ON prescription.pres_pharm_id = emp_pharm.emp_id
        JOIN employee AS emp_pharmtech ON prescription.pres_tech_id = emp_pharmtech.emp_id
        JOIN pharmacist ON prescription.pres_pharm_id = pharmacist.pharm_id
        JOIN pharmtech ON prescription.pres_tech_id = pharmtech.tech_id
        JOIN doctor ON prescription.pres_doc_lisc = doctor.doc_lisc";

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
        echo "Prescription ID: " . $row["pres_id"]. " | Name: " . $row["pres_name"]. "<br>";
        echo "Pharmacist ID: " . $row["pharm_id"]. " | Pharmacist Name: " . $row["pharm_lname"]. "<br>";
        echo "Pharm Tech ID: " . $row["tech_id"]. " | Pharm Tech Name: " . $row["tech_lname"]. "<br>";
        echo "Prescribing Doctor Name: " . $row["doc_name"]. "<br>";
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();
?>
