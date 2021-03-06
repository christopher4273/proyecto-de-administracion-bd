<?php
session_start();
if (!isset($_SESSION['user_-id'])) {
    header('Location:../Views/login.php');
    exit;
} 
require_once '../Controllers/UserController.php';
require_once '../DataBase/Conection.php';
// require_once '../Includes/Header.php';
?>
<?php include('../Includes/Header.php'); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="../css/general.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

</head>

<body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">

    <div class="row justfy-content-center" style="font-family: Segoe UI">
        <div class="col-2 "></div>
        <div class="cad newSale col-8 mt-4 ">
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
            <h1 class="leap"> Nuevo Usuario</h1>
            <!-- <img src="../imagenes/imguserv2.png" alt="imagenusuario" class="rounded">-->
            <form method="POST" action="?c=UserController&a=save" class="forma">
                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label">N??mero de cedula</label>
                    <input type="number" name="id_usuario" class="form-control" placeholder="Ingrese el id del usuario" required />
                </div>
                <div class="mb-2">
                    <label for="inputPassword" class="form-label">Contrase??a</label>
                    <input type="password" name="contrasenia" class="form-control" placeholder="Ingrese la contrase??a" required />
                </div>
                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label">Nombre completo</label>
                    <input type="text" name="nombre_completo" class="form-control" placeholder="Ingrese el nombre completo del usuario" required />
                </div>
                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" placeholder="Correo" required />
                    <div id="emailHelp" class="form-text">No compartas tu correo con nadie.</div>
                </div>
                <div class="mb-2">
                    <label for="exampleInputEmail1" class="form-label">Telefono</label>
                    <input type="number" name="telefono" class="form-control" placeholder="Telefono" required />
                </div>
                <div class="btnContainer mb-4">
                    <input type="submit" name="UserController" class="btn btn-success" value="Guardar">
                    <button type="button" class="btn btn-danger">
                        <a class="link" href="../index.php"><span class="sr-only"></span>Cancelar</a>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
        <div>


            <script>

            </script>


</body>

</html>
<?php

//require_once '../DataBase/Conection.php';

$controller = 'UserController';

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