<?php
require_once('../conexion/conexion.php');

class ProductoModelo
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function obtenerProductos(){
        $query = "SELECT * FROM productos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProducto($id)
    {
        $query = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosDatatable($search, $orderColumn, $orderDir, $start, $length)
    {
        $query = "SELECT * FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE 1 = 1";
        if (!empty($search)) {
            $query .= " AND ( p.costo LIKE :search
            OR p.producto LIKE :search 
            OR p.id LIKE :search
            OR c.categoria LIKE :search)";
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
        FROM productos p JOIN categorias c ON p.categoria_id = c.id
        WHERE 1 = 1";
        if (!empty($search)) {
            $query .= " AND ( p.costo LIKE :search
            OR p.producto LIKE :search 
            OR p.id LIKE :search
            OR c.categoria LIKE :search) ";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function agregarProducto($producto, $url, $costo, $categoria_id)
    {
        $query = "INSERT INTO productos (producto, url, costo, categoria_id) VALUES (:producto, :url, :costo, :categoria_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        return $stmt->execute();
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
        $query = "UPDATE inventario SET stock= stock + :cantidad WHERE producto_id= :producto_id AND color_id= :color_id AND sucursal_id= :sucursal_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':color_id', $color_id, PDO::PARAM_INT);
        $stmt->bindParam(':sucursal_id', $sucursal_id, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad);
        return $stmt->execute();
    }
}
