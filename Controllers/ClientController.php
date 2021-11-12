<?php
    //Se incluye el modelo donde conectará el controlador.
    require_once '../Models/Client.php';
    require_once '../DataBase/Conection.php';

    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $action = $_GET['action'];
        $c = $_GET['client'];
        if($action=='search'){
            $clien=new Client();
            $clien->search($c);
        }
    }
?>

<?php
    class ClientController{
        private $client;
        //Creación del modelo
        public function __CONSTRUCT(){
            $this->client = new Client();
        }
        //Método que registrar al modelo una nueva valoracion.
        public function save(){
            if(isset($_POST['ClientController'])){
            $pvd = new Client();
            //Captura de los datos del formulario (vista).
            $pvd->id_cliente = $_POST['id_cliente'];
            $pvd->nombre_completo = $_POST['nombre_completo'];
            $pvd->correo = $_POST['correo'];
            $pvd->numero_telefonico = $_POST['numero_telefonico'];
            $this->client->add($pvd);
            echo '<script>window.open("../Views/NewClient.php","_self",null,true);</script>';
            }
        }
        //Método que modifica.
        public function edit(){
            $pvd = new Client();
            $pvd->id_cliente = $_REQUEST['id_cliente'];
            $pvd->nombre_completo = $_REQUEST['nombre_completo'];
            $pvd->correo = $_REQUEST['correo'];
            $pvd->numero_telefonico = $_REQUEST['numero_telefonico'];
            $this->client->update($pvd);
            echo '<script>window.open("../Views/ClientList.php","_self",null,true);</script>';
        }
        //Método que elimina la tupla valoracion con el id dado.
        public function delete(){
            $this->client->delete($_REQUEST['id']);
            echo '<script>window.open("../Views/ClientList.php","_self",null,true);</script>';
        }
}