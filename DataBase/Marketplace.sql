CREATE DATABASE marketplace
USE marketplace

CREATE TABLE tbcategoria
(id_categoria INT identity primary key not null,
nom_categoria VARCHAR(50),
descripcion VARCHAR(300))

CREATE TABLE tbdetallefactura
(id_detallefactura INT identity primary key not null,
subtotal FLOAT,
descuento FLOAT,
cantidad INT,

factura INT,
producto INT)

CREATE TABLE tbfactura
(id_factura INT identity primary key not null,
fecha DATETIME,
subtotal FLOAT,
impuesto FLOAT,
total FLOAT,

cliente INT,
vendedor INT)

CREATE TABLE tbproducto 
(id_producto INT identity primary key not null,
descripcion VARCHAR(500),
stock INT,
precio FLOAT,
imagen VARCHAR,

categoria INT)

CREATE TABLE tbcliente 
(id_cliente INT identity primary key not null,
nombre_completo VARCHAR(300),
correo VARCHAR(45),
numero_telefonico INT)

CREATE TABLE tbusuario
(id_usuario INT identiTy primary key not null,
contrasenia VARCHAR (200),
nombre_completo VARCHAR (40),
correo VARCHAR(40),
telefono INT)

ALTER table tbdetallefactura add constraint fk1
foreign key (factura) references tbfactura (id_factura)

ALTER table tbdetallefactura add constraint fk2
foreign key (producto) references tbproducto (id_producto)

ALTER table tbfactura add constraint fk3
foreign key (cliente) references tbcliente (id_cliente)

ALTER table tbfactura add constraint fk4
foreign key (vendedor) references tbusuario (id_usuario)

ALTER table tbproducto add constraint fk5
foreign key (categoria) references tbcategoria (id_categoria)



--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE CATEGORIA
--CREATE
IF OBJECT_ID ('csp_categoria') IS NOT NULL
BEGIN
DROP PROC createsp_categoria
END
GO
CREATE PROCEDURE createsp_categoria
@id_categoria INT,
@nom_categoria VARCHAR(50),
@descripcion VARCHAR(300)
AS
BEGIN
INSERT INTO tbcategoria (
id_categoria,
nom_categoria,
descripcion)
VALUES (
@id_categoria,
@nom_categoria,
@descripcion)
SET @id_categoria = SCOPE_IDENTITY()
SELECT
	id_categoria = @id_categoria,
	nom_categoria = @nom_categoria,
	descripcion = @descripcion
FROM tbcategoria
WHERE id_categoria = @id_categoria
END
--READ
IF OBJECT_ID('rsp_categoria') IS NOT NULL
BEGIN 
    DROP PROC readsp_categoria
END 
GO
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
IF OBJECT_ID('usp_categoria') IS NOT NULL
BEGIN 
DROP PROC updatesp_categoria
END 
GO
CREATE PROC updatesp_categoria
	@id_categoria INT,
	@nom_categoria VARCHAR(50),
	@descripcion VARCHAR(300)
  
AS 
BEGIN 
UPDATE tbcategoria
SET id_categoria = @id_categoria,
	nom_categoria = @nom_categoria,
	descripcion = @descripcion
WHERE  id_categoria = @id_categoria
END
GO
--DELETE
IF OBJECT_ID('dsp_categoria') IS NOT NULL
BEGIN 
DROP PROC deletesp_categoria
END 
GO
CREATE PROC deletesp_categoria 
    @id_categoria INT
AS 
BEGIN 
DELETE
FROM   tbcategoria
WHERE  id_categoria = @id_categoria
 
END
GO
--FIN DE CRUD PROCEDIMIENTOS CATEGORIA
-------------------------------------------------------------------------------------
--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE CLIENTES
--CREAR
IF OBJECT_ID ('csp_clientes') IS NOT NULL
BEGIN
DROP PROC createsp_clientes
END
GO
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
numero_telefonico)
VALUES (
@id_cliente,
@nombre_completo,
@correo,
@numero_telefonico)
SET @id_cliente = SCOPE_IDENTITY()
SELECT
	id_cliente = @id_cliente,
	nombre_completo = @nombre_completo,
	correo = @correo,
	numero_telefonico = @numero_telefonico
FROM tbcliente
WHERE id_cliente = @id_cliente
END
--READ
IF OBJECT_ID('rsp_cliente') IS NOT NULL
BEGIN 
    DROP PROC readsp_cliente
END 
GO
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
IF OBJECT_ID('usp_cliente') IS NOT NULL
BEGIN 
DROP PROC updatesp_cliente
END 
GO
CREATE PROC updatesp_cliente
@id_cliente INT,
@nombre_completo VARCHAR(300),
@correo VARCHAR(45),
@numero_telefonico INT
  
AS 
BEGIN 
UPDATE tbcliente
SET id_cliente = @id_cliente,
	nombre_completo = @nombre_completo,
	correo = @correo,
	numero_telefonico = @numero_telefonico
WHERE  id_cliente = @id_cliente
END
GO
--DELETE
IF OBJECT_ID('dsp_cliente') IS NOT NULL
BEGIN 
DROP PROC deletesp_cliente
END 
GO
CREATE PROC deletesp_cliente
    @id_cliente INT
AS 
BEGIN 
DELETE
FROM   tbcliente
WHERE  id_cliente = @id_cliente
 
END
GO
--FIN DE CRUD PROCEDIMIENTOS CLIENTE
-------------------------------------------------------------------------------------
--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE USUARIOS
--CREATE
IF OBJECT_ID('csp_usuario') IS NOT NULL
BEGIN 
DROP PROC sp_usuario 
END
GO
CREATE PROCEDURE sp_usuarioCrear
@id INT, 
@contrasenia VARCHAR(50),
@nombre_completo VARCHAR(50),
@correo VARCHAR(50),
@numero_telefonico VARCHAR(50) 
AS
BEGIN
INSERT INTO tbusuario  (
id_usuario , 
contrasenia ,
nombre_completo ,
correo,
telefono)
    VALUES (
@id, 
@contrasenia ,
@nombre_completo ,
@correo ,
@numero_telefonico )
SET @id = SCOPE_IDENTITY()
SELECT 
      contrasenia = @contrasenia,
       nombre_completo = @nombre_completo,
	   correo = @correo,
	   numero_telefonico = @numero_telefonico
FROM tbusuario 
WHERE  id_usuario = @id
END
GO
--READ
IF OBJECT_ID('csp_usuarioRead') IS NOT NULL
BEGIN 
    DROP PROC csp_usuarioRead
END 
GO
CREATE PROC csp_usuarioRead
    @id int
AS 
BEGIN 
 
    SELECT id_usuario, contrasenia, nombre_completo, correo, telefono
    FROM   tbusuario  
    WHERE  (id_usuario = @id) 
END
GO
--UPDATE
IF OBJECT_ID('csp_usuarioUpdate') IS NOT NULL
BEGIN 
DROP PROC csp_usuarioUpdate
END 
GO
CREATE PROC csp_usuarioUpdate
@id INT, 
@contrasenia VARCHAR(50),
@nombre_completo VARCHAR(50),
@correo VARCHAR(50),
@numero_telefonico VARCHAR(50)
AS 
BEGIN 
UPDATE tbusuario
SET  
      contrasenia = @contrasenia,
       combre_completo = @nombre_completo,
	   correo = @correo,
	   telefono = @numero_telefonico
WHERE  id_usuario = @id
END
GO
--DELETE
IF OBJECT_ID('csp_usuarioDelete') IS NOT NULL
BEGIN 
DROP PROC csp_usuarioDelete
END 
GO
CREATE PROC csp_usuarioDelete 
    @id int
AS 
BEGIN 
DELETE
FROM   tbusuario
WHERE   id_usuario = @id
END
GO

--FIN DE CRUD PROCEDIMIENTOS USUARIO
-------------------------------------------------------------------------------------