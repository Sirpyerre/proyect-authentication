<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 14:31
 */

namespace Usuarios\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Usuarios\Model\Login as LoginService;
use Usuarios\Form\Login as LoginForm;
use Usuarios\Form\LoginValidator;
use Zend\View\Exception\RuntimeException;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    private $login;

    /**
     * LoginController constructor.
     * @param $login
     */
    public function __construct(LoginService $login)
    {
        $this->login = $login;
    }

    public function indexAction()
    {
        return [
            'titulo' => 'Login',
            'form' => new LoginForm('login'),
            'identity' => $this->login->getIdentity()
        ];
    }

    public function autenticarAction()
    {
        if (!$this->request->isPost()) {
            $this->redirect()->toRoute('login', ['action' => 'index']);
        }
        $form = new LoginForm("login");
        $form->setInputFilter(new LoginValidator());
        $data = $this->request->getPost();
        $form->setData($data);

        if (!$form->isValid()) {
            $modelView = new ViewModel(['titulo' => 'Login', 'form' => $form]);
            $modelView->setTemplate('usuarios/login/index');
            return $modelView;
        }
        $values = $form->getData();

        try {

            $this->login->setMessage('El nombre de Usuario y Password no coinciden.', LoginService::NOT_IDENTITY);
            $this->login->setMessage('La contraseña ingresada es incorrecta. Inténtelo de nuevo.',
                LoginService::INVALID_CREDENTIAL);
            $this->login->setMessage('Los campos de Usuario y Password no pueden dejarse en blanco.',
                LoginService::INVALID_LOGIN);
            $this->login->login($values['email'], $values['password']);
            $this->flashMessenger()->addSuccessMessage('Has iniciado sesión con éxito.');

            return $this->redirect()->toRoute('login', ['action' => 'success']);
        } catch (RuntimeException $e) {

            $this->flashMessenger()->addErrorMessage('Login con error');
            $this->flashMessenger()->addErrorMessage($e->getMessage());

            return $this->redirect()->toRoute('login', ['action' => 'index']);
        }
    }

    public function successAction()
    {
        return ['titulo' => 'Página de exito'];
    }

    public function logoutAction()
    {
        $this->login->logout();
        $this->flashMessenger()->addSuccessMessage('Has cerrado sesión');
        return $this->redirect()->toRoute('login', ['action' => 'index']);
    }
}