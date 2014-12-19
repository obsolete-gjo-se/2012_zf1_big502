<?php

class Admin_Model_Forms_SitemapForm extends Big502_Form_BaseForm {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     *
     * @param $options unknown_type           
     * @param $em Doctrine\ORM\EntityManager
     *            TODO Zend_Form nochmal ansehen
     */
    public function __construct($options = null, Doctrine\ORM\EntityManager $em = null){
        
        parent::__construct($options);
        $this->_em = $em;
        
        $this->setMethod('post');
        
        $title = new Zend_Form_Element_Text('title');
        $title->setAttrib('size', 28)
            ->setLabel("Title")
            ->setRequired(true)
            ->addErrorMessage("A title is required");
        
        $lang = new Zend_Form_Element_Text('lang');
        $lang->setAttrib('size', 28)
            ->setLabel("Language")
            ->setRequired(true)
            ->addErrorMessage("A lang is required");
        
        $keyword = new Zend_Form_Element_Text('keyword');
        $keyword->setAttrib('size', 28)
            ->setLabel('Keyword')
            ->setRequired(true)
            ->addErrorMessage("A Keyword is required");
        
        $descr = new Zend_Form_Element_Text('descr');
        $descr->setAttrib('size', 28)
            ->setLabel('Description')
            ->setRequired(true)
            ->addErrorMessage("Description is required");
        
        $robots = new Zend_Form_Element_Text('robots');
        $robots->setAttrib('size', 28)
            ->setLabel('Robots')
            ->setRequired(true)
            ->addErrorMessage("Robots is required");
        
        $url = new Zend_Form_Element_Text('url');
        $url->setAttrib('size', 28)
            ->setLabel('URL')
            ->setRequired(true)
            ->addErrorMessage("URL is required");
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Create Site");
        
        $this->addElements(
                array(
                    $title, 
                    $lang, 
                    $keyword, 
                    $descr, 
                    $robots, 
                    $url, 
                    $submit
                ));
    
    }
}