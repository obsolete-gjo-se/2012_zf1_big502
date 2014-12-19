<?php

class Admin_FilesController extends Big502_Controller_BaseController {

    public function indexFilesAction(){

    }

    public function storeFilesFromSystemAction(){
        
        $root = '..';
        
        // aktuelle Files aus System
        $filesSystem = new Big502_Diverse_GetFiles();
        $filesSystemObject = $filesSystem->scanSystem($root);
        
        // SystemFiles als Array darstellen
        foreach ($filesSystemObject as $systemFile) {
            
            if($systemFile->isFile()) {
                
                $filesSystemArray[] = $systemFile->getPathname();
            }
        }
        
        // aktuelle Files aus DB in Object
        $entity = 'Big502\Entity\FilesEntity';
        $repositoryFunction = 'findAllFiles';
        $viewvar = 'files';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $filesDbObject = $repository;
        
        // DatenbankFiles als Array darstellen
        foreach ($filesDbObject as $dbFile) {
            $filesDbArray[] = $dbFile->name;
        
        }
        
        foreach ($filesSystemObject as $systemFile) {
            
            if($systemFile->isFile()) {
                
                if(! in_array($systemFile->getPathname(), $filesDbArray, true)) {

                    // in DB speichern
                    $filesdb = new Big502\Entity\FilesEntity();
                    $filesdb->name = $systemFile->getPathname();
                    $this->em->persist($filesdb);
                
                }
            }
        }
        
        foreach ($filesDbObject as $dbFile){
            
            if(!in_array($dbFile->name, $filesSystemArray, true)) {

                // // aus DB löschen
                $entity = 'Big502\Entity\FilesEntity';
                $fileId = $this->em->getRepository($entity)->findOneById($dbFile->id);
                
                if($fileId !== null) {
                    $this->em->remove($fileId);
                }
            }
        }
        

        
        $this->em->flush();
        
        // neue Files aus DB in View
        $entity = 'Big502\Entity\FilesEntity';
        $repositoryFunction = 'findAllFiles';
        $viewvar = 'files';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
    }

    public function updateFilesAction(){

        $request = $this->getRequest();
        
        // TODO Zend_Form überarbeiten
        $form = new Admin_Model_Forms_FilesForm();
        $form->getElement('submit')->setLabel('Update File');
        
        $entity = 'Big502\Entity\FilesEntity';
        $file = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($file === null) {
            // TODO Messages
            $this->_helper->messenger('error', 'Invalid Controller');
            return $this->_redirect('/admin/files/store');
        } else {
            if($request->isPost()) {
                if($form->isValid($this->_request->getPost())) {

                    $file->name = $form->getValue('name');
                    $file->code = $form->getValue('code');
                    
                    $this->em->persist($file);
                    $this->em->flush();

                    return $this->_redirect('/admin/files/store');
                } else {
                    // Assign errors to view
                    $this->view->errors = $form->getErrors();
                }
            } else {
                
                $formData = array(
                    "name" => $file->name, 
                    "code" => $file->code 
                );
                
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }

}





