<?php

require_once '/application/modules/admin/controllers/Verify.php';

class Admin_VerifyTest extends Zend_Test_PHPUnit_ControllerTestCase {

    public function setUp(){
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, 
                APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function test_falseIfNoAtSign(){
        $actual = Admin_Verify::checkEmail('manuel.kiessling.net');
        $this->assertFalse($actual);
    
    }

    public function test_trueIfAtSign(){
        $actual = Admin_Verify::checkEmail('manuel@kiessling.net');
        $this->assertTrue($actual);        
    }

}
