<?php

class Admin_Model_Forms_RolesSelectForm extends Zend_Form_Element_Select {
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
        
        $this->addMultiOption('', 'Please select a group...');
        
        foreach ($roles as $role) {
            $this->addMultiOption($role->id, $role->name);
        }
    }
}