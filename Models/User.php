<?php

require_once '../DataBase/conection.php';

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
		/*	$serverName = "localhost";
			$connectionInfo = array( "Database"=>"marketplace");
			$con = sqlsrv_connect( $serverName, $connectionInfo);
			if($con) {
				 echo "Conexión establecida.<br />";
			}else{
				 echo "Conexión no se pudo establecer.<br />";
				 die( print_r( sqlsrv_errors(), true));
			}*/

			/*$sql = "EXEC sp_UsuarioCrear";
	
	        // Initialize parameters and prepare the statement. 
	        // Variables $qty and $id are bound to the statement, $stmt.
	        //$qty = 0; $id = 0;
	        $stmt = sqlsrv_prepare( 
			    $con, 
			    $sql, 
			    array( 
				    &$data->id, 
		            &$data->contrasenia,
		            &$data->nombre_completo,
		            &$data->correo,
		            &$data->numero_telefonico
			    ));
	        if( !$stmt ) {
	     	    die( print_r( sqlsrv_errors(), true));
				 echo "********************ERROR AL AGREGAR USUARIO********************";
	        }*/

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
				@contrasenia = ?,@nombre_completo = ?,@correo = ?,@telefono = ?";
				$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			 // Se ejecuta y se evalua 
			if(sqlsrv_execute($stmt))
			{
				echo "EXITO AL AGREGAR.<br />";
					 
			}
			else
			{
				echo "ERROR AL AGREGAR.<br />";
	
			}
		} catch (Exception $e)
		{

		}
	}
	//Este método selecciona todas las tuplas de la tabla
	//usuario en caso de error se muestra por pantalla.

	public function get()
	{
		try
		{
			$sql = "select id_usuario, contrasenia, nombre_completo, correo, telefono
			FROM v_mostrarUsuarios";
			$result = array();
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);
			$i = 0;

			while($r = sqlsrv_fetch_array($stm)){
				/*$result['id_usuario'] = $r['id_usuario'];
				$result['nombre_completo'] = $r['nombre_completo'];
				$result['correo'] = $r['correo'];
				$result['telefono'] = $r['telefono'];*/
				$id_usuario = $r['id_usuario'];
				$nombre_completo = $r['nombre_completo'];
				$correo = $r['correo'];
				$telefono = $r['telefono'];
				$result = array(
						/*'id_usuario'=>$r['id_usuario'],
						'nombre_completo'=>$r['nombre_completo'],
						'correo'=>$r['correo'], 
						'telefono'=>$r['telefono'],*/
						0=>$id_usuario,
                        1=>$nombre_completo,
                        2=>$correo,
                        3=>$telefono
				);
				print $result[0]."<br />";
				print $result[1]."<br />";
				print $result[2]."<br />";
				print $result[3]."<br />";

			/*	print $r['nombre_completo']."<br />";
				print $r['correo']."<br />";
				print $r['telefono']."<br />";*/
				//print $result;
				$i++;
				//print $result['id_usuario'];
			}
			return $result;
		}
		catch(Exception $e)
		{
			//Obtener mensaje de error.
			die($e->getMessage());
		}
	}
/*
	public function login($id, $pContrasenna){

		$stm =$this->con->prepare("SELECT * FROM usuario WHERE id=? AND contrasenia=?");
		
		$stm->execute(array($id,$pContrasenna));
	//	return $stm->fetch(PDO::FETCH_OBJ);

		
	 
		return $stm->fetch(PDO::FETCH_ASSOC);
	}

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
	}

	//Este método elimina la tupla usuario dado un id.
	public function delete($id)
	{
		try
		{
			//Sentencia SQL para eliminar una tupla utilizando
			$stm = $this->con
			            ->prepare("DELETE FROM usuario WHERE id = ?");
			$stm->execute(array($id));
			$_SESSION['message'] = 'Usuario eliminado correctamente';
			$_SESSION['message_type'] = 'success';
		} catch (Exception $e)
		{
			$_SESSION['message'] = 'Error al eliminar usuario';
			$_SESSION['message_type'] = 'dark';
		}
	}
	//Método que actualiza una tupla a partir de la clausula
	//Where y el id del usuario.
	public function update($data)
	{
		try{
			//Sentencia SQL para actualizar los datos.
			$sql = "UPDATE usuario SET nombre_completo=?, correo=? ,numero_telefonico=? WHERE id = ?";
			//Ejecución de la sentencia a partir de un arreglo.
			$this->con->prepare($sql)
			     ->execute(
				    array(
                        $data->nombre_completo,
                       // $data-> estado,
                        $data->correo,
                        $data->numero_telefonico,
                      //  $data->tipo_usuario,
                      //  $data->imagen,
						$data->id
					)
				);
				$_SESSION['message'] = 'Usuario actualizado correctamente';
				$_SESSION['message_type'] = 'success';
			} catch (Exception $e)
			{
				$_SESSION['message'] = 'Error al actualizar usuario';
				$_SESSION['message_type'] = 'dark';
			}

	}*/


}