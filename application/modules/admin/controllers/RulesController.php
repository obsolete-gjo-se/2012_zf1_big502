<?php

class Admin_RulesController extends Big502_Controller_BaseController {

    public function indexRulesAction(){
        
        $entity = 'Big502\Entity\RulesEntity';
        $repositoryFunction = 'findAllRules';
        $viewvar = 'rules';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
        

       
    }

}