<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/Product.php';
//require_once '../DataBase/Conection.php';    
 //
class ProductController{

    private $producto;
    //Creación del modelo
    public function __CONSTRUCT(){
        $this->producto = new Product();
    }
    //Método que registra al modelo un nuevo producto.
    public function save(){
        try{
            if(isset($_POST['ProductController'])){
                $pvd = new Product();
                //Captura de los datos del formulario (vista).
                $pvd->id_producto = $_POST['id_producto'];
                $pvd->descripcion = $_POST['descripcion'];
                $pvd->stock = $_POST['stock'];
                $pvd->precio = $_POST['precio'];
                //$pvd->imagen = $_POST['imagen'];
                $pvd->categoria = $_REQUEST['categoria'];
                //Registro al modelo usuario.
                $this->producto->add($pvd); 
                echo '<script>window.open("../Views/NewProduct.php","_self",null,true);</script>';
            }
        }catch (Exception $e){
            $e->getMessage();
        }
     }

    //Método que modifica el modelo de un producto.
    public function edit(){
        $pvd = new Product();
        $pvd->id_producto = $_REQUEST['id_producto'];
        $pvd->descripcion = $_REQUEST['descripcion'];
        $pvd->stock = $_REQUEST['stock'];
        $pvd->precio=$_REQUEST['precio'];
        //$pvd->imagen=$_REQUEST['imagen'];
        $pvd->categoria=$_REQUEST['categoria'];
        
        $this->producto->update($pvd); echo '<script  type="text/javascript">window.open("../Views/ProductList.php","_self",null,true);</script>';
   
   
    }
    public function editStock(){
        $pvd = new Product();
        $pvd->id_producto = $_REQUEST['id_producto'];
        $pvd->stock = $_REQUEST['stock'];

        $this->producto->updateStock($pvd); echo '<script  type="text/javascript">window.open("../Views/ProductList.php","_self",null,true);</script>';
    }
    //Método que elimina la tupla producto con el id dado.
    public function delete(){
        $this->producto->delete($_REQUEST['id']); 
        echo '<script>window.open("../Views/ProductList.php","_self",null);</script>';
    }
}