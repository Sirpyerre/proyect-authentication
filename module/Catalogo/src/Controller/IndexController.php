<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Catalogo\Controller;

use Catalogo\Form\ProductoValidator;
use Catalogo\Model\Dao\IProductoDao;
use Catalogo\Model\Entity\Producto;
use Zend\Mvc\Controller\AbstractActionController;
use Catalogo\Form\Producto as ProductoForm;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $productoDao;

    public function __construct(IProductoDao $productoDao)
    {
        $this->productoDao = $productoDao;
    }

    public function indexAction()
    {
        return ['titulo' => 'Lista de productos',
            'productos' => $this->productoDao->obtenerTodos()];
    }

    public function crearAction()
    {
        $form = new ProductoForm('producto');
        $modelView = new ViewModel(['titulo' => 'Crear Producto', 'form' => $form]);
        $modelView->setTemplate('catalogo/index/form');
        return $modelView;
    }

    public function guardarAction()
    {
        if(!$this->request->isPost()){
            return $this->redirect()->toRoute('catalogo');
        }

        $form = new ProductoForm('producto');

        $form->setInputFilter(new ProductoValidator());
        $data = $this->request->getPost();

        $form->setData($data);

        if(!$form->isValid()){
            $modelView = new ViewModel(['titulo' => 'Validando Producto', 'form' => $form]);
            $modelView->setTemplate('catalogo/index/form');
            return $modelView;
        }

        $producto = new Producto();
        $producto->exchangeArray($form->getData());

        $this->productoDao->guardar($producto);
        return $this->redirect()->toRoute('catalogo');
    }

    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id){
            return $this->redirect()->toRoute('catalogo');
        }

        $form = new ProductoForm('producto');

        $producto = $this->productoDao->obtenerPorId($id);

        $form->bind($producto);
        $form->get('send')->setAttribute('value', 'Editar');
        $modelView = new ViewModel(['titulo' => 'Editar Producto', 'form' => $form]);
        $modelView->setTemplate('catalogo/index/form');
        return $modelView;
    }

    public function eliminarAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id){
            return $this->redirect()->toRoute('catalogo');
        }

        $producto = new Producto();
        $producto->setId($id);

        $this->productoDao->eliminar($producto);
        return $this->redirect()->toRoute('catalogo');
    }


}
