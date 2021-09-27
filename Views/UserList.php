<?php
/*session_start();
  
if (!isset($_SESSION['user_-id'])) {
    header('Location: ../Views/login.php');
    exit;
}*/
require_once '../Models/User.php';
require_once '../DataBase/Conection.php';
require_once '../Includes/Header.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="url=http://localhost/Proyecto-Base-de-Datos/Views/UserList.php">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="../css/general.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

</head>

<body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">

    <div class="row" style="font-family: Segoe UI">
        <div class="col-1"></div>
        <div class=" col-10 newSale mt-5">
        <?php 
        if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php $_SESSION['message'] = null;
                $_SESSION['message_type'] = null;
            } ?>
            <h1 class="  mt-3 mb-3">Lista Usuarios</h1>
            <table class="table mt-2">
                <thead class="thead-dark">
                    <tr class="bg-light">
                        <th scope="col">Cedula</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Telefono</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usuario = new User();
                    //$usuarios = $usuario->get();
                    echo $usuario->get();?>
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="?c=UserController&a=edit" method="post">
                                <label>Id</label>
                                <input type="text" name="id_usuario" id="id_usuario" class="form-control" readonly>
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input type="email" name="correo" id="correo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Teléfono</label>
                                    <input type="number" name="telefono" id="telefono" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <button type="button" name="cerrar" class="btn btn-danger cerrar">Cerrar</button>
                                    <button type="submit" name="save" class="btn btn-success save" href="UserList.php">Guardar cambios</button>
                                </div>
                                </td>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <button type="button" class="btn btn-dark">
                    <a class="link" href="../index.php"><span class="sr-only"></span>Regresar</a>
                </button>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
    <script>
        $('.editbtn').on('click', function() {

            $tr = $(this).closest('tr');
            var datos = $tr.children("td").map(function() {
                return $(this).text();
            });
            $('#id_usuario').val(datos[0]);
            $('#nombre_completo').val(datos[1]);
            $('#correo').val(datos[2]);
            $('#telefono').val(datos[3]);
        });
    </script>
</body>

</html>
<?php

$controller = 'UserController';

// Todo esta lógica hara el papel de un FrontController
if (!isset($_REQUEST['c'])) {
    //Llamado de la página principal
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