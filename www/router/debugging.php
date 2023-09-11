<?php
http_response_code(500);
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Error - 500" />
    <meta property="og:description" content="" />
    <meta property="og:site_name" content="<?php echo $app_name; ?>" />
    <meta property="og:image" content="<?php echo $app_logo; ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="theme-color" content="<?php echo $app_theme; ?>" />
    <title>Error - 500</title>

    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="/static/css/error.css" />
</head>

<body>
    <div class="card position-absolute top-50 start-50 translate-middle">
        <div class="card-header">
            <h2>Internal Server Error From PHP Code</h2><button class="btn btn-primary" onclick="window.location.reload();">Reload</button>
        </div>
        <div class="card-body bg-dark text-danger" id="error-text"></div>
    </div>
    <?php include 'footer.php' ?>
    <script src="/static/js/error.js"></script>
    <script>
        writeErrorText(`<?php echo str_replace('`', "`+'`'+`", $error_message); ?>`);
    </script>
</body>

</html>