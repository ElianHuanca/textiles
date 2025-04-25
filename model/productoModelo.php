<?php

class ProductoModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function obtenerProductos(){
        $query = "SELECT * FROM productos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosDatatable($search, $orderColumn, $orderDir, $start, $length)
    {
        $query = "SELECT * FROM productos WHERE 1 = 1 ";
        if (!empty($search)) {
            $query .= " AND ( costo LIKE :search
            OR producto LIKE :search 
            OR id LIKE :search)";
        }
        $query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :length";
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':length', $length, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCantidadProductos($search)
    {
        $query = "SELECT COUNT(*) total 
        FROM productos 
        WHERE 1 = 1";
        if (!empty($search)) {
            $query .= " AND ( costo LIKE :search
            OR producto LIKE :search 
            OR id LIKE :search) ";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
