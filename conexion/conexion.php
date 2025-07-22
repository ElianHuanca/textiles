<?php

class Conexion
{
    private static $dbHost = "localhost";
    private static $dbName = "textiles";
    private static $dbUsername = "root";
    private static $dbPassword = "";

    public static function conectar()
    {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8",
                self::$dbUsername,
                self::$dbPassword
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
}
