<?php

class User
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto usuario
        public $id;
        public $contrasenia;
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
	public function add(User $data)
	{
		try//,estado,correo,numero_telefonico,tipo_usuario,imagen
		{
            mssql_select_db('marketplace', $con);    

            $stmt = mssql_init('csp_usuario', $con);

            mssql_bind($stmt, '@id_usuario', $data->id, SQLINT4, false, false, 10);
            mssql_bind($stmt, '@contrasenia', $data->contrasenia, SQLVARCHAR, false, false, 200);
            mssql_bind($stmt, '@nombre_completo', $data->nombre_completo, SQLVARCHAR, false, false, 40);
            mssql_bind($stmt, '@correo', $data->correo, SQLVARCHAR, false, false, 40);
            mssql_bind($stmt, '@telefono', $data->telefono, SQLINT4, false, false, 12);
            //mssql_bind($stmt, 'RETVAL', $p_salida, SQLINT4);
            
            mssql_execute($stmt);
            mssql_free_statement($stmt);

            mssql_close($con);

            $_SESSION['message'] = 'Usuario creado correctamente';
			$_SESSION['message_type'] = 'success';
		} catch (Exception $e)
		{
			$_SESSION['message'] = 'Error al crear usuario';
			$_SESSION['message_type'] = 'dark';
		}
	}
	//Este método selecciona todas las tuplas de la tabla
	//usuario en caso de error se muestra por pantalla.

	/*public function get()
	{
		try
		{
			$result = array();
			//Sentencia SQL para selección de datos.
			$stm = $this->con->prepare("SELECT * FROM usuario");
			//Ejecución de la sentencia SQL.
			$stm->execute();
			//fetchAll — Devuelve un array que contiene todas las filas del conjunto
			//de resultados
			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			//Obtener mensaje de error.
			die($e->getMessage());
		}
	}

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