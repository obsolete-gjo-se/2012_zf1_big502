<?php

class Admin_Model_Forms_ControllersSelectForm extends Zend_Form_Element_Select {
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct($spec, \Doctrine\ORM\EntityManager $em, $options = null){
        // TODO Zend_Form RF
        $this->_em = $em;
        
        parent::__construct($spec, $options);
    }

    public function init(){
        
        // TODO - RF - das geht besser
        if(! ($this->_em instanceof Doctrine\ORM\EntityManager) || $this->_em === null)
            throw new Zend_Exception("No entity manager defined in '" . __CLASS__ . "'");
        
        $dql = $this->_em->createQuery(
                'SELECT partial c.{id,name, module} FROM Big502\Entity\ResourceControllersEntity c ORDER BY c.module ASC, c.name ASC');
        $controllers = $dql->getResult();
        
        $this->addMultiOption('', 'Bitte Controller wählen...');
        foreach ($controllers as $controller)
            $this->addMultiOption($controller->id, $controller->module . ' / ' . $controller->name);
        
        parent::init();
    }
}