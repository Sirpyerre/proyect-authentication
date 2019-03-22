<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 16:57
 */

namespace Catalogo\Model\Dao;


use Catalogo\Model\Entity\Producto;

interface IProductoDao
{
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function guardar(Producto $producto);
    public function eliminar(Producto $producto);
}