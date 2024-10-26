<?php
require_once __DIR__ . '\..\domain\user.php';
require_once __DIR__ . '\..\constant\env.php';

$username = @$_POST['username'];
$password = @$_POST['password'];

if($username && $password) {
  $response = register($username, $password);

  if(is_null($response)) {
    trigger_error('failed registering the user', E_USER_ERROR);
  } else {
    header('Location: ' . $BASE_URL . '/todo');
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>
<body>
  <h1>Ini halaman register</h1>

  <form method="post">
    <div>
      <label for="username">username</label>
      <input type="text" name="username" id="username">
    </div>

    <div>
      <label for="password">password</label>
      <input type="password" name="password" id="password">
    </div>

    <button>register</button>
  </form>
</body>
</html>