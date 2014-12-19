<?php

class Admin_RolesController extends Big502_Controller_BaseController {

    /**
     * Display all groups with pagination
     *
     * URL: /backoffice/group/index
     */
    public function indexRolesAction(){
        
        $entity = 'Big502\Entity\RolesEntity';
        $repositoryFunction = 'findAllRoles';
        $viewvar = 'roles';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
    }

    /**
     * Create a new Role
     */
    public function createRolesAction(){
        
        $request = $this->getRequest();
        
        $form = new Admin_Model_Forms_RolesForm($this->em);
        
        if($request->isPost()) {
            if($form->isValid($request->getParams())) {
                
                $role = new Big502\Entity\RolesEntity();
                $role->name = $request->name;
                
                if($request->parentRole != '') {
                    $role->parent = $this->em->getReference('Big502\Entity\RolesEntity', 
                            $request->parentRole);
                }
                
                $this->em->persist($role);
                $this->em->flush();
                
                // TODO Massege
                $this->_helper->messenger('success', 
                        sprintf(Zend_Registry::get('config')->messages->role->create, 
                                $request->name));
                return $this->_redirect('/admin/role/create');
            } else {
                $this->view->errors = $form->getErrors();
            }
        }
        $this->view->form = $form;
    }

    /**
     * Update the Role passed by the 'id' GET parameter
     */
    public function updateRolesAction(){
        
        $isInvalid = false;
        $request = $this->getRequest();
        
        if($request->id) {
            
            $entity = 'Big502\Entity\RolesEntity';
            $repositoryFunction = 'findOneById';
            
            $role = $this->em->getRepository($entity)->$repositoryFunction($request->id);
            
            // TODO Zend_Form - scheint mir ein wneig durcheinander
            if($role !== null) {
                
                $form = new Admin_Model_Forms_RolesForm($this->em);
                $form->getElement('submit')->setLabel('Update Role');
                
                if($request->isPost()) {
                    if($form->isValid($request->getParams())) {
                        $role->name = $request->name;
                        
                        if($request->parentRole)
                            $role->parent = $this->em->getReference('Big502\Entity\RolesEntity', 
                                    $request->parentRole);
                        
                        $this->em->persist($role);
                        $this->em->flush();
                        
                        // TODO Masseges
                        $this->_helper->messenger('success', 
                                sprintf(Zend_Registry::get('config')->messages->role->update, 
                                        $request->name));
                        return $this->_redirect('/admin/role');
                    } else {
                        $this->view->errors = $form->getErrors();
                    }
                }
                $formData['name'] = $role->name;
                if($role->parent !== null) {
                    
                    $formData['parentRole'] = $role->parent->id;
                }
                
                $form->populate($formData);
                $this->view->form = $form;
            } else {
                $isInvalid = true;
            }
        } else {
            $isInvalid = true;
        }
        
        // TODO Massege
        if($isInvalid) {
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->role->invalid);
            return $this->_redirect('/admin/role');
        }
    }

    /**
     * Delete the Role passed by the 'id' GET parameter
     */
    public function deleteRolesAction(){
        
        $request = $this->getRequest();
        
        if(! isset($request->id)) {
            // TODO Massege (Helper bauen??!)
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->role->invalid);
            return $this->_redirect('/admin/role');
        }
        
        $entity = 'Big502\Entity\RolesEntity';
        $repositoryFunction = 'findOneById';
        
        $role = $this->em->getRepository($entity)->$repositoryFunction($request->id);
        
        if($role !== null) {
            // TODO Cascade - hier anders gelöst (Kinder vorher manuell löschen)
            if(count($role->rules)) {
                // Masseges
                $this->_helper->messenger('error', 
                        'Unable to remove group. Please remove dependencies first (Manual)');
                return $this->_redirect('/admin/role');
            }
            
            $roleName = $role->name;
            
            $this->em->remove($role);
            $this->em->flush();
            
            // TODO Masseges
            $this->_helper->messenger('success', 
                    sprintf(Zend_Registry::get('config')->messages->role->delete, $roleName));
            return $this->_redirect('/admin/role');
        } else {
            // TODO Masseegs
            $this->_helper->messenger('success', 
                    Zend_Registry::get('config')->messages->role->invalid);
            return $this->_redirect('/admin/role');
        }
    }

    /**
     * Edit the rules for the role passed by GET param 'id'
     * This method will create rules if they do not exist.
     * Any checkboxes that are not ticked will be handled as 'deny',
     * ticked checkboxes are handled as 'allow' in the ACL
     */
    public function rulesAction(){
        
        $request = $this->getRequest();
        
        if($request->id) {
            
            $entity = 'Big502\Entity\RolesEntity';
            $repositoryFunction = 'findOneById';
            
            $role = $this->em->getRepository($entity)->$repositoryFunction($request->id);
            
            if($role !== null) {
                
                $form = new Admin_Model_Forms_RolesRulesForm($this->em);
                
                if($request->isPost()) {
                    
                    if($form->isValid($request->getParams())) {
                        
                        $formValues = $form->getValues();
                        Zend_Debug::dump($formValues);
                        
                        foreach ($formValues['rule'] as $controllerId => $resourceActionsAccess) {
                            
                            $entity = 'Big502\Entity\ResourceControllersEntity';
                            $repositoryFunction = 'findOneById';
                            
                            $controller = $this->em->getRepository($entity)->$repositoryFunction(
                                    $controllerId);
                            
                            foreach ($resourceActionsAccess as $actionId => $allow) {
                                
                                $entity = 'Big502\Entity\RulesEntity';
                                $repositoryFunction = 'findOneBy';
                                
                                $rule = $this->em->getRepository($entity)->$repositoryFunction(
                                        array(
                                            'resourceAction' => $actionId, 
                                            'resourceController' => $controllerId, 
                                            'role' => $role->id
                                        ));
                                
                                if($rule === null) {
                                    
                                    $rule = new Big502\Entity\RulesEntity();
                                    
                                    $rule->resourceAction = $this->em->getReference(
                                            'Big502\Entity\ResourceActionsEntity', $actionId);
                                    
                                    $rule->resourceController = $this->em->getReference(
                                            'Big502\Entity\ResourceControllersEntity', $controllerId);                                    $rule = new Big502\Entity\RulesEntity();

                                    $rule->role = $this->em->getReference(
                                            'Big502\Entity\RolesEntity', $role->id);
                                }
                                
                                // Set allow/deny on privilege
                                $rule->allow = ($allow == '1' ? true : false);
                                
                                $this->em->persist($rule);
                                $this->em->flush();
                                
                                unset($rule);
                            }
                        }
                        
                        Big502_Acl_Manager::save();

                        // TODO Masseges
                        $this->_helper->messenger('success', 
                                sprintf(
                                        Zend_Registry::get('config')->messages->role->rule->update, 
                                        $role->name));
                        return $this->_redirect('/admin/role');
                    }
                }
                
                $entity = 'Big502\Entity\RulesEntity';
                $repositoryFunction = 'getRulesForRole';
                
                $rules = $this->em->getRepository($entity)->$repositoryFunction($role->id);
                
                $form->populate($rules, $role->id);
                $this->view->roleName = $role->name;
                $this->view->form = $form;
            } else {
                // TODO Masseges
                $this->_helper->messenger('error', 'Invalid group');
                return $this->_redirect('/admin/role');
            }
        } else {
            // TODO Masseges
            $this->_helper->messenger('error', 'Invalid group');
            return $this->_redirect('/admin/role');
        }
    }

}