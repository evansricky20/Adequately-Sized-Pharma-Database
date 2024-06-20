<?php
$emp_id = $_POST['emp_id'];
$emp_fname = $_POST['emp_fname'];
$emp_mname = $_POST['emp_mname'];
$emp_lname = $_POST['emp_lname'];
$emp_address = $_POST['emp_address'];
$emp_phonenumber = $_POST['emp_phonenumber'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO employee(emp_id, emp_fname, emp_mname, emp_lname, emp_address, emp_phonenumber) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $emp_id, $emp_fname, $emp_mname, $emp_lname, $emp_address, $emp_phonenumber);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
