<?php

class Admin_FunctionTestsController extends Big502_Controller_BaseController {

    public function indexFunctionTestsAction(){
        
        $entity = 'Big502\Entity\FunctionTestsEntity';
        $repositoryFunction = 'findAllFunctionTests';
        $viewvar = 'functionTests';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
    }
    
    public function createFunctionTestsAction(){
    
        $form = new Admin_Model_Forms_FunctionTestsForm();
                $form->setAction('/admin/functiontests/create');
    
        if($this->getRequest()->isPost()) {
    
            if($form->isValid($this->_request->getPost())) {
    
                $functionTest = new Big502\Entity\FunctionTestsEntity();
                $functionTest->name = $form->getValue('name');
                $functionTest->descr = $form->getValue('descr');
    
                $this->em->persist($functionTest);
                $this->em->flush();
    
                // Display message and redirect back to index
                // TODO Zend_Form: Messages
//                 $this->_helper->messenger('success',
//                         sprintf(Zend_Registry::get('config')->messages->controllers->create,
//                                 $form->getValue('name')));
                return $this->_redirect('/admin/functiontests/create');
    
            } else {
                // Assign errors to view
                $this->view->errors = $form->getErrors();
            }
        }
    
        // Display form
        $this->view->form = $form;
    }
    
    public function updateFunctionTestsAction(){
    
        $request = $this->getRequest();
    
        $form = new Admin_Model_Forms_FunctionTestsForm();
        $form->getElement('submit')->setLabel('Update Function Tests');
    
        $entity = 'Big502\Entity\FunctionTestsEntity';
        $test = $this->em->getRepository($entity)->findOneById($request->id);
    
        if($test === null) {
            // TODO Messages
           // $this->_helper->messenger('error', 'Invalid Controller');
            return $this->_redirect('/admin/functiontests');
        } else {
            if($request->isPost()) {
                if($form->isValid($this->_request->getPost())) {
    
                    $test->name = $form->getValue('name');
                    $test->descr = $form->getValue('descr');
    
                    $this->em->persist($test);
                    $this->em->flush();
    
                    // TODO Messages
//                     $this->_helper->messenger('success',
//                             sprintf(Zend_Registry::get('config')->messages->controller->update,
//                                     $controllerName));
                    return $this->_redirect('/admin/functiontests');
                } else {
                    // Assign errors to view
                    $this->view->errors = $form->getErrors();
                }
            } else {
                // Populate form
                $formData = array(
                        "name" => $test->name,
                        "descr" => $test->descr
                );
    
                $form->populate($formData);
            }
        }
    
        // Display form
        $this->view->form = $form;
    }
    
    public function deleteFunctionTestsAction(){
    
        $request = $this->getRequest();
    
        if(! isset($request->id)) {
            // TODO Messages
//             $this->_helper->messenger('error',
//                     Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/functiontests');
        }
    
        $entity = 'Big502\Entity\FunctionTestsEntity';
        $test = $this->em->getRepository($entity)->findOneById($request->id);
    
        if($test !== null) {
    
            $this->em->remove($test);
            $this->em->flush();
    
            // TODO Message
//             $controllerName = $controller->name;
//             $this->_helper->messenger('success',
//                     sprintf(Zend_Registry::get('config')->messages->controller->delete,
//                             $controllerName));
            return $this->_redirect('/admin/functiontests');
        } else {
    
            // TODO Message
//             $this->_helper->messenger('error',
//                     Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/functiontests');
        }
    }

    public function executeFunctionTestsAction(){
        $test1 = $this->standardLinkOpenSite();
        
        Echo 'Test Standard-Link öffnet Seite: <br />';
        foreach ($test1 as $test){
            echo $test;
        }
        
    }
    
    public function getFunctionTestArray($functionTestId){
    
        $functionTests = array();
    
        $dql = 'SELECT s FROM Big502\Entity\SitemapEntity s
                JOIN s.functionTests ft
                WHERE ft.id = ?1';
    
        $SitemapEntities = $this->getEntityManager()
        ->createQuery($dql)
        ->setParameter(1, $functionTestId)
        ->getResult();
    
        foreach ($SitemapEntities as $test) {
            $functionTests[] = $test->name;
        }
    
        return $functionTests;
    }

    protected  function standardLinkOpenSite(){
        
        $summary = array();
        
        $iim1 = new COM("imacros");
        
        $s = $iim1->iimInit("-runner -tray");
        
        $root = "http://dev.big502";
        
//         $entity = 'Big502\Entity\SitemapEntity';
//         $repositoryFunction = 'findAllUrls';
                
//         $repository = $this->em->getRepository($entity)->$repositoryFunction();
                
        $urlarray = array(
            $root . '/', 
            $root . '/admin', 
            $root . '/login'
        );
        
        foreach ($urlarray as $url) {
            
            $macro = "CODE:";
            $macro .= "VERSION BUILD=6021121" . "\r\n";
            $macro .= "TAB T=1" . "\r\n";
            $macro .= "TAB CLOSEALLOTHERS" . "\r\n";
            $macro .= "CLEAR" . "\r\n";
            $macro .= "SET !FILESTOPWATCH mydata.csv" . "\r\n";
            $macro .= "STOPWATCH ID=total" . "\r\n";
            $macro .= "STOPWATCH ID=load_page" . "\r\n";
            $macro .= "URL GOTO=$url" . "\r\n";
            $macro .= "STOPWATCH ID=load_page" . "\r\n";
            // $macro .= "TAG POS=1 TYPE=TITLE ATTR=* EXTRACT=HTM" . "\r\n";
            $macro .= "TAG POS=1 TYPE=P ATTR=TXT:* EXTRACT=TXT" . "\r\n";
            $macro .= "STOPWATCH ID=total" . "\r\n";
            
            $s = $iim1->iimPlay($macro);
            
            if($s === 1) {
                
                // echo 'soweit allet ok : <br />';
                $summary[] = 'extract= ' . $url . ': ' . $iim1->iimGetLastExtract . '<br />';
            }
            
            if($s < 0) {
                
                $summary[] = "Fehlernummer " . $s . ', Fehlerbeschreibung: ' . $iim1->iimGetLastError .
                         '<br />';
            }
        }
        $s = $iim1->iimExit();
        return $summary;
    }

}