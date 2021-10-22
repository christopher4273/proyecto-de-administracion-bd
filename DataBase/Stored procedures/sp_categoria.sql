-------------------------------------------------------------------------------------
--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE CATEGORIA
--CREATE
CREATE PROCEDURE createsp_categoria
    @id_categoria INT,
    @nom_categoria VARCHAR(50),
    @descripcion VARCHAR(300)
AS
    BEGIN
		INSERT INTO tbcategoria (
			id_categoria,
			nom_categoria,
			descripcion
		)
	VALUES (
			@id_categoria,
			@nom_categoria,
			@descripcion
		)
	SET @id_categoria = SCOPE_IDENTITY()
		SELECT  id_categoria = @id_categoria,
				nom_categoria = @nom_categoria,
				descripcion = @descripcion
		FROM tbcategoria
		WHERE id_categoria = @id_categoria
	END
--READ
CREATE PROC readsp_categoria
    @id_categoria int
AS 
	BEGIN 
 
		SELECT id_categoria, nom_categoria, descripcion
		FROM   tbcategoria  
		WHERE  (id_categoria = @id_categoria) 
	END
GO
--UPDATE
CREATE PROC updatesp_categoria
	@id_categoria INT,
	@nom_categoria VARCHAR(50),
	@descripcion VARCHAR(300)
  
AS 
	BEGIN 
		UPDATE tbcategoria
			SET nom_categoria = @nom_categoria,
				descripcion = @descripcion
			WHERE  id_categoria = @id_categoria
	END
GO
--DELETE
CREATE PROC deletesp_categoria 
    @id_categoria INT
AS 
	BEGIN 
		DELETE
			FROM   tbcategoria
			WHERE  id_categoria = @id_categoria 
	END
GO
--VISTA DE CATEGORIA, MOSTRAR LA CATEGORIA
create view v_mostrarCategoria as
	SELECT id_categoria, nom_categoria, descripcion
		FROM   tbcategoria  
go
--FIN DE CRUD PROCEDIMIENTOS CATEGORIA
-------------------------------------------------------------------------------------