<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuarios\Controller;

use Usuarios\Form\UsuariosForm;
use Usuarios\Form\UsuariosValidator;
use Usuarios\Model\Dao\IUsuario;
use Usuarios\Model\Entity\Usuario;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class IndexController extends AbstractActionController
{
    private $listaUsuario;
    private $config;

    public function __construct(IUsuario $usuarioDao, array $config)
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

    public function crearAction()
    {
        $form = new UsuariosForm('usuario');
        $viewModel = new ViewModel(['titulo' => 'Nuevo Usuario', 'form' => $form]);
        $viewModel->setTemplate('usuarios/index/form');
        return $viewModel;
    }

    public function guardarAction()
    {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('usuarios');
        }

        $form = new UsuariosForm('usuario');
        $form->setInputFilter(new UsuariosValidator());
        $data = $this->request->getPost();
        $form->setData($data);

        if (!$form->isValid()) {
            $viewModel = new ViewModel(['titulo' => 'Validando Usuario', 'form' => $form]);
            $viewModel->setTemplate('usuarios/index/form');
            return $viewModel;
        }

        $usuario = new Usuario();
        $usuario->exchangeArray($form->getData());
        $this->listaUsuario->guardar($usuario);
        return $this->redirect()->toRoute('usuario');
    }

    public function editarAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('usuario');
        }

        $form = new UsuariosForm('usuario');
        $usuario = $this->listaUsuario->obtenerPorId($id);
        $form->bind($usuario);
        $form->get('send')->setAttribute('value', 'Editar');
        $view = new ViewModel(['title' => 'Editar Usuario', 'form' => $form]);
        $view->setTemplate('usuarios/index/form');
        return $view;
    }

    public function eliminarAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id){
            return $this->redirect()->toRoute('usuario');
        }

        $usuario = new Usuario();
        $usuario->setId($id);

        $this->listaUsuario->eliminar($usuario);
        return $this->redirect()->toRoute('usuario');
    }

    public function verAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $resultado = $this->listaUsuario->obtenerPorId($id);

        $view = new ViewModel(['usuario' => $resultado,
            'titulo' => "Detalle index"]);
        $view->setTerminal(true);
        return $view;
    }
}
