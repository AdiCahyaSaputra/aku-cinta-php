<?php

require_once __DIR__ . '\..\constant\env.php';

function middleware(string $name, $redirectIfGuest = '/login', $redirectIfAuth = '/todo')
{
  switch ($name) {
    case 'guest':
      guest($redirectIfAuth);
      break;

    case 'auth':

      auth($redirectIfAuth, $redirectIfGuest);
      break;
  }
}

function guest(string $redirectIfAuth)
{
  global $BASE_URL;

  $user = checkUserAuth();

  if (!is_null($user)) {
    header('Location: ' . $BASE_URL . $redirectIfAuth);
  }
}

function auth(string $redirectIfAuth, string $redirectIfGuest)
{
  global $BASE_URL;

  $guestUrl = ['/login', '/register'];

  $currentUri = $_SERVER['REQUEST_URI'];
  $user = checkUserAuth();

  if (!is_null($user) && in_array($currentUri, $guestUrl)) {
    header('Location: ' . $BASE_URL . $redirectIfAuth);
  }

  if (is_null($user)) {
    header('Location: ' . $BASE_URL . $redirectIfGuest);
  }
}

function checkUserAuth()
{
  global $SECRET_KEY;

  $token = @$_COOKIE['token'];
  $user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;

  if ($token && !is_null($user)) {
    $verifiedToken = password_verify($user->username . ' - ' . $SECRET_KEY, $token);

    if ($verifiedToken) {
      return isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : null;
    }
  }

  return null;
}
