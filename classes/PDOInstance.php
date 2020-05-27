<?php
class PDOInstance extends PDO
{

    public function __construct($driver, $host, $database, $username, $password)
    {
        try {
            $dsn = "$driver:host=$host;dbname=$database";
            $instance = parent::__construct($dsn, $username, $password);
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $instance;
        } catch (\Exception $e) {
            exit('Servidor en mantenci&oacute;n');
        }
    }
}