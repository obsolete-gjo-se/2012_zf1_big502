<?php

class Admin_Model_Forms_LoginForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('login');
        $this->setMethod('post');
        $this->setAction('/login');

        $email = new Zend_Form_Element_Text('email'); 
        $email->setAttrib('size', 28)
              ->removeDecorator("label")
              ->removeDecorator("htmlTag")
              ->removeDecorator("Errors")
              ->setRequired(true)
              ->addValidator('emailAddress')
              ->addErrorMessage("A valid email address is required")
              ->setValue("mail");

        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('size', 28)
                 ->removeDecorator("label")
                 ->removeDecorator("htmlTag")
                 ->removeDecorator("Errors")
                 ->setRequired(true)
                 ->addErrorMessage("Password is required and can't be empty");

        $submit = new Zend_Form_Element_Submit('submit'); 
        $submit->setLabel("Log in →");
        $submit->removeDecorator("DtDdWrapper");

        //$this->setDecorators( array( array('ViewScript',
          //                           array('viewScript' => '_form_login.phtml')))); 

        $this->addElements(array($email, $password, $submit));
    }

}