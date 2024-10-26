<?php

mysqli_report(MYSQLI_REPORT_ALL | MYSQLI_REPORT_STRICT);

try {
  $connection = new mysqli('localhost', 'root', '', 'test_db');
} catch(mysqli_sql_exception $e) {
  trigger_error('database connection error', E_USER_ERROR);
}
