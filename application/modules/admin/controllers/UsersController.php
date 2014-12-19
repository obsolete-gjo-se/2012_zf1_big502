<?php

class Admin_UsersController extends Big502_Controller_BaseController {

    public function indexUsersAction(){
        
        $entity = 'Big502\Entity\UsersEntity';
        $method = 'findAllUsers';
        $viewvar = 'users';
        
        $this->view->$viewvar = $this->em->getRepository($entity)->$method();
    }

    public function createUsersAction(){
        
        $form = new Admin_Model_Forms_UsersForm();
        
        if($this->getRequest()->isPost()) {
            
            if($form->isValid($this->_request->getPost())) {
                
                $user = new Big502\Entity\UsersEntity();
                
                $user->firstname = $form->getValue('firstname');
                $user->surname = $form->getValue('surname');
                $user->email = $form->getValue('email');
                $user->password = $form->getValue('password');
                
                $provider = $this->em->getReference('Big502\Entity\ProvidersEntity', 
                        $form->getValue('provider'));
                $user->provider = $provider;
                
                // TODO Zend_Form RF: zur Zeit ohne Funktion, und unset wird
                // nicht erkannt
                // dazu Video ZC ansehen (n:m Beziehung)
                foreach ($form->getValue('roles') as $roleId) {
                    $role = $this->em->getReference('Big502\Entity\RolesEntity', $roleId);
                    $user->roles = $role;
                    unset($role);
                }
                
                $this->em->persist($user);
                $this->em->flush();
                
                // TODO Masseges
                $this->_helper->messenger('success', 
                        sprintf(Zend_Registry::get('config')->messages->account->create, 
                                $form->getValue('email')));
                return $this->_redirect('/admin/user/create');
            } else {
                // Assign errors to view
                $this->view->errors = $form->getErrors();
            }
        }
        // Assign form
        $this->view->form = $form;
    }

    /**
     * Update the user that was passed via the 'id' GET parameter
     */
    public function updateUsersAction(){
        
        // TODO Masseges RF - schon Anfang, aber nicht konsequent
        $isInvalid = false;
        
        $form = new Admin_Model_Forms_UsersForm();
        $form->setAction("");
        
        $form->getElement("password")->setRequired(false);
        $form->getElement("confirmPassword")->setRequired(false);
        $form->getElement("submit")->setLabel("Update");
        
        $request = $this->getRequest();
        
        if(isset($request->id)) {
            
            $user = $this->em->getRepository('Big502\Entity\UsersEntity')->findOneById($request->id);
            
            if($user !== null) {
                
                if($request->isPost()) {
                    
                    if($form->isValid($this->_request->getPost())) {
                        
                        // TODO die if-Abfrag eist doppelt
                        if($user !== null) {
                            
                            $user->firstname = $form->getValue('firstname');
                            $user->surname = $form->getValue('surname');
                            $user->email = $form->getValue('email');
                            
                            if($form->getValue('password') != '') {
                                $user->password = $form->getValue('password');
                            }
                            
                            $user->provider = $this->em->getReference(
                                    'Big502\Entity\ProvidersEntity', $form->getValue('provider'));
                            
                            $userRoleIds = $this->em->getRepository('Big502\Entity\UsersEntity')->getRoleIdArray(
                                    $user->id);
                            
                            foreach ($user->roles as $role) {
                                if(! in_array($role->id, $form->getValue('roles'))) {
                                    $user->roles->removeElement($role);
                                }
                            }
                            
                            foreach ($form->getValue('roles') as $roleId) {
                                if(! in_array($roleId, $userRoleIds)) {
                                    $role = $this->em->getRepository('Big502\Entity\RolesEntity')->findOneById(
                                            $roleId);
                                    
                                    if($role !== null)
                                        $user->roles = $role;
                                    
                                    unset($role);
                                }
                            }
                            
                            $this->em->persist($user);
                            $this->em->flush();
                            
                            // TODO Masseges
                            $this->_helper->messenger('success', 
                                    sprintf(Zend_Registry::get('config')->messages->account->update, 
                                            $form->getValue('email')));
                            return $this->_redirect('/admin/user');
                        } else {
                            // Display error message
                            $this->_helper->messenger('error', 
                                    Zend_Registry::get('config')->messages->account->invalid);
                            return $this->_redirect('/admin/user');
                        }
                    
                    } else {
                        $this->view->errors = $form->getErrors();
                    }
                } else {
                    $formData = array(
                        'firstname' => $user->firstname, 
                        'surname' => $user->surname, 
                        'email' => $user->email, 
                        'provider' => $user->provider->id, 
                        'roles' => $this->em->getRepository('Big502\Entity\UsersEntity')->getRoleIdArray(
                                $user->id)
                    );
                    
                    $form->populate($formData);
                }
                
                $this->view->form = $form;
            } else {
                $isInvalid = true;
            }
        } else {
            $isInvalid = true;
        }
        
        if($isInvalid) {
            // Masseges RF -
            $this->_helper->messenger('error', 
                    Zend_Registry::get('config')->messages->account->invalid);
            return $this->_redirect('/admin/user');
        }
    }

    /**
     * Delete the user with the id passed via the GET param
     */
    public function deleteUsersAction(){
        
        $request = $this->getRequest();
        
        if(isset($request->id)) {
            
            $user = $this->em->getRepository('Big502\Entity\UsersEntity')->findOneById($request->id);

            if($user !== null) {

                $userEmail = $user->email;
                
                $this->em->remove($user);
                $this->em->flush();
                
                // TODO Masseges
                $this->_helper->messenger('success', 
                        sprintf(Zend_Registry::get('config')->messages->account->delete, $userEmail));
                return $this->_redirect('/admin/user');
            }
        }
        // TODO Masseges
        $this->_helper->messenger('success', 
                Zend_Registry::get('config')->messages->account->invalid);
        return $this->_redirect('/admin/user');
    }

    public function loginAction(){
        
        $form = new Admin_Model_Forms_LoginForm();
        
        if($this->getRequest()->isPost()) {
            
            if($form->isValid($this->_request->getPost())) {
                
                if($this->_authenticate($this->em, $this->_request->getPost())) {
                    
                    $entity = 'Big502\Entity\UsersEntity';
                    $repositoryFunction = 'findOneByEmail';
                    
                    $users = $this->em->getRepository($entity)->$repositoryFunction(
                            $form->getValue('email'));
                    
                    $this->em->persist($users);
                    $this->em->flush();
                    
                    // TODO Masseage
                    $this->_helper->messenger('success', 
                            Zend_Registry::get('config')->messages->login->successful);
                    return $this->_redirect("/admin");
                } else {
                    $this->view->error = true;
                }
            } else {
                $this->view->error = true;
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction(){
        
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/login');
    }

    public function searchUsersAction(){
        // TODO später einbauen
    }

    protected function _authenticate($em, $data){
        
        $authAdaptor = new Big502_Auth_AuthAdapter();
        $authAdaptor->setEm($em);
        $authAdaptor->setEntityName('Big502\Entity\UsersEntity');
        $authAdaptor->setIdentityColumn('email');
        $authAdaptor->setCredentialColumn('password');
        
        $authAdaptor->setIdentity($data['email']);
        $authAdaptor->setCredential($data['password'], false);
        
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdaptor);
        
        if($result->isValid()) {
            // TODO Auth oder ACL?? - public?
            if(isset($data['public'])) {
                
                if($data['public'] == true) {
                    Zend_Session::rememberMe(3600);
                    return true;
                }
            }
            Zend_Session::forgetMe();
            return true;
        } else {
            return false;
        
        }
    
    }

}