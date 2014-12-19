<?php

class Admin_Model_Forms_UsersForm extends Big502_Form_BaseForm {

    // TODO Zend_Form RF - entweder so, oder wie RolesForm
//     public function __construct(Doctrine\ORM\EntityManager $em, $options = null){
    
//         parent::__construct($options);
    
//         $this->_em = $em;
        
        public function __construct($options = null)
        {
            parent::__construct($options);
            $_em = Zend_Registry::getInstance()->get('doctrine')->getEntityManager();
    
        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setAttrib('size', 28)
            ->setLabel("Firstname")
            ->setRequired(true)
            ->addErrorMessage("A first name is required");
        
        $surname = new Zend_Form_Element_Text('surname');
        $surname->setAttrib('size', 28)
            ->setLabel("Surname")
            ->setRequired(true)
            ->addErrorMessage("A surname is required");
        
        $provider = new Admin_Model_Forms_ProvidersSelectForm('provider', $_em);
        $provider->setLabel("Provider")
            ->setRequired(true)
            ->addErrorMessage("A provider needs to be selected");
        
        $roles = new Admin_Model_Forms_RolesMultiCheckboxForm('roles', $_em);
        
        // TODO Zend_Form RF: Abgleich mit DB Inhalt auf gleiche Inhalte
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('size', 28)
            ->setLabel("Email")
            ->setRequired(true)
            ->addValidator('emailAddress')
            ->addErrorMessage("A valid email address is required");
        
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('size', 28)
            ->setLabel("Password")
            ->setRequired(true)
            ->addErrorMessage("A password is required and can't be empty");
        
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->setAttrib('size', 28)
            ->setLabel("Confrim Password")
            ->setRequired(true)
            ->addValidator('Identical', false, array(
            'token' => 'password'
        ))
            ->addErrorMessage("The passwords do not match");
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Create User");
        
        $this->addElements(
                array(
                    $firstname, 
                    $surname, 
                    $email, 
                    $password, 
                    $confirmPassword, 
                    $provider, 
                    $roles,
                    $submit
                ));
        
        // Add elements to display Role to make it look neat
        $this->addDisplayGroup(
                array(
                    'firstname', 
                    'surname'
                ), 'contacts', array(
                    'legend' => 'Contact Information'
                ));
        
        $this->addDisplayGroup(
                array(
                    'email', 
                    'provider',
                    'roles' 
                ), 'account', array(
                    'legend' => 'Account Information'
                ));
        
        $this->addDisplayGroup(
                array(
                    'password', 
                    'confirmPassword'
                ), 'passwords', array(
                    'legend' => 'Password'
                ));
        
        $this->addDisplayGroup(array(
            'submit'
        ), 'submit');
    }

}