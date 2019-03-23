<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 15:07
 */

namespace Usuarios\Form;


use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Form;

class Login extends Form
{

    /**
     * Login constructor.
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(['type' => Email::class,
            'name' => 'email',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Email',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]
        ]);

        $this->add([
            'type' => Password::class,
            'name' => 'password',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Password',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label'
                ]
            ]
        ]);

        $this->add([
            'name' => 'send',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-primary',
            ]
        ]);
    }
}