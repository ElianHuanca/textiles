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

    public function obtenerCosto($producto_id){
        $query = "SELECT costo FROM productos WHERE id= :producto_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['costo'];
    }

    public function actualizarCosto($producto_id, $costo){
        $query = "UPDATE productos SET costo= :costo WHERE id= :producto_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':costo', $costo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function actualizarStock($producto_id,$color_id,$sucursal_id, $cantidad){
        $query = "UPDATE inventario SET stock= stock + :cantidad WHERE id= :producto_id AND color_id= :color_id AND sucursal_id= :sucursal_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':color_id', $color_id, PDO::PARAM_INT);
        $stmt->bindParam(':sucursal_id', $sucursal_id, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad);
        return $stmt->execute();
    }
}
