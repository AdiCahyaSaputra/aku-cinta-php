<?php

set_error_handler(function ($errno, $errstr) {
  if ($errno === E_WARNING || $errno === E_ERROR || $errno === E_USER_ERROR) {
    echo $errstr;

    require_once __DIR__ . '\pages\error.php';

    exit;
  }

  return false;
});

require_once __DIR__ . '\database\connection.php';
require_once __DIR__ . '\middleware\index.php';
require_once __DIR__ . '\constant\env.php';

switch ($_SERVER['REQUEST_URI']) {
  case '/login':

    middleware('guest');

    require_once __DIR__ . '\pages\login.php';
    break;

  case '/register':

    middleware('guest');

    require_once __DIR__ . '\pages\register.php';
    break;

  case '/todo':

    middleware('auth');

    require_once __DIR__ . '\pages\todo.php';
    break;

  case '/':
    header('Location: ' . $BASE_URL . '/todo');
    break;

  default:
    require_once __DIR__ . '\pages\404.php';
    break;
}
