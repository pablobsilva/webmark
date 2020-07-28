<?php

class Empresa
{

    private $id;
    private $nombre;
    private $direccion; 
    private $giro;
    private $correo;
    private $telefono;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    
    public function getnombre()
    {
        return $this->nombre;
    }
    public function setnombre($nombre){
        $this->nombre = $nombre;
    }

    public function getdireccion()
    {
        return $this->direccion;
    }
    public function setdireccion($direccion){
        $this->direccion = $direccion;
    }

    public function getgiro()
    {
        return $this->giro;
    }
    public function setgiro($giro){
        $this->giro = $giro;
    }

    public function getcorreo()
    {
        return $this->correo;
    }
    public function setcorreo($correo){
        $this->correo = $correo;
    }

    public function gettelefono()
    {
        return $this->telefono;
    }
    public function settelefono($telefono){
        $this->telefono = $telefono;
    }


}