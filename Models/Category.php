<?php

require_once '../DataBase/conection.php';
//
class Category
{
	//Atributo para conexión a SGBD

	private $con;
		//Atributos del objeto usuario
        public $nom_categoria;
        public $descripcion;
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
	public function add(Category $data)
	{
		try
		{
			$myparams['nom_categoria'] = $data->nom_categoria;
			$myparams['descripcion'] = $data->descripcion;
		   //Se crea un array con de parámetros
			$procedure_params = array(
			    array(&$myparams['nom_categoria'], SQLSRV_PARAM_IN),
			    array(&$myparams['descripcion'], SQLSRV_PARAM_IN),
			);	
				//Se se pasan los parámetros 
				$sql = "EXEC createsp_categoria @nom_categoria = ?, 
				@descripcion = ?";
				$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
			 // Se ejecuta y se evalua 
			 if(sqlsrv_execute($stmt)){
				$_SESSION['message'] = 'Categoria creada correctamente';
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
			$sql = "select id_categoria, nom_categoria, descripcion
			FROM v_mostrarCategoria";
			//Sentencia SQL para selección de datos.
			$stm = sqlsrv_query($this->con, $sql);
			if($option==1){
				while($r = sqlsrv_fetch_array($stm)){
					$id_categoria = $r['id_categoria'];
					$nom_categoria = $r['nom_categoria'];
					$descripcion = $r['descripcion'];
					?>
						<tr class="bg-light">
							<td><?php echo $id_categoria; ?></td>
							<td><?php echo $nom_categoria; ?></td>
							<td><?php echo $descripcion?></td>
							<td>
								<a type="button" class="btn btn-success editbtn far fa-edit" data-toggle="modal" data-target="#editar"></a>
								<a type="button" class="btn btn-danger deletebtn fas fa-trash" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=CategoryController&a=delete&id=<?php echo $r['id_categoria']; ?>"></a>
								
							</td>
						</tr>
					<?php 
				}  				

			}else if($option==2){
				while($r = sqlsrv_fetch_array($stm)){
					$id_categoria = $r['id_categoria'];
					$nom_categoria = $r['nom_categoria'];
					?>
						<option value="<?php echo $id_categoria; ?>"><?php echo $nom_categoria; ?></option>
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

	public function delete($id_categoria)
	{
		try
		{
			$procedure_params = array($id_categoria);
			//Sentencia SQL para eliminar una tupla utilizando
			$sql = "EXEC deletesp_categoria @id_categoria = ?";
			$stm = sqlsrv_prepare($this->con, $sql, $procedure_params);

			if(sqlsrv_execute($stm))
			{
				$_SESSION['message'] = "Categoria eliminada correctamente";
				$_SESSION['message_type'] = 'success';
			}else{
				$_SESSION['message'] = 'Error al eliminar, ya asociada a un producto';
				$_SESSION['message_type'] = 'dark';
			}
		} catch (Exception $e){

		}
	}

	public function update($data)
	{
		//Sentencia SQL para actualizar los datos.
		try
		{
			$myparams['id_categoria'] = $data->id_categoria;
			$myparams['nom_categoria'] = $data->nom_categoria;
			$myparams['descripcion'] = $data->descripcion;
			
			
			//Se crea un array con de parámetros
			$procedure_params = array(
				array(&$myparams['id_categoria'], SQLSRV_PARAM_IN),
				array(&$myparams['nom_categoria'], SQLSRV_PARAM_IN),
				array(&$myparams['descripcion'], SQLSRV_PARAM_IN),
			);
					
			//Se se pasan los parámetros 
			$sql = "EXEC updatesp_categoria @id_categoria = ?,
			@nom_categoria = ?, @descripcion = ?";
			$stmt = sqlsrv_prepare($this->con, $sql, $procedure_params);
	
			print $data->id_categoria;
		    print $data->nom_categoria;
			print $data->descripcion;
			// Se ejecuta y se evalua 
			if(!sqlsrv_execute($stmt)) {
				//die( print_r( sqlsrv_errors(), true));

				$_SESSION['message'] = 'Error al modificar ';
				$_SESSION['message_type'] = 'dark';
			}
			else{
				$_SESSION['message'] = "Categoria actualizada correctamente";
				$_SESSION['message_type'] = 'success';
			}

		} catch (Exception $e){

		}

	}
}