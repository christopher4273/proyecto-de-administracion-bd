--CRUD DE PROCEDIMIENTOS DE ALMACENAMIENTO DE DETALLE DE USUARIO
--CREATE
CREATE PROCEDURE createsp_DetalleFactura
	@subtotal float,
	@descuento float,
	@cantidad int,
	@factura int,
	@producto int
AS
	BEGIN
	IF((select stock from tbproducto where id_producto = @producto) >= @cantidad)
		BEGIN
		update tbproducto set stock=stock-@cantidad from tbproducto where id_producto = @producto
		INSERT INTO tbdetallefactura (subtotal, descuento, cantidad, factura, producto) 
		VALUES (@subtotal, @descuento, @cantidad, @factura, @producto)
		/*return 0*/
		END
	ELSE
		BEGIN
		Print 'Las unidades existentes no son suficientes para realizar la venta.'
		END
	END
GO