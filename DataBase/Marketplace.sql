CREATE DATABASE marketplace
GO
USE marketplace

CREATE TABLE tbcategoria(
    id_categoria INT primary key identity,
    nom_categoria VARCHAR(50),
    descripcion VARCHAR(300)
    )

CREATE TABLE tbproducto(
    id_producto INT primary key not null,
    descripcion VARCHAR(500),
    stock INT,
    precio FLOAT,
    imagen VARCHAR,
    categoria INT
	foreign key (categoria) references tbcategoria (id_categoria)
    )

CREATE TABLE tbcliente (
    id_cliente INT primary key not null,
    nombre_completo VARCHAR(300),
    correo VARCHAR(45),
    numero_telefonico INT
    )

CREATE TABLE tbusuario(
    id_usuario INT primary key not null,
    contrasenia VARCHAR (200),
    nombre_completo VARCHAR (40),
    correo VARCHAR(40),
    telefono INT
    )

CREATE TABLE tbfactura(
    id_factura INT primary key not null,
    fecha DATETIME,
    subtotal FLOAT,
    impuesto FLOAT,
    total FLOAT,
    cliente INT,
    vendedor INT
	foreign key (cliente) references tbcliente (id_cliente),
	foreign key (vendedor) references tbusuario (id_usuario)
    )

CREATE TABLE tbdetallefactura(
    id_detallefactura INT primary key not null,
    subtotal FLOAT,
    descuento FLOAT,
    cantidad INT,
    factura INT,
    producto INT
	foreign key (factura) references tbfactura (id_factura),
	foreign key (producto) references tbproducto (id_producto)
    )
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
-- Auditorias
--------------------------------------------------
--tabla auditoria de factura
create table facturaAuditoria(
  idLog int IDENTITY(1,1) PRIMARY KEY,
  actividad varchar(99) NOT NULL,
  vendedor varchar(99) NOT NULL,
  cliente varchar (40) NULL,
  fecha date NOT NULL
)
go
-- auditoria para eliminacioon de factura
create trigger facturaInsert 
	on tbfactura
		AFTER DELETE
			AS
			declare @accion varchar(90)
			declare @id_factura varchar(40)
			declare @cliente varchar(40)
			declare @vendedor varchar(40)
			select @id_factura = id_factura from deleted
			select @cliente = cliente from deleted
			select @vendedor = vendedor from deleted
			BEGIN
				SET NOCOUNT ON; -- Evita salida de informacion sobre los registros afectados
				select @accion = Concat('Se elimino la factura numero: ', @id_factura)
				insert into facturaAuditoria
				values ( @accion, @vendedor ,@cliente,  SYSDATETIME())
			END;
go
--PROCEDIMIENTOS ALMACENADOS PRODUCTO
--CREATE
CREATE PROCEDURE sp_ProductoCrear
    @id_producto INT, 
    @descripcion VARCHAR(50),
    @stock INT,
    @precio FLOAT,
    @categoria INT 
AS
    BEGIN
        INSERT INTO tbproducto  (
            id_producto, 
            descripcion ,
            stock,
            precio,
            categoria)
        VALUES (
            @id_producto, 
            @descripcion ,
            @stock,
            @precio,
            @categoria)
        SELECT 
               descripcion = @descripcion,
               stock = @stock,
               precio = @precio,
               categoria = @categoria
        FROM tbproducto as p inner join tbcategoria as c on p.categoria = c.id_categoria
        WHERE  id_producto = @id_producto
    END
GO

--VISTA DE PRODUCTOS, MOSTRAR LOS PRODUCTOS
create view v_mostrarProducto as
	SELECT id_producto, descripcion, stock, precio, categoria
		FROM   tbproducto 
go
-- tabla auditoria producto
create table productoAuditoria(
  idLog int IDENTITY(1,1) PRIMARY KEY,
  actividad varchar(99) NOT NULL,
  precioAc varchar(99) NOT NULL,
  fecha date NOT NULL
)
go
-- auditoria de precio producto
create trigger productoInsert 
	on tbproducto
		AFTER UPDATE
			AS
			declare @accion varchar(90)
			declare @precioaAc varchar(40)
			declare @idproducto varchar(40)
			select @idproducto = id_producto from inserted
			select @precioaAc = precio from inserted
			BEGIN
				SET NOCOUNT ON; -- Evita salida de informacion sobre los registros afectados
				select @accion = Concat('Se actualizo el producto: ', @idproducto)
				insert into productoAuditoria
				values ( @accion, @precioaAc,  SYSDATETIME())
			END;
go