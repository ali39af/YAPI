<?php
if (!$FromRouter) {
    include '../403.php';
    exit();
}
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);

if (isset($_POST["event"])) {
    if ($_POST["event"] == "login") {
        if ($app_login == true) {
            if (isset($_POST["username"])) {
                if (isset($_POST["password"])) {
                    $username = stripcslashes($_POST["username"]);
                    $password = stripcslashes($_POST["password"]);
                    $username = mysqli_real_escape_string($mysql_connection, $username);
                    $password = mysqli_real_escape_string($mysql_connection, $password);
                    $sql = "select * from users where username = '" . $username . "' and password = '" . md5($password) . "'";
                    $result = mysqli_query($mysql_connection, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $_SESSION["token"] = $row["token"];
                        $_SESSION["is_login"] = "true";
                        header('Location: /admin/dashboard');
                        exit();
                    } else {
                        $_SESSION["message"] = "Login Failed.";
                        $_SESSION["message_color"] = "danger";
                        if (isset($_SESSION["is_login"])) {
                            if ($_SESSION["is_login"] == "true") {
                                unset($_SESSION["is_login"]);
                            }
                        }
                        if (isset($_SESSION["token"])) {
                            unset($_SESSION["token"]);
                        }
                        header('Location: /admin/login');
                        exit();
                    }
                }
            }
        } else {
            $_SESSION["message"] = "Login Disable.";
            $_SESSION["message_color"] = "danger";
            header('Location: /admin/login');
            exit();
        }
    }
    if (isset($_SESSION["token"])) {
        $token = stripcslashes($_SESSION["token"]);
        $token = mysqli_real_escape_string($mysql_connection, $token);
        $sql_1 = "SELECT * FROM `users` WHERE `token` = '" . $token . "'";
        $result_1 = mysqli_query($mysql_connection, $sql_1);
        $row_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
        $count_1 = mysqli_num_rows($result_1);
        if ($count_1 != 1) {
            $_SESSION["message"] = "Your token is invalid.";
            if (isset($_SESSION["is_login"])) {
                if ($_SESSION["is_login"] == "true") {
                    unset($_SESSION["is_login"]);
                }
            }
            if (isset($_SESSION["token"])) {
                unset($_SESSION["token"]);
            }
            header('Location: /admin/login');
            exit();
        } else {
            if ($_POST["event"] == "data_edit") {
                if (isset($_POST["id"])) {
                    if (isset($_POST["data"])) {
                        $id = stripcslashes($_POST["id"]);
                        $data = stripcslashes($_POST["data"]);
                        $id = mysqli_real_escape_string($mysql_connection, $id);
                        $data = mysqli_real_escape_string($mysql_connection, $data);
                        $sql = "SELECT * FROM `data` WHERE `id` = '" . $id . "' AND `author_id` = " . $row_1["id"];
                        $result = mysqli_query($mysql_connection, $sql);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $count = mysqli_num_rows($result);
                        if ($count == 1) {
                            $sql_2 = "UPDATE `data` SET `data` = '" . $data . "' WHERE `data`.`id` = '" . $id . "';";
                            $sql_3 = "UPDATE `data` SET `create_or_edit_date` = '" . date("Y-m-d") . "' WHERE `data`.`id` = '" . $id . "';";
                            if (mysqli_query($mysql_connection, $sql_2)) {
                                if (mysqli_query($mysql_connection, $sql_3)) {
                                    $_SESSION["message"] = "Editing Done.";
                                    $_SESSION["message_color"] = "success";
                                    header('Location: /admin/dashboard?loc=data_edit&id=' . $id);
                                    exit();
                                } else {
                                    $_SESSION["message"] = "Editing Failed.";
                                    $_SESSION["message_color"] = "danger";
                                    header('Location: /admin/dashboard?loc=data_edit&id=' . $id);
                                    exit();
                                }
                            } else {
                                $_SESSION["message"] = "Editing Failed.";
                                $_SESSION["message_color"] = "danger";
                                header('Location: /admin/dashboard?loc=data_edit&id=' . $id);
                                exit();
                            }
                        } else {
                            $_SESSION["message"] = "Editing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=data_edit&id=' . $id);
                            exit();
                        }
                    }
                }
            }
            if ($_POST["event"] == "data_create") {
                if (isset($_POST["data"])) {
                    $data = stripcslashes($_POST["data"]);
                    $data = mysqli_real_escape_string($mysql_connection, $data);
                    $sql = "INSERT INTO `data` (`id`, `author_id`, `data`, `create_or_edit_date`) VALUES (NULL, '" . $row_1["id"] . "', '" . $data . "', '" . date("Y-m-d") . "');";
                    if (mysqli_query($mysql_connection, $sql)) {
                        $_SESSION["message"] = "Creating Done.";
                        $_SESSION["message_color"] = "success";
                        header('Location: /admin/dashboard?loc=data');
                        exit();
                    } else {
                        $_SESSION["message"] = "Creating Failed.";
                        $_SESSION["message_color"] = "danger";
                        header('Location: /admin/dashboard?loc=data_create');
                        exit();
                    }
                }
            }
            if ($_POST["event"] == "data_remove") {
                if (isset($_POST["data_id"])) {
                    $data_id = stripcslashes($_POST["data_id"]);
                    $data_id = mysqli_real_escape_string($mysql_connection, $data_id);
                    $sql = "SELECT * FROM `data` WHERE `id` = '" . $data_id . "' AND `author_id` = " . $row_1["id"];
                    $result = mysqli_query($mysql_connection, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $sql_2 = "DELETE FROM `data` WHERE `data`.`id` = '" . $data_id . "'";
                        if (mysqli_query($mysql_connection, $sql_2)) {
                            $_SESSION["message"] = "Removing Done.";
                            $_SESSION["message_color"] = "success";
                            header('Location: /admin/dashboard?loc=data');
                            exit();
                        } else {
                            $_SESSION["message"] = "Removing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=data_remove&id=' . $data_id);
                            exit();
                        }
                    } else {
                        $_SESSION["message"] = "Removing Failed.";
                        $_SESSION["message_color"] = "danger";
                        header('Location: /admin/dashboard?loc=data_remove&id=' . $data_id);
                        exit();
                    }
                }
            }
            if ($_POST["event"] == "redirect_edit") {
                if (isset($_POST["id"])) {
                    if (isset($_POST["url"])) {
                        $id = stripcslashes($_POST["id"]);
                        $url = stripcslashes($_POST["url"]);
                        $id = mysqli_real_escape_string($mysql_connection, $id);
                        $url = mysqli_real_escape_string($mysql_connection, $url);
                        $sql = "SELECT * FROM `redirect` WHERE `id` = '" . $id . "' AND `author_id` = " . $row_1["id"];
                        $result = mysqli_query($mysql_connection, $sql);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $count = mysqli_num_rows($result);
                        if ($count == 1) {
                            $sql_2 = "UPDATE `redirect` SET `url` = '" . $url . "' WHERE `redirect`.`id` = '" . $id . "';";
                            $sql_3 = "UPDATE `redirect` SET `create_or_edit_date` = '" . date("Y-m-d") . "' WHERE `redirect`.`id` = '" . $id . "';";
                            if (mysqli_query($mysql_connection, $sql_2)) {
                                if (mysqli_query($mysql_connection, $sql_3)) {
                                    $_SESSION["message"] = "Editing Done.";
                                    $_SESSION["message_color"] = "success";
                                    header('Location: /admin/dashboard?loc=redirect_edit&id=' . $id);
                                    exit();
                                } else {
                                    $_SESSION["message"] = "Editing Failed.";
                                    $_SESSION["message_color"] = "danger";
                                    header('Location: /admin/dashboard?loc=redirect_edit&id=' . $id);
                                    exit();
                                }
                            } else {
                                $_SESSION["message"] = "Editing Failed.";
                                $_SESSION["message_color"] = "danger";
                                header('Location: /admin/dashboard?loc=redirect_edit&id=' . $id);
                                exit();
                            }
                        } else {
                            $_SESSION["message"] = "Editing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=redirect_edit&id=' . $id);
                            exit();
                        }
                    }
                }
            }
            if ($_POST["event"] == "redirect_create") {
                if (isset($_POST["url"])) {
                    $url = stripcslashes($_POST["url"]);
                    $url = mysqli_real_escape_string($mysql_connection, $url);
                    $sql = "INSERT INTO `redirect` (`id`, `author_id`, `url`, `create_or_edit_date`) VALUES (NULL, '" . $row_1["id"] . "', '" . $url . "', '" . date("Y-m-d") . "');";
                    if (mysqli_query($mysql_connection, $sql)) {
                        $_SESSION["message"] = "Creating Done.";
                        $_SESSION["message_color"] = "success";
                        header('Location: /admin/dashboard?loc=redirect');
                        exit();
                    } else {
                        $_SESSION["message"] = "Creating Failed.";
                        $_SESSION["message"] = "#dc3545";
                        header('Location: /admin/dashboard?loc=redirect_create');
                        exit();
                    }
                }
            }
            if ($_POST["event"] == "redirect_remove") {
                if (isset($_POST["redirect_id"])) {
                    $redirect_id = stripcslashes($_POST["redirect_id"]);
                    $redirect_id = mysqli_real_escape_string($mysql_connection, $redirect_id);
                    $sql = "SELECT * FROM `redirect` WHERE `id` = '" . $redirect_id . "' AND `author_id` = " . $row_1["id"];
                    $result = mysqli_query($mysql_connection, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $sql_2 = "DELETE FROM `redirect` WHERE `redirect`.`id` = '" . $redirect_id . "'";
                        if (mysqli_query($mysql_connection, $sql_2)) {
                            $_SESSION["message"] = "Removing Done.";
                            $_SESSION["message_color"] = "success";
                            header('Location: /admin/dashboard?loc=redirect');
                            exit();
                        } else {
                            $_SESSION["message"] = "Removing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=redirect_remove&id=' . $redirect_id);
                            exit();
                        }
                    } else {
                        $_SESSION["message"] = "Removing Failed.";
                        $_SESSION["message_color"] = "danger";
                        header('Location: /admin/dashboard?loc=redirect_remove&id=' . $redirect_id);
                        exit();
                    }
                }
            }
            if ($_POST["event"] == "license_edit") {
                if (isset($_POST["id"])) {
                    if (isset($_POST["app_id"])) {
                        if (isset($_POST["owner_id"])) {
                            if (isset($_POST["license"])) {
                                if (isset($_POST["eval"])) {
                                    $id = stripcslashes($_POST["id"]);
                                    $app_id = stripcslashes($_POST["app_id"]);
                                    $owner_id = stripcslashes($_POST["owner_id"]);
                                    $license = stripcslashes($_POST["license"]);
                                    $eval = stripcslashes($_POST["eval"]);
                                    $id = mysqli_real_escape_string($mysql_connection, $id);
                                    $app_id = mysqli_real_escape_string($mysql_connection, $app_id);
                                    $owner_id = mysqli_real_escape_string($mysql_connection, $owner_id);
                                    $license = mysqli_real_escape_string($mysql_connection, $license);
                                    $eval = mysqli_real_escape_string($mysql_connection, $eval);
                                    $sql = "SELECT * FROM `license` WHERE `id` = '" . $id . "' AND `author_id` = " . $row_1["id"];
                                    $result = mysqli_query($mysql_connection, $sql);
                                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                    $count = mysqli_num_rows($result);
                                    if ($count == 1) {
                                        $sql_2 = "UPDATE `license` SET `app_id` = '" . $app_id . "' WHERE `license`.`id` = '" . $id . "';";
                                        $sql_3 = "UPDATE `license` SET `owner_id` = '" . $owner_id . "' WHERE `license`.`id` = '" . $id . "';";
                                        $sql_4 = "UPDATE `license` SET `license` = '" . $license . "' WHERE `license`.`id` = '" . $id . "';";
                                        $sql_5 = "UPDATE `license` SET `eval` = '" . $eval . "' WHERE `license`.`id` = '" . $id . "';";
                                        $sql_6 = "UPDATE `license` SET `create_or_edit_date` = '" . date("Y-m-d") . "' WHERE `license`.`id` = '" . $id . "';";
                                        if (mysqli_query($mysql_connection, $sql_2)) {
                                            if (mysqli_query($mysql_connection, $sql_3)) {
                                                if (mysqli_query($mysql_connection, $sql_4)) {
                                                    if (mysqli_query($mysql_connection, $sql_5)) {
                                                        if (mysqli_query($mysql_connection, $sql_6)) {
                                                            $_SESSION["message"] = "Editing Done.";
                                                            $_SESSION["message_color"] = "success";
                                                            header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                                            exit();
                                                        } else {
                                                            $_SESSION["message"] = "Editing Failed.";
                                                            $_SESSION["message_color"] = "danger";
                                                            header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                                            exit();
                                                        }
                                                    } else {
                                                        $_SESSION["message"] = "Editing Failed.";
                                                        $_SESSION["message_color"] = "danger";
                                                        header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                                        exit();
                                                    }
                                                } else {
                                                    $_SESSION["message"] = "Editing Failed.";
                                                    $_SESSION["message_color"] = "danger";
                                                    header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                                    exit();
                                                }
                                            } else {
                                                $_SESSION["message"] = "Editing Failed.";
                                                $_SESSION["message_color"] = "danger";
                                                header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                                exit();
                                            }
                                        } else {
                                            $_SESSION["message"] = "Editing Failed.";
                                            $_SESSION["message_color"] = "danger";
                                            header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                            exit();
                                        }
                                    } else {
                                        $_SESSION["message"] = "Editing Failed.";
                                        $_SESSION["message_color"] = "danger";
                                        header('Location: /admin/dashboard?loc=license_edit&id=' . $id);
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($_POST["event"] == "license_create") {
                if (isset($_POST["app_id"])) {
                    if (isset($_POST["owner_id"])) {
                        if (isset($_POST["eval"])) {
                            $app_id = stripcslashes($_POST["app_id"]);
                            $owner_id = stripcslashes($_POST["owner_id"]);
                            $eval = stripcslashes($_POST["eval"]);
                            $app_id = mysqli_real_escape_string($mysql_connection, $app_id);
                            $owner_id = mysqli_real_escape_string($mysql_connection, $owner_id);
                            $eval = mysqli_real_escape_string($mysql_connection, $eval);
                            $random_license_string = '';
                            for ($i = 0; $i < 12; $i++) {
                                $random_license_string .= $characters[rand(0, $charactersLength - 1)];
                            }
                            $sql = "INSERT INTO `license` (`id`, `author_id`, `app_id`, `owner_id`, `license`, `eval`, `create_or_edit_date`) VALUES (NULL, '" . $row_1["id"] . "', '" . $app_id . "', '" . $owner_id . "', '" . $random_license_string . "', '" . $eval . "', '" . date("Y-m-d") . "');";
                            if (mysqli_query($mysql_connection, $sql)) {
                                $_SESSION["message"] = "Creating Done.";
                                $_SESSION["message_color"] = "success";
                                header('Location: /admin/dashboard?loc=license');
                                exit();
                            } else {
                                $_SESSION["message"] = "Creating Failed.";
                                $_SESSION["message_color"] = "danger";
                                header('Location: /admin/dashboard?loc=license_create');
                                exit();
                            }
                        }
                    }
                }
            }
            if ($_POST["event"] == "license_remove") {
                if (isset($_POST["license_id"])) {
                    $license_id = stripcslashes($_POST["license_id"]);
                    $license_id = mysqli_real_escape_string($mysql_connection, $license_id);
                    $sql = "SELECT * FROM `license` WHERE `id` = '" . $license_id . "' AND `author_id` = " . $row_1["id"];
                    $result = mysqli_query($mysql_connection, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $sql_2 = "DELETE FROM `license` WHERE `license`.`id` = '" . $license_id . "'";
                        if (mysqli_query($mysql_connection, $sql_2)) {
                            $_SESSION["message"] = "Removing Done.";
                            $_SESSION["message_color"] = "success";
                            header('Location: /admin/dashboard?loc=license');
                            exit();
                        } else {
                            $_SESSION["message"] = "Removing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=license_remove&id=' . $license_id);
                            exit();
                        }
                    } else {
                        $_SESSION["message"] = "Removing Failed.";
                        $_SESSION["message_color"] = "danger";
                        header('Location: /admin/dashboard?loc=license_remove&id=' . $license_id);
                        exit();
                    }
                }
            }
            if ($_POST["event"] == "update_edit") {
                if (isset($_POST["id"])) {
                    if (isset($_POST["version"])) {
                        if (isset($_POST["news"])) {
                            if (isset($_POST["download"])) {
                                $id = stripcslashes($_POST["id"]);
                                $version = stripcslashes($_POST["version"]);
                                $news = stripcslashes($_POST["news"]);
                                $download = stripcslashes($_POST["download"]);
                                $id = mysqli_real_escape_string($mysql_connection, $id);
                                $version = mysqli_real_escape_string($mysql_connection, $version);
                                $news = mysqli_real_escape_string($mysql_connection, $news);
                                $download = mysqli_real_escape_string($mysql_connection, $download);
                                $sql = "SELECT * FROM `update` WHERE `id` = '" . $id . "' AND `author_id` = " . $row_1["id"];
                                $result = mysqli_query($mysql_connection, $sql);
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                $count = mysqli_num_rows($result);
                                if ($count == 1) {
                                    $sql_2 = "UPDATE `update` SET `version` = '" . $version . "' WHERE `update`.`id` = '" . $id . "';";
                                    $sql_3 = "UPDATE `update` SET `news` = '" . $news . "' WHERE `update`.`id` = '" . $id . "';";
                                    $sql_4 = "UPDATE `update` SET `download` = '" . $download . "' WHERE `update`.`id` = '" . $id . "';";
                                    $sql_5 = "UPDATE `update` SET `create_or_edit_date` = '" . date("Y-m-d") . "' WHERE `update`.`id` = '" . $id . "';";
                                    if (mysqli_query($mysql_connection, $sql_2)) {
                                        if (mysqli_query($mysql_connection, $sql_3)) {
                                            if (mysqli_query($mysql_connection, $sql_4)) {
                                                if (mysqli_query($mysql_connection, $sql_5)) {
                                                    $_SESSION["message"] = "Editing Done.";
                                                    $_SESSION["message_color"] = "success";
                                                    header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                                    exit();
                                                } else {
                                                    $_SESSION["message"] = "Editing Failed.";
                                                    $_SESSION["message_color"] = "danger";
                                                    header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                                    exit();
                                                }
                                            } else {
                                                $_SESSION["message"] = "Editing Failed.";
                                                $_SESSION["message_color"] = "danger";
                                                header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                                exit();
                                            }
                                        } else {
                                            $_SESSION["message"] = "Editing Failed.";
                                            $_SESSION["message_color"] = "danger";
                                            header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                            exit();
                                        }
                                    } else {
                                        $_SESSION["message"] = "Editing Failed.";
                                        $_SESSION["message_color"] = "danger";
                                        header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                        exit();
                                    }
                                } else {
                                    $_SESSION["message"] = "Editing Failed.";
                                    $_SESSION["message_color"] = "danger";
                                    header('Location: /admin/dashboard?loc=update_edit&id=' . $id);
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
            if ($_POST["event"] == "update_create") {
                if (isset($_POST["version"])) {
                    if (isset($_POST["news"])) {
                        if (isset($_POST["download"])) {
                            $version = stripcslashes($_POST["version"]);
                            $news = stripcslashes($_POST["news"]);
                            $download = stripcslashes($_POST["download"]);
                            $version = mysqli_real_escape_string($mysql_connection, $version);
                            $news = mysqli_real_escape_string($mysql_connection, $news);
                            $download = mysqli_real_escape_string($mysql_connection, $download);
                            $sql = "INSERT INTO `update` (`id`, `author_id`, `version`, `news`, `download`, `create_or_edit_date`) VALUES (NULL, '" . $row_1["id"] . "', '" . $version . "', '" . $news . "', '" . $download . "', '" . date("Y-m-d") . "');";
                            if (mysqli_query($mysql_connection, $sql)) {
                                $_SESSION["message"] = "Creating Done.";
                                $_SESSION["message_color"] = "success";
                                header('Location: /admin/dashboard?loc=update');
                                exit();
                            } else {
                                $_SESSION["message"] = "Creating Failed.";
                                $_SESSION["message_color"] = "danger";
                                header('Location: /admin/dashboard?loc=update_create');
                                exit();
                            }
                        }
                    }
                }
            }
            if ($_POST["event"] == "update_remove") {
                if (isset($_POST["update_id"])) {
                    $update_id = stripcslashes($_POST["update_id"]);
                    $update_id = mysqli_real_escape_string($mysql_connection, $update_id);
                    $sql = "SELECT * FROM `update` WHERE `id` = '" . $update_id . "' AND `author_id` = " . $row_1["id"];
                    $result = mysqli_query($mysql_connection, $sql);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        $sql_2 = "DELETE FROM `update` WHERE `update`.`id` = '" . $update_id . "'";
                        if (mysqli_query($mysql_connection, $sql_2)) {
                            $_SESSION["message"] = "Removing Done.";
                            $_SESSION["message_color"] = "success";
                            header('Location: /admin/dashboard?loc=update');
                            exit();
                        } else {
                            $_SESSION["message"] = "Removing Failed.";
                            $_SESSION["message_color"] = "danger";
                            header('Location: /admin/dashboard?loc=update_remove&id=' . $update_id);
                            exit();
                        }
                    } else {
                        $_SESSION["message"] = "Removing Failed.";
                        $_SESSION["message_color"] = "danger";
                        header('Location: /admin/dashboard?loc=update_remove&id=' . $update_id);
                        exit();
                    }
                }
            }
        }
    }
    if ($_POST["event"] == "setup") {
        if (isset($_POST["username"])) {
            if (isset($_POST["password"])) {
                if (isset($_POST["confirm_password"])) {
                    if ($_POST["password"] == $_POST["confirm_password"]) {
                        $username = stripcslashes($_POST["username"]);
                        $password = stripcslashes($_POST["password"]);
                        $confirm_password = stripslashes($_POST["confirm_password"]);
                        $username = mysqli_real_escape_string($mysql_connection, $username);
                        $password = mysqli_real_escape_string($mysql_connection, $password);
                        $confirm_password = mysqli_real_escape_string($mysql_connection, $confirm_password);
                        $random_token_string = '';
                        for ($i = 0; $i < 128; $i++) {
                            $random_token_string .= $characters[rand(0, $charactersLength - 1)];
                        }
                        $sql = "INSERT INTO `users` (`id`, `username`, `password`, `token`) VALUES (NULL, '" . $username . "', '" . md5($password) . "', '" . $random_token_string . "');";
                        if (mysqli_query($mysql_connection, $sql)) {
                            $_SESSION["message"] = "Setup Done You Can Login Now.";
                            $_SESSION["message_color"] = "success";
                            if (isset($_SESSION["is_login"])) if ($_SESSION["is_login"] == "true") unset($_SESSION["is_login"]);
                            if (isset($_SESSION["token"])) unset($_SESSION["token"]);
                            header('Location: /admin/login');
                            exit();
                        } else {
                            $_SESSION["message"] = "Setup Failed.";
                            $_SESSION["message_color"] = "danger";
                            if (isset($_SESSION["is_login"])) if ($_SESSION["is_login"] == "true") unset($_SESSION["is_login"]);
                            if (isset($_SESSION["token"])) unset($_SESSION["token"]);
                            header('Location: /admin/setup');
                            exit();
                        }
                    } else {
                        $_SESSION["message"] = "Password Not Confirm!";
                        $_SESSION["message_color"] = "danger";
                        if (isset($_SESSION["is_login"])) if ($_SESSION["is_login"] == "true") unset($_SESSION["is_login"]);
                        if (isset($_SESSION["token"])) unset($_SESSION["token"]);
                        header('Location: /admin/setup');
                        exit();
                    }
                }
            }
        }
    }
} else {
    header('Location: /admin');
    exit();
}
