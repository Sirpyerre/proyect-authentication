<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 10:11
 */

namespace Application\Controller;


use Application\Model\Dao\UsuarioDao;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractActionController
{
    private $listaUsuario;
    private $config;

    public function __construct(UsuarioDao $usuarioDao, array $config)
    {
        $this->listaUsuario = $usuarioDao;
        $this->config = $config;
    }

    public function indexAction()
    {
        return $this->redirect()->toRoute('usuario', ['action' => 'listar']);
    }

    public function listarAction()
    {
        $layout = $this->layout();
        $layout->algunaVariable = 'Hola, alguna variable para el layout';
//        $layout->setTemplate('layout/layout_otro');
        return new ViewModel([
            'listaUsuario' => $this->listaUsuario->obtenerTodos(),
            'titulo' => $this->config['parametros']['mvc']['index']['titulo']
        ]);
    }

    public function verAction()
    {
        $id =(int) $this->params()->fromRoute('id',0);

        $resultado = $this->listaUsuario->obtenerPorId($id);

        $view = new ViewModel(['usuario' => $resultado,
            'titulo' => "Detalle index"]);
        $view->setTerminal(true);
        return $view;
    }
}