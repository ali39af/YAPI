<?php
if (!$FromRouter) {
    include '../../403.php';
    exit();
}
header('Content-Type: application/json; charset=utf-8');
if ($api_status == true) {
    $author_id = stripcslashes($_GET["author_id"]);
    $author_id = mysqli_real_escape_string($mysql_connection, $author_id);
    $app_id = stripcslashes($_GET["app_id"]);
    $app_id = mysqli_real_escape_string($mysql_connection, $app_id);
    $license = stripcslashes($_GET["license"]);
    $license = mysqli_real_escape_string($mysql_connection, $license);
    if ($license == null || $app_id == null || $author_id == null) {
        http_response_code(405);
        echo '{"status":"405","message":"method not allowed null values!"}';
        exit();
    }
    $sql_1 = "SELECT * FROM `license` WHERE `app_id` = '" . $app_id . "' AND `license` = '" . $license . "' AND `author_id` = '" . $author_id . "'";
    $result = mysqli_query($mysql_connection, $sql_1);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        http_response_code(202);
        echo '{"status":"202","message":"license exist","license":"' . $license . '","app_id":"' . $app_id . '","owner_id":"' . $row["owner_id"] . '","eval":"' . (($row["eval"] == '') ? 'false' : 'true') . '"}';
    } else {
        http_response_code(404);
        echo '{"status":"404","message":"license not found!"}';
    }
} else {
    http_response_code(503);
    echo '{"status":"503","message":"api is offline!"}';
}
