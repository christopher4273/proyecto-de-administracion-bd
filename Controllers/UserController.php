<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/User.php';
//require_once '../DataBase/Conection.php';    
 //
class UserController{

    private $usuario;
    //Creación del modelo
    public function __CONSTRUCT(){
        $this->usuario = new User();
    }
    //Método que registra al modelo un nuevo usuario.
    public function save(){
        try{
            if(isset($_POST['UserController'])){
                $pvd = new User();
                //Captura de los datos del formulario (vista).
                $pvd->id_usuario = $_POST['id_usuario'];
                $pvd->contrasenia = $_POST['contrasenia'];
                $pvd->nombre_completo = $_POST['nombre_completo'];
                $pvd->correo = $_REQUEST['correo'];
                $pvd->telefono = $_REQUEST['telefono'];
                //Registro al modelo usuario.
                $this->usuario->add($pvd); 
                echo '<script>window.open("../Views/NewUser.php","_self",null,true);</script>';
            }
        }catch (Exception $e){
            $e->getMessage();
        }
     }
    public function login(){
        if (isset($_POST['login'])) {
            $pvd = new User();
            $id = $_POST['id'];
            $contrasenia = $_POST['contrasenia'];
            $result = $this->usuario->login($id, $contrasenia);
            if (!$result) {
              //  echo "<script> alert('Usuario o contraseña incorrecto!'); </script>";
              $_SESSION['message'] = 'Cedula o contraseña incorrecto';
              $_SESSION['message_type'] = 'dark';
              echo '<script>window.open("../Views/Login.php","_self",null,true);</script>';
            } else {
                    $_SESSION['user_-id'] = $result['id'];
                    header('Location: ../index.php'); 
            }
        }
    }
    //Método que modifica el modelo de un usuario.
    public function edit(){
        $pvd = new User();
        $pvd->id=$_REQUEST['id_usuario'];
        $pvd->nombre_completo = $_REQUEST['nombre_completo'];
        $pvd->correo = $_REQUEST['correo'];
        $pvd->numero_telefonico = $_REQUEST['telefono'];
        $this->usuario->update($pvd); echo '<script  type="text/javascript">window.open("../Views/UserList.php","_self",null,true);</script>';
   
   
    }
    //Método que elimina la tupla usuario con el id dado.
    public function delete(){
        $this->usuario->delete($_REQUEST['id']); 
        echo '<script>window.open("../Views/UserList.php","_self",null);</script>';
    }
}