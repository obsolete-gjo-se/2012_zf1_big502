<?php

class Big502_Controller_BaseController extends Zend_Controller_Action {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function init(){
        
        $this->_initEntityManager();
        $this->_initModuleSwitch();
        $this->_initHeadTitle();
        $this->_initHeadMeta();
        $this->_initHeadLink();
        $this->_initHeadScript();
    }

    public function preDispatch(){
        parent::preDispatch();
        
        // TODO in getResourceNames auslagern (ActionHelper)
        $moduleName = $this->getRequest()->getModuleName();
        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();
        
        Zend_Registry::set('moduleName', $moduleName);
        Zend_Registry::set('controllerName', $controllerName);
        Zend_Registry::set('actionName', $actionName);
        
        $this->_checkResourceActionRules();
    }

    /**
     * Queries the Actions and Rules and redirects the user to a different
     * page if he doesn't have the required permissions for accessing the
     * current page
     *
     * @access protected
     * @return void
     */
    protected function _checkResourceActionRules(){
        
        $roles = array();
        $isAllowed = false;
//        $isDebug = false;
        
        $moduleName = Zend_Registry::get('moduleName');
        $controllerName = Zend_Registry::get('controllerName');
        $actionName = Zend_Registry::get('actionName');
        
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity()) {
            $user = $this->em->getRepository('Big502\Entity\UsersEntity')->findOneByEmail(
                    $auth->getIdentity());
            $roles = $this->em->getRepository('Big502\Entity\UsersEntity')->getRoleNameArray(
                    $user->id);
        } else {
            $roles[] = 'guests';
        }
        
        foreach ($roles as $role) {

//        TODO ZF_Debug            
//             if(Big502_Acl_Manager::isAllowed($role, 'testing', 'zfdebug')) {
                
//                 $isDebug = true;
//             }
            
            if(Big502_Acl_Manager::isAllowed($role, $moduleName . ':' . $controllerName, $actionName)) {
                
                $isAllowed = true;
            }
        }
        
//         if(! $isDebug) {
//             Zend_Controller_Front::getInstance()->unregisterPlugin(
//                     'ZFDebug_Controller_Plugin_Debug');
//         }

        
        if(! $isAllowed) {
            
            if(isset($user)) {
                
                return $this->_redirect('/admin/error/forbidden');
            }
            
            return $this->_redirect('/login');
        }
    }

    protected function _initEntityManager(){
        $this->em = Zend_Registry::get('em');
    }

    protected function _initModuleSwitch(){
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $module = $request->module;
        switch ($module) {
            case "admin":
                $this->view->layout()->setLayout('layout_admin');
                break;
            case "frontend":
                $this->view->layout()->setLayout('layout_front');
                break;
        }
    }

    protected function _initHeadTitle(){
        $this->view->headTitle('Inhalt aus DB')->setIndent(2);
    }

    protected function _initHeadMeta(){
        $this->view->headMeta()
            ->setIndent(2)
            ->setHttpEquiv('Content-Type', 'text/html; charset=utf-8')
            ->setName('keywords', 'Keywords aus DBöäü')
            ->setName('description', 'Description aus DB')
            ->setName('robots', 'Robots aus DB')
            ->setName('language', 'de');
    }

    protected function _initHeadLink(){
        $this->view->headLink()
            ->setIndent(2)
            ->setStylesheet('/css/central.css')
            ->appendStylesheet('/css/patches/patch_central.css', 'screen', 'lte IE 7')
            ->headLink(
                array(
                    'href' => '/images/favicon.ico', 
                    'rel' => 'shortcut icon', 
                    'type' => 'image/x-icon'
                ));
    }

    protected function _initHeadScript(){
        $this->view->headScript()
            ->setIndent(2)
            ->setFile('/js/jquery-1.7.1.min.js')
            ->appendFile('/js/jquery.validate.min.js');
    }
}