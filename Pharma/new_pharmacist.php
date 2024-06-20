<?php
$pharm_id = $_POST['pharm_id'];
$pharm_lisc = $_POST['pharm_lisc'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO pharmacist(pharm_id, pharm_lisc) VALUES (?, ?)");
    $stmt->bind_param("ss", $pharm_id, $pharm_lisc);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
