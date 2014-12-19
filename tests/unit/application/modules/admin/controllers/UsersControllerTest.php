<?php

class Admin_UsersControllerTest extends ControllerTestCase {
    
    private $dispatchIndexUsers = 'admin/user';

    public function setUp(){
        parent::setUp();
        //$this->helper = new Big502_Acl_Manager();
    }

//     public function testHelperUsesAnAclObjectToDetermineIfUserIsPermitted(){
//         $acl = $this->getMock('Zend_Acl', array(
//             'isAllowed'
//         ));
//         $acl->expects($this->once())
//             ->method('isAllowed')
//             ->with($this->equalTo('foo'), $this->equalTo('default/index'), $this->equalTo('index'));
        
//         $this->helper->setAcl($acl);
//         $this->helper->isAllowed('foo', 'default/index', 'index');
//     }

    public function testIndexUsersShouldHaveResponseCode(){
        $this->dispatch($this->dispatchIndexUsers);
        $this->assertResponseCode('200');
    }

    public function testIndexUsersShouldHaveModule(){
        $this->dispatch($this->dispatchIndexUsers);
        $this->assertModule('admin');
    }

    public function testIndexUsersShouldHaveController(){
        $this->dispatch($this->dispatchIndexUsers);
        $this->assertController('users');
    }

    public function testIndexUsersShouldHaveAction(){
        $this->dispatch($this->dispatchIndexUsers);
        $this->assertAction('index-users');
    }
    
    public function testViewObjectContainsStringProperty()
    {
        $this->dispatch('admin/user');
    
        $controller = new Admin_UsersController(
                $this->request,
                $this->response,
                $this->request->getParams()
        );
        $controller->indexUsersAction();
    
        $this->assertTrue(isset($controller->view->string));
    }
    
    // public function testIndexUsersEntityShouldBe(){
    // $controller = new Admin_UsersController();
    // $action = $controller->indexUsersAction()->$entity;
    // $this->assertEquals($action, 'Big502\Entity\UsersEntity');
    // }
    
    // Test für login
    // public function testValidLoginShouldGoToProfilePage()
    // {
    // $this->request->setMethod('POST')
    // ->setPost(array(
    // 'username' => 'foobar',
    // 'password' => 'foobar'
    // ));
    // $this->dispatch('/user/login');
    // $this->assertRedirectTo('/user/view');
    
    // $this->resetRequest()
    // ->resetResponse();
    // $this->request->setMethod('GET')
    // ->setPost(array());
    // $this->dispatch('/user/view');
    // $this->assertRoute('default');
    // $this->assertModule('default');
    // $this->assertController('user');
    // $this->assertAction('view');
    // $this->assertNotRedirect();
    // $this->assertQuery('dl');
    // $this->assertQueryContentContains('h2', 'User: foobar');
    // }
    
    // Fixture:
    // public function loginUser($user, $password)
    // {
    // $this->request->setMethod('POST')
    // ->setPost(array(
    // 'username' => $user,
    // 'password' => $password,
    // ));
    // $this->dispatch('/user/login');
    // $this->assertRedirectTo('/user/view');
    // $this->resetRequest()
    // ->resetResponse();
    
    // $this->request->setPost(array());
    
    // // ...
    // }
    
    // Tests zum Fixture (siehe oben)
    // public function testValidLoginShouldRedirectToProfilePage()
    // {
    // $this->loginUser('foobar', 'foobar');
    // }
    
    // public function testAuthenticatedUserShouldHaveCustomizedProfilePage()
    // {
    // $this->loginUser('foobar', 'foobar');
    // $this->request->setMethod('GET');
    // $this->dispatch('/user/view');
    // $this->assertNotRedirect();
    // $this->assertQueryContentContains('h2', 'foobar');
    // }
    
    // public function
    // testAuthenticatedUsersShouldBeRedirectedToProfileWhenVisitingLogin()
    // {
    // $this->loginUser('foobar', 'foobar');
    // $this->request->setMethod('GET');
    // $this->dispatch('/user');
    // $this->assertRedirectTo('/user/view');
    // }
    
    // public function testUserShouldRedirectToLoginPageOnLogout()
    // {
    // $this->loginUser('foobar', 'foobar');
    // $this->request->setMethod('GET');
    // $this->dispatch('/user/logout');
    // $this->assertRedirectTo('/user');
    // }
    
    // public function testRegistrationShouldFailWithInvalidData()
    // {
    // $data = array(
    // 'username' => 'This will not work',
    // 'email' => 'this is an invalid email',
    // 'password' => 'Th1s!s!nv@l1d',
    // 'passwordVerification' => 'wrong!',
    // );
    // $request = $this->getRequest();
    // $request->setMethod('POST')
    // ->setPost($data);
    // $this->dispatch('/user/register');
    // $this->assertNotRedirect();
    // $this->assertQuery('form .errors');
    // }
}