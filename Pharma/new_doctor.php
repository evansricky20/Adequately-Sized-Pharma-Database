<?php
$doc_lisc = $_POST['doc_lisc'];
$doc_spec = $_POST['doc_spec'];
$doc_name = $_POST['doc_name'];
$doc_phonenumber = $_POST['doc_phonenumber'];
$clinic_name = $_POST['clinic_name'];

$conn = new mysqli('localhost','root','','asp', 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn->prepare("INSERT INTO doctor(doc_lisc, doc_spec, doc_name, doc_phonenumber, clinic_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $doc_lisc, $doc_spec, $doc_name, $doc_phonenumber, $clinic_name);
    if ($stmt->execute()) {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
