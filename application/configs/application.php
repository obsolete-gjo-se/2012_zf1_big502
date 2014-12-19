<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/../../application'));

defined('LIBRARY') || define('LIBRARY', realpath(__DIR__ . '/../../library'));


defined('TEST_FIXTURES') || define('TEST_FIXTURES', realpath(__DIR__ . '/../../tests/fixtures'));

defined('APPLICATION_ENV') || define('APPLICATION_ENV', 
        (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

set_include_path(
        implode(PATH_SEPARATOR, 
                array(
                    LIBRARY, 
                    get_include_path(),
                    TEST_FIXTURES                    
                )));

require_once 'Zend/Application.php';