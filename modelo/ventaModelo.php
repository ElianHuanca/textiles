<?php

require_once('../conexion/conexion.php');
require_once('metodosModelo.php');

class VentaModelo
{
    private $db;
    private $metodosModelo;

    public function __construct()
    {
        $this->db = Conexion::conectar();
        $this->metodosModelo = new MetodosModelo();
    }

    public function obtenerVentasDatatable($search, $orderColumn, $orderDir, $start, $length)
    {
        $query = "SELECT v.*,s.sucursal
        FROM ventas v
        JOIN sucursales s ON s.id = v.sucursal_id
        WHERE 1 = 1 ";
        if (!empty($search)) {
            $query .= " AND ( v.fecha LIKE :search
            OR v.total_ganancias LIKE :search
            OR v.total LIKE :search 
            OR v.descuento LIKE :search
            OR s.sucursal LIKE :search
            OR v.id LIKE :search)";
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

    public function obtenerCantidadVentas($search)
    {
        $query = "SELECT COUNT(*) total 
        FROM ventas v
        JOIN sucursales s ON s.id = v.sucursal_id
        WHERE 1 = 1 ";
        if (!empty($search)) {
            $query .= " AND ( v.fecha LIKE :search
            OR v.total_ganancias LIKE :search
            OR v.total LIKE :search 
            OR v.descuento LIKE :search
            OR s.sucursal LIKE :search
            OR v.id LIKE :search)";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtenerVentaHoy($sucursal_id)
    {
        $query = "SELECT * FROM ventas WHERE DATE(fecha) = CURDATE() AND sucursal_id = :sucursal_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sucursal_id', $sucursal_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearVenta($data, $tabla = 'ventas')
    {
        return $this->metodosModelo->crear($data, $tabla);
    }

    public function actualizarVenta($id, $data, $tabla = 'ventas')
    {
        return $this->metodosModelo->editar($id, $data, $tabla);
    }

    public function actualizarProductoVenta($id, $data, $tabla = 'venta_producto')
    {
        return $this->metodosModelo->editar($id, $data, $tabla);
    }

    public function crearProductoVenta($data, $tabla = 'venta_producto')
    {
        return $this->metodosModelo->crear($data, $tabla);
    }
}
