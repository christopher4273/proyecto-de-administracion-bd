<?php

class Detail
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto producto
        public $id_detalle;
        public $subtotal;
        public $descuento;
        public $producto;
		public $cantidad;
        public $factura;
     //   public $imagen;


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

    	
	public function add($data, $sql)
	{
		try
		{
				//Se se pasan los parámetros 
			$stmt = sqlsrv_prepare($this->con, $sql, $data);
	
			 // Se ejecuta y se evalua 

			 /*		if(sqlsrv_execute($stmt)){
						echo "EXITO AL AGREGAR.<br />";
						$_SESSION['message'] = 'Detalle creado correctamente';
						$_SESSION['message_type'] = 'success';
					}
					else{
						echo "ERROR AL AGREGAR.<br />";
						$_SESSION['message'] = 'Error al crear detalle';
						$_SESSION['message_type'] = 'dark';
					} */
			$validar=0;
			if(!sqlsrv_execute($stmt)){
				$validar=1;
				echo "EXITO AL AGREGAR.<br />";
				$_SESSION['message'] = 'Detalle creado correctamente';
				$_SESSION['message_type'] = 'success';
			}
			else if($validar==0){
				echo "ERROR AL AGREGAR.<br />";
				$_SESSION['message'] = 'Error al crear detalle';
				$_SESSION['message_type'] = 'dark';
			}
		} catch (Exception $e)
		{
			$_SESSION['message'] = 'Error al crear detalle';
			$_SESSION['message_type'] = 'dark';
		}

	}
	public function get()
	{
		try
		{
			$result = array();
			//Sentencia SQL para selección de datos.
			$stm = $this->con->prepare("SELECT * FROM detallefactura");
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

	//Datos producto x id
	public function search($factura)
	{
		try
		{
			//la clausula Where para especificar el id del producto.
			$stm = $this->con->prepare("SELECT * FROM detallefactura WHERE factura = ?");
			//Ejecución de la sentencia SQL utilizando el parámetro id.
			$stm->execute(array($factura));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function details($factura){
		try
		{
			//la clausula Where para especificar el id del producto.
			$stm = $this->con->prepare("SELECT * FROM detallefactura WHERE factura = ?");
			//Ejecución de la sentencia SQL utilizando el parámetro id.
			$stm->execute(array($factura));
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e)
		{
			die($e->getMessage());
		}
	}

	//Este método elimina la tupla producto dado un id.
	/*public function delete($id_detalle)
	{
		try
		{
			//Sentencia SQL para eliminar una tupla utilizando
			$stm = $this->con->prepare("DELETE FROM detalle WHERE id_detalle = ?");
			$stm->execute(array($id_detalle));
			$_SESSION['message'] = 'Detalle eliminado correctamente';
			$_SESSION['message_type'] = 'success';
		} catch (Exception $e)
		{
			$_SESSION['message'] = 'error';
			$_SESSION['message_type'] = 'dark';
		}
	}*/
	//Método que actualiza una tupla a partir de la clausula
	//Where y el id del producto.
	/*public function update($data)
	{

		try{
			//Sentencia SQL para actualizar los datos.
			$sql = "UPDATE detallefactura SET subtotal=?, descuento=?, producto=?, cantidad=?, factura=? WHERE id_detalle=?";
            
			//Ejecución de la sentencia a partir de un arreglo.
			$this->con->prepare($sql)
			     ->execute(
				    array(
                        $data->subtotal,
                        $data->descuento,
                        $data->producto,
                        $data->cantidad,
                        $data->factura,
                        $data->id_detalle
					)
				);
				$_SESSION['message'] = 'Detalle editado correctamente';
				$_SESSION['message_type'] = 'success';
			} catch (Exception $e)
			{
				$_SESSION['message'] = 'error';
				$_SESSION['message_type'] = 'dark';
			}
	}*/


}