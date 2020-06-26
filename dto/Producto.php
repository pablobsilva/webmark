<?php

class Producto {

    private $id;
    private $nombre;
    private $precio;
    private $codigodebarra;
    private $stock;
    private $categoria;
    

    public function getId()
    {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function getCodigodebarra()
    {
        return $this->codigodebarra;
    }
    public function setCodigodebarra($codigodebarra){
        $this->codigodebarra = $codigodebarra;
    }

    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock){
        $this->stock = $stock;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

}