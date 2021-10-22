--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE CLIENTES
--CREAR
CREATE PROCEDURE createsp_clientes
	@id_cliente INT,
	@nombre_completo VARCHAR(300),
	@correo VARCHAR(45),
	@numero_telefonico INT
AS
	BEGIN
		INSERT INTO tbcliente(
			id_cliente,
			nombre_completo,
			correo,
			numero_telefonico
			)
	VALUES (
		@id_cliente,
		@nombre_completo,
		@correo,
		@numero_telefonico
		)
	SET @id_cliente = SCOPE_IDENTITY()
		SELECT	id_cliente = @id_cliente,
				nombre_completo = @nombre_completo,
				correo = @correo,
				numero_telefonico = @numero_telefonico
		FROM tbcliente
		WHERE id_cliente = @id_cliente
	END
--READ
CREATE PROC readsp_cliente
    @id_cliente int
AS 
BEGIN 
    SELECT id_cliente, nombre_completo, correo, numero_telefonico
    FROM   tbcliente  
    WHERE  (id_cliente = @id_cliente) 
END
GO
--UPDATE

CREATE PROC updatesp_cliente
	@id_cliente INT,
	@nombre_completo VARCHAR(300),
	@correo VARCHAR(45),
	@numero_telefonico INT
  
AS 
	BEGIN 
		UPDATE tbcliente
	SET 
		nombre_completo = @nombre_completo,
		correo = @correo,
		numero_telefonico = @numero_telefonico
	WHERE  id_cliente = @id_cliente
	END
GO
--DELETE

CREATE PROC deletesp_cliente
    @id_cliente INT
AS 
	BEGIN 
		DELETE
		FROM   tbcliente
		WHERE  id_cliente = @id_cliente
	END
GO
--VISTA DE CLIENTE, MOSTRAR LOS CLIENTE
create view v_mostrarCliente as
	SELECT id_cliente, nombre_completo, correo, numero_telefonico
    FROM   tbcliente  
go
/*SELECT id_cliente, nombre_completo, correo, numero_telefonico
    FROM   v_mostrarCliente  */
--FIN DE CRUD PROCEDIMIENTOS CLIENTE
-------------------------------------------------------------------------------------