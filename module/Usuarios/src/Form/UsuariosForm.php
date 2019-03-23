<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 12:36
 */

namespace Usuarios\Form;


use Zend\Form\Form;
use Zend\Form\Element;

class UsuariosForm extends Form
{

    public function __construct()
    {
        parent::__construct($name);
        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'nombre',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'nombre',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'apellido',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'apellido',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'email',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'E-mail',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Crear',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}