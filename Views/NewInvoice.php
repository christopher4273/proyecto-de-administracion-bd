<?php
session_start();

if (!isset($_SESSION['user_-id'])) {
    header('Location: ../Views/login.php');
    exit;
}

require_once '../Controllers/InvoiceController.php';
//require_once '../Controllers/DetalleController.php';
require_once '../Models/User.php';
require_once '../Models/Client.php';
require_once '../Models/Invoice.php';
require_once '../Models/Product.php';
require_once '../DataBase/Conection.php';
require_once '../Includes/Header.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="../css/general.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

</head>

<body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">
    <div class="row justfy-content-center">
        <div class="col-2 "></div> 

        <div class="col-8 mt-4 ">        
        <div class="col-8 mt-4 ">              
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
                </div>
            <div class="newSale">

                <form method="POST" action="?c=InvoiceController&a=save" class="facturaForm">
                    <div class="saleTitle"> Agregar una nueva factura </div>
                    <div class="mb-2">
                        <select class="form-select" aria-label="Default select example" name="cliente">
                            <option value="">Seleccione un cliente</option>
                            <?php
                                $cliente = new Client();
                                //$usuarios = $usuario->get();
                                $cliente->get(2);
                            ?>                
                        </select>
                    </div>
                    <div class="mb-2">
                        <select class="form-select" aria-label="Default select example" name="vendedor">
                            <option value="">Seleccione un vendedor</option>
                            <?php
                                $user = new User();
                                //$usuarios = $usuario->get();
                                $user->get(2);
                            ?>
                        </select>
                    </div>
                    <div class="btnContainer">
                        <input type="submit" name="InvoiceController" class="btn btn-success" value="Guardar">
                        <button type="button" class="btn btn-danger">
                            <a class="link" href="../index.php"><span class="sr-only"></span>Cancelar</a>
                        </button>
                    </div>
                </form>
            </div>
            <div class="newSale">
                <form method="POST" action="?c=DetalleController&a=save">
                    <div class="saleTitle"> Añadir productos a la factura</div>
                    <br>
                    <div class="mb-2">
                        <select class="form-select" aria-label="Default select example" name="factura" required>
                            <option value="">Seleccione una factura</option>
                            <?php
                            $factura = new Factura();
                            foreach ($factura->get() as $r) {
                            ?>
                                <?php
                                $c = new Cliente();
                                $c = $c->search($r->cliente);
                                ?>
                                <option value="<?php echo $r->id_factura; ?>">Id factura: <?php echo $r->id_factura; ?>
                                    Cliente: <?php echo $c->nombre_completo; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="descuento" class="form-label">Ingrese el descuento a aplicar </label>
                        <input type="text" name="descuento" class="form-control" placeholder="Ingrese el descuento a aplicar" required/>
                    </div>
                    <div class="mb-2">
                        <select class="form-select" aria-label="Default select example" name="producto" required>
                            <option value="">Seleccione un producto</option>
                            <?php
                            $producto = new Producto();
                            foreach ($producto->get() as $r) {
                            ?>
                                <option value="<?php echo $r->id_producto; ?>"><?php echo $r->descripcion; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="cantidad" class="form-label">Cantidad </label>
                        <input type="number" name="cantidad" class="form-control" placeholder="Ingrese la cantidad de productos" required/>
                    </div>
                    <div class="btnContainer">
                        <input type="submit" name="DetalleController" class="btn btn-success" value="Guardar">
                        <button type="button" class="btn btn-danger">
                            <a class="link" href="../index.php"><span class="sr-only"></span>Cancelar</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-2"></div>
        <div>


            <script>

            </script>


</body>

</html>
<?php

//require_once '../DataBase/Conection.php';

$controller = 'FacturaController';

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