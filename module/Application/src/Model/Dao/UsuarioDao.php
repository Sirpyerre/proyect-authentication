<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 11:00
 */

namespace Application\Model\Dao;


use Application\Model\Entity\Usuario;
use ArrayObject;

class UsuarioDao
{
    private $listaUsuario;

    public function __construct()
    {
        $this->listaUsuario = new ArrayObject();

        $this->listaUsuario->append(new Usuario(1, "Andres", "Guzman"));
        $this->listaUsuario->append(new Usuario(2, "Linus", "Torvalds"));
        $this->listaUsuario->append(new Usuario(3, "Steve", "Jobs"));
        $this->listaUsuario->append(new Usuario(4, "Rasmus", "Lerdorf"));
        $this->listaUsuario->append(new Usuario(5, "Erich", "Gamma"));
        $this->listaUsuario->append(new Usuario(6, "Richard", "Helm"));
        $this->listaUsuario->append(new Usuario(7, "Ralph", "Johnson"));
        $this->listaUsuario->append(new Usuario(8, "John", "Vlissides"));
        $this->listaUsuario->append(new Usuario(9, "James", "Gosling"));
        $this->listaUsuario->append(new Usuario(10, "Bruce", "Lee"));
        $this->listaUsuario->append(new Usuario(11, "Peter", "Parker"));
    }

    public function obtenerTodos()
    {
        return $this->listaUsuario;
    }

    public function obtenerPorId($id)
    {
        $resultado = null;
        foreach ($this->listaUsuario as $usuario) {
            if($usuario->getId() == $id) {
                $resultado = $usuario;
                break;
            }
        }

        return $resultado;
    }
}