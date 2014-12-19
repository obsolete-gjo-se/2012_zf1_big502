<?php

class ExampleTestsCode extends Zend_Test_PHPUnit_ControllerTestCase {

    public function test_falseIfNoAtSign(){
        $actual = Application_Model_Example::checkEmail('manuel.kiessling.net');
        $this->assertFalse($actual);
    }

    public function test_trueIfAtSign(){
        $actual = Application_Model_Example::checkEmail('manuel@kiessling.net');
        $this->assertTrue($actual, 'der Fehler liegt hier!');
    }

    public function testIndexActionShouldContainLoginForm(){
        $this->dispatch('/user');
        $this->assertAction('index');
        $this->assertQueryCount('form#loginForm', 1);
    }

    public function testPostAction(){
        $request = $this->getRequest();
        
        $request->setMethod('POST');
        $request->setPost(
                array(
                    'foo' => 'bar', 
                    'baz' => 'x'
                ));
        
        $this->dispatch('/my/post/action');
        $this->assertRedirectTo('/my/expected/redirect');
    }
    
    public function testSave() {
        $my_id = $model->create();
    
        $request = $this->getRequest();
    
        $request->setMethod('POST');
        $request->setPost(array(
                'name' => 'unittest modified',
                'id' => $my_id,
        ));
    
        $this->dispatch("/save/object/");
        $this->assertRedirectRegex('#/edit/object/id/[\d]+$#');
    
        $data = $model->get($my_id);
        $this->assertEquals($data['name'], 'unittest modified');
    
        $my_id = $model->delete($my_id);
    }

    public function testValidLoginShouldGoToProfilePage(){
        $this->request->setMethod('POST')->setPost(
                array(
                    'username' => 'foobar', 
                    'password' => 'foobar'
                ));
        $this->dispatch('/user/login');
        $this->assertRedirectTo('/user/view');
        
        $this->resetRequest()->resetResponse();
        
        $this->request->setMethod('GET')->setPost(array());
        $this->dispatch('/user/view');
        $this->assertRoute('default');
        $this->assertModule('default');
        $this->assertController('user');
        $this->assertAction('view');
        $this->assertNotRedirect();
        $this->assertQuery('dl');
        $this->assertQueryContentContains('h2', 'User: foobar');
    }

    public function testNewArrayIsEmpty(){
        // Create the Array fixture.
        $fixture = array();
        
        // Assert that the size of the Array fixture is 0.
        $this->assertEquals(0, sizeof($fixture));
    }

    public function testArrayContainsAnElement(){
        // Create the Array fixture.
        $fixture = array();
        
        // Add an element to the Array fixture.
        $fixture[] = 'Element';
        
        // Assert that the size of the Array fixture is 1.
        $this->assertEquals(1, sizeof($fixture));
    }

    public function testCallingControllerWithoutActionShouldPullFromIndexAction(){
        $this->dispatch('/user');
        $this->assertResponseCode(200);
        $this->assertController('user');
        $this->assertAction('index');
    }

    public function testIndexActionShouldContainLoginForm2(){
        $this->dispatch('/user');
        $this->assertResponseCode(200);
        $this->assertSelect('form#login');
    }

    public function testValidLoginShouldInitializeAuthSessionAndRedirectToProfilePage(){
        $this->request->setMethod('POST')->setPost(
                array(
                    'username' => 'foobar', 
                    'password' => 'foobar'
                ));
        $this->dispatch('/user/login');
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->assertRedirectTo('/user/view');
    
    }

    public function testIndexWithMessageAction(){
        $this->getRequest()
            ->setParams(array(
            "m" => "test message"
        ))
            ->setMethod('GET');
        $this->dispatch('/');
        $this->assertAction("index");
        $this->assertController("index");
        $this->assertXpathContentContains("id('message')", "test message");
    
    }

    public function testIndexNoMessageAction(){
        $this->dispatch('/');
        $this->assertAction("index");
        $this->assertController("index");
        $this->assertResponseCode(200);
        $this->assertXpathContentContains("id('message')", "no message");
    }

    public function testAboutAction(){
        $this->dispatch("/index/about");
        $this->assertController("index");
        $this->assertAction("about");
        $this->assertResponseCode(200);
    }

    public function testCanAddCountry(){
        $testCountry = "Canada";
        $this->stats->AddCountry($testCountry);
        $countries = $this->stats->GetCountries();
        foreach ($countries as $country) {
            if($testCountry == $country) {
                $this->assertEquals($country, $testCountry);
                break;
            }
        
        }
    }

    public function testGetBody(){
        
        $request = $this->getRequest();
        $request->setMethod('POST')->setPost(
                array(
                    'username' => 'user', 
                    'password' => 'pass'
                ));
        $this->dispatch('/login');
        
        $params = array(
            'action' => 'index', 
            'controller' => 'Foo', 
            'module' => 'bar'
        );
        $url = $this->url($this->urlizeOptions($params));
        
        $this->dispatch($url);
        
        var_dump($this->getResponse()->getBody());
        die();
    }

    public function testLoginDisplaysAForm(){
        $this->dispatch('/auth/index');
        $this->assertQueryContentContains('h1', 'Login');
        $this->assertQuery('form#login'); // id of form
    }

    public function testCallWithoutActionShouldPullFromIndexAction(){
        $this->dispatch('/user');
        $this->assertController('user');
        $this->assertAction('index');
    }

    public function testLoginFormShouldContainLoginAndRegistrationForms(){
        $this->dispatch('/user');
        $this->assertQueryCount('form', 2);
    }

    public function testInvalidCredentialsShouldResultInRedisplayOfLoginForm(){
        $request = $this->getRequest();
        $request->setMethod('POST')->setPost(
                array(
                    'username' => 'bogus', 
                    'password' => 'reallyReallyBogus'
                ));
        $this->dispatch('/user/login');
        $this->assertNotRedirect();
        $this->assertQuery('form');
    }

    public function testValidLoginShouldRedirectToProfilePage(){
        $this->loginUser('foobar', 'foobar');
    }

    public function loginUser($user, $password){
        $this->request->setMethod('POST')->setPost(
                array(
                    'username' => $user, 
                    'password' => $password
                ));
        $this->dispatch('/user/login');
        $this->assertRedirectTo('/user/view');
        $this->resetRequest()->resetResponse();
        
        $this->request->setPost(array());
        
        // ...
    }

    public function testAuthenticatedUserShouldHaveCustomizedProfilePage(){
        $this->loginUser('foobar', 'foobar');
        $this->request->setMethod('GET');
        $this->dispatch('/user/view');
        $this->assertNotRedirect();
        $this->assertQueryContentContains('h2', 'foobar');
    }

    public function testAuthenticatedUsersShouldBeRedirectedToProfileWhenVisitingLogin(){
        $this->loginUser('foobar', 'foobar');
        $this->request->setMethod('GET');
        $this->dispatch('/user');
        $this->assertRedirectTo('/user/view');
    }

    public function testUserShouldRedirectToLoginPageOnLogout(){
        $this->loginUser('foobar', 'foobar');
        $this->request->setMethod('GET');
        $this->dispatch('/user/logout');
        $this->assertRedirectTo('/user');
    }

    public function testRegistrationShouldFailWithInvalidData(){
        $data = array(
            'username' => 'This will not work', 
            'email' => 'this is an invalid email', 
            'password' => 'Th1s!s!nv@l1d', 
            'passwordVerification' => 'wrong!'
        );
        $request = $this->getRequest();
        $request->setMethod('POST')->setPost($data);
        $this->dispatch('/user/register');
        $this->assertNotRedirect();
        $this->assertQuery('form .errors');
    }
}