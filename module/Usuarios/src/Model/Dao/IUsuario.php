<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 9:15
 */

namespace Usuarios\Model\Dao;


use Usuarios\Model\Entity\Usuario;

interface IUsuario
{
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Usuario $usuario);
    public function eliminar(Usuario $usuario);
}