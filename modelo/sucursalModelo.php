<?php

class SucursalModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function obtenerSucursales()
    {
        $query = "SELECT * FROM sucursales";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerStock($producto_id)
    {
        $query = "SELECT SUM(stock) as stock FROM inventario WHERE producto_id = :producto_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['stock'] !== null ? (int)$resultado['stock'] : 0;
    }
}
