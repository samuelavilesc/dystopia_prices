<?php
include"../conexiondb.php";
session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION['logged']=true;
            $_SESSION['username']=$username;
            echo'Sesión iniciada correctamente. Redirigiendo';
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "No existe ningún usuario con los datos ingresados. Por favor registrate.";
    }
}

mysqli_close($conn);
?>
