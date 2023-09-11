<?php
$routeFolders = ["admin", "api"];
$debugging = true;

$FromRouter = true;
try {
    ob_start();
    session_start();
    include 'config.php';

    // Check For Errors
    if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
            case '403':
                include './router/403.php';
                return;
            case '404':
                include './router/404.php';
                return;
            case '500':
                include './router/500.php';
                return;
        }
    }

    $requestPath = str_replace("..", "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

    if ($requestPath === '/' || in_array(trim($requestPath, '/'), $routeFolders)) {
        $targetFile = './router/' . trim($requestPath, '/') . '/index.php';

        if (file_exists($targetFile))
            include $targetFile;
        else
            include './router/404.php';
    } else {
        $pathParts = explode('/', trim($requestPath, '/'));

        if (count($pathParts) > 0 && in_array($pathParts[0], $routeFolders)) {
            $folder = array_shift($pathParts);
            $targetFile = './router/' . $folder . '/' . implode('/', $pathParts) . '.php';
            if (file_exists($targetFile))
                include $targetFile;
            else
                include './router/404.php';
        } else 
            include './router/404.php';
    }
} catch (\Throwable $error_message) {
    ob_clean();
    if ($debugging)
        include './router/debugging.php';
    else 
        include './router/500.php';
}
?>
