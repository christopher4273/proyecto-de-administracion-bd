<?php
session_start();

if (!isset($_SESSION['user_-id'])) {
    header('Location: ../Views/login.php');
    exit;
}

require_once '../Models/Invoice.php';
//require_once '../Models/Detalle.php';
require_once '../DataBase/Conection.php';
require_once '../Includes/Header.php';
require_once '../Models/Product.php';
require_once '../Models/User.php';
require_once '../Models/Client.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="../css/general.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">
    <div class="row" style="font-family: Segoe UI">
        <div class="col-1"></div>

        <div class="col-10 newSale  mt-4 ">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php $_SESSION['message'] = null;
                $_SESSION['message_type'] = null;
            } ?>
            <h1 class=" mt-3 mb-3">Lista de Facturaci??n</h1>
            <table class="table mt-2">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id factura</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Impuesto</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Total</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Vendedor</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        $invoice = new Invoice();
                        echo $invoice->get(1);
                     ?>
                </tbody>
            </table>
            <div class="mb-2">
                <button type="button" class="btn btn-dark">
                    <a class="link" href="../index.php"><span class="sr-only"></span>Regresar</a>
                </button>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</body>

</html>
<?php

$controller = 'InvoiceController';

// Todo esta l??gica hara el papel de un FrontController
if (!isset($_REQUEST['c'])) {
    //Llamado de la p??gina principal
    require_once "../Controllers/$controller.php";
    $controller = ucwords($controller);
    $controller = new $controller;
} else {
    // Obtiene el controlador a cargar
    $controller = strtolower($_REQUEST['c']);
    $accion = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

    // Instancia el controlador
    require_once "../Controllers/$controller.php";
    $controller = ucwords($controller);
    $controller = new $controller;

    // Llama la accion
    call_user_func(array($controller, $accion));
}
?>