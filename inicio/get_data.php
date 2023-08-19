<?php
// Establish a database connection
include "../conexiondb.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $query = "SELECT timestamp, price FROM prices_new WHERE url = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $url);
    $stmt->execute();
    $result = $stmt->get_result();


    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();


    // Output data in JSON format
    header('Content-Type: application/json');
    echo json_encode($data);
}

?>