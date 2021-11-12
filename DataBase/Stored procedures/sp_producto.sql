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

--READ
CREATE PROC csp_ProductoRead
    @id_producto INT
AS 
    BEGIN 
        SELECT p.id_producto, p.descripcion, p.stock, p.precio, p.categoria
        FROM   tbproducto as p inner join tbcategoria as c on p.categoria = c.id_categoria
        WHERE  (id_producto = @id_producto)
    END
GO
--UPDATE
CREATE PROC csp_ProductoUpdate
    @id_producto INT, 
    @descripcion VARCHAR(50),
    @stock INT,
    @precio FLOAT,
    @categoria INT

AS 
    BEGIN 
        UPDATE tbproducto
        SET  
               descripcion = @descripcion,
               stock = @stock,
               precio = @precio,
               categoria = @categoria
			   FROM tbproducto as p inner join tbcategoria as c on p.categoria = c.id_categoria
        WHERE  id_producto = @id_producto
    END
GO
--DELETE
CREATE PROC csp_ProductoDelete 
    @id_producto int
AS 
	BEGIN 
		DELETE
		FROM   tbproducto
		WHERE   id_producto = @id_producto
	END
GO
--VISTA DE PRODUCTOS, MOSTRAR LOS PRODUCTOS
create view v_mostrarProducto as
	SELECT id_producto, p.descripcion, stock, precio, (select c.nom_categoria FROM tbcategoria as c WHERE p.categoria = c.id_categoria) as Categoria
		FROM   tbproducto as p inner join tbcategoria as c on p.categoria = c.id_categoria
		WHERE p.id_producto = p.id_producto AND p.categoria = c.id_categoria
go
-------------------------------------------------------------------------------------------------