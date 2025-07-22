<?php

class CompraModelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function obtenerComprasDatatable($search, $orderColumn, $orderDir, $start, $length)
    {
        $query = "SELECT c.*,s.sucursal
        FROM compras c
        JOIN sucursales s ON s.id = c.sucursal_id
        WHERE 1 = 1 ";
        if (!empty($search)) {
            $query .= " AND ( c.fecha LIKE :search
            OR c.total LIKE :search 
            OR c.total_gastos LIKE :search
            OR s.sucursal LIKE :search
            OR c.id LIKE :search)";
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

    public function obtenerCantidadCompras($search)
    {
        $query = "SELECT COUNT(*) total 
        FROM compras c
        JOIN sucursales s ON s.id = c.sucursal_id
        WHERE 1 = 1 ";
        if (!empty($search)) {
            $query .= " AND ( c.fecha LIKE :search
            OR c.total LIKE :search 
            OR c.total_gastos LIKE :search
            OR s.sucursal LIKE :search
            OR c.id LIKE :search)";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtenerCompraProducto($compra_id){
        $query = "SELECT cp.*
        FROM compra_producto cp        
        WHERE cp.compra_id= :compra_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':compra_id', $compra_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCompra($id)
    {
        $query = "SELECT * FROM compras WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function eliminar($id){
        try {
            $query = "DELETE FROM compras WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
