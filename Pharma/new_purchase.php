<?php
$buys_cust_id = $_POST['buys_cust_id'];
$buys_pres_id = $_POST['buys_pres_id'];
$buys_date = $_POST['buys_date'];
$buys_cost = $_POST['buys_cost'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO buys(buys_cust_id, buys_pres_id, buys_date, buys_cost) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $buys_cust_id, $buys_pres_id, $buys_date, $buys_cost);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
