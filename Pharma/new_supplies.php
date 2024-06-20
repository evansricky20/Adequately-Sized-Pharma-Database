<?php
$supps_id = $_POST['supps_id'];
$supps_pres_id = $_POST['supps_pres_id'];
$supps_count = $_POST['supps_count'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO supplies(supps_id, supps_pres_id, supps_count) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $supps_id, $supps_pres_id, $supps_count);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
