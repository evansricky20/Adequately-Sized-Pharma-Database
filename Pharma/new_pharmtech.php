<?php
$tech_id = $_POST['tech_id'];
$tech_certnum = $_POST['tech_certnum'];
$tech_pharm_id = $_POST['tech_pharm_id'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO pharmtech(tech_id, tech_certnum, tech_pharm_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tech_id, $tech_certnum, $tech_pharm_id);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
