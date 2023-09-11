<?php
if (!$FromRouter) {
   include '../403.php';
   exit();
}
if (isset($_SESSION["token"]))
    unset($_SESSION["token"]);
if (isset($_SESSION["is_login"]))
    unset($_SESSION["is_login"]);
$_SESSION["message"] = "You are now Logout.";
$_SESSION["message_color"] = "success";
header('Location: /admin/login');
exit();
