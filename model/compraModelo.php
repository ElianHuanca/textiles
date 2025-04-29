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
        $query = "SELECT *
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

    public function crear($data, $tabla)
    {
        try {
            $columns = '';
            $placeholders = '';
            foreach ($data as $key => $value) {
                $columns .= "$key, ";
                $placeholders .= ":$key, ";
            }
            $columns = rtrim($columns, ', ');
            $placeholders = rtrim($placeholders, ', ');

            $query = "INSERT INTO $tabla ($columns) VALUES ($placeholders)";

            $stmt = $this->db->prepare($query);

            foreach ($data as $key => &$value) {
                $stmt->bindParam(":$key", $value);
            }

            $stmt->execute();
            $lastInsertId = $this->db->lastInsertId();
            if ($lastInsertId) {
                $data['id'] = $lastInsertId;
            }
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Retorna false en caso de error
        }
    }
}
