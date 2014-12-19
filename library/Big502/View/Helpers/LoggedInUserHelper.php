<?php

class Big502_View_Helper_LoggedInUserHelper {
    
    public $view;
    
    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    function setView($view){
        $this->view = $view;
    }

    function loggedInUserHelper(){
        
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity()) {
            
            $this->em = Zend_Registry::get('em');
            $user = $this->em->getRepository('Big502\Entity\UsersEntity')->findOneByEmail(
                    $auth->getIdentity());
            
            $userfirstname = $this->view->escape($user->firstname);
            $usersurname = $this->view->escape($user->surname);
            
            $logoutUrl = $this->view->url(array(), 'logout');
            
            $string = 'LoggedIn als ' . $userfirstname . ' ' . $usersurname . '<a href="' .
                     $logoutUrl . '">  | LogOut</a>';
                
                } else {
                    $loginUrl = $this->view->url(array(), 'login');
                    $string = '<a href="' . $loginUrl . '">LogIn</a>';
                }
                return $string;
            }
        
        }
