<?php
require_once('../conexion/conexion.php');
require_once('../modelo/metodosModelo.php');

class ColorModelo
{
    private $db;
    private $metodosModelo;

    public function __construct()
    {
        $this->db = Conexion::conectar();
        $this->metodosModelo = new MetodosModelo();
    }

    public function obtenerColores()
    {
        $query = "SELECT * FROM colores";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerColoresDatatable($search, $orderColumn, $orderDir, $start, $length)
    {
        $query = "SELECT * FROM colores WHERE 1 = 1";
        if (!empty($search)) {
            $query .= " AND ( color LIKE :search
            OR codigo LIKE :search)";
        }
        $query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :length";
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $query .= " AND ( color LIKE :search
            OR codigo LIKE :search)";
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

    public function obtenerCantidadColores($search)
    {
        $query = "SELECT COUNT(*) total 
        FROM colores
        WHERE 1 = 1";
        if (!empty($search)) {
            $query .= " AND ( color LIKE :search
            OR codigo LIKE :search)";            
        }
        $stmt = $this->db->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function crearColor($data, $tabla = 'colores')
    {
        return $this->metodosModelo->crear($data, $tabla);
    }
}
