<?php
//Se incluye el modelo donde conectará el controlador.
require_once '../Models/Invoice.php';
//require_once '../Models/Detalle.php';
require_once '../DataBase/Conection.php';    
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
        if(isset($_POST['InvoiceController'])){
        $pvd = new Invoice();
        //Captura de los datos del formulario (vista).
        $pvd->id_factura = $_POST['id_factura'];
        $pvd->fecha =  date("Y-m-d H:i:s");
        $pvd->subtotal = 0;
        $pvd->impuesto = 0;
        $pvd->total = 0;
        $pvd->cliente = $_POST['cliente'];
        $pvd->vendedor = $_POST['vendedor'];
        //Registro.
        $this->factura->add($pvd);
        //echo '<script>window.open("../Views/NewInvoice.php","_self",null,true);</script>';
    
     }

    }

    /*public function calculate($id){
        $pvd = new Factura();
        $f=new Factura();
        $array = $this->detalle->details($id);
        $f = $this->factura->search($id);
        $sub=0;
        $det=0;
        foreach($array as $detail){
            $det = $detail->subtotal;
            $sub = $sub+$det;
        }
        $f->subtotal = $sub;
        $f->impuesto = $sub*0.13;
        $f->total = $f->subtotal+$f->impuesto;
        $pvd=$f;
        $this->factura->update($pvd);
    }*/
}