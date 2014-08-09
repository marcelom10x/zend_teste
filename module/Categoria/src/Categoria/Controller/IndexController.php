<?php

namespace Categoria\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function __construct() {
        $this->form = 'Categoria\Form\CategoryForm';
        $this->controller = 'categoria';
        $this->route = 'categoria/default';
        $this->service = '';
        $this->entity = 'Categoria\Entity\Category';
    }
    
    public function indexAction() 
    {
        $config = $this->getServiceLocator()->get('Config');
        var_dump($config['doctrine']); die;
    }

    

}