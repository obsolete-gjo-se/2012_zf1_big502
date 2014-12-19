<?php

class Admin_Model_Forms_ControllersForm extends Big502_Form_BaseForm {
    
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
        
        $module = new Zend_Form_Element_Text('module');
        $module->setAttrib('size', 28)
        ->setLabel("Module")
        ->setRequired(true)
        ->addErrorMessage("A module is required");
        
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
        
        $zones = new Zend_Form_Element_MultiCheckbox('zones');
        $zones->setOptions(
                array(
                    'label' => 'Active in', 
                    'multiOptions' => array(
                        "dev" => "Development", 
                        "prod" => "Production"
                    )
                ));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Create Controller");
        
        $this->addElements(array(
            $module,
            $name, 
            $description, 
            $zones, 
            $submit
        ));
    
    }
}