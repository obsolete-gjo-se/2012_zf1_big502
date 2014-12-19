<?php

class Admin_ResourceActionsController extends Big502_Controller_BaseController {

    /**
     * List and paginate all privileges
     *
     * URL: /admin/action
     */
    public function indexResourceActionsAction(){
        
        $entity = 'Big502\Entity\ResourceActionsEntity';
        $repositoryFunction = 'findAllActions';
        $viewvar = 'actions';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
        
        // TODO Pagination
        // $pagination = new Zend_Paginator(new
        // DoctrineExtensions\Paginate\PaginationAdapter($repository));
        // $pagination->setCurrentPageNumber($this->_getPage())
        // ->setItemCountPerPage(20)
        // ->setPageRange(10);
        
        // $this->view->$viewvar = $pagination;
    }

    /**
     * Create a new Action
     */
    public function createResourceActionsAction(){
        
        $request = $this->getRequest();
        // TODO RF
        $form = new Admin_Model_Forms_ActionsForm(null, $this->em);
        
        if($request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                
                $actions = new Big502\Entity\ResourceActionsEntity();
                
                $entity = 'Big502\Entity\ResourceControllersEntity';
                $repositoryFunction = 'findOneById';
                $param = 'resourceController';
                
                $controller = $this->em->getRepository($entity)->$repositoryFunction(
                        $request->getParam($param));
                
                $actions->name = $request->getParam('name');
                $actions->description = $request->getParam('description');
                $actions->resourceController = $controller;
                
                $this->em->persist($actions);
                $this->em->flush();
                
                // TODO Massege
                $this->_helper->messenger('success', 
                        sprintf(Zend_Registry::get('config')->messages->action->create, 
                                $actions->name, $request->getParam('name')));
                return $this->_redirect('/admin/action/create');
            } else {
                $this->view->errors = $form->getErrors();
            }
        }
        $this->view->form = $form;
    }

    /**
     * Update the Actions passed via the id GET param
     */
    public function updateResourceActionsAction(){
        
        $request = $this->getRequest();
        
        // TODO Zend_Form
        $form = new Admin_Model_Forms_ActionsForm(null, $this->em);
        $form->getElement('submit')->setLabel('Update Action');
        
        $entity = 'Big502\Entity\ResourceActionsEntity';
        $repositoryFunction = 'findOneById';
        $param = 'id';
        
        $action = $this->em->getRepository($entity)->$repositoryFunction($request->$param);
        
        if($action === null) {
            // TODO Massege
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->action->invalid);
            return $this->_redirect('/admin/action');
        } else {
            if($request->isPost()) {
                if($form->isValid($this->_request->getPost())) {
                    
                    $entity = 'Big502\Entity\ResourceControllersEntity';
                    $repositoryFunction = 'findOneById';
                    $param = 'resourceController';
                    
                    $controller = $this->em->getRepository($entity)->$repositoryFunction(
                            $request->$param);
                    
                    $action->name = $request->name;
                    $action->description = $request->description;
                    $action->resourceActions = $controller;
                    
                    $this->em->persist($action);
                    $this->em->flush();
                    
                    // TODO Massege
                    $this->_helper->messenger('success', 
                            sprintf(Zend_Registry::get('config')->messages->action->update, 
                                    $action->name, $request->getParam('name')));
                    return $this->_redirect('/admin/action');
                } else {
                    $this->view->errors = $form->getErrors();
                }
            } else {
                $formData = array(
                    "name" => $action->name, 
                    "description" => $action->description, 
                    "resourceController" => $action->resourceController->id
                );
                
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }

    /**
     * Delete the Action passed by the id GET param.
     */
    public function deleteResourceActionsAction(){
        
        $request = $this->getRequest();
        
        if(! isset($request->id)) {
            // TODO Massege
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->action->invalid);
            return $this->_redirect('/admin/action');
        }
        
        $entity = 'Big502\Entity\ResourceActionsEntity';
        $repositoryFunction = 'findOneById';
        $param = 'id';
        
        $action = $this->em->getRepository($entity)->$repositoryFunction($request->$param);
        
        if($action !== null) {
            
            $this->em->remove($action);
            $this->em->flush();
            
            // TODO Massege
            $controllerName = $action->resourceController->name;
            $actionName = $action->name;
            $this->_helper->messenger('success', 
                    sprintf(Zend_Registry::get('config')->messages->action->delete, $controllerName, 
                            $actionName));
            return $this->_redirect('/admin/action');
        } else {
            // TODO Massege
            $this->_helper->messenger('success', 
                    Zend_Registry::get('config')->messages->action->invalid);
            return $this->_redirect('/admin/action');
        }
    }

}