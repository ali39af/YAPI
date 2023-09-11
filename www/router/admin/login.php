<?php
if (!$FromRouter) {
    include '../403.php';
    exit();
}
if (isset($_SESSION["is_login"]))
    if ($_SESSION["is_login"] == "true") {
        header('Location: /admin/dashboard');
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?php echo $app_name; ?> - Login" />
    <meta property="og:description" content="" />
    <meta property="og:site_name" content="<?php echo $app_name; ?>" />
    <meta property="og:image" content="<?php echo $app_logo; ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="theme-color" content="<?php echo $app_theme; ?>" />
    <title><?php echo $app_name; ?> - Login</title>
    <?php include 'router/header.php'; ?>
</head>

<body>

    <center>
        <form action="./events" method="POST" style="margin: 20px;max-width: 350px;margin-top: 100px;margin-bottom: 100px;">
            <h2>Login</h2>

            <?php if (isset($_SESSION["message"])) {
                if (isset($_SESSION["message_color"])) {
                    echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                    unset($_SESSION["message"]);
                    unset($_SESSION["message_color"]);
                }
            } ?>

            <input type="text" name="username" class="form-control" style="margin-top: 5px;" placeholder="Username" required />
            <input type="password" name="password" class="form-control" style="margin-top: 5px;" placeholder="Password" required />
            <div class="d-grid gap-2" style="margin-top: 5px;">
                <button type="submit" name="event" class="btn btn-warning" value="login">Login</button>
            </div>
        </form>
    </center>

    <?php include 'router/footer.php'; ?>

</body>

</html>