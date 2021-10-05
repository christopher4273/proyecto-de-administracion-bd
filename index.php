<?php
session_start();
if (!isset($_SESSION['user_-id'])) {
    header('Location: Views/login.php');
    exit;
} else {
    // Show users the page!
}
function q() 
{
    echo "hoka";
    $_SESSION['user_-id'] = null;
}
//echo $_SESSION['user_-id'] ;
?>

<!DOCTYPE html> 

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Store</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">


</head>

<body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">TECHNOMARKET</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <div class="dropdown show">
                            <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                Categorias
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="Views/NewCategory.php">Agregar<span class="sr-only">(current)</span></a>
                                <a class="dropdown-item" href="Views/CategoryList.php">Mostrar<span class="sr-only">(current)</span></a>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <div class="dropdown show">
                            <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                Productos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="Views/NewProduct.php">Agregar<span class="sr-only">(current)</span></a>
                                <a class="dropdown-item" href="Views/ProductList.php">Mostrar<span class="sr-only">(current)</span></a>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <div class="dropdown show">
                            <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                Usuarios
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="Views/NewUser.php">Agregar<span class="sr-only">(current)</span></a>
                                <a class="dropdown-item" href="Views/UserList.php">Mostrar<span class="sr-only">(current)</span></a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown show">
                            <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                Facturacion
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="Views/NewInvoice.php">Agregar<span class="sr-only">(current)</span></a>
                                <a class="dropdown-item" href="Views/InvoiceList.php">Mostrar<span class="sr-only">(current)</span></a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown show">
                            <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown">
                                Clientes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="Views/NewClient.php">Agregar<span class="sr-only">(current)</span></a>
                                <a class="dropdown-item" href="Views/ClientList.php">Mostrar<span class="sr-only">(current)</span></a>

                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-item" href="Views/Information.php">Informacion</a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="Controllers/Logout.php">Salir</a>
                    </li>
                    </li>

                </ul>
            </div>
        </nav>
        <main class="row text-white">
            <div class="col-3"></div>
            <div class="col-6 mt-5">
                <h1 class="text-center">TECHNO MARKET</h1>
                <p class="lead text-center">TECHNO MARKET es un sistema process sale que te brindará la gestión de los productos de tu tienda
                de abarrotes, además de las experiencia de llevar un registro de tus clientes para actividades de tu conveniencia.</p>
            </div>
            <div class="col-3"></div>

        </main>

    </div>
    <script>
        $(document).ready(function() {
            $('.button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = '../Controllers/UserController.php',
                    data = {
                        'action': clickBtnValue
                    };
                $.post(ajaxurl, data, function(response) {
                    // Response div goes here.
                    alert("action performed successfully");
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>

</body>

</html>