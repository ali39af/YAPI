<?php
$app_name = "YAPI";
$app_logo = "/static/images/logo.png";
$app_theme = "#ffff00";
$app_login = true;
$api_status = true;

$mysql_host = "db";
$mysql_username = "root";
$mysql_password = "1234";
$mysql_database = "yapi";

$mysql_connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database);

if (mysqli_connect_errno()) {
	$error_message = 'Failed to connect to MySQL: ' . mysqli_connect_error();
	include './router/debugging.php';
	exit();
} else {
	$result = mysqli_query($mysql_connection, "SHOW TABLES LIKE 'users';");
	if ($result && mysqli_num_rows($result) == 0) {
		$error_message = "Please Import DataBase.SQL File On DataBase";
		include './router/debugging.php';
		exit();
	}
}
