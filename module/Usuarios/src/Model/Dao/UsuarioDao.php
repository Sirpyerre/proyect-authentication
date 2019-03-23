<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 9:20
 */

namespace Usuarios\Model\Dao;

use Usuarios\Model\Entity\Usuario;
use Zend\Db\TableGateway\TableGateway;

class UsuarioDao implements IUsuario
{
    protected $tableGateway;

    /**
     * UsuarioDao constructor.
     * @param $tableGateway
     */
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
        $rowSet = $this->tableGateway->select(['id' => $id]);
        $row = $rowSet->current();
        if (!$row) {
            throw new \Exception("No se pudo encontrar el usuario: $id");
        }

        return $row;
    }

    public function guardar(Usuario $usuario)
    {
        $data = [
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'email' => $usuario->getEmail(),
            'password' => $usuario->getPassword()
        ];

        $id = (int)$usuario->getId();

        if ($id == 0){
            $this->tableGateway->insert($data);
        } else {
            if($this->obtenerPorId($id)){
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new \RuntimeException("Id del usuario no existe");
            }
        }
    }

    public function eliminar(Usuario $usuario)
    {
       $this->tableGateway->delete(['id'=> $usuario->getId()]);
    }

}