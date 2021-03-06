<?php

require_once '../DataBase/conection.php';
//
class User
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto usuario
        public $id_usuario;
        public $contrasenia;
        public $nombre_completo;
        public $correo;
        public $telefono;

	//Método de conexión a SGBD.
	public function __CONSTRUCT()
	{
		try
		{
			$this->con = Conection::conectar();
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

    	//Método que registra un nuevo usuario a la tabla.
	public function add(User $data)
	{
		try
		{
			$myparams['id_usuario'] = $data->id_usuario;
			$myparams['contrasenia'] = $data->contrasenia;
			$myparams['nombre_completo'] = $data->nombre_completo;
			$myparams['correo'] = $data->correo;
			$myparams['telefono'] = $data->telefono;
		
		   //Se crea un array con de parámetros
			$procedure_params = array(
			    array(&$myparams['id_usuario'], SQLSRV_PARAM_IN),
			    array(&$myparams['contrasenia'], SQLSRV_PARAM_IN),
			    array(&$myparams['nombre_completo'], SQLSRV_PARAM_IN),
			    array(&$myparams['correo'], SQLSRV_PARAM_IN),
			    array(&$myparams['telefono'], SQLSRV_PARAM_IN)
			);
				
				//Se se pasan los parámetros 
				$sql = "EXEC sp_UsuarioCrear @id_usuario = ?, 
				@contrasenia = ?, @nombre_completo = ?, @correo = ?, @telefono = ?";
				$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			 // Se ejecuta y se evalua 
			if(sqlsrv_execute($stmt)){
				$_SESSION['message'] = 'Usuario creado correctamente';
				$_SESSION['message_type'] = 'success';
			}
			else{

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
			$sql = "select id_usuario, nombre_completo, correo, telefono
			FROM v_mostrarUsuarios";
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);
			if($option==1){
				while($r = sqlsrv_fetch_array($stm)){
					$id_usuario = $r['id_usuario'];
					$nombre_completo = $r['nombre_completo'];
					$correo = $r['correo'];
					$telefono = $r['telefono'];
					?>
						<tr class="bg-light">
							<td><?php echo $id_usuario; ?></td>
							<td><?php echo $nombre_completo; ?></td>
							<td><?php echo $correo; ?></td>
							<td><?php echo $telefono; ?></td>
							<td>

								<a type="button" class="btn btn-success editbtn far fa-edit" data-toggle="modal" data-target="#editar"></a>
								
								<a type="button" class="btn btn-danger deletebtn fas fa-trash" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=UserController&a=delete&id=<?php echo $r['id_usuario']; ?>"></i></a>
								
							</td>
						</tr>
					<?php 
				}  
			}/*else if($option==2){
				while($r = sqlsrv_fetch_array($stm)){
					$id_usuario = $r['id_usuario'];
					$nombre_completo = $r['nombre_completo'];
					?>
						<option value="<?php echo $id_usuario; ?>"><?php echo $nombre_completo; ?></option>
					<?php 
				}
			}*/
	    }
		catch(Exception $e)
		{
			//Obtener mensaje de error.
			die($e->getMessage());
		}
	}

	public function login($id, $pContrasenna){
		$procedure_params = array($id, $pContrasenna);

		$sql = "csp_UsuarioLogin @id_usuario = ?, @contrasenia=?";
		$stm = sqlsrv_query($this->con, $sql, $procedure_params);

		$valiU="";
		 $valiU = $row = sqlsrv_fetch_array($stm,SQLSRV_FETCH_ASSOC);
		 return  $valiU ;

	
	}
/*
	//Datos usuario x id
	public function search($id)
	{
		try
		{
			//la clausula Where para especificar el id del usuario.
			$stm = $this->con->prepare("SELECT * FROM usuario WHERE id = ?");
			//Ejecución de la sentencia SQL utilizando el parámetro id.
			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}*/

	//Este método elimina la tupla usuario dado un id.
	public function delete($id)
	{
		try
		{
			$procedure_params = array($id);
			//Sentencia SQL para eliminar una tupla utilizando
			$sql = "EXEC csp_UsuarioDelete @id_usuario = ?";
			$stm = sqlsrv_prepare($this->con, $sql, $procedure_params);

			if(sqlsrv_execute($stm))
			{
				$_SESSION['message'] = "Usuario $id eliminado correctamente";
				$_SESSION['message_type'] = 'success';
			}else{
				$_SESSION['message'] = 'Error al eliminar usuario';
				$_SESSION['message_type'] = 'dark';
			}
		} catch (Exception $e){

		}
	}
	//Método que actualiza una tupla a partir de la clausula
	//Where y el id del usuario.
	public function update($data)
	{
		//Sentencia SQL para actualizar los datos.
		try
		{
			$myparams['nombre_completo'] = $data->nombre_completo;
			$myparams['correo'] = $data->correo;
			$myparams['telefono'] = $data->telefono;
			$myparams['id_usuario'] = $data->id_usuario;
			
			//Se crea un array con de parámetros
			$procedure_params = array(
				array(&$myparams['nombre_completo'], SQLSRV_PARAM_IN),
				array(&$myparams['correo'], SQLSRV_PARAM_IN),
				array(&$myparams['telefono'], SQLSRV_PARAM_IN),
				array(&$myparams['id_usuario'], SQLSRV_PARAM_IN)
			);
					
			//Se se pasan los parámetros 
			$sql = "EXEC csp_UsuarioUpdate @nombre_completo = ?,
			@correo = ?, @telefono = ?, @id_usuario = ?";
			$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			print $data->nombre_completo;
		    print $data->correo;
			print $data->telefono;
			print $data->id_usuario;
			// Se ejecuta y se evalua 
			if(!sqlsrv_execute($stmt)) {
				//die( print_r( sqlsrv_errors(), true));

				$_SESSION['message'] = 'Error al modificar usuario';
				$_SESSION['message_type'] = 'dark';
			}
			else{
				$_SESSION['message'] = "Usuario $data->id_usuario actualizado correctamente";
				$_SESSION['message_type'] = 'success';
			}
		} catch (Exception $e){

		}

	}


}