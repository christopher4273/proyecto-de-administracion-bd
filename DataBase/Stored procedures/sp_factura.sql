--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE FACTURA
--CREATE
CREATE PROCEDURE createsp_factura
    @id_factura INT,
    @fecha datetime,
    @subtotal float,
	@impuesto float,
	@total float,
	@cliente int,
	@vendedor int
AS
    BEGIN
		INSERT INTO tbfactura(
			 id_factura,
			 fecha,
			 subtotal,
			 impuesto,
			 total,
			 cliente,
			 vendedor
		)
	VALUES (
			@id_factura,
			@fecha,
			@subtotal,
			@impuesto,
			@total,
			@cliente,
			@vendedor
		)
	SET @id_factura = SCOPE_IDENTITY()
		SELECT  
			 id_factura = @id_factura,
			 fecha = @fecha,
			 subtotal = @subtotal,
			 impuesto = @impuesto,
			 total = @total,
			 cliente = @cliente,
			 vendedor = @vendedor

		FROM tbfactura
		WHERE id_factura = @id_factura
	END
	
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
