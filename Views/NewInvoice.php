<?php
    session_start();
    if (!isset($_SESSION['user_-id'])) {
        header('Location: ../Views/login.php');
        exit;
    }

    require_once '../Controllers/InvoiceController.php';
    //require_once '../Controllers/DetailController.php';
    require_once '../Models/User.php';
    require_once '../Models/Client.php';
    require_once '../Models/Invoice.php';
    require_once '../Models/Product.php';
    require_once '../DataBase/Conection.php';
    require_once '../Includes/Header.php';
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Store</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link href="../css/general.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <script type="text/javascript">
        var added = 0;
        $(document).ready(function(){
            $('#InvoiceController').click(function(){
                if(added == 0){
                    var d = $('#facturaForm').serialize();
                    $.ajax({
                        type:"POST",
                        url:"../Controllers/InvoiceController.php",
                        data:{datos: d, action:'add'},
                        success:function(){
                            document.getElementById('InvoiceController').disabled=true;
                            document.getElementById('cliente').value="";
                            showId();
                            added=1;
                        }
                    });
                }
                else{
                    document.getElementById('InvoiceController').disabled=true;
                }
            });

            function showId(){
                $.ajax({
                    type: 'GET',
                    url: '../Controllers/InvoiceController.php',
                    data: {action:'getId'},
                    dataType:'text',
                    success: function(respuesta) {
                        //Copiamos el resultado en #mostrar
                        $('#idFactura').html(respuesta);
                        showClient();
                    }
                });
            }

            function showClient(){
                var c=document.getElementById('provisional').value;
                $.ajax({
                    type: 'GET',
                    url: '../Controllers/ClientController.php',
                    data: {action:'search', client:c},
                    dataType:'text',
                    success: function(respuesta) {
                        //Copiamos el resultado en #mostrar
                        $('#client').html(respuesta);
                    }
                });
            }

            $('#addDetail').click(function(){
                var prod = document.getElementById('idProduct').value;
                var cant = document.getElementById('cantidad').value;
                var desc = document.getElementById('descuento').value;
                var precio = 0;

                if($('#idFactura').html() !="" && document.getElementById('cantidad').value > 0 && added == 1){
                    $.ajax({
                        type: 'GET',
                        url: '../Controllers/DetailController.php',
                        data: {action:'search', product: prod},
                        dataType:'text',
                        success: function(respuesta) {
                            //Copiamos el resultado en #mostrar
                            precio=respuesta;
                            sendData(prod, cant, precio, desc);
                        }
                    });

                }    
            });

            /*function newDiv(){

            }*/
            var count = 0;
            function sendData(prod, cant, precio, desc){
                $.ajax({
                    type: 'GET',
                    url: '../Controllers/DetailController.php',
                    data: {action:'sendData', producto: prod, cantidad: cant, precio: precio, descuento: desc},
                    dataType:'text',
                    success: function(respuesta) {
                        //Copiamos el resultado en #mostrar
                        var data = $.parseJSON(respuesta);
                        var desc = data.descuento;
                        var subtotal = data.subtotal;
                        var fact = $('#idFactura').html();

                        count = count + 1;
                        output = '<tr id="row_'+count+'">';
                        output += '<td>'+fact+' <input type="hidden" name="fact[]" id="fact'+count+'" value="'+fact+'" /></td>';
                        output += '<td>'+prod+' <input type="hidden" name="prod[]" id="prod'+count+'" value="'+prod+'" /></td>';
                        output += '<td>'+cant+' <input type="hidden" name="cant[]" id="cant'+count+'" value="'+cant+'" /></td>';
                        output += '<td>'+precio+' <input type="hidden" name="precio[]" id="precio'+count+'" value="'+precio+'" /></td>';
                        output += '<td>'+desc+' <input type="hidden" name="desc[]" id="desc'+count+'" value="'+desc+'" /></td>';
                        output += '<td>'+subtotal+' <input type="hidden" name="subtotal[]" id="subtotal'+count+'" value="'+subtotal+'" /></td>';
                        output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Eliminar</button></td>';
                        output += '</tr>';
                        $('#user_data').append(output);
                        document.getElementById('product').value = "";
                        document.getElementById('cantidad').value = "";  
                        document.getElementById('descuento').value = "";                  
                    }
                }); 
            }

            /*$('#detailForm').on('submit', function(event){
                event.preventDefault();
                var count_data = 0;
                $('#prod').each(function(){
                    count_data = count_data + 1;
                });
                if(count_data > 0){
                    var form_data = $(this).serialize();
                    $.ajax({
                        url:'../Controllers/DetailController.php',
                        method:"POST",
                        data:form_data,
                        success:function(data){
                            
                        }
                    })
                }/*else{
                    $('#action_alert').html('<p>Please Add atleast one data</p>');
                    $('#action_alert').dialog('open');
                }*/
            //});
        });

        function cleanInvoice(){
            $('#client').html("");
            $('#idFactura').html("");
            added = 0;
        }

        function enable(){
            if(document.getElementById('cliente').value!="" && added == 0){
                document.getElementById('InvoiceController').disabled=false;
                document.getElementById('provisional').value = document.getElementById('cliente').value;
            }
            else{
                document.getElementById('InvoiceController').disabled=true;
            }
        }
        $(document).on('click', '.remove_details', function(){
            var row_id = $(this).attr("id");
            $('#row_'+row_id+'').remove();
        });

    </script>
    <body style="background-image: url(https://madariagamendoza.cl/wp-content/uploads/2019/01/fondo-gris.jpg); ">
        <div class="row justfy-content-center">
            <div class="col-2 "></div> 
            <div class="col-8 mt-4 ">        
                <div class="col-8 mt-4 ">              
                    <?php if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['message'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php $_SESSION['message'] = null;
                        $_SESSION['message_type'] = null;
                    } ?>
                </div>
                <div class="newSale">
                    <div class="saleTitle"> Facturaci??n </div>   
                    <form method="POST" id="facturaForm" class="facturaForm">
                        <div class="mb-2">
                            <br>
                            <select id="cliente" onchange="enable()" class="form-select" aria-label="Default select example" name="cliente">
                                <option value="">Seleccione un cliente</option>
                                <?php
                                    $cliente = new Client();
                                    $cliente->get(2);
                                ?>                
                            </select>
                        </div>
                        <div class="mb-2">
                            <input hidden="true" type="text" id="vendedor" name="vendedor" class="form-control bg-white" value="<?php echo $_SESSION['user_-id']; ?>"/> 
                        </div>                   
                        <div>
                            <button title="Generar factura" type="button" disabled id="InvoiceController" name="InvoiceController" class="btn btn-success btn-save">Guardar</button>
                        </div>
                    </form>
                    <div class="invoiceData">
                        <div class="mb-1">
                            <strong for="idFactura" class="form-label ">Factura</strong>
                            <div id="idFactura" class="form-control bg-white invoice-data"></div>
                        </div>
                        <input hidden="true" id="provisional" class="form-control"/>
                        <div class="mb-1">
                            <strong for="client" class="form-label ">Cliente</strong>
                            <div id="client" class="form-control bg-white invoice-data" ></div>
                        </div>
                        <div class="mb-2">
                            <button onclick="cleanInvoice()" type="button" id="cleanInvoice" class="btn btn-danger" style="margin-top:24px;">
                                Limpiar
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="newDetail">
                        <div class="mb-2">
                            <select id="product" class="form-select" aria-label="Default select example" name="product">
                                <option value="">Seleccione un producto</option>
                                <?php
                                    $product = new Product();
                                    $product->get(2);
                                ?>               
                            </select>
                        </div>
                        <div class="mb-2" style="width: 30%">
                            <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Ingrese la cantidad de productos" required />
                        </div>
                        <div class="mb-2" style="width: 30%">
                            <input type="text" id="descuento" name="descuento" class="form-control" placeholder="Ingrese el % de descuento a aplicar" required/>
                        </div>
                        <div class="mb-2" >
                            <a title="Agregar a la factura" type="button" class="fas fa-plus-square addDetail" id="addDetail" name="addDetail"></a>
                        </div>
                    </div>
                    <form method="POST" class="detailForm" id="detailForm" action="?c=DetailController&a=save">
                        <div class="detail">
                            <table class="table table-striped table-bordered" id="user_data">  
                                <tr>
                                    <th>Factura</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                    <th>Acci??n</th>
                                </tr>
                            </table>
                        </div>
                        <div class="container-saveDetail">
                            <button title="Guardar detalles" type="submit" id="DetailController" name="DetailController" class="btn btn-success" style="margin-right: 5px"> Guardar</button>
                            <button type="button" class="btn btn-danger">
                                    <a class="link" >Cancelar</a>
                            </button>
                        </div>
                    </form>    
                </div>
            </div>
            <div class="col-2"></div>
        <div>
    </body>
</html>
<?php
    $controller = 'InvoiceController';

    // Todo esta l??gica hara el papel de un FrontController
    if (!isset($_REQUEST['c'])) {
        //Llamado de la p??gina principal
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