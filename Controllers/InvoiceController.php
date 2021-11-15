<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/Invoice.php';
//require_once '../Models/Detalle.php';
require_once '../DataBase/Conection.php';    

    if(isset($_POST['action']) && !empty($_POST['action'])) {
        $invoiceController = new InvoiceController();
        $action = $_POST['action'];
        if($action=='add'){
            $invoiceController->save();
        }
    }

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $act = $_GET['action'];
        if($act=='getId'){
            $inv=new Invoice();
            $inv->getId();
        }
    }

?>

<?php

class InvoiceController{
    private $factura;
    private $detalle;
    //Creación del modelo
    public function __CONSTRUCT(){
        $this->factura = new Invoice();
        //$this->detalle = new Detalle();
    }

    //Método que registrar.
    public function save(){
        try{
           /// if(isset($_POST['InvoiceController'])){
                parse_str($_POST['datos'], $data);
                $arreglo = array(
                    "cliente"  => $data['cliente'],
                    "vendedor" => $data['vendedor']
                );
                $pvd = new Invoice();
                //Captura de los datos del formulario (vista).
            // $pvd->id_factura = $_POST['id_factura'];
                $pvd->fecha =  date("Y-m-d H:i:s");
                $pvd->subtotal = 0.0;
                $pvd->impuesto = 0.0;
                $pvd->total = 0.0;
                $pvd->cliente = $arreglo['cliente'];
                $pvd->vendedor = $arreglo['vendedor'];
                //Registro.
                $this->factura->add($pvd);
                //echo '<script>window.open("../Views/NewInvoice.php","_self",null,true);</script>';
        
            //}
        }catch (Exception $e){
            $e->getMessage();
        }
    }
}