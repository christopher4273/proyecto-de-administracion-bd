<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/Category.php';
//require_once '../DataBase/Conection.php';    
 //
class CategoryController{

    private $categoria;
    //Creación del modelo
    public function __CONSTRUCT(){
        $this->categoria = new Category();
    }
    //Método que registra al modelo una nueva categoria.
    
    public function save(){
        try{
            if(isset($_POST['CategoryController'])){
                $pvd = new Category();
                //Captura de los datos del formulario (vista).
              //  $pvd->id_usuario = $_POST['id_usuario'];
                $pvd->nom_categoria = $_POST['nom_categoria'];
                $pvd->descripcion = $_POST['descripcion'];
                //Registro al modelo usuario.
                $this->categoria->add($pvd); 
                echo '<script>window.open("_self",null,true);</script>';
            }
        }catch (Exception $e){
            $e->getMessage();
        }
     }

    //Método que elimina la tupla categoria con el id dado.
    public function delete(){
        $this->categoria->delete($_REQUEST['id']); 
        //echo '<script>window.open("../Views/CategoryList.php","_self",null);</script>';
    }

    //Método que modifica el modelo de un usuario.
    public function edit(){
    $pvd = new Category();
        $pvd->id_categoria = $_REQUEST['id_categoria'];
        $pvd->nom_categoria = $_REQUEST['nom_categoria'];
        $pvd->descripcion = $_REQUEST['descripcion'];
        $this->categoria->update($pvd); echo '<script  type="text/javascript">window.open("../Views/CategoryList.php","_self",null,true);</script>';
          
    }
}