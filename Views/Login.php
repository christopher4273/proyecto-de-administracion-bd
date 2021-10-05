<?php
require_once '../Controllers/UserController.php';
require_once '../DataBase/Conection.php';
session_start();

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

<body>
   <div class="sidenav">
      <div class="login-main-text">
         <h2>TECHNOMARKET<br>Inicio Sesión</h2>
         <p>Inicia sesión para acceder al Process Sale de TECHNOMARKET</p>
      </div>
   </div>
   <div class="main">
      <div class="col-md-6 col-sm-12">
         <div class="login-form">
            <?php if (isset($_SESSION['message'])) { ?>
               <div class="alert alert-<?= $_SESSION['message_type'] ?> role=" alert>
                  <?= $_SESSION['message'] ?>
               </div>
            <?php $_SESSION['message'] = null;
               $_SESSION['message_type'] = null;
            } ?>
            <form method="post" action="?c=UserController&a=login">
               <div class="form-group">
                  <label>Cedula</label>
                  <input type="number" class="form-control" placeholder="Cedula" name="id" required />
               </div>
               <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" class="form-control" placeholder="Contraseña" name="contrasenia" required />
               </div>
               <button type="submit" name="login" class="btn btn-dark mt-3" value="Guardar">Acceder</button>
            </form>
         </div>
      </div>
   </div>
</body>

</html>
<?php
//require_once '../DataBase/Conection.php';
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