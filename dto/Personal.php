<?php

class Personal {

    private $rut;
    private $nombre;
    private $apellidoMaterno;
    private $apellidoPaterno;

    public function getRut()
    {
        return $this->rut;
    }
    public function setRut($rut)
    {
        return $this->rut = $rut;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        return $this->nombre = $nombre;
    }

    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }
    public function setApellidoMaterno($apellidoMaterno)
    {
        return $this->apellidoMaterno = $apellidoMaterno;
    }

    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }
    public function setApellidoPaterno($apellidoPaterno)
    {
        return $this->apellidoPaterno = $apellidoPaterno;
    }



}