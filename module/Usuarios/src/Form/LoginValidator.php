<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 15:06
 */

namespace Usuarios\Form;


use Zend\InputFilter\InputFilter;

class LoginValidator extends InputFilter
{

    /**
     * LoginValidator constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'email',
            'validators' => [
                [
                    'name' => 'EmailAddress',

                ]
            ]
        ]);

        $this->add([
            'name' => 'password',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 4,
                        'max' => 8
                    ]

                ],
                [
                    'name' => 'Alnum'
                ]
            ]
        ]);
    }
}