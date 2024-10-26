<?php
require_once __DIR__ . '\..\database\connection.php';
require_once __DIR__ . '\..\constant\env.php';

function createToken($username)
{
  global $SECRET_KEY;

  return password_hash($username . ' - ' . $SECRET_KEY, PASSWORD_BCRYPT);
}

function register($username, $password)
{
  global $connection;

  try {
    $username = htmlspecialchars($username);
    $password = password_hash(htmlspecialchars($password), PASSWORD_BCRYPT);

    $statement = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    $statement->bind_param("ss", $username, $password);

    $statement->execute();

    $token = createToken($username);
    $user = [
      'id' => $connection->insert_id,
      'username' => $username,
    ];

    setcookie('token', $token, time() + 60 * 60 * 1); // expire on 1 hour
    setcookie('user', json_encode($user), time() + 60 * 60 * 1); // expire on 1 hour

    $statement->close();
    $connection->close();

    return $user;
  } catch (Exception $e) {
    return null;
  }
}

function login($username, $password)
{
  global $connection;

  try {
    $username = htmlspecialchars($username);

    $statement = $connection->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");

    $statement->bind_param("s", $username);
    $statement->execute();

    $result = $statement->get_result();

    $user = $result->fetch_assoc();

    $statement->close();
    $connection->close();

    if (is_null($user)) {
      return null;
    }

    $verifiedPassword = password_verify(htmlspecialchars($password), $user['password']);

    if ($verifiedPassword) {
      $token = createToken($username);
      $user = [
        'id' => $user['id'],
        'username' => $username,
      ];

      setcookie('token', $token, time() + 60 * 60 * 1); // expire on 1 hour
      setcookie('user', json_encode($user), time() + 60 * 60 * 1); // expire on 1 hour

      return $user;
    }

    return null;
  } catch (Exception $e) {
    return null;
  }
}
