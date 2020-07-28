<?php

class Usuario 
{

    private $usuario;
    private $pass; 

    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    
    public function getPass()
    {
        return $this->pass;
    }
    public function setPass($pass){
        $this->pass = $pass;
    }


}