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
require_once __DIR__ . '\routes.php';

route('/login', function () {
  middleware('guest');

  require_once __DIR__ . '\pages\login.php';
});

route('/register', function () {
  middleware('guest');

  require_once __DIR__ . '\pages\register.php';
});

route('/todo', function () {
  middleware('auth');

  require_once __DIR__ . '\pages\todo.php';
});

route('/todo/{id}', function($params) {
  middleware('auth');
  
  [$id] = $params;

  require_once __DIR__ . '\pages\single-todo.php';
});


route('/todo/{todoId}/user/{userId}', function($params) { // Example aja buat pamer klo route yang di bikin from scratch ini berfungsi 😎
  [$todoId, $userId] = $params;

  echo $todoId . ' ' . $userId;
});

route('/', function() {
  global $BASE_URL;

  header('Location: ' . $BASE_URL . '/todo');
});

require_once __DIR__ . '\pages\404.php';