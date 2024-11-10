<?php
require_once 'config.php';

try {
	$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;";

	$pdo = new PDO($dsn, $db_user, $db_password);
} catch (PDOException $e) {
	die($e->getMessage());
}

?>

