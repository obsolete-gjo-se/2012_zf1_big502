<?php

class Admin_Model_Forms_RolesMultiCheckboxForm extends Zend_Form_Element_MultiCheckbox {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct($spec, Doctrine\ORM\EntityManager $em, $options = null){
        
        $this->_em = $em;
        
        parent::__construct($spec, $options);
    }

    public function init(){
        
        parent::init();
        
        if($this->_em === null)
            throw new Zend_Exception("No entity manager defined in '" . __CLASS__ . "'");
        
        $dql = $this->_em->createQuery('SELECT partial r.{id,name} FROM Big502\Entity\RolesEntity r');
        $roles = $dql->getResult();
        
        foreach ($roles as $role) {
            $this->addMultiOption($role->id, $role->name);
        }
    }
}