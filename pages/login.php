<?php
require_once __DIR__ . '\..\domain\user.php';
require_once __DIR__ . '\..\constant\env.php';

$username = @$_POST['username'];
$password = @$_POST['password'];

$loginFailed = false;

if ($username && $password) {
  $response = login($username, $password);

  if (is_null($response)) {
    $loginFailed = true;
  } else {
    $loginFailed = false;

    header('Location: ' . $BASE_URL . '/todo');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <?php if($loginFailed) : ?>
    <p>Kredensial salah</p>
  <?php endif; ?>
  <h1>Halaman Login</h1>

  <form method="post">
    <div>
      <label for="username">username</label>
      <input type="text" name="username" id="username">
    </div>

    <div>
      <label for="password">password</label>
      <input type="password" name="password" id="password">
    </div>

    <button>login</button>
  </form>

  <a href="/register">Belom punya akun</a>
</body>

</html>