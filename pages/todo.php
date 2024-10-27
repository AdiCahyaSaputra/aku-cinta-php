<?php
require_once __DIR__ . '\..\domain\todo.php';

$todos = getAllTodos();

$requestMethod = @$_POST['_method'];

if (isset($requestMethod) && $requestMethod === 'post') {
  $todoName = $_POST['name'];

  if (isset($todoName)) {
    $response = createTodo($todoName);

    if (is_null($response)) {
      trigger_error("failed to create todo", E_USER_ERROR);

      exit;
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
  }
}

if (isset($requestMethod) && $requestMethod === 'delete') {
  $todoId = $_POST['id'];

  if (isset($todoId)) {
    $response = deleteTodo($todoId);

    if (is_null($response)) {
      trigger_error('failed to delete todo', E_USER_ERROR);
      exit;
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>
</head>

<body>
  <h1>Todo user ini</h1>

  <form method="post">
    <input type="hidden" name="_method" value="post">
    <input type="text" name="name" placeholder="todo name" required>
    <button>buat</button>
  </form>

  <?php foreach ($todos as $todo) : ?>
    <div>
      <p><?= $todo['name']; ?></p>
      <a href="<?= "/todo/" . $todo['id'] ?>">edit</a>
      <form method="post">
        <input type="hidden" name="id" value="<?= $todo['id'] ?>">
        <input type="hidden" name="_method" value="delete">
        <button onclick="return confirm('yakin bre?')">hapus</button>
      </form>
    </div>
  <?php endforeach ?>
</body>

</html>