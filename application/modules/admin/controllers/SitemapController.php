<?php

class Admin_SitemapController extends Big502_Controller_BaseController {

    public function indexSitemapAction(){
        
        $entity = 'Big502\Entity\SitemapEntity';
        $repositoryFunction = 'getAllSites';
        $viewvar = 'sites';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
    }
    
    public function createSiteAction(){
        
        $form = new Admin_Model_Forms_SitemapForm();        
        $form->setAction('/admin/sitemap/create');
        
        if($this->getRequest()->isPost()) {
        
            if($form->isValid($this->_request->getPost())) {
        
                $sites = new Big502\Entity\SitemapEntity();
                $sites->title = $form->getValue('title');
                $sites->language = $form->getValue('lang');
                $sites->keyword = $form->getValue('keyword');
                $sites->descr = $form->getValue('descr');
                $sites->robots = $form->getValue('robots');
                $sites->url = $form->getValue ('url');
                
                $this->em->persist($sites);
                $this->em->flush();
        
                return $this->_redirect('/admin/sitemap/create');
        
            } else {
                // Assign errors to view
                $this->view->errors = $form->getErrors();
            }
        }
        
        // Display form
        $this->view->form = $form;
    }
    
    public function updateSiteAction(){
        
        $request = $this->getRequest();
        
        // TODO Zend_Form überarbeiten
        $form = new Admin_Model_Forms_SitemapForm();

        $form->getElement('submit')->setLabel('Update Site');
        
        $entity = 'Big502\Entity\SitemapEntity';
        $site = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($site === null) {
            // TODO Messages
            $this->_helper->messenger('error', 'Invalid Site');
            return $this->_redirect('/admin/sitemap');
        } else {
            if($request->isPost()) {
                if($form->isValid($this->_request->getPost())) {
        

                $site->title = $form->getValue('title');
                $site->language = $form->getValue('lang');
                $site->keyword = $form->getValue('keyword');
                $site->descr = $form->getValue('descr');
                $site->robots = $form->getValue('robots');
                $site->url = $form->getValue ('url');
        
                    $this->em->persist($site);
                    $this->em->flush();
        

                    return $this->_redirect('/admin/sitemap');
                } else {
                    // Assign errors to view
                    $this->view->errors = $form->getErrors();
                }
            } else {
                // Populate form
                $formData = array(
                        "title" => $site->title,
                        "lang" => $site->language,
                        "keyword" => $site->keyword,
                        "descr" => $site->descr,
                        'robots' => $site->robots,
                        'url' => $site->url
                );
        
                $form->populate($formData);
            }
        }
        
        // Display form
        $this->view->form = $form;
    }
    
    public function deleteSiteAction(){
        
        $request = $this->getRequest();
        
        if(! isset($request->id)) {
            // TODO Messages
//             $this->_helper->messenger('error',
//                     Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/sitemap');
        }
        
        $entity = 'Big502\Entity\SitemapEntity';
        $site = $this->em->getRepository($entity)->findOneById($request->id);
        
        if($site !== null) {
        
            $this->em->remove($site);
            $this->em->flush();
        
            // TODO Message
//             $controllerName = $controller->name;
//             $this->_helper->messenger('success',
//                     sprintf(Zend_Registry::get('config')->messages->controller->delete,
//                             $controllerName));
            return $this->_redirect('/admin/sitemap');
        } else {
        
            // TODO Message
//             $this->_helper->messenger('error',
//                     Zend_Registry::get('config')->messages->controller->invalid);
            return $this->_redirect('/admin/sitemap');
        }
    }
    
    public function showAllUrlsWithFunctionTestsAction(){
    
        $entity = 'Big502\Entity\SitemapEntity';
        $repositoryFunction = 'getAllSites';
        $viewvar = 'urls';
    
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
        
        $entity = 'Big502\Entity\SitemapEntity';
        $repositoryFunction = 'getAllFunctionTests';
        $viewvar = 'functionTests';
        
        $repository = $this->em->getRepository($entity)->$repositoryFunction();
        $this->view->$viewvar = $repository;
        
//         $entity = 'Big502\Entity\SitemapEntity';
//         $repositoryFunction = 'getAllFunctionTestsForUrl';
//         $viewvar = 'functionTestsForUrl';
        
//         $repository = $this->em->getRepository($entity)->$repositoryFunction();
//         $this->view->$viewvar = $repository;
    }


}

