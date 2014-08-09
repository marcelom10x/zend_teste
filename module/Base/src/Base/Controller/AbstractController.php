<?php

namespace Base\Controller;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    
    abstract function __construct();
    /**
     * Lista Resultados
     * @return array|void
     */
    public function indexAction()
    {
        $list = $this->getEM()->getRepository($this->entity)->findAll();
        return new ViewModel(array('data' => $list));
    }
    
    public function inserirAction()
    {
        
        if(is_string($this->form))
            $form = new $this->form;
        else
            $form = $this->form;
        
        $request = $this->getRequest();
        if($request->isPost())
        {
            $form->setData($request->getPost());
            
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                
                if($service->save($request->getPost()->toArray()))
                {
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                    
                }
                else
                {
                    $this->flashMessenger()->addErrorMessage('Não foi possível cadastrar!');
                }
                
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }
        
        if($this->flashMessenger()->hasSuccessMessages())
            return new ViewModel(array('form' => $form, 'success' => $this->flashMessenger()->getSuccessMessages()));
        if($this->flashMessenger()->hasErrorMessages())
            return new ViewModel(array('form' => $form, 'error' => $this->flashMessenger()->getErrorMessages()));
        
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel(array('form' => $form));
    }
    
    public function editarAction()
    {
        if(is_string($this->form))
            $form = new $this->form;
        else
            $form = $this->form;
        
        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);
        
        $repository = $this->getEM()->getRepository($this->entity)->find($param);
        
        if($repository)
        {
            $array = array();
            foreach($repository->toArray() as $key => $value)
            {
                if($value instanceof \DateTime)
                    $array[$key] = $value->format('d/m/Y');
                else
                    $array[$key] = $value;
            }
            
            $form->setData($array);
            
            if($repository->isPost())
            {
                $form->setData($request->getPost());
            
                if($form->isValid())
                {
                    $service = $this->getServiceLocator()->get($this->service);

                    $data = $request->getPost()->toArray();
                    $data['id'] = (int) $param;
                    
                    if($service->save($data))
                    {
                        $this->flashMessenger()->addSuccessMessage('Atualizado com sucesso!');

                    }
                    else
                    {
                        $this->flashMessenger()->addErrorMessage('Não foi possível atualizar!');
                    }

                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
                }
            }
            
        }
        else
        {
            $this->flashMessenger()->addInfoMessage('Resgistro não foi encontrado');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
        
        if($this->flashMessenger()->hasSuccessMessages())
            return new ViewModel(array('form' => $form, 
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param));
        if($this->flashMessenger()->hasErrorMessages())
            return new ViewModel(array('form' => $form, 'error' => $this->flashMessenger()->getErrorMessages(), 'id' => $param));
        
        if($this->flashMessenger()->hasInfoMessages())
            return new ViewModel(array('form' => $form, 'warning' => $this->flashMessenger()->getInfoMessages(), 'id' => $param));
       
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel(array('form' => $form, 'id' => $param));
    }
    /**
     * 
     * @return |Zend|Http|Response
     */
    public function excluirAction()
    {
        $service = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);
        
        if($service->remove(array('id' => $id)))
            $this->flashMessenger ()->addSuccessMessage ('Registro deletado com sucesso!');
        else
            $this->flashMessenger ()->addErrorMessage ('Não foi posssicel deletar o registro');
        
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        
    }
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEM()
    {
        if($this->em == null)
        {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        
        return $this->em;
    }
}
