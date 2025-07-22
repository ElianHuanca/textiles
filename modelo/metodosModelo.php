<?php
class MetodosModelo
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
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
            return false;
        }
    }
}
