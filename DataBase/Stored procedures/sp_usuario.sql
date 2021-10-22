--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE USUARIOS
--CREATE
CREATE PROCEDURE sp_UsuarioCrear
	@id_usuario INT, 
	@contrasenia VARCHAR(50),
	@nombre_completo VARCHAR(50),
	@correo VARCHAR(50),
	@telefono VARCHAR(50) 
AS
	BEGIN
		INSERT INTO tbusuario  (
			id_usuario , 
			contrasenia ,
			nombre_completo ,
			correo,
			telefono)
		VALUES (
			@id_usuario, 
			@contrasenia ,
			@nombre_completo ,
			@correo ,
			@telefono )
		SELECT 
			   contrasenia = @contrasenia,
			   nombre_completo = @nombre_completo,
			   correo = @correo,
			   telefono = @telefono
		FROM tbusuario 
		WHERE  id_usuario = @id_usuario
	END
GO
--READ
CREATE PROC csp_UsuarioRead
    @id_usuario int
AS 
	BEGIN 
		SELECT id_usuario, contrasenia, nombre_completo, correo, telefono
		FROM   tbusuario  
		WHERE  (id_usuario = @id_usuario) 
	END
GO
--UPDATE
CREATE PROC csp_UsuarioUpdate
	@id_usuario INT, 
	@nombre_completo VARCHAR(50),
	@correo VARCHAR(50),
	@telefono VARCHAR(50)
AS 
	BEGIN 
		UPDATE tbusuario
		SET  
			   nombre_completo = @nombre_completo,
			   correo = @correo,
			   telefono = @telefono
		WHERE  id_usuario = @id_usuario
	END
GO
--DELETE
CREATE PROC csp_UsuarioDelete 
    @id_usuario int
AS 
	BEGIN 
		DELETE
		FROM   tbusuario
		WHERE   id_usuario = @id_usuario
	END
GO
IF OBJECT_ID('csp_UsuarioLogin') IS NOT NULL
	BEGIN 
		DROP PROC csp_UsuarioLogin
	END 
GO
CREATE PROC csp_UsuarioLogin
    @id_usuario int,
	@contrasenia varchar(200)

AS 
	BEGIN 
		SELECT id_usuario, contrasenia
		FROM   tbusuario  
		WHERE  (id_usuario = @id_usuario AND contrasenia = @contrasenia) 
	END
GO
--VISTA DE USUARIO, MOSTRAR LOS USUARIOS
create view v_mostrarUsuarios as
	SELECT id_usuario, nombre_completo, correo, telefono
		FROM   tbusuario 
go
/*SELECT id_usuario, nombre_completo, correo, telefono
		FROM   v_mostrarUsuarios */
--FIN DE CRUD PROCEDIMIENTOS USUARIO
-------------------------------------------------   