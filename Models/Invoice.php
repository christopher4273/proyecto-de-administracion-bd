<?php
require_once '../DataBase/conection.php';
class Invoice
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto usuario
      public  $fecha;
      public  $subtotal;
      public  $impuesto ;
      public  $total;
      public  $cliente;
	  public  $vendedor;



	//Método de conexión a SGBD.
	public function __CONSTRUCT()
	{
		try
		{
			$this->con = Conection::Conectar();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    	//Método que registra un nuevo usuario a la tabla.
	public function add(Invoice $data)
	{
		try
		{
			//$myparams['id_factura'] = $data->id_factura;
			$myparams['fecha'] = $data->fecha;
			$myparams['subtotal'] = $data->subtotal;
			$myparams['impuesto'] = $data->impuesto;
			$myparams['total'] = $data->total;
			$myparams['cliente'] = $data->cliente;
			$myparams['vendedor'] = $data->vendedor;			
		
		   //Se crea un array con de parámetros
			$procedure_params = array(
			    //array(&$myparams['id_factura'], SQLSRV_PARAM_IN),
			    array(&$myparams['fecha'], SQLSRV_PARAM_IN),
			    array(&$myparams['subtotal'], SQLSRV_PARAM_IN),
			    array(&$myparams['impuesto'], SQLSRV_PARAM_IN),
			    array(&$myparams['total'], SQLSRV_PARAM_IN),
			    array(&$myparams['cliente'], SQLSRV_PARAM_IN),
			    array(&$myparams['vendedor'], SQLSRV_PARAM_IN)				
			);
				
				//Se se pasan los parámetros 
			$sql = "EXEC createsp_factura @fecha = ?, @subtotal = ?,
			@impuesto = ?, @total = ?, @cliente = ?, @vendedor = ?";
			$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			 // Se ejecuta y se evalua 
			if(sqlsrv_execute($stmt)){
				echo "EXITO AL AGREGAR.<br />";
			}else{
				echo "ERROR AL AGREGAR.<br />";
			}
		} catch (Exception $e){

		}
	}
	//Este método selecciona todas las tuplas de la tabla
	//usuario en caso de error se muestra por pantalla.

	public function get($option)
	{
		try
		{
			$sql = "select id_factura, fecha, subtotal, impuesto,
			total, cliente, vendedor FROM v_mostrarFactura";
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);
			if($option==1){
				while($r = sqlsrv_fetch_array($stm)){
					$id_factura = $r['id_factura'];
					$fecha =  $r['fecha']->format('d-m-Y');
					$subtotal = $r['subtotal'];
					$impuesto = $r['impuesto'];
					$total = $r['total'];	
					$cliente = $r['cliente'];		
					$vendedor = $r['vendedor'];								
					?>
						<tr class="bg-light">
							<td><?php echo $id_factura; ?></td>
							<td><?php echo $fecha; ?></td>
							<td><?php echo $impuesto; ?></td>
							<td><?php echo $subtotal; ?></td>
							<td><?php echo $total; ?></td>
							<td><?php echo $cliente; ?></td>
							<td><?php echo $vendedor; ?></td>
							<td>
								<button type="button" class="btn btn-success editbtn" data-toggle="modal" data-target="#editar">Editar</button>
								<button type="button" class="btn btn-danger mt-0">
									<a class="link" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=InvoiceController&a=delete&id=<?php echo $r['id_factura']; ?>">Eliminar</a>
								</button>
							</td>
						</tr>
					<?php 
				}  				

			}else if($option==2){
				while($r = sqlsrv_fetch_array($stm)){
					$id_factura = $r['id_factura'];
					$fecha = $r['fecha'];
					?>
						<option value="<?php echo $id_factura; ?>"><?php echo $fecha; ?></option>
					<?php 
				}
			}
	    }
		catch(Exception $e)
		{
			//Obtener mensaje de error.
			die($e->getMessage());
		}
	}

	//Datos usuario x id
	public function search($id_factura)
	{
		try
		{
			//la clausula Where para especificar el id del usuario.
			$stm = $this->con->prepare("SELECT * FROM factura WHERE id_factura = ?");
			//Ejecución de la sentencia SQL utilizando el parámetro id.
			$stm->execute(array($id_factura));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	//Este método elimina la tupla usuario dado un id.
	public function delete($id_factura)
	{
		try
		{
			//Sentencia SQL para eliminar una tupla utilizando
			$stm = $this->con
			            ->prepare("DELETE FROM factura WHERE id_factura = ?");
			$stm->execute(array($id_factura));
			$_SESSION['message'] = 'Factura eliminada correctamente';
			$_SESSION['message_type'] = 'success';
		} catch (Exception $e)
		{
			$_SESSION['message'] = 'No se puede eliminar factura';
			$_SESSION['message_type'] = 'dark';
		}
	}
	//Método que actualiza una tupla a partir de la clausula
	//Where y el id del usuario.
	public function update($data)
	{
		
			//Sentencia SQL para actualizar los datos.
			$sql = "UPDATE factura SET fecha=?, subtotal=? ,impuesto=?, total=?, cliente=?, vendedor=? WHERE id_factura = ?";

			//Ejecución de la sentencia a partir de un arreglo.
			$this->con->prepare($sql)
			     ->execute(
				    array(
						$data->fecha,
						$data->subtotal,
						$data->impuesto,
						$data->total,
						$data->cliente,
						$data->vendedor,
						$data->id_factura
					)
				);
	}


}