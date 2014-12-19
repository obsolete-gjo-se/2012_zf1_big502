<?php

class Big502_Acl_Manager {
    
    public static $indexKey = 'ActionRules';

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected static $em;

    /**
     * Load the ACL to the Registry if is not there
     *
     * This function takes care about generating the acl from the db
     * if the info is not in the registry and/or APC.
     *
     * If the acl is inside APC we load it from there.
     *
     * @return void
     */
    public static function load(){
        
        if(! self::_checkIfExist()) {
            if(! $acl = self::_getFromApc()) {
                $acl = self::_generateFromDb();
                self::_storeInApc($acl);
            }
            self::_storeInRegistry($acl);
        }
    }

    /**
     * Regenerate the Acl from the DB and update APC and Zend_Registry
     *
     * @return boolean
     */
    public static function save(){
        $acl = self::_generateFromDb();
        self::_storeInApc($acl);
        self::_storeInRegistry($acl);
    }

    /**
     * Check if a role is allowed for a certain resource
     *
     * @param $role string           
     * @param $resourceController string - inklusive $module
     * @param $resourceAction string           
     * @return boolean
     */
    public static function isAllowed($role = NULL, $resourceController = NULL, $resourceAction = NULL){
        
        if(empty($role)) {
            $role = Zend_Auth::getInstance()->getIdentity();
        }
        
        if(! empty($resourceController)) {

            $filterChain = new Zend_Filter();
            $filterChain->addFilter(new Zend_Filter_Word_DashToCamelCase());
            
            $resourceController = $filterChain->filter($resourceController);
            $resourceController = lcfirst($resourceController);
        }
        
        if(! empty($resourceAction)) {

            $filterChain = new Zend_Filter();
            $filterChain->addFilter(new Zend_Filter_Word_DashToCamelCase());
            
            $resourceAction = $filterChain->filter($resourceAction);
            $resourceAction = lcfirst($resourceAction);
        }
        
        // TODO ACL - versteh ich nicht!
        return self::_getFromRegistry()->isAllowed($role, $resourceController, 
               $resourceAction);
    }

    /**
     * Log a message related to Action And Rules
     *
     * @param $msg string           
     * @param $level string           
     * @return void
     * TODO Zend_Log
     */
    public static function log($msg, $level = Zend_Log::INFO){

    }

    /**
     * Check if the acl exists in Zend_Registry
     *
     * @return boolean
     */
    private static function _checkIfExist(){
        return Zend_Registry::isRegistered(self::$indexKey);
    }
    
    /**
     * Generate the Acl object from the permission file
     *
     * @return Zend_Acl
     */
    private static function _generateFromDb(){
        
        $em = Zend_Registry::get('em');
        
        $aclObject = new Zend_Acl();
        
        $roles = $em->getRepository('Big502\Entity\RolesEntity')->findAll();
        foreach ($roles as $role) {
            if($role->parent !== null)
                $aclObject->addRole(new Zend_Acl_Role($role->name), $role->parent->name);
            else
                $aclObject->addRole(new Zend_Acl_Role($role->name));
        }
        
        $controllers = $em->getRepository('Big502\Entity\ResourceControllersEntity')->findAll();
        foreach ($controllers as $controller) {
            $aclObject->addResource(new Zend_Acl_Resource($controller->module . ':' . $controller->name));
        }

        $rules = $em->getRepository('Big502\Entity\RulesEntity')->findAll();
        foreach ($rules as $rule) {
            switch (APPLICATION_ENV) {
                case 'production':
                    $envAllowed = $rule->resourceAction->resourceController->activeOnProduction;
                    break;
                default:
                    $envAllowed = $rule->resourceAction->resourceController->activeOnDev;
            }
            
            $role = $rule->role->name;
            $module = $rule->resourceAction->resourceController->module;
            $controller = $rule->resourceAction->resourceController->name;
            $action = $rule->resourceAction->name;
            
            if($rule->allow && $envAllowed) {
                $aclObject->allow($role, $module . ':' . $controller, $action); 
            } else {
                $aclObject->deny($role, $module . ':' . $controller, $action);
            }
        }
        
        return $aclObject;
    
    }
    
    /**
     * Store the Acl in the Registry
     *
     * @return void
     */
    private static function _storeInRegistry($acl){
        Zend_Registry::set(self::$indexKey, $acl);
    }
    
    /**
     * Get Acl from Registry
     *
     * @return void
     */
    private static function _getFromRegistry(){
        if(self::_checkIfExist()) {
            return Zend_Registry::get(self::$indexKey);
        }
    
        return false;
    }

    /**
     * Store the Acl in APC
     *
     * @return void
     * TODO APC alles?
     */
    private static function _storeInApc($acl = NULL){

    }
    
    /**
     * Retrieve the acl from APC
     *
     * @return Zend_Acl | boolean
     * TODO APC - ist das schon alles??
     */
    private static function _getFromApc(){
    
    }
}