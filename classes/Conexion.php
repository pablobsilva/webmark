<?php
class Conexion
{
    private static $db;

    public static function retornar()
    {
        if (!self::$db) {
            include 'PDOInstance.php';
            $driver = 'mysql';
            $host = '127.0.0.1';
            $dbname = 'mydb';
            $user = 'root';
            $pass = '';
            $connection = new PDOInstance($driver, $host, $dbname, $user, $pass);
            $connection->query("SET NAMES 'utf8'");
            self::$db = $connection;
        }
        return self::$db;
    }
}