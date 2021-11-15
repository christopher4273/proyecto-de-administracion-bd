<?php
    //Se incluye el modelo donde conectará el controlador.
    require_once '../Models/Detail.php';
    require_once '../Controllers/InvoiceController.php';
    require_once '../Models/Product.php';
    require_once '../DataBase/conection.php';

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $act = $_GET['action'];
        $p = $_GET['product'];
        if($act=='search'){
            $prod=new Product();
            $prod->search($p);
            $det=new DetailController();
            $det->calcular($p);
        }
    }

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $act = $_GET['action'];
        $p = $_GET['product'];
        if($act=='sendData'){
            $prod=new Product();
            $prod->search($p);
            $det=new DetailController();
            $det->calcular($p);
        }
    }

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

            //$prod = $this->prod->search($pvd->producto);

            //Registro al modelo detalle.
            $this->detalle->add($pvd);

            $this->facturaController->calculate($pvd->factura);
            echo '<script>window.open("../Views/NewInvoice.php","_self",null,true);</script>';
        
        }

        public function calcular($id){
            
            $cant=$_GET['cantidad'];
            $d;
            $p = ;
            //$prod = $p->search($id);
            $sub = $prod->precio*$cant;

            if($d>1 && $d<=100){
                $des = $d/100;
                $des = $sub*$des;
            }
            else if($prod->descuento<1 && $prod->descuento<=100){
                $des = $sub*$prod->descuento;
            }
            if($prod->descuento<1){
                $prod->descuento = 0;
            }
            $prod->descuento = $des;

            $prod->subtotal = $sub-$prod->descuento;

        }
    }