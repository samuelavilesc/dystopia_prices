<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    die("Te has intentado colar pillin");
}

include "../conexiondb.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$url = $_POST['url'];
$name = $_POST['name'];
$owner = $_SESSION['username']; // Assuming the username is stored in the session

// Insert data into the products_pcbox table
$sql = "INSERT INTO products_pcbox (url, owner, name) VALUES ('$url', '$owner', '$name')";

if ($conn->query($sql) === TRUE) {
    echo "Producto añadido correctamente!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>