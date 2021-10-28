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
--VISTA DE PRODUCTOS, MOSTRAR LOS PRODUCTOS
create view v_mostrarProducto as
	SELECT id_producto, descripcion, stock, precio, categoria
		FROM   tbproducto 
go
-------------------------------------------------------------------------------------------------