<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuarios\Controller;

use Usuarios\Model\Dao\UsuarioDao;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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
            'titulo' => $this->config['parametros']['mvc']['usuario']['titulo']
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
