<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 17:19
 */

namespace Catalogo\Form;


use Zend\Form\Form;
use Zend\Form\Element;

class Producto extends Form
{

    /**
     * Producto constructor.
     */
    public function __construct()
    {
        parent::__construct($name);
        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class,
        ]);
        $this->add([
            'type' => Element\Text::class,
            'name' => 'descripcion',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Descripcion',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);
        $this->add([
            'type' => Element\Text::class,
            'name' => 'precio',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Precio',
                'label_attributes' => [
                    'class' => 'col-sm-2 control-label',
                ],
            ],
        ]);
        $this->add([
            'type' => Element\Text::class,
            'name' => 'cantidad',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Cantidad',
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