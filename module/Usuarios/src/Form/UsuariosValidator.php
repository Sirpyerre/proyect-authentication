<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 12:36
 */

namespace Usuarios\Form;


use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

class UsuariosValidator extends InputFilter
{

    public function __construct()
    {
        $this->add([
            'name' => 'id',
            'filters' => [
                ['name' => 'Int'],
            ],
        ]);

        $this->add([
            'name' => 'nombre',
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
            'name' => 'apellido',
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
            'name' => 'email',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS,
                        'useMxCheck'
                    ],
                ],
            ],
        ]);
    }
}