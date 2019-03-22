<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 10:11
 */

namespace Application\Controller;


use Application\Model\Entity\Usuario;
use ArrayObject;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractActionController
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
    }


    public function indexAction()
    {
        return $this->redirect()->toRoute('usuario', ['action' => 'listar']);
    }

    public function listarAction()
    {
        return new ViewModel([
            'listaUsuario' => $this->listaUsuario,
            'titulo' => 'Lista de usuarios'
        ]);
    }

    public function verAction()
    {
        $id =(int) $this->params()->fromRoute('id',0);

        $result = null;

        foreach ($this->listaUsuario as $usuario) {
            if($usuario->getId() == $id) {
                $resultado = $usuario;
                break;
            }
        }
        return new ViewModel(['usuario' => $resultado,
            'titulo' => "Detalle usuario"]);
    }
}