<?php
if (!$FromRouter) {
    include '../403.php';
    exit();
}
header('Content-Type: application/json; charset=utf-8');
include "./config.php";
if ($api_status == true) {
    http_response_code(202);
    echo '{"status":"202","message":"api is online!"}';
} else {
    http_response_code(503);
    echo '{"status":"503","message":"api is offline!"}';
}
