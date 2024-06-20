<?php
$pres_id = $_POST['pres_id'];
$pres_name = $_POST['pres_name'];
$pres_price = $_POST['pres_price'];
$pres_stock = $_POST['pres_stock'];
$pres_pharm_id = $_POST['pres_pharm_id'];
$pres_tech_id = $_POST['pres_tech_id'];
$pres_doc_lisc = $_POST['pres_doc_lisc'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO prescription(pres_id, pres_name, pres_price, pres_stock, pres_pharm_id, pres_tech_id, pres_doc_lisc) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $pres_id, $pres_name, $pres_price, $pres_stock, $pres_pharm_id, $pres_tech_id, $pres_doc_lisc);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
