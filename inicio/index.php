<?php
session_start();
if ($_SESSION['logged'] == false) {
    header("Location: ../login");
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
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">

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
            margin-left: 130px;
            /* Adjust as needed */
        }
        .caja {
                margin:20px auto 40px auto;	
                height:30px;
                overflow: hidden;
                width: 230px;
                position:relative;
            }
            select {
                border: none;
                font-size: 14px;
                height: 30px;
                padding: 5px;
                width: 250px;
            }
            select:focus{ outline: none;}

            .caja::after{
                content:"\025be";
                display:table-cell;
                padding-top:7px;
                text-align:center;
                width:30px;
                height:30px;
                background-color:#69F1A1;;
                position:absolute;
                top:0;
                right:0px;	
                pointer-events: none;
            }

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
                    url: "menu_registrar.php",
                    data: formData,
                    success: function (response) {
                        $("#response").html(response);
                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <!-- Custom styles for this template -->
    <link href="../bootstrap/cover.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/sign-in.css">
</head>

<body class="d-flex h-100 text-center text-bg-dark">


    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div class="logo">
                <a href="../index.php"><img src="../assets/logo.png"></a>
            </div>
            <div>
                <nav class="nav nav-masthead justify-content-center float-md-none">
                    <a class="nav-link fw-bold py-1 px-0 active" aria-current="page">
                       Bienvenido, <?php echo ($_SESSION['username']) ?>
                    </a>
                    <a href="logout.php" class="nav-link fw-bold py-1 px-0">Cerrar sesión</a>
                </nav>
            </div>

        </header>

        <main class="px-3">
            <h2>Añadir producto</h2>
            <form>
                <div class="form-floating">
                    <input type="text" class="form-control" type="text" name="name" id="name" required
                        placeholder="Nombre">
                    <br>
                    <label for="floatingInput">Nombre</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" type="text" name="url" id="url" required
                        placeholder="Enlace">
                    <label for="floatingPassword">Enlace</label>
                    <br>
                </div>
                <input class="btn btn-primary w-100 py-2" type="submit" value="Añadir">
            </form>
            <span id="response"></span>

            <h2>Tus productos</h2>
            <div class="caja">
            <select name="existing_products" id="existing_products" class="desplegable-productos">
                <option value="" disabled selected>Selecciona un producto</option>
                <?php
                include "../conexiondb.php";
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $owner = $_SESSION['username'];

                $sql = "SELECT id, name FROM products_pcbox WHERE owner = '$owner'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                }

                $conn->close();
                ?>
            </select>
            </div>

            <script src="../lib/Chart.js"></script>
            <canvas id="myChart" style="width:100%;max-width:600px;"></canvas>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const dropdown = document.getElementById("existing_products");
                    const chartCanvas = document.getElementById("myChart");

                    dropdown.addEventListener("change", function () {
                        const selectedOption = dropdown.options[dropdown.selectedIndex];
                        const selectedProductId = selectedOption.value;

                        // Fetch the URL based on the selected product ID
                        fetch('get_url.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'product_id=' + encodeURIComponent(selectedProductId)
                        })
                            .then(response => response.text())
                            .then(url => {
                                // Fetch the product's price based on the retrieved URL
                                fetch('get_precio.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'product_url=' + encodeURIComponent(url)
                                })
                                    .then(response => response.text())
                                    .then(price => {
                                        const lowerBound = price * 0.8; // 20% lower
                                        const upperBound = price * 1.2; // 20% higher

                                        fetch('get_data.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: 'url=' + encodeURIComponent(url)
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                const xValues = data.map(item => item.timestamp);
                                                const yValues = data.map(item => item.price);

                                                new Chart("myChart", {
                                                    type: "line",
                                                    data: {
                                                        labels: xValues,
                                                        datasets: [{
                                                            fill: false,
                                                            lineTension: 0,
                                                            backgroundColor: "rgba(255,255,255,1.0)",
                                                            borderColor: "rgba(255,255,255,0.6)",
                                                            data: yValues
                                                        }]
                                                    },
                                                    options: {
                                                        legend: { display: false },
                                                        scales: {
                                                            yAxes: [{ ticks: { min: lowerBound, max: upperBound } }],
                                                        }
                                                    }
                                                });

                                            })
                                            .catch(error => {
                                                console.error('Error fetching data:', error);
                                            });
                                    })
                                    .catch(error => {
                                        console.error('Error fetching URL:', error);
                                    });

                            })

                    });
                });
            </script>
        </main>

        <footer class="mt-auto text-white-50">
            <p>&copy;2023 Dystopia Prices. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>

</html>