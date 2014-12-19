<?php
use Doctrine\DBAL\Types\Type;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initCaching(){
        
        $frontendOptions = array(
            'lifetime' => 3600, 
            'automatic_serialization' => true
        );
        
        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../data/cache'
        );
        
        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        
        Zend_Registry::set('Zend_Cache', $cache);
    
    }
    
    // Do not rename this method _initDoctrine() this will result in a circular
    // dependency error.
    protected function _initDoctrineExtra(){
        
        $doctrine = $this->bootstrap('doctrine')->getResource('doctrine');
        
        $em = $doctrine->getEntityManager();
        
        Zend_Registry::set('em', $em);
    }

    protected function _initRoutes(){
        
        $this->bootstrap('frontController');
        $router = $this->getResource('frontController')->getRouter();
        
        $this->bootstrap('caching');
        $cache = Zend_Registry::get('Zend_Cache');
        
        $myroutes = $cache->load('myroutes');
        
        if($myroutes === false) {
            $myroutes = array();
            
            $route = new Zend_Controller_Router_Route('/', 
                    array(
                        'module' => 'frontend', 
                        'controller' => 'index', 
                        'action' => 'index-index'
                    ));
            $myroutes['/'] = $route;
            
            // TODO Login/logout in Frontend verschieben
            $route = new Zend_Controller_Router_Route('/login', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'login'
                    ));
            $myroutes['login'] = $route;
            
            $route = new Zend_Controller_Router_Route('/logout', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'logout'
                    ));
            $myroutes['logout'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'index', 
                        'action' => 'index-index'
                    ));
            $myroutes['admin'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/error/forbidden', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'error', 
                        'action' => 'forbidden-error'
                    ));
            $myroutes['error-forbidden'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sitemap', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'sitemap', 
                        'action' => 'index-sitemap'
                    ));
            $myroutes['sitemap'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sitemap/create',
                    array(
                            'module' => 'admin',
                            'controller' => 'sitemap',
                            'action' => 'create-site'
                    ));
            $myroutes['site-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sitemap/update/:id',
                    array(
                            'module' => 'admin',
                            'controller' => 'sitemap',
                            'action' => 'update-site',
                            'id' => ''
                    ));
            $myroutes['site-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sitemap/delete/:id',
                    array(
                            'module' => 'admin',
                            'controller' => 'sitemap',
                            'action' => 'delete-site',
                            'id' => ''
                    ));
            $myroutes['site-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sitemap/functiontests',
                    array(
                            'module' => 'admin',
                            'controller' => 'sitemap',
                            'action' => 'show-all-urls-with-function-tests'
                    ));
            $myroutes['sitemap-functiontests'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/sessiontest', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'index', 
                        'action' => 'session-test'
                    ));
            $myroutes['session-test'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/phpinfo', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'index', 
                        'action' => 'show-php-info'
                    ));
            $myroutes['phpinfo'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/files', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'files', 
                        'action' => 'index-files'
                    ));
            $myroutes['files'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/files/store', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'files', 
                        'action' => 'store-files-from-system'
                    ));
            $myroutes['store-files'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/files/update/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'files', 
                        'action' => 'update-files', 
                        'id' => ''
                    ));
            $myroutes['file-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/user', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'index-users'
                    ));
            $myroutes['user'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/user/create', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'create-users'
                    ));
            $myroutes['user-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/user/update/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'update-users', 
                        'id' => ''
                    ));
            $myroutes['user-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/user/delete/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'users', 
                        'action' => 'delete-users', 
                        'id' => ''
                    ));
            $myroutes['user-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/controller', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-controllers', 
                        'action' => 'index-resource-controllers'
                    ));
            $myroutes['controller'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/controller/create', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-controllers', 
                        'action' => 'create-resource-controllers'
                    ));
            $myroutes['controller-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/controller/update/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-controllers', 
                        'action' => 'update-resource-controllers', 
                        'id' => ''
                    ));
            $myroutes['controller-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/controller/delete/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-controllers', 
                        'action' => 'delete-resource-controllers', 
                        'id' => ''
                    ));
            $myroutes['controller-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/controller/toggle/:zone/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-controllers', 
                        'action' => 'toggle-resource-controllers', 
                        'zone' => 'keine Angabe', 
                        'id' => 'keine id'
                    ));
            $myroutes['controller-toggle'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/action', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-actions', 
                        'action' => 'index-resource-actions'
                    ));
            $myroutes['action'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/action/create', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-actions', 
                        'action' => 'create-resource-actions'
                    ));
            $myroutes['action-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/action/update/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-actions', 
                        'action' => 'update-resource-actions', 
                        'id' => ''
                    ));
            $myroutes['action-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/action/delete/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'resource-actions', 
                        'action' => 'delete-resource-actions', 
                        'id' => ''
                    ));
            $myroutes['action-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/role', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'roles', 
                        'action' => 'index-roles', 
                        'id' => ''
                    ));
            $myroutes['role'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/role/create', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'roles', 
                        'action' => 'create-roles', 
                        'id' => ''
                    ));
            $myroutes['role-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/role/update/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'roles', 
                        'action' => 'update-roles', 
                        'id' => ''
                    ));
            $myroutes['role-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/role/delete/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'roles', 
                        'action' => 'delete-roles', 
                        'id' => ''
                    ));
            $myroutes['role-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/role/rules/:id', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'roles', 
                        'action' => 'rules', 
                        'id' => ''
                    ));
            $myroutes['role-rules'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/rule', 
                    array(
                        'module' => 'admin', 
                        'controller' => 'rules', 
                        'action' => 'index-rules', 
                        'id' => ''
                    ));
            $myroutes['rule'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/functiontests',
                    array(
                            'module' => 'admin',
                            'controller' => 'function-tests',
                            'action' => 'index-function-tests',
                            'id' => ''
                    ));
            $myroutes['function-tests'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/functiontests/create',
                    array(
                            'module' => 'admin',
                            'controller' => 'function-tests',
                            'action' => 'create-function-tests'
                    ));
            $myroutes['functionTest-create'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/functiontests/update/:id',
                    array(
                            'module' => 'admin',
                            'controller' => 'function-tests',
                            'action' => 'update-function-tests',
                            'id' => ''
                    ));
            $myroutes['functionTest-update'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/functiontests/delete/:id',
                    array(
                            'module' => 'admin',
                            'controller' => 'function-tests',
                            'action' => 'delete-function-tests',
                            'id' => ''
                    ));
            $myroutes['functionTest-delete'] = $route;
            
            $route = new Zend_Controller_Router_Route('/admin/functiontests/execute',
                    array(
                            'module' => 'admin',
                            'controller' => 'function-tests',
                            'action' => 'execute-function-tests'
                    ));
            $myroutes['functionTest-execute'] = $route;
            
            $cache->save($myroutes);
        }
        $router->addRoutes($myroutes);
    }

    protected function _initConfig(){
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
        return $config;
    }
    // TODO Session (in Zusammenhang mit Doctrine)
    // protected function _initSession(){
    
    // $options = $this->getOptions();
    
    // $config = $options['resources']['session'];
    // Zend_Session::setOptions($config);
    
    // Zend_Session::start();
    // }
    
    protected function _initView(){
        
        $options = $this->getOptions();
        $config = $options['resources']['view'];
        
        if(isset($config)) {
            $view = new Zend_View($config);
        } else {
            $view = new Zend_View();
        }
        
        if(isset($config['doctype'])) {
            $view->doctype($config['doctype']);
        }
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        
        return $view;
    }

    protected function _initErrorHandler(){
        
        // TODO : über app.ini lösen?!
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(
                new Zend_Controller_Plugin_ErrorHandler(
                        array(
                            'module' => 'admin', 
                            'controller' => 'error', 
                            'action' => 'index-error'
                        )));
    }

    /**
     * Initialize the Action and Rules System
     *
     * @return void
     */
    protected function _initActionRules(){
        $this->bootstrap('doctrine');
        Big502_Acl_Manager::load();
    }

}