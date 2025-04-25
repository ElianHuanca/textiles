CREATE TABLE sucursales(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal VARCHAR(100) NOT NULL
);

CREATE TABLE productos(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100) NOT NULL,
    costo DECIMAL(10, 2) NOT NULL DEFAULT 0
);

CREATE TABLE colores(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    color VARCHAR(100) NOT NULL,
    codigo VARCHAR(100) NOT NULL
);

CREATE TABLE inventario (
    id_sucursal TINYINT UNSIGNED NOT NULL,
    id_producto TINYINT UNSIGNED NOT NULL,
    id_color TINYINT UNSIGNED NOT NULL,
    stock DECIMAL(10, 2) NOT NULL DEFAULT 0,
    PRIMARY KEY (id_sucursal, id_producto, id_color),
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_color) REFERENCES colores(id)
);

CREATE TABLE ventas(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    fecha DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    descuento DECIMAL(10, 2) NOT NULL,
    id_sucursal TINYINT UNSIGNED NOT NULL,
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id)
);

CREATE TABLE venta_producto (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_venta INT UNSIGNED NOT NULL,
    id_producto TINYINT UNSIGNED NOT NULL,
    id_color TINYINT UNSIGNED NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    ganancias DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_color) REFERENCES colores(id)
);

CREATE TABLE compras(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_sucursal TINYINT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    total_gastos DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id)
);

CREATE TABLE compra_producto (
    id_compra INT UNSIGNED NOT NULL,
    id_producto TINYINT UNSIGNED NOT NULL,
    id_color TINYINT UNSIGNED NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_compra, id_producto, id_color),
    FOREIGN KEY (id_compra) REFERENCES compras(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_color) REFERENCES colores(id)
);

CREATE TABLE tipos_gastos(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo_gasto VARCHAR(100) NOT NULL
);

CREATE TABLE gastos(
    id_tipo_gasto TINYINT UNSIGNED NOT NULL,  
    id_compra INT UNSIGNED NOT NULL,
    gasto DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_tipo_gasto, id_compra),
    FOREIGN KEY (id_compra) REFERENCES compras(id),
    FOREIGN KEY (id_tipo_gasto) REFERENCES tipos_gastos(id)
);

INSERT INTO sucursales (sucursal) VALUES ('Ramada');

INSERT INTO productos (producto) VALUES 
('Razo Suizo SemiLicra'),
('Razo Suizo Rigido');

INSERT INTO colores (color, codigo) VALUES 
('Perla', 'EAE0C8');

INSERT INTO tipos_gastos (tipo_gasto) VALUES 
('Transporte Terrestre'),
('Transporte Maritimo'),
('Transporte Aereo'),
('Nacionalizacion'),
('Poliza'),
('Taxi');