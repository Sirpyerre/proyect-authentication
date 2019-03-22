<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 10:13
 */

namespace Usuarios\Model\Entity;


class Usuario
{
    private $id, $nombre, $apellido;

    public function __construct($id, $nombre, $apellido)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }
}