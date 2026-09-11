<?php
// app/bootstrap.php

ini_set('display_errors', 1);
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('ENVIRONMENT', 'testing');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once APP_PATH . '/config/app.php';
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/includes/functions.php';
require_once APP_PATH . '/includes/csrf.php';
require_once APP_PATH . '/includes/validation.php';
