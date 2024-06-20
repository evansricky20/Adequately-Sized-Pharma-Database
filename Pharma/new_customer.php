<?php
$cust_id = $_POST['cust_id'];
$cust_fname = $_POST['cust_fname'];
$cust_lname = $_POST['cust_lname'];
$cust_dob = $_POST['cust_dob'];
$cust_address = $_POST['cust_address'];
$cust_phonenumber = $_POST['cust_phonenumber'];
$cust_insurancenum = $_POST['cust_insurancenum'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO customer(cust_id, cust_fname, cust_lname, cust_dob, cust_address, cust_phonenumber, cust_insurancenum) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssii", $cust_id, $cust_fname, $cust_lname, $cust_dob, $cust_address, $cust_phonenumber, $cust_insurancenum);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
