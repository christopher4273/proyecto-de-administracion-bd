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
    @id_factura int
AS 
	BEGIN 
 
		SELECT 
			 id_factura,
			 fecha,
			 subtotal,
			 impuesto,
			 total,
			 cliente,
			 vendedor
		FROM   tbfactura  
		WHERE  (id_factura = @id_factura) 
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
			 id_factura = @id_factura,
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
			id_factura,
			 fecha,
			 subtotal,
			 impuesto,
			 total,
			 cliente,
			 vendedor
		FROM   tbfactura  
go