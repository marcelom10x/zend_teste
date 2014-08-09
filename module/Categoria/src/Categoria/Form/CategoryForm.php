<?php

namespace Categoria\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;
use Zend\Form\Form;

class CategoryForm extends Form 
{
    public function __construct() 
    {
        parent::__construct(null);
        $this->setAttribute('method', 'POST');
        
        $nome = new Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes(array(
                    'maxlength' => 45
                ));
        $this->add($nome);
        $button = new Button('submit');
        $button->setLabel('salvar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn'
                ));
        
        $this->add($button);
        
    }
}
