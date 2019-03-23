<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 17:24
 */

namespace Catalogo\Form;


use Zend\InputFilter\InputFilter;

class ProductoValidator extends InputFilter
{

    /**
     * ProductoValidator constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'id',
            'filters' => [
                ['name' => 'Int'],
            ],
        ]);
        $this->add([
            'name' => 'descripcion',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'Alnum',
                    'options' => [
                        'allowWhiteSpace' => true,
                    ],
                ],
            ],
        ]);
        $this->add([
            'name' => 'precio',
            'validators' => [
                [
                    'name' => 'Int',
                ],
            ],
        ]);
        $this->add([
            'name' => 'cantidad',
            'validators' => [
                [
                    'name' => 'Int',
                ],
            ],
        ]);
    }
}