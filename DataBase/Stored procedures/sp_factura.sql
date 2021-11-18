--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE FACTURA
--CREATE
CREATE PROCEDURE createsp_factura
 
    @fecha datetime,
    @subtotal float,
	@impuesto float,
	@total float,
	@cliente int,
	@vendedor int

AS
	BEGIN
  
		INSERT INTO tbfactura
    		("fecha","subtotal", "impuesto", "total", "cliente", "vendedor")
			VALUES (
				@fecha,
				@subtotal,
				@impuesto,
				@total,
				@cliente,
				@vendedor
			)
	END 
GO
	
--READ
CREATE PROC readsp_factura
AS 
	BEGIN 
 
		SELECT 
			 f.id_factura,
			 f.fecha,
			 p.id_producto,
			 d.cantidad,
			 d.descuento,
			 f.impuesto,
			 f.subtotal,
			 f.total,
			 f.cliente,
			 f.vendedor
		FROM   tbfactura AS f INNER JOIN tbdetallefactura 
		AS d ON f.id_factura = d.factura INNER JOIN tbproducto 
		AS p ON d.producto = p.id_producto  
	END
GO

CREATE PROC readsp_id_factura
AS 
	BEGIN 
 
		SELECT TOP 1 * FROM tbfactura ORDER BY id_factura DESC
	END
GO
--UPDATE
CREATE PROC updatesp_factura
    @id_factura INT,
    @fecha datetime,
    @subtotal float,
	@impuesto float,
	@total float,
	@cliente int,
	@vendedor int
  
AS 
	BEGIN 
		UPDATE tbfactura
			SET 
			 fecha = @fecha,
			 subtotal = @subtotal,
			 impuesto = @impuesto,
			 total = @total,
			 cliente = @cliente,
			 vendedor = @vendedor
			WHERE   id_factura = @id_factura
	END
GO
--DELETE
CREATE PROC deletesp_factura 
    @id_factura INT
AS 
	BEGIN 
		DELETE
			FROM   tbfactura
			WHERE   id_factura = @id_factura
	END
GO
--VISTA DE CATEGORIA, MOSTRAR LA CATEGORIA
create view v_mostrarFactura as
	SELECT 
		f.id_factura,
		f.fecha,
	    p.id_producto,
		d.cantidad,
		d.descuento,
		f.impuesto,
		f.subtotal,
		f.total,
		f.cliente,
		f.vendedor
	FROM   tbfactura AS f INNER JOIN tbdetallefactura 
	AS d ON f.id_factura = d.factura INNER JOIN tbproducto 
	AS p ON d.producto = p.id_producto  
go