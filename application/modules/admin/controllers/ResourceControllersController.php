<?php

class Admin_ResourceControllersController extends Big502_Controller_BaseController {

    /**
     * List all controllers with pagination
     *
     * URL: /admin/controllers
     */
    public function indexResourceControllersAction(){
        
        $entity = 'Big502\Entity\ResourceControllersEntity';
        $repositoryFunction = 'findAllControllers';
        $viewvar = 'controllers';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
    }

    public function createResourceControllersAction(){
        
        $form = new Admin_Model_Forms_ControllersForm();
        $form->setAction('/admin/controller/create');
        
        if($this->getRequest()->isPost()) {

            if($form->isValid($this->_request->getPost())) {

                $controllers = new Big502\Entity\ResourceControllersEntity();
                $controllers->module = $form->getValue('module');
                $controllers->name = $form->getValue('name');
                $controllers->description = $form->getValue('description');
                $controllers->activeOnDev = in_array('dev', $form->getValue('zones'));
                $controllers->activeOnProduction = in_array('prod', $form->getValue('zones'));
                
                $this->em->persist($controllers);
                $this->em->flush();
                
                // Display message and redirect back to index
                // TODO Zend_Form: Messages
                $this->_helper->messenger('success', 
                        sprintf(Zend_Registry::get('config')->messages->controllers->create, 
                                $form->getValue('name')));
                return $this->_redirect('/admin/controller/create');
            
            } else {
                // Assign errors to view
                $this->view->errors = $form->getErrors();
            }
        }
        
        // Display form
        $this->view->form = $form;
    }

    /**
     * Update the Controller passed via the 'id' GET param
     *
     * URL: /admin/controller/update/?
     */
    
    public function updateResourceControllersAction(){
        
        $request = $this->getRequest();
        
        // TODO Zend_Form überarbeiten
        $form = new Admin_Model_Forms_ControllersForm();
        // TODO Zend_Form: kommt hier ohne action atribute aus: was ist bei
        // Falscheingaben?
        // zB $form->setAction('/admin/controller/update (id wie?)'); - auf sich
        // selbst
        $form->getElement('submit')->setLabel('Update Controller');
        
        $entity = 'Big502\Entity\ResourceControllersEntity';
        $controller = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($controller === null) {
            // TODO Messages
            $this->_helper->messenger('error', 'Invalid Controller');
            return $this->_redirect('/admin/controller');
        } else {
            if($request->isPost()) {
                if($form->isValid($this->_request->getPost())) {
                    
                    $controllerName = $controller->name;
                    $controller->module = $form->getValue('module');
                    $controller->name = $form->getValue('name');
                    $controller->description = $form->getValue('description');
                    $controller->activeOnDev = in_array('dev', $form->getValue('zones'));
                    $controller->activeOnProduction = in_array('prod', $form->getValue('zones'));
                    
                    $this->em->persist($controller);
                    $this->em->flush();
                    
                    // TODO Messages
                    $this->_helper->messenger('success', 
                            sprintf(Zend_Registry::get('config')->messages->controller->update, 
                                    $controllerName));
                    return $this->_redirect('/admin/controller');
                } else {
                    // Assign errors to view
                    $this->view->errors = $form->getErrors();
                }
            } else {
                // Populate zones array
                $zones = array();
                ($controller->activeOnDev == '1' ? $zones[] = 'dev' : null);
                ($controller->activeOnProduction == '1' ? $zones[] = 'prod' : null);
                
                // Populate form
                $formData = array(
                    "module" => $controller->module,
                    "name" => $controller->name, 
                    "description" => $controller->description, 
                    "zones" => $zones
                );
                
                $form->populate($formData);
            }
        }
        
        // Display form
        $this->view->form = $form;
    }

    /**
     * Delete the flag passed by the 'id' GET param
     *
     * URL: /backoffice/flag/delete/id/?
     */
    public function deleteResourceControllersAction(){
        
        $request = $this->getRequest();
        
        if(! isset($request->id)) {
            // TODO Messages
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/controller');
        }
        
        $entity = 'Big502\Entity\ResourceControllersEntity';
        $controller = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($controller !== null) {
            
            $this->em->remove($controller);
            $this->em->flush();
            
            // TODO Message
            $controllerName = $controller->name;
            $this->_helper->messenger('success', 
                    sprintf(Zend_Registry::get('config')->messages->controller->delete, 
                            $controllerName));
            return $this->_redirect('/admin/controller');
        } else {
            
            // TODO Message
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/controller');
        }
    }

    /**
     * Toggle which zone the flag is enabled on.
     * By passing the 'id' and 'zone' GET param, this
     * method will enable the flag on the zone if the
     * flag is disabled, and vica-versa
     * 
     * TODO die URL ansehen
     * URL: /admin/controller/toggle/zone/?/id/?
     */
    public function toggleResourceControllersAction(){
        
        $request = $this->getRequest();
        
        //$this->view = var_dump($request);
        
        // TODO Massege
        // TODO getParam('xyz') - einheitlich ersetzen mit $request->xyz (in OOP Manier) 
        if($request->zone === null || $request->id === null) {
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/controller');
        }
        
        $entity = 'Big502\Entity\ResourceControllersEntity';
        $controller = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($controller !== null) {
            $controllerName = $controller->name;
            
            // TODO tausch mit $request->zone
            switch ($request->getParam('zone')) {
                case 'dev':
                    $zone = 'development';
                    $currentState = $controller->activeOnDev;
                    $controller->activeOnDev =! $currentState;
                    break;
                case 'prod':
                    $zone = 'production';
                    $currentState = $controller->activeOnProduction;
                    $controller->activeOnProduction =! $currentState;
                    break;
                default:
                    
                    break;
            }
            
            $this->em->persist($controller);
            $this->em->flush();
            
            // TODO Massege
            $this->_helper->messenger('success', 
                    sprintf(Zend_Registry::get('config')->messages->controller->toggle, $controllerName, 
                            (! $currentState ? 'enabled' : 'disabled'), $zone));
            return $this->_redirect('/admin/controller');
        } else {
            // TODO Massege
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/controller');
        }
    }

}