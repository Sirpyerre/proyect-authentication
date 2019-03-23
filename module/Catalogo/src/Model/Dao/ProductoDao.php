<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 17:00
 */

namespace Catalogo\Model\Dao;


use Catalogo\Model\Entity\Producto;
use Zend\Db\TableGateway\TableGateway;

class ProductoDao implements IProductoDao
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function obtenerTodos()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function obtenerPorId($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \RuntimeException("No se pudo encontrar el producto: $id");
        }

        return $row;
    }

    public function guardar(Producto $producto)
    {
        $data = ['descripcion' => $producto->getDescripcion(),
            'cantidad' => $producto->getCantidad(),
            'precio' => $producto->getPrecio()
        ];

        $id = (int)$producto->getId();

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \RuntimeException('Id del producto no existe');
            }
        }
    }

    public function eliminar(Producto $producto)
    {
        $this->tableGateway->delete(['id' => $producto->getId()]);
    }

}