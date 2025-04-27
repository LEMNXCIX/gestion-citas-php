<?php

class Contenedor
{
    private $instancias = [];

    public function registrar($nombre, $resolver)
    {
        $this->instancias[$nombre] = $resolver;
    }

    public function resolver($nombre)
    {
        if (!isset($this->instancias[$nombre])) {
            throw new Exception("No se encontro la dependencia: $nombre");
        }

        return call_user_func($this->instancias[$nombre]);
    }
}