<?php

class Admin_Model_Forms_ProvidersSelectForm extends Zend_Form_Element_Select {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct($spec, Doctrine\ORM\EntityManager $em, $options = null){
        
        $this->_em = $em;
        
        parent::__construct($spec, $options);
    }

    public function init(){
        
        // TODO Zend_Form
        $dql = $this->_em->createQuery('SELECT partial p.{id,name} FROM Big502\Entity\ProvidersEntity p');
        $providers = $dql->getResult();
        
        $this->addMultiOption('', 'Please select one...');
        
        foreach ($providers as $provider)
            $this->addMultiOption($provider->id, $provider->name);
    }
}