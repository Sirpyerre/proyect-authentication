<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 9:50
 */

namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CursoController extends AbstractActionController
{

    public function listarAction()
    {
        return new ViewModel([
            'cursos' => [
                'Symfony 3', 'Laravel 5', 'Zend Framework 3', 'CodeIgniter 3'
            ],
            'Titulo' => 'Listar acción',
            'Fecha' => new \DateTime('now')
        ]);
    }
}