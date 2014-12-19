<?php

require_once dirname(__FILE__) . '/application/modules/admin/controllers/UsersControllerTest.php';

/**
 * Static test suite.
 */
class allTests extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct(){
        $this->setName('allTests');

        $this->addTestSuite('Admin_UsersControllerTest');
    }

    /**
     * Creates the suite.
     */
    public static function suite(){
        return new self();
    }
}

