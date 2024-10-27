<?php
require_once __DIR__ . '\..\domain\todo.php';
require_once __DIR__ . '\..\constant\env.php';

$todo = getSingleTodo($id); // variable $id are automagically here 

if (is_null($todo)) {
  trigger_error('failed to get single todo', E_USER_ERROR);
}

$requestMethod = @$_POST['_method'];

if (isset($requestMethod) && $requestMethod === 'put') {
  $todoId = $_POST['id'];
  $todoName = $_POST['name'];

  if (isset($todoId)) {
    $response = editTodo($todoId, $todoName);

    if(is_null($response)) {
      trigger_error('failed to edit todo', E_USER_ERROR);

      exit;
    }

    header('Location: ' . $BASE_URL . '/todo');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo Detail</title>
</head>

<body>
  <button onclick="window.history.back()">kembali</button>
  <h1>Edit todo</h1>

  <form method="post">
    <input type="hidden" name="_method" value="put" />
    <input type="hidden" name="id" value="<?= $todo['id'] ?>" />
    <input type="text" name="name" value="<?= $todo['name'] ?>" required />
    <button>Edit</button>
  </form>
</body>

</html>