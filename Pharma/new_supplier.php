<?php
$supp_id = $_POST['supp_id'];
$supp_name = $_POST['supp_name'];
$supp_address = $_POST['supp_address'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO supplier(supp_id, supp_name, supp_address) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $supp_id, $supp_name, $supp_address);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
