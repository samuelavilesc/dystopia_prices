<?php
include "conexiondb.php";
if (!$conn) {
    die("Conexion fallida " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];
    
    // Hash the password for security (you should use a stronger hashing method in a real-world application)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_query);

    if (!$result) {
        echo "Error: " . $check_query . "<br>" . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            echo "Ese nombre de usuario ya está en uso, escoge otro distinto.";
        } else {
            // Insert the new user
            $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                echo "Usuario registrado correctamente. Redirigiendo a inicio de sesión";
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        }
    }
}

mysqli_close($conn);
?>
