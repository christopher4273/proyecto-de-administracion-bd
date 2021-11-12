<?php
require_once '../DataBase/conection.php';
class Client
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto usuario
        public $id_cliente;
        public $nombre_completo;
        public $correo;
        public $numero_telefonico;

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
	public function add(Client $data)
	{
		try
		{
			$myparams['id_cliente'] = $data->id_cliente;
			$myparams['nombre_completo'] = $data->nombre_completo;
			$myparams['correo'] = $data->correo;
			$myparams['numero_telefonico'] = $data->numero_telefonico;
		//	$myparams['telefono'] = $data->telefono;
		
		   //Se crea un array con de parámetros
			$procedure_params = array(
			    array(&$myparams['id_cliente'], SQLSRV_PARAM_IN),
			    array(&$myparams['nombre_completo'], SQLSRV_PARAM_IN),
			    array(&$myparams['correo'], SQLSRV_PARAM_IN),
			    array(&$myparams['numero_telefonico'], SQLSRV_PARAM_IN),
			   // array(&$myparams['telefono'], SQLSRV_PARAM_IN)
			);
				
				//Se se pasan los parámetros 
				$sql = "EXEC createsp_clientes @id_cliente = ?, 
				@nombre_completo = ?, @correo = ?, @numero_telefonico = ?";
				$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			 // Se ejecuta y se evalua 
			if(sqlsrv_execute($stmt)){
				echo "EXITO AL AGREGAR.<br />";
			}
			else{
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
			$sql = "select id_cliente, nombre_completo, correo, numero_telefonico
			FROM v_mostrarCliente";
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);

			if($option==1){
				while($r = sqlsrv_fetch_array($stm)){
					$id_cliente = $r['id_cliente'];
					$nombre_completo = $r['nombre_completo'];
					$correo = $r['correo'];
					$numero_telefonico = $r['numero_telefonico'];
					?>
						<tr class="bg-light">
							<td><?php echo $id_cliente; ?></td>
							<td><?php echo $nombre_completo; ?></td>
							<td><?php echo $correo; ?></td>
							<td><?php echo $numero_telefonico; ?></td>
							<td>
								<button type="button" class="btn btn-success editbtn" data-toggle="modal" data-target="#editar">Editar</button>
								<button type="button" class="btn btn-danger mt-0">
									<a class="link" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=ClientController&a=delete&id=<?php echo $r['id_cliente']; ?>">Eliminar</a>
								</button>
							</td>
						</tr>
					<?php 
				}  				
			}else if($option==2){
				while($r = sqlsrv_fetch_array($stm)){
					$id_cliente = $r['id_cliente'];
					$nombre_completo = $r['nombre_completo'];
					?>
						<option value="<?php echo $id_cliente; ?>"><?php echo $nombre_completo; ?></option>
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
	public function search($id)
	{
		$query = "EXEC readsp_cliente";		
		$stm = sqlsrv_query($this->con, $query);
		while($r = sqlsrv_fetch_array($stm)){
			$cli=$r['id_cliente'];
		}
		if($cli!=null){
			echo $cli;
		}
	}

	//Este método elimina la tupla usuario dado un id.
	public function delete($id)
	{
		try
		{
			$procedure_params = array($id);
			//Sentencia SQL para eliminar una tupla utilizando
			$sql = "EXEC deletesp_cliente @id_cliente = ?";
			$stm = sqlsrv_prepare($this->con, $sql, $procedure_params);

			sqlsrv_execute($stm);
		} catch (Exception $e){

		}
	}
	//Método que actualiza una tupla a partir de la clausula
	//Where y el id del usuario.
	public function update($data)
	{
		try
		{
			$myparams['nombre_completo'] = $data->nombre_completo;
			$myparams['correo'] = $data->correo;
			$myparams['numero_telefonico'] = $data->telefono;
			$myparams['id_cliente'] = $data->id_usuario;
			
			//Se crea un array con de parámetros
			$procedure_params = array(
				array(&$myparams['nombre_completo'], SQLSRV_PARAM_IN),
				array(&$myparams['correo'], SQLSRV_PARAM_IN),
				array(&$myparams['numero_telefonico'], SQLSRV_PARAM_IN),
				array(&$myparams['id_cliente'], SQLSRV_PARAM_IN)
			);
					
			//Se se pasan los parámetros 
			$sql = "EXEC updatesp_cliente @nombre_completo = ?,
			@correo = ?, @numero_telefonico = ?, @id_cliente = ?";
			$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			print $data->nombre_completo;
		    print $data->correo;
			print $data->numero_telefonico;
			print $data->id_cliente;
			// Se ejecuta y se evalua 
			if(!sqlsrv_execute($stmt)) {
				die( print_r( sqlsrv_errors(), true));
	        }

		} catch (Exception $e){

		}

	}


}