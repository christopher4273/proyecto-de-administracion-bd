<?php
    //Se incluye el modelo donde conectará el controlador.
    require_once '../Models/Detail.php';
    require_once '../Controllers/InvoiceController.php';
    require_once '../Models/Product.php';
    require_once '../DataBase/conection.php';

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $act = $_GET['action'];
        if($act=='search'){
            $p = $_GET['product'];
            $producto=new Product();
            $product=$producto->search($p);
        }
    }

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $act = $_GET['action'];
        if($act=='sendData'){
            $c = $_GET['cantidad'];
            $p = $_GET['precio'];
            $d = $_GET['descuento'];
            $det=new DetailController();
            $det->calcular($c, $p, $d);
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
        }

        //Método que registrar al modelo un nuevo detalle.
        public function save(){

            if(isset($_POST['DetailController'])){

                for($count = 0; $count<count($_POST['prod']); $count++){

                    $myparams['subtotal'] = $_POST['subtotal'][$count];
                    $myparams['descuento'] = $_POST['desc'][$count];
                    $myparams['producto'] = $_POST['prod'][$count];
                    $myparams['cantidad'] = $_POST['cant'][$count];
                    $myparams['factura'] = $_POST['fact'][$count];

                    $sql .= "EXEC createsp_DetalleFactura @subtotal = ?, 
                    @descuento = ?, @cantidad = ?, @factura = ?, @producto = ?" ;

                    $procedure_params = array(
                        array(&$myparams['subtotal'], SQLSRV_PARAM_IN),
                        array(&$myparams['descuento'], SQLSRV_PARAM_IN),
                        array(&$myparams['cantidad'], SQLSRV_PARAM_IN),
                        array(&$myparams['factura'], SQLSRV_PARAM_IN),
                        array(&$myparams['producto'], SQLSRV_PARAM_IN)
                    );
                } 

                /*$pvd = new  Detail();
                //Captura de los datos del formulario (vista).
                $pvd->subtotal = $_POST['subtotal'];
                $pvd->descuento = $_POST['desc'];
                $pvd->producto = $_POST['prod'];
                $pvd->cantidad = $_POST['cant'];
                $pvd->factura = $_POST['desc'];*/

                //$prod = $this->prod->search($pvd->producto);

                //Registro al modelo detalle.
                $this->detalle->add($procedure_params, $sql);
                echo '<script>window.open("../Views/NewInvoice.php","_self",null,true);</script>';
            }    
        }

        public function calcular($c, $p, $d){
            
            //$cant=$_GET['cantidad'];
            $cant = $c;
            $desc = $d;
            $precio = $p;
            //$prod = $p->search($id);
            $sub = $precio*$cant;
            $descuento = 0;

            if($desc>1 && $desc<=100){
                $desc = $desc/100;
                $descuento = $sub*$desc;
            }
            else if($desc<1 && $desc<=100){
                $descuento = $sub*$desc;
            }

            $subtotal = $sub-$descuento;

            $arreglo['descuento'] = $descuento;
            $arreglo['subtotal'] = $subtotal;

            echo (json_encode( $arreglo));

        }

    }