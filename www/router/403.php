<?php
http_response_code(403);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Error - 403" />
    <meta property="og:description" content="" />
    <meta property="og:site_name" content="<?php echo $app_name; ?>" />
    <meta property="og:image" content="<?php echo $app_logo; ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="theme-color" content="<?php echo $app_theme; ?>" />
    <title>Error - 403</title>

    <?php include 'header.php'; ?>
</head>

<body>
    <center>
        <h1 style="font-size: 120px;margin-top: 200px;">403</h1>
        <h6 style="margin-top: 3px;">Forbidden!</h6>
    </center>

    <?php include 'footer.php'; ?>
</body>

</html>