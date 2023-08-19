<?php
session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
  header("Location: inicio");
  exit();
} else {

}
?>

<!doctype html>
<html lang="es" class="h-100" data-bs-theme="auto">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dystopia Prices</title>
  <link rel="icon" href="../assets/favicon.png" type="image/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">
  <link href="bootstrap/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    label {
      color: black;
    }

    .logo img {
      vertical-align: middle;
      padding-top: 2.5rem;
    }

    .nav-link {
      display: flex;
      align-items: center;
      margin-top: 0;
      margin-bottom: 0;
      padding-top: 0.5rem;
      /* Adjust as needed */
      padding-bottom: 0.5rem;
      /* Adjust as needed */
      margin-left: 150px; /* Adjust as needed */
    }

  </style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $("form").submit(function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
          type: "POST",
          url: "registrar.php",
          data: formData,
          success: function (response) {
            $("#response").html(response);
            if(response!="Ese nombre de usuario ya está en uso, escoge otro distinto."){
             setTimeout(function () {
              window.location.href = 'login/index.php';
            }, 1000);
          }
          },
          error: function (xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
  </script>


  <!-- Custom styles for this template -->
  <link href="bootstrap/cover.css" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap/sign-in.css">
</head>

<body class="d-flex h-100 text-center text-bg-dark">



  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
      <div class="logo">
      <a href="index.php"><img src="assets/logo.png"></a>
      </div>
      <div>
        <nav class="nav nav-masthead justify-content-center float-md-none">
          <a class="nav-link fw-bold py-1 px-0 " aria-current="page" href="login">Iniciar sesión</a>
          <a class="nav-link fw-bold py-1 px-0 active" href="#registro">Registrarse</a>
        </nav>
      </div>
    </header>

    <main class="px-3">
      <!--Imagen o slogan-->
      <form id="registro" class="registro" method="POST">
      <h1 class="h3 mb-3 fw-normal">Registrarse</h1>
        <div class="form-floating">
          <input type="text" class="form-control" id="username" name="username" required placeholder="Usuario">
          <br>
          <label for="floatingInput">Usuario</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" type="password" id="password" name="password" required
            placeholder="Contraseña">
          <label for="floatingPassword">Contraseña</label>
        </div>
        <br>
        <button class="btn btn-primary w-100 py-2" type="submit">Registrarse</button>
      </form>
      <span id="response"></span>
    </main>

    <footer class="mt-auto text-white-50">
      <p>&copy;2023 Dystopia Prices. Todos los derechos reservados.</p>
    </footer>
  </div>
</body>

</html>