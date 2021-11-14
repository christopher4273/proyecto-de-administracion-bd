<?php

require_once '../DataBase/conection.php';
//
class Product
{
	//Atributo para conexión a SGBD

	private $con;

		//Atributos del objeto usuario
        public $id_producto;
        public $descripcion;
        public $stock;
        public $precio;
        //public $imagen;
        public $categoria;

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
	public function add(Product $data)
	{
		try
		{
			$myparams['id_producto'] = $data->id_producto;
			$myparams['descripcion'] = $data->descripcion;
			$myparams['stock'] = $data->stock;
			$myparams['precio'] = $data->precio;
			//$myparams['imagen'] = $data->imagen;
            $myparams['categoria'] = $data->categoria;
		
		   //Se crea un array con de parámetros
			$procedure_params = array(
			    array(&$myparams['id_producto'], SQLSRV_PARAM_IN),
			    array(&$myparams['descripcion'], SQLSRV_PARAM_IN),
			    array(&$myparams['stock'], SQLSRV_PARAM_IN),
			    array(&$myparams['precio'], SQLSRV_PARAM_IN),
			    //array(&$myparams['imagen'], SQLSRV_PARAM_IN),
                array(&$myparams['categoria'], SQLSRV_PARAM_IN)
			);
				
				//Se se pasan los parámetros 
				$sql = "EXEC sp_ProductoCrear @id_producto = ?, 
				@descripcion = ?, @stock = ?, @precio = ?, @categoria = ?";
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
			$sql = "select id_producto, descripcion, stock, precio, categoria
			FROM v_mostrarProducto";
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);
			if($option==1){
				while($r = sqlsrv_fetch_array($stm)){
					$id_producto = $r['id_producto'];
					$descripcion = $r['descripcion'];
					$stock = $r['stock'];
					$precio = $r['precio'];
					//$imagen = $r['imagen'];
					$categoria = $r['categoria'];
					?>
						<tr class="bg-light">
							<td><?php echo $id_producto; ?></td>
							<td><?php echo $descripcion; ?></td>
							<td><?php echo $stock; ?></td>
							<td><?php echo $precio; ?></td>
							
							<td><?php echo $categoria; ?></td>
							<td>
								<a type="button" class="btn btn-success editbtn far fa-edit" data-toggle="modal" data-target="#editar"></a>
								
								<a type="button" class="btn btn-danger deletebtn fas fa-trash" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=ProductController&a=delete&id=<?php echo $r['id_producto']; ?>"></i></a>
								
							</td>
						</tr>
					<?php 
				} 
			}else if($option==2){
				while($r = sqlsrv_fetch_array($stm)){
					$id_producto = $r['id_producto'];
					$descripcion = $r['descripcion'];
					?>
						<option id="idProduct" value="<?php echo $id_producto; ?>"><?php echo $descripcion; ?></option>
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
			$sql = "EXEC csp_ProductoDelete @id_producto = ?";
			$stm = sqlsrv_prepare($this->con, $sql, $procedure_params);

			sqlsrv_execute($stm);
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
			$myparams['descripcion'] = $data->descripcion;
			$myparams['stock'] = $data->stock;
			$myparams['precio'] = $data->precio;
			//$myparams['imagen'] = $data->imagen;
			$myparams['categoria'] = $data->categoria;
			$myparams['id_producto'] = $data->id_producto;
			
			//Se crea un array con de parámetros
			$procedure_params = array(
				array(&$myparams['descripcion'], SQLSRV_PARAM_IN),
				array(&$myparams['stock'], SQLSRV_PARAM_IN),
				array(&$myparams['precio'], SQLSRV_PARAM_IN),
				//array(&$myparams['imagen'], SQLSRV_PARAM_IN),
				array(&$myparams['categoria'], SQLSRV_PARAM_IN),
				array(&$myparams['id_producto'], SQLSRV_PARAM_IN)
			);
					
			//Se se pasan los parámetros 
			$sql = "EXEC csp_ProductoUpdate @descripcion = ?,
			@stock = ?, @precio = ?, @categoria = ?, @id_producto = ?";
			$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			print $data->descripcion;
		    print $data->stock;
			print $data->precio;
			//print $data->imagen;
			print $data->categoria;
			print $data->id_producto;
			// Se ejecuta y se evalua 
			if(!sqlsrv_execute($stmt)) {
				die( print_r( sqlsrv_errors(), true));
	        }

		} catch (Exception $e){

		}

	}

	//public function updateStock($data)
	//{
		//Sentencia SQL para actualizar los datos.
	//	try
	//	{
			
	//		$myparams['stock'] = $data->stock;
			
	//		$myparams['id_producto'] = $data->id_producto;
			
			//Se crea un array con de parámetros
	//		$procedure_params = array(
				
	//			array(&$myparams['stock'], SQLSRV_PARAM_IN),
				
	//			array(&$myparams['id_producto'], SQLSRV_PARAM_IN)
	//		);
					
			//Se se pasan los parámetros 
	//		$sql = "EXEC csp_ProductoStockUpd @stock = ?, @id_producto = ?";
			
	//		$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			
	//	    print $data->stock;
			
	//		print $data->id_producto;
			// Se ejecuta y se evalua 
	//		if(!sqlsrv_execute($stmt)) {
	//			die( print_r( sqlsrv_errors(), true));
	 //       }

	//	} catch (Exception $e){

	//	}

	//}

}