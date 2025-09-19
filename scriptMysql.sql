CREATE TABLE sucursales(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal VARCHAR(100) 
);

INSERT INTO sucursales (sucursal) VALUES ('Ramada'),('Feria');

CREATE TABLE categorias(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(100)
);

INSERT INTO categorias (categoria) VALUES ('Tela'),('Aplique');

CREATE TABLE productos(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100),
    url VARCHAR(255),
    costo DECIMAL(6,2)DEFAULT 0,
    categoria_id TINYINT UNSIGNED,
    activo BOOLEAN DEFAULT 1,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE colores(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    color VARCHAR(100),
    codigo VARCHAR(100) 
);

CREATE TABLE inventario (
    sucursal_id TINYINT UNSIGNED,
    producto_id TINYINT UNSIGNED,
    color_id TINYINT UNSIGNED,
    stock DECIMAL(6,2)DEFAULT 0,
    PRIMARY KEY (sucursal_id, producto_id, color_id),
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

CREATE TABLE ventas(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    fecha DATE,
    total DECIMAL(6,2),
    descuento DECIMAL(6,2),
    total_ganancias DECIMAL(6,2),
    sucursal_id TINYINT UNSIGNED,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id)
);

CREATE TABLE venta_producto (   
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id INT UNSIGNED ,
    producto_id TINYINT UNSIGNED ,
    color_id TINYINT UNSIGNED ,
    cantidad DECIMAL(6,2) ,
    precio DECIMAL(6,2) ,
    subtotal DECIMAL(6,2) ,
    ganancias DECIMAL(6,2) ,    
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id)
);

CREATE TABLE compras(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sucursal_id TINYINT UNSIGNED,
    fecha DATE,
    total DECIMAL(6,2),
    total_gastos DECIMAL(6,2),
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id)
);

CREATE TABLE compra_producto (
    compra_id INT UNSIGNED ,
    producto_id TINYINT UNSIGNED ,
    color_id TINYINT UNSIGNED ,
    cantidad DECIMAL(6,2) ,
    precio DECIMAL(6,2) ,
    subtotal DECIMAL(6,2) ,
    PRIMARY KEY (compra_id, producto_id, color_id),
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (color_id) REFERENCES colores(id) 
);

CREATE TABLE tipos_gastos(
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo_gasto VARCHAR(100) 
);

CREATE TABLE gastos(
    tipo_gasto_id TINYINT UNSIGNED ,  
    compra_id INT UNSIGNED ,
    gasto DECIMAL(6,2) ,
    PRIMARY KEY (tipo_gasto_id, compra_id),
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (tipo_gasto_id) REFERENCES tipos_gastos(id)
);

/* DELIMITER $$
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

DELIMITER ; */

INSERT INTO colores (color, codigo) VALUES 
('Blanco', 'FFFFFF'),
('Negro', '000000'),
('Fuchsia', 'FF00FF'),
('Verde Agua', '00FFFF'),
('Guindo', '800000'),
('Azul Electrico', '0000FF'),
('Verde Botella', '006B3F'),
('Azul Marino','000080'),
('Amarillo', 'FFFF00'),
('Lila','D29BFD'),
('Rojo', 'FF0000'),
('Rosado', 'FF69B4'),
('Rosado Bebe', 'FFB6C1'),
('Celeste', '00BFFF'),
('Celeste Azulado', '6DACEF'),
('Palo De Rosa', 'D7A9A9'),
('Perla', 'EAE0C8');

INSERT INTO tipos_gastos (tipo_gasto) VALUES 
('Transporte Terrestre'),
('Transporte Maritimo'),
('Transporte Aereo'),
('Nacionalizacion'),
('Poliza'),
('Taxi');

SELECT p.producto,c.color,i.stock 
FROM inventario i 
JOIN productos p on p.id=i.producto_id AND p.id IN(1,3,5,6) 
JOIN colores c ON c.id=i.color_id 
WHERE i.sucursal_id=1 AND i.stock < 4
ORDER BY p.producto,c.color