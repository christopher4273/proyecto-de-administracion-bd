<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/Detail.php';
require_once '../Controllers/InvoiceController.php';
require_once '../Models/Product.php';
require_once '../DataBase/conection.php';    

class DetailController{

    private $detalle;
    private $prod;
    private $facturaController;

    //Creación del modelo
    public function __CONSTRUCT(){
        $this->detalle = new Detail();
        $this->prod = new Product();
        $this->facturaController = new InvoiceController();
    }

    //Método que registrar al modelo un nuevo detalle.
    public function save(){

        if(isset($_POST['DetailController'])){
        $pvd = new  Detail();
        //Captura de los datos del formulario (vista).
        $pvd->subtotal = 0;
        $pvd->descuento = $_POST['descuento'];
        $pvd->producto = $_POST['producto'];
        $pvd->cantidad = $_POST['cantidad'];
        $pvd->factura = $_POST['factura'];

        $prod = $this->prod->search($pvd->producto);
        $sub = $prod->precio*$pvd->cantidad;

        if($pvd->descuento>1 && $pvd->descuento<=100){
            $des = $pvd->descuento/100;
            $des = $sub*$des;
        }
        else if($pvd->descuento<1 && $pvd->descuento<=100){
            $des = $sub*$pvd->descuento;
        }
        if($pvd->descuento<1){
            $pvd->descuento = 0;
        }
        $pvd->descuento = $des;

        $pvd->subtotal = $sub-$pvd->descuento;

        //Registro al modelo detalle.
        $this->detalle->add($pvd);

        $this->facturaController->calculate($pvd->factura);
        echo '<script>window.open("../Views/NewInvoice.php","_self",null,true);</script>';
    
     }

    }
}