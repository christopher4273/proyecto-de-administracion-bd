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

-- tabla auditoria producto
create table productoAuditoria(
  idLog int IDENTITY(1,1) PRIMARY KEY,
  actividad varchar(99) NOT NULL,
  precioAc varchar(99) NOT NULL,
  stock varchar (99),
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
			declare @stock varchar (99)
			select @stock = stock from inserted
			select @idproducto = id_producto from inserted
			select @precioaAc = precio from inserted
			BEGIN
				SET NOCOUNT ON; -- Evita salida de informacion sobre los registros afectados
				select @accion = Concat('Se actualizo el producto: ', @idproducto)
				insert into productoAuditoria
				values ( @accion, @precioaAc, @stock, SYSDATETIME())
			END;
go