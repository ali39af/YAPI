<?php
if (!$FromRouter) {
    include '../../403.php';
    exit();
}
header('Content-Type: application/json; charset=utf-8');
if ($api_status == true) {
    $id = stripcslashes($_GET["id"]);
    $id = mysqli_real_escape_string($mysql_connection, $id);
    if ($id == null) {
        http_response_code(405);
        echo '{"status":"405","message":"method not allowed id is null!"}';
        exit;
    }
    $sql_1 = "SELECT * FROM `redirect` WHERE `id` = '" . $id . "'";
    $result = mysqli_query($mysql_connection, $sql_1);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        http_response_code(202);
        echo '{"status":"202","message":"redirection exist!","address":"' . $row["url"] . '"}';
    } else {
        http_response_code(404);
        echo '{"status":"404","message":"redirection not found!"}';
    }
} else {
    http_response_code(503);
    echo '{"status":"503","message":"api is offline!"}';
}
