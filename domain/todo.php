<?php

require_once __DIR__ . '\..\database\connection.php';
require_once __DIR__ . '\..\domain\user.php';

function getAllTodos()
{
  global $connection;

  try {
    $user = getCurrentUser();

    $statement = $connection->prepare("SELECT * FROM todos FORCE INDEX (user_id) WHERE user_id = ?");

    $statement->bind_param('i', $user->id);
    $statement->execute();

    $result = $statement->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    $statement->close();

    return $data;
  } catch (Exception $e) {
    echo $e->getMessage();

    return null;
  }
}

function createTodo($name)
{
  global $connection;

  try {
    $user = getCurrentUser();

    $statement = $connection->prepare("INSERT INTO todos (user_id, name) VALUES (?, ?)");

    $statement->bind_param('is', $user->id, htmlspecialchars($name));
    $statement->execute();

    $statement->close();

    return 1;
  } catch (Exception $e) {
    return null;
  }
}

function deleteTodo($id)
{
  global $connection;

  try {
    echo $id;

    $statement = $connection->prepare("DELETE FROM todos WHERE id = ?");

    $statement->bind_param('i', htmlspecialchars($id));
    $statement->execute();

    $statement->close();

    return 1;
  } catch (Exception $e) {
    return null;
  }
}

function getSingleTodo($id)
{
  global $connection;

  $id = htmlspecialchars($id);

  try {
    $statement = $connection->prepare("SELECT * FROM todos WHERE id = ?");

    $statement->bind_param('i', $id);
    $statement->execute();

    $result = $statement->get_result();

    $data = $result->fetch_assoc();

    $statement->close();

    return $data;
  } catch (Exception $e) {
    return null;
  }
}

function editTodo($id, $name)
{
  global $connection;

  $id = htmlspecialchars($id);
  $name = htmlspecialchars($name);

  try {
    $statement = $connection->prepare("UPDATE todos SET name = ? WHERE id = ?");

    $statement->bind_param('si', $name, $id);
    $statement->execute();

    $statement->close();

    return 1;
  } catch (Exception $e) {
    return null;
  }
}
