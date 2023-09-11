<?php
if (!$FromRouter) {
    include '../403.php';
    exit();
}
$sql = "SELECT * FROM `users`";
$result = mysqli_query($mysql_connection, $sql);
if (mysqli_num_rows($result) == 0) {
    header('Location: /admin/setup');
    exit();
} else {
    header('Location: /admin/login');
    exit();
}
echo var_dump($result);
