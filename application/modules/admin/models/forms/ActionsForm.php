<?php

class Admin_Model_Forms_ActionsForm extends Big502_Form_BaseForm {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function __construct($options = null, Doctrine\ORM\EntityManager $em = null){
        
        // TODO Zend_Form RF
        parent::__construct($options);
        $this->_em = $em;
        
        $this->setMethod('post');
        
        $controller = new Admin_Model_Forms_ControllersSelectForm('resourceController', $this->_em);
        $controller->setLabel("Controller")
            ->setRequired(true)
            ->addErrorMessage("A Controller is required");
        
        $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('size', 28)
            ->setLabel("Name")
            ->setRequired(true)
            ->addErrorMessage("A name is required");
        
        $description = new Zend_Form_Element_Text('description');
        $description->setAttrib('size', 28)
            ->setLabel('Description')
            ->setRequired(true)
            ->addErrorMessage("A description is required");
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Create Action");
        
        $this->addElements(
                array(
                    $controller, 
                    $name, 
                    $description, 
                    $submit
                ));
    
    }
}