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

insert into tbcliente(id_cliente, nombre_completo, correo, numero_telefonico) values ('123','mario', 'mamama', 84848484);

insert into tbusuario(id_usuario, nombre_completo, correo, telefono) values ('456','sonia', 'mamama', 84848484);

EXEC createsp_factura 
			 @id_factura = 16,
			 @fecha = '02/02/2021',
			 @subtotal = 75000,
			 @impuesto = 1000,
			 @total = 74000,
			 @cliente = 123,
			 @vendedor = 456
go