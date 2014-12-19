<?php

class Admin_Model_Forms_FunctionTestsForm extends Big502_Form_BaseForm {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * 
     * @param unknown_type $options
     * @param Doctrine\ORM\EntityManager $em
     * TODO Zend_Form nochmal ansehen
     */
    public function __construct($options = null, Doctrine\ORM\EntityManager $em = null){
        
        parent::__construct($options);
        $this->_em = $em;
        
        $this->setMethod('post');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('size', 28)
            ->setLabel("Name")
            ->setRequired(true)
            ->addErrorMessage("A name is required");
        
        $descr = new Zend_Form_Element_Text('descr');
        $descr->setAttrib('size', 28)
            ->setLabel('Description')
            ->setRequired(true)
            ->addErrorMessage("A description is required");
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Create Function Test");
        
        $this->addElements(array(
            $name, 
            $descr, 
            $submit
        ));
    
    }
}