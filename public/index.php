<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */

chdir(dirname(__DIR__));

define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?? 'production');
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../module'));

if (APPLICATION_ENV == 'production') {
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../maestrobet.site/module'));
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include APPLICATION_PATH . '/../vendor/autoload.php';

if (!class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
            . "- Type `composer install` if you are developing locally.\n"
            . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
            . "- Type `docker-compose run zf composer install` if you are using Docker.\n"
    );
}
// Retrieve configuration
$appConfig = require APPLICATION_PATH . '/../config/application.config.php';
if (file_exists(APPLICATION_PATH . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require APPLICATION_PATH . '/../config/development.config.php');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Run the application!
Application::init($appConfig)->run();
