<?php

error_reporting(E_ALL | E_STRICT);

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../../application'));

defined('LIBRARY') || define('LIBRARY', realpath(__DIR__ . '/../../../library'));

defined('TEST_FIXTURES') || define('TEST_FIXTURES', realpath(__DIR__ . '/../../../tests/fixtures'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));



// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
        LIBRARY,
        get_include_path(),
        TEST_FIXTURES
)));

require_once 'Zend/Application.php';
require_once 'ControllerTestCase.php';