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
    id_factura INT primary key identity,
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
