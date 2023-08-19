<?php
include "../conexiondb.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    $query = "SELECT url FROM products_pcbox WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($url);
    $stmt->fetch();
    $stmt->close();

    // Send the URL back as the response
    echo $url;
}
?>
