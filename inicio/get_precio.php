<?php
include "../conexiondb.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_url = $_POST['product_url'];

    $query = "SELECT price FROM prices_new WHERE url = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $product_url);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    // Send the price back as the response
    echo $price;
}
?>
