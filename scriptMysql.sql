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
    sucursal_id TINYINT UNSIGNED NOT NULL,
    producto_id TINYINT UNSIGNED NOT NULL,
    color_id TINYINT UNSIGNED NOT NULL,
    stock DECIMAL(10, 2) NOT NULL DEFAULT 0,
    PRIMARY KEY (sucursal_id, producto_id, color_id),
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

CREATE TABLE ventas(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    fecha DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    descuento DECIMAL(10, 2) NOT NULL,
    total_ganancias DECIMAL(10, 2) NOT NULL,
    sucursal_id TINYINT UNSIGNED NOT NULL,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id)
);

ALTER TABLE ventas ADD COLUMN total_ganancias DECIMAL(10, 2) NOT NULL;

CREATE TABLE venta_producto (    
    venta_id INT UNSIGNED NOT NULL,
    producto_id TINYINT UNSIGNED NOT NULL,
    color_id TINYINT UNSIGNED NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    ganancias DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (venta_id, producto_id, color_id),
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

CREATE TABLE compras(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal_id TINYINT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    total_gastos DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id)
);

CREATE TABLE compra_producto (
    compra_id INT UNSIGNED NOT NULL,
    producto_id TINYINT UNSIGNED NOT NULL,
    color_id TINYINT UNSIGNED NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,    
    PRIMARY KEY (compra_id, producto_id, color_id),
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id) 
);

CREATE TABLE tipos_gastos(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo_gasto VARCHAR(100) NOT NULL
);

CREATE TABLE gastos(
    tipo_gasto_id TINYINT UNSIGNED NOT NULL,  
    compra_id INT UNSIGNED NOT NULL,
    gasto DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (tipo_gasto_id, compra_id),
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (tipo_gasto_id) REFERENCES tipos_gastos(id)
);

DELIMITER $$

CREATE TRIGGER after_insert_sucursal
AFTER INSERT ON sucursales
FOR EACH ROW
BEGIN
  INSERT INTO inventario (sucursal_id, producto_id, color_id, stock)
  SELECT NEW.id, p.id, c.id, 0
  FROM productos p, colores c;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_insert_producto
AFTER INSERT ON productos
FOR EACH ROW
BEGIN
  INSERT INTO inventario (sucursal_id, producto_id, color_id, stock)
  SELECT s.id, NEW.id, c.id, 0
  FROM sucursales s, colores c;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_insert_color
AFTER INSERT ON colores
FOR EACH ROW
BEGIN
  INSERT INTO inventario (sucursal_id, producto_id, color_id, stock)
  SELECT s.id, p.id, NEW.id, 0
  FROM sucursales s, productos p;
END$$

DELIMITER ;

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
