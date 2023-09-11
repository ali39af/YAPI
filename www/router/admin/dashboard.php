<?php
if (!$FromRouter) {
    include '../403.php';
    exit();
}
$is_page_error = "true";
if (!isset($_SESSION["is_login"])) {
    if (!isset($_SESSION["token"])) {
        $_SESSION["message"] = "Please Login first.";
        header('Location: /admin/login');
        exit();
    }
} else {
    if (isset($_SESSION["token"])) {
        $is_page_error = "false";
    }
}
if ($is_page_error == "true") {
    $_SESSION["message"] = "Unknown error please try again.";
    if (isset($_SESSION["is_login"]))
        unset($_SESSION["is_login"]);
    if (isset($_SESSION["token"]))
        unset($_SESSION["token"]);
    header('Location: /admin/login ');
    exit();
} else {
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
        if (!isset($_GET["loc"])) {
            header('Location: /admin/dashboard?loc=dashboard');
            exit();
        }
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta property="og:title" content="<?php echo $app_name; ?> - App" />
            <meta property="og:description" content="" />
            <meta property="og:site_name" content="<?php echo $app_name; ?>" />
            <meta property="og:image" content="<?php echo $app_logo; ?>" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta name="theme-color" content="<?php echo $app_theme; ?>" />
            <title><?php echo $app_name; ?> - Dashboard</title>
            <?php include 'router/header.php'; ?>

            <link rel="stylesheet" href="/static/css/dashboard.css" />
        </head>

        <body>

            <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
                <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="/admin/dashboard?loc=dashboard"><?php echo $app_name; ?></a>
                <button class="navbar-toggler position-absolute d-md-none collapsed" style="margin-right: 55px;" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav">
                    <div class="nav-item text-nowrap">
                        <a class="nav-link px-3" href="/admin/logout">Logout</a>
                    </div>
                </div>
            </header>

            <div class="container-fluid">
                <div class="row">
                    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="position-sticky pt-3 sidebar-sticky">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'dashboard') {
                                                            echo "active";
                                                        } ?>" aria-current="page" href="/admin/dashboard?loc=dashboard">
                                        <span data-feather="home" class="align-text-bottom"></span>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'data') {
                                                            echo "active";
                                                        } ?>" href="/admin/dashboard?loc=data">
                                        <span data-feather="file" class="align-text-bottom"></span>
                                        Data
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'redirect') {
                                                            echo "active";
                                                        } ?>" href="/admin/dashboard?loc=redirect">
                                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                        Redirect
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'license') {
                                                            echo "active";
                                                        } ?>" href="/admin/dashboard?loc=license">
                                        <span data-feather="users" class="align-text-bottom"></span>
                                        License
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'update') {
                                                            echo "active";
                                                        } ?>" href="/admin/dashboard?loc=update">
                                        <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                                        Update
                                    </a>
                                </li>
                            </ul>

                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                                <span>INFO</span>
                                <a class="link-secondary" href="/admin/dashboard?loc=docoment" aria-label="Add a new report">
                                    <span data-feather="plus-circle" class="align-text-bottom"></span>
                                </a>
                            </h6>
                            <ul class="nav flex-column mb-2">
                                <li class="nav-item">
                                    <a class="nav-link <?php if ($_GET['loc'] == 'docoment') {
                                                            echo "active";
                                                        } ?>" href="/admin/dashboard?loc=docoment">
                                        <span data-feather="file-text" class="align-text-bottom"></span>
                                        Docoment
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://yservices.ir">
                                        <span data-feather="file-text" class="align-text-bottom"></span>
                                        Webiste
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2"><?php if ($_GET["loc"] == 'dashboard') {
                                                echo "Dashbaord";
                                            }
                                            if ($_GET["loc"] == 'data') {
                                                echo "Data";
                                            }
                                            if ($_GET["loc"] == 'redirect') {
                                                echo "Redirect";
                                            }
                                            if ($_GET["loc"] == 'license') {
                                                echo "License";
                                            }
                                            if ($_GET["loc"] == 'update') {
                                                echo "Update";
                                            }
                                            if ($_GET["loc"] == 'docoment') {
                                                echo "Docoment";
                                            } ?></h1>
                        </div>

                        <?php
                        if (isset($_GET["loc"])) {
                            if ($_GET["loc"] == 'docoment') {
                        ?>

                                <div class="container mt-4">
                                    <h1>API Documentation - Version 1.1</h1>

                                    <div class="accordion" id="accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStatusCheck" aria-expanded="true" aria-controls="collapseStatusCheck">
                                                    API Status
                                                </button>
                                            </h2>
                                            <div id="collapseStatusCheck" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <h2>API Status</h2>
                                                    <p><strong>Method:</strong> GET -> Check Website Status</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 202: API is online!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 503: API is offline!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "202",
    "message": "API is online!"
}

{
    "status": "503",
    "message": "API is offline!"
}
        </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExistData" aria-expanded="true" aria-controls="collapseExistData">
                                                    Check Data Exist
                                                </button>
                                            </h2>
                                            <div id="collapseExistData" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <h2>Check Data Exist</h2>
                                                    <p><strong>Method:</strong> GET -> Check Exist Data</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/data/check/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 202: data exist!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: data not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "202",
    "message": "data exist!"
}

{
    "status": "404",
    "message": "data not found!"
}
        </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/data/check/?id=1000"

response = requests.get(url)

if response.status_code == 202:
    print("Data exists!")
else:
    print("Data not found!")
        </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/data/check/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 202) {
            console.log("Data exists!");
        } else {
            console.log("Data not found!");
        }
    })
    .catch(error => {
        console.error(error);
    });
        </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetData" aria-expanded="true" aria-controls="collapseGetData">
                                                    Get Data
                                                </button>
                                            </h2>
                                            <div id="collapseGetData" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Get Data Details -->
                                                    <h2>Get Data</h2>
                                                    <p><strong>Method:</strong> GET -> Get Data</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/data/get/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 200: Data retrieved successfully!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: Data not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "200",
    "message": "Data retrieved successfully!"
}

{
    "status": "404",
    "message": "Data not found!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/data/get/?id=1000"

response = requests.get(url)

if response.status_code == 200:
    print("Data retrieved successfully!")
else:
    print("Data not found!")
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/data/get/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 200) {
            console.log("Data retrieved successfully!");
        } else {
            console.log("Data not found!");
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExistRedirect" aria-expanded="true" aria-controls="collapseExistRedirect">
                                                    Check Exist Redirect
                                                </button>
                                            </h2>
                                            <div id="collapseExistRedirect" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Check Exist Redirect Details -->
                                                    <h2>Check Exist Redirect</h2>
                                                    <p><strong>Method:</strong> GET -> Check Exist Redirect</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/redirect/check/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 202: Redirection exists!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: Redirection not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "202",
    "message": "Redirection exists!",
    "address": "https://aparat.com"
}

{
    "status": "404",
    "message": "Redirection not found!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/redirect/check/?id=1000"

response = requests.get(url)

if response.status_code == 202:
    print("Redirection exists at:", response.json()["address"])
else:
    print("Redirection not found!")
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/redirect/check/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 202) {
            console.log("Redirection exists at:", response.data.address);
        } else {
            console.log("Redirection not found!");
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetRedirectFile" aria-expanded="true" aria-controls="collapseGetRedirectFile">
                                                    Get Redirect Location
                                                </button>
                                            </h2>
                                            <div id="collapseGetRedirectFile" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Get Redirect Location Details -->
                                                    <h2>Get Redirect Location</h2>
                                                    <p><strong>Method:</strong> GET -> Get Redirect Location</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/redirect/get/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 302: Redirecting to Target Location
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: Redirection not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "302",
    "message": "Redirecting to Target Location"
}

{
    "status": "404",
    "message": "Redirection not found!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/redirect/get/?id=1000"

response = requests.get(url)

if response.status_code == 302:
    print("Redirecting to:", response.headers['Location'])
elif response.status_code == 404:
    print("Redirection not found!")
else:
    print("Unexpected response status:", response.status_code)
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/redirect/get/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 302) {
            console.log("Redirecting to:", response.headers.location);
        } else if (response.status === 404) {
            console.log("Redirection not found!");
        } else {
            console.log("Unexpected response status:", response.status);
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExistLicense" aria-expanded="true" aria-controls="collapseExistLicense">
                                                    Check Exist License
                                                </button>
                                            </h2>
                                            <div id="collapseExistLicense" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Check Exist License Details -->
                                                    <h2>Check Exist License</h2>
                                                    <p><strong>Method:</strong> GET -> Check Exist License</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/license/check/?author_id=[user_id]&app_id=test&license=u7iu67t5</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 202: License exists
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: License not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "202",
    "message": "License exists",
    "license": "u7iu67t5",
    "app_id": "test",
    "owner_id": "ali39",
    "eval": "false"
}

{
    "status": "404",
    "message": "License not found!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/license/check/?author_id=[user_id]&app_id=test&license=u7iu67t5"

response = requests.get(url)

if response.status_code == 202:
    license_data = response.json()
    print(f"License {license_data['license']} exists for app {license_data['app_id']} owned by {license_data['owner_id']}")
else:
    print("License not found!")
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/license/check/?author_id=[user_id]&app_id=test&license=u7iu67t5";

axios.get(url)
    .then(response => {
        if (response.status === 202) {
            const license_data = response.data;
            console.log(`License ${license_data.license} exists for app ${license_data.app_id} owned by ${license_data.owner_id}`);
        } else {
            console.log("License not found!");
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetEvalData" aria-expanded="true" aria-controls="collapseGetEvalData">
                                                    Get Eval Data
                                                </button>
                                            </h2>
                                            <div id="collapseGetEvalData" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Get Eval Data Details -->
                                                    <h2>Get Eval Data</h2>
                                                    <p><strong>Method:</strong> GET -> Get Eval Data</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/license/eval/?author_id=[user_id]&app_id=test&license=u7iu67t5</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 200: Eval data retrieved successfully!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: License not found or eval is false in this license!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "200",
    "message": "Eval data retrieved successfully!"
}

{
    "status": "404",
    "message": "License not found or eval is false in this license!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/license/eval/?author_id=[user_id]&app_id=test&license=u7iu67t5"

response = requests.get(url)

if response.status_code == 200:
    print("Eval data retrieved successfully!")
else:
    print("License not found or eval is false in this license!")
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/license/eval/?author_id=[user_id]&app_id=test&license=u7iu67t5";

axios.get(url)
    .then(response => {
        if (response.status === 200) {
            console.log("Eval data retrieved successfully!");
        } else {
            console.log("License not found or eval is false in this license!");
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExistAppUpdate" aria-expanded="true" aria-controls="collapseExistAppUpdate">
                                                    Check Exist App Update
                                                </button>
                                            </h2>
                                            <div id="collapseExistAppUpdate" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Check Exist App Update Details -->
                                                    <h2>Check Exist App Update</h2>
                                                    <p><strong>Method:</strong> GET -> Check Exist App Update</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/update/check/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 202: Update exists!
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: Update not found!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "202",
    "message": "Update exists!",
    "version": "1.1",
    "news": "hey this new release!",
    "download": "false"
}

{
    "status": "404",
    "message": "Update not found!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/update/check/?id=1000"

response = requests.get(url)

if response.status_code == 202:
    update_data = response.json()
    print(f"Update version {update_data['version']} is available: {update_data['news']}")
else:
    print("Update not found!")
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/update/check/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 202) {
            const update_data = response.data;
            console.log(`Update version ${update_data.version} is available: ${update_data.news}`);
        } else {
            console.log("Update not found!");
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetDownloadAppUpdate" aria-expanded="true" aria-controls="collapseGetDownloadAppUpdate">
                                                    Get Download App Update
                                                </button>
                                            </h2>
                                            <div id="collapseGetDownloadAppUpdate" class="accordion-collapse collapse" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <!-- Get Download App Update Details -->
                                                    <h2>Get Download App Update</h2>
                                                    <p><strong>Method:</strong> GET -> Get Download App Update</p>
                                                    <p><strong>Endpoint:</strong> <code>https://api.example.com/api/update/download/?id=1000</code></p>
                                                    <div class="alert alert-success" role="alert">
                                                        Status 302: Redirecting to Target Download Location
                                                    </div>
                                                    <div class="alert alert-danger" role="alert">
                                                        Status 404: Update not found or download is false in this update!
                                                    </div>
                                                    <!-- Response Example -->
                                                    <div class="docs card">
                                                        <!-- Response Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Response Example Content -->
                                                            <h3>Response Example</h3>
                                                            <pre>
{
    "status": "302",
    "message": "Redirecting to Target Download Location"
}

{
    "status": "404",
    "message": "Update not found or download is false in this update!"
}
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Python Example -->
                                                    <div class="docs card">
                                                        <!-- Python Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Python Example Content -->
                                                            <h3>Python Example</h3>
                                                            <pre>
import requests

url = "https://api.example.com/api/update/download/?id=1000"

response = requests.get(url)

if response.status_code == 302:
    print("Redirecting to download location:", response.headers['Location'])
elif response.status_code == 404:
    print("Update not found or download is false in this update!")
else:
    print("Unexpected response status:", response.status_code)
                    </pre>
                                                        </div>
                                                    </div>
                                                    <!-- Node.js Example -->
                                                    <div class="docs card">
                                                        <!-- Node.js Example Header -->
                                                        <div class="card-header d-flex flex-row">
                                                            <div class="wi-1"></div>
                                                            <div class="wi-2"></div>
                                                            <div class="wi-3"></div>
                                                            <div class="wi-4"></div>
                                                        </div>
                                                        <div class="docs_codes card">
                                                            <!-- Node.js Example Content -->
                                                            <h3>Node.js Example</h3>
                                                            <pre>
const axios = require('axios');

const url = "https://api.example.com/api/update/download/?id=1000";

axios.get(url)
    .then(response => {
        if (response.status === 302) {
            console.log("Redirecting to download location:", response.headers.location);
        } else if (response.status === 404) {
            console.log("Update not found or download is false in this update!");
        } else {
            console.log("Unexpected response status:", response.status);
        }
    })
    .catch(error => {
        console.error(error);
    });
                    </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>



                </div>
        <?php
                            }
                        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'dashboard') {
        ?>

                <h3>User Info</h3>
                <h6>author_id: <?php echo $row_1["id"]; ?></h6>
                <h6>author_username: <?php echo $row_1["username"]; ?></h6>

                <div class="mt-5 alert alert-danger" id="security_alert" style="display: none;">
                    <strong>Security Risk:</strong> .htaccess file not deployed on the webserver.
                </div>

                <div class="mt-5 alert alert-warning text-center" id="security_loading" style="display: none;">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                <div class="mt-5 alert alert-success " id="security_success" style="display: none;">
                    The Router is <strong>Secure.</strong>
                </div>
                <script src="/static/js/security_check.js"></script>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'data') {
        ?>

                <?php if (isset($_SESSION["message"])) {
                    if (isset($_SESSION["message"])) {
                        echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                        unset($_SESSION["message"]);
                        unset($_SESSION["message_color"]);
                    }
                } ?>
                <div class="d-grid gap-2">
                    <a href="dashboard?loc=data_create" class="btn btn-primary" type="button">Create New Data</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Data</th>
                            <th scope="col">Modify Date</th>
                            <th scope="col">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_list = "";
                        $sql_data_list = "SELECT * FROM `data` WHERE `author_id` = " . $row_1["id"];
                        $sql_data_list_result = mysqli_query($mysql_connection, $sql_data_list);

                        while ($row_data_list = mysqli_fetch_array($sql_data_list_result, MYSQLI_ASSOC)) {
                            $readmore = $row_data_list["data"];
                            $readmore = strip_tags($readmore);
                            if (strlen($readmore) > 35) {
                                $readmoreCut = substr($readmore, 0, 35);
                                $endPoint = strrpos($readmoreCut, ' ');
                                $readmore = $endPoint ? substr($readmoreCut, 0, $endPoint) : substr($readmoreCut, 0);
                                $readmore .= '...';
                            }
                            $data_list = $data_list . '<tr><th scope="row">' . $row_data_list["id"] . '</th><td>' . $readmore . '</td><td>' . $row_data_list["create_or_edit_date"] . '</td><td><a href="dashboard?loc=data_edit&id=' . $row_data_list["id"] . '">Edit</a> <a style="color: red;" href="dashboard?loc=data_remove&id=' . $row_data_list["id"] . '">Remove</a></td></tr>';
                        }

                        echo $data_list;
                        ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'data_create') {
        ?>

                <form action="events" method="POST" style="margin: 20px;">
                    <?php if (isset($_SESSION["message"])) {
                        if (isset($_SESSION["message"])) {
                            echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                            unset($_SESSION["message"]);
                            unset($_SESSION["message_color"]);
                        }
                    } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="modify_date">Modify Date</label>
                                <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="data">Data</label>
                                <textarea type="text" id="data" class="form-control" name="data" rows="4" placeholder="Your Data" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="/admin/dashboard?loc=data" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="event" value="data_create" class="btn btn-warning">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'data_edit') {
                $sql_data_edit_id = stripcslashes($_GET["id"]);
                $sql_data_edit_id = mysqli_real_escape_string($mysql_connection, $sql_data_edit_id);
                $sql_data_edit = "SELECT * FROM `data` WHERE `id` = '" . $sql_data_edit_id . "' AND `author_id` = " . $row_1["id"];
                $sql_data_edit_result = mysqli_query($mysql_connection, $sql_data_edit);
                $sql_data_edit_row = mysqli_fetch_array($sql_data_edit_result, MYSQLI_ASSOC);
                $sql_data_edit_result_count = mysqli_num_rows($sql_data_edit_result);
                if ($sql_data_edit_result_count == 1) {
        ?>

                    <form action="events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="modify_date">Modify Date</label>
                                    <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" class="form-control" value="<?php echo $sql_data_edit_row["id"]; ?>" name="id" placeholder="ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <label for="data">Data</label>
                                    <textarea type="text" id="data" class="form-control" name="data" rows="4" placeholder="Your Data" required><?php echo $sql_data_edit_row["data"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=data" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="data_edit" class="btn btn-warning">Edit</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'data_remove') {
                $sql_data_remove_id = stripcslashes($_GET["id"]);
                $sql_data_remove_id = mysqli_real_escape_string($mysql_connection, $sql_data_remove_id);
                $sql_data_remove = "SELECT * FROM `data` WHERE `id` = '" . $sql_data_remove_id . "' AND `author_id` = " . $row_1["id"];
                $sql_data_remove_result = mysqli_query($mysql_connection, $sql_data_remove);
                $sql_data_remove_row = mysqli_fetch_array($sql_data_remove_result, MYSQLI_ASSOC);
                $sql_data_remove_result_count = mysqli_num_rows($sql_data_remove_result);
                if ($sql_data_remove_result_count == 1) {
        ?>

                    <form action="events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="data_id">Data ID</label>
                                    <input type="text" id="data_id" class="form-control" value="<?php echo $sql_data_remove_row["id"]; ?>" name="data_id" placeholder="Data ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=data" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="data_remove" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'redirect') {
        ?>

                <?php if (isset($_SESSION["message"])) {
                    if (isset($_SESSION["message"])) {
                        echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                        unset($_SESSION["message"]);
                        unset($_SESSION["message_color"]);
                    }
                } ?>
                <div class="d-grid gap-2">
                    <a href="dashboard?loc=redirect_create" class="btn btn-primary" type="button">Create New Data</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">URL</th>
                            <th scope="col">Modify Date</th>
                            <th scope="col">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $redirect_list = "";
                        $sql_redirect_list = "SELECT * FROM `redirect` WHERE `author_id` = " . $row_1["id"];
                        $sql_redirect_list_result = mysqli_query($mysql_connection, $sql_redirect_list);

                        while ($row_redirect_list = mysqli_fetch_array($sql_redirect_list_result, MYSQLI_ASSOC)) {
                            $readmore = $row_redirect_list["url"];
                            $readmore = strip_tags($readmore);
                            if (strlen($readmore) > 35) {
                                $readmoreCut = substr($readmore, 0, 35);
                                $endPoint = strrpos($readmoreCut, ' ');
                                $readmore = $endPoint ? substr($readmoreCut, 0, $endPoint) : substr($readmoreCut, 0);
                                $readmore .= '...';
                            }
                            $redirect_list = $redirect_list . '<tr><th scope="row">' . $row_redirect_list["id"] . '</th><td>' . $readmore . '</td><td>' . $row_redirect_list["create_or_edit_date"] . '</td><td><a href="dashboard?loc=redirect_edit&id=' . $row_redirect_list["id"] . '">Edit</a> <a style="color: red;" href="dashboard?loc=redirect_remove&id=' . $row_redirect_list["id"] . '">Remove</a></td></tr>';
                        }

                        echo $redirect_list;
                        ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'redirect_edit') {
                $sql_redirect_edit_id = stripcslashes($_GET["id"]);
                $sql_redirect_edit_id = mysqli_real_escape_string($mysql_connection, $sql_redirect_edit_id);
                $sql_redirect_edit = "SELECT * FROM `redirect` WHERE `id` = '" . $sql_redirect_edit_id . "' AND `author_id` = " . $row_1["id"];
                $sql_redirect_edit_result = mysqli_query($mysql_connection, $sql_redirect_edit);
                $sql_redirect_edit_row = mysqli_fetch_array($sql_redirect_edit_result, MYSQLI_ASSOC);
                $sql_redirect_edit_result_count = mysqli_num_rows($sql_redirect_edit_result);
                if ($sql_redirect_edit_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="modify_date">Modify Date</label>
                                    <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" class="form-control" value="<?php echo $sql_redirect_edit_row["id"]; ?>" name="id" placeholder="ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <label for="url">URL</label>
                                    <input type="text" id="url" class="form-control" value="<?php echo $sql_redirect_edit_row["url"]; ?>" name="url" placeholder="Your Url" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=redirect" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="redirect_edit" class="btn btn-warning">Edit</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'redirect_create') {
        ?>

                <form action="/admin/events" method="POST" style="margin: 20px;">
                    <?php if (isset($_SESSION["message"])) {
                        if (isset($_SESSION["message"])) {
                            echo '<div class="cAlert alert" style="background-color: ' . $_SESSION["message"] . ';">' . $_SESSION["message"] . '</div>';
                            unset($_SESSION["message"]);
                            unset($_SESSION["message"]);
                        }
                    } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="modify_date">Modify Date</label>
                                <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="url">URL</label>
                                <input type="text" id="url" class="form-control" value="" name="url" placeholder="Your Url" required>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="/admin/dashboard?loc=redirect" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="event" value="redirect_create" class="btn btn-warning">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'redirect_remove') {
                $sql_redirect_remove_id = stripcslashes($_GET["id"]);
                $sql_redirect_remove_id = mysqli_real_escape_string($mysql_connection, $sql_redirect_remove_id);
                $sql_redirect_remove = "SELECT * FROM `redirect` WHERE `id` = '" . $sql_redirect_remove_id . "' AND `author_id` = " . $row_1["id"];
                $sql_redirect_remove_result = mysqli_query($mysql_connection, $sql_redirect_remove);
                $sql_redirect_remove_row = mysqli_fetch_array($sql_redirect_remove_result, MYSQLI_ASSOC);
                $sql_redirect_remove_result_count = mysqli_num_rows($sql_redirect_remove_result);
                if ($sql_redirect_remove_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="redirect_id">redirect ID</label>
                                    <input type="text" id="redirect_id" class="form-control" value="<?php echo $sql_redirect_remove_row["id"]; ?>" name="redirect_id" placeholder="redirect ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=redirect" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="redirect_remove" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'license') {
        ?>

                <?php if (isset($_SESSION["message"])) {
                    if (isset($_SESSION["message"])) {
                        echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                        unset($_SESSION["message"]);
                        unset($_SESSION["message_color"]);
                    }
                } ?>
                <div class="d-grid gap-2">
                    <a href="dashboard?loc=license_create" class="btn btn-primary" type="button">Create New Data</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">App ID</th>
                            <th scope="col">Owner ID</th>
                            <th scope="col">License</th>
                            <th scope="col">Eval</th>
                            <th scope="col">Modify Date</th>
                            <th scope="col">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $license_list = "";
                        $sql_license_list = "SELECT * FROM `license` WHERE `author_id` = " . $row_1["id"];
                        $sql_license_list_result = mysqli_query($mysql_connection, $sql_license_list);

                        while ($row_license_list = mysqli_fetch_array($sql_license_list_result, MYSQLI_ASSOC)) {
                            $license_eval = 'true';
                            if ($row_license_list["eval"] == '') {
                                $license_eval = 'false';
                            }
                            $license_list = $license_list . '<tr><th scope="row">' . $row_license_list["id"] . '</th><td>' . $row_license_list["app_id"] . '</td><td>' . $row_license_list["owner_id"] . '</td><td>' . $row_license_list["license"] . '</td><td>' . $license_eval . '</td><td>' . $row_license_list["create_or_edit_date"] . '</td><td><a href="dashboard?loc=license_edit&id=' . $row_license_list["id"] . '">Edit</a> <a style="color: red;" href="dashboard?loc=license_remove&id=' . $row_license_list["id"] . '">Remove</a></td></tr>';
                        }

                        echo $license_list;
                        ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'license_edit') {
                $sql_license_edit_id = stripcslashes($_GET["id"]);
                $sql_license_edit_id = mysqli_real_escape_string($mysql_connection, $sql_license_edit_id);
                $sql_license_edit = "SELECT * FROM `license` WHERE `id` = '" . $sql_license_edit_id . "' AND `author_id` = " . $row_1["id"];
                $sql_license_edit_result = mysqli_query($mysql_connection, $sql_license_edit);
                $sql_license_edit_row = mysqli_fetch_array($sql_license_edit_result, MYSQLI_ASSOC);
                $sql_license_edit_result_count = mysqli_num_rows($sql_license_edit_result);
                if ($sql_license_edit_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="modify_date">Modify Date</label>
                                    <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" class="form-control" value="<?php echo $sql_license_edit_row["id"]; ?>" name="id" placeholder="ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="app_id">App ID</label>
                                    <input type="text" id="app_id" class="form-control" value="<?php echo $sql_license_edit_row["app_id"]; ?>" name="app_id" placeholder="App ID" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="owner_id">Owner ID</label>
                                    <input type="text" id="owner_id" class="form-control" value="<?php echo $sql_license_edit_row["owner_id"]; ?>" name="owner_id" placeholder="Owner ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <label for="license">License</label>
                                    <input type="text" id="license" class="form-control" value="<?php echo $sql_license_edit_row["license"]; ?>" name="license" placeholder="License" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <label for="eval">Eval</label>
                                    <textarea type="text" id="eval" class="form-control" name="eval" rows="4" placeholder="Your Eval Data"><?php echo $sql_license_edit_row["eval"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=license" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="license_edit" class="btn btn-warning">Edit</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'license_create') {
        ?>

                <form action="/admin/events" method="POST" style="margin: 20px;">
                    <?php if (isset($_SESSION["message"])) {
                        if (isset($_SESSION["message"])) {
                            echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                            unset($_SESSION["message"]);
                            unset($_SESSION["message_color"]);
                        }
                    } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="modify_date">Modify Date</label>
                                <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="app_id">App ID</label>
                                <input type="text" id="app_id" class="form-control" value="" name="app_id" placeholder="App ID" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="owner_id">Owner ID</label>
                                <input type="text" id="owner_id" class="form-control" value="" name="owner_id" placeholder="Owner ID" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="eval">Eval</label>
                                <textarea type="text" id="eval" class="form-control" name="eval" rows="4" placeholder="Your Eval Data"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="/admin/dashboard?loc=license" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="event" value="license_create" class="btn btn-warning">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'license_remove') {
                $sql_license_remove_id = stripcslashes($_GET["id"]);
                $sql_license_remove_id = mysqli_real_escape_string($mysql_connection, $sql_license_remove_id);
                $sql_license_remove = "SELECT * FROM `license` WHERE `id` = '" . $sql_license_remove_id . "' AND `author_id` = " . $row_1["id"];
                $sql_license_remove_result = mysqli_query($mysql_connection, $sql_license_remove);
                $sql_license_remove_row = mysqli_fetch_array($sql_license_remove_result, MYSQLI_ASSOC);
                $sql_license_remove_result_count = mysqli_num_rows($sql_license_remove_result);
                if ($sql_license_remove_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="license_id">License ID</label>
                                    <input type="text" id="license_id" class="form-control" value="<?php echo $sql_license_remove_row["id"]; ?>" name="license_id" placeholder="License ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=license" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="license_remove" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'update') {
        ?>

                <?php if (isset($_SESSION["message"])) {
                    if (isset($_SESSION["message"])) {
                        echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                        unset($_SESSION["message"]);
                        unset($_SESSION["message_color"]);
                    }
                } ?>
                <div class="d-grid gap-2">
                    <a href="dashboard?loc=update_create" class="btn btn-primary" type="button">Create New Data</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Version</th>
                            <th scope="col">News</th>
                            <th scope="col">Download</th>
                            <th scope="col">Modify Date</th>
                            <th scope="col">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $update_list = "";
                        $sql_update_list = "SELECT * FROM `update` WHERE `author_id` = " . $row_1["id"];
                        $sql_update_list_result = mysqli_query($mysql_connection, $sql_update_list);

                        while ($row_update_list = mysqli_fetch_array($sql_update_list_result, MYSQLI_ASSOC)) {
                            $update_download = 'true';
                            if ($row_update_list["download"] == '') {
                                $update_download = 'false';
                            }
                            $readmore = $row_update_list["news"];
                            $readmore = strip_tags($readmore);
                            if (strlen($readmore) > 35) {
                                $readmoreCut = substr($readmore, 0, 35);
                                $endPoint = strrpos($readmoreCut, ' ');
                                $readmore = $endPoint ? substr($readmoreCut, 0, $endPoint) : substr($readmoreCut, 0);
                                $readmore .= '...';
                            }
                            $update_list = $update_list . '<tr><th scope="row">' . $row_update_list["id"] . '</th><td>' . $row_update_list["version"] . '</td><td>' . $readmore . '</td><td>' . $update_download . '</td><td>' . $row_update_list["create_or_edit_date"] . '</td><td><a href="dashboard?loc=update_edit&id=' . $row_update_list["id"] . '">Edit</a> <a style="color: red;" href="dashboard?loc=update_remove&id=' . $row_update_list["id"] . '">Remove</a></td></tr>';
                        }

                        echo $update_list;
                        ?>
                    </tbody>
                </table>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'update_edit') {
                $sql_update_edit_id = stripcslashes($_GET["id"]);
                $sql_update_edit_id = mysqli_real_escape_string($mysql_connection, $sql_update_edit_id);
                $sql_update_edit = "SELECT * FROM `update` WHERE `id` = '" . $sql_update_edit_id . "' AND `author_id` = " . $row_1["id"];
                $sql_update_edit_result = mysqli_query($mysql_connection, $sql_update_edit);
                $sql_update_edit_row = mysqli_fetch_array($sql_update_edit_result, MYSQLI_ASSOC);
                $sql_update_edit_result_count = mysqli_num_rows($sql_update_edit_result);
                if ($sql_update_edit_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="modify_date">Modify Date</label>
                                    <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="id">ID</label>
                                    <input type="text" id="id" class="form-control" value="<?php echo $sql_update_edit_row["id"]; ?>" name="id" placeholder="ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <label for="version">Version</label>
                                    <input type="text" id="version" class="form-control" value="<?php echo $sql_update_edit_row["version"]; ?>" name="version" placeholder="Version" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <label for="news">News</label>
                                    <textarea type="text" id="news" class="form-control" name="news" rows="2" placeholder="News" required><?php echo $sql_update_edit_row["news"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <label for="download">Download</label>
                                    <textarea type="text" id="download" class="form-control" name="download" rows="2" placeholder="download Url"><?php echo $sql_update_edit_row["download"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=update" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="update_edit" class="btn btn-warning">Edit</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'update_create') {
        ?>

                <form action="/admin/events" method="POST" style="margin: 20px;">
                    <?php if (isset($_SESSION["message"])) {
                        if (isset($_SESSION["message"])) {
                            echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                            unset($_SESSION["message"]);
                            unset($_SESSION["message_color"]);
                        }
                    } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="modify_date">Modify Date</label>
                                <input type="date" id="modify_date" class="form-control" value="<?php echo date("Y-m-d"); ?>" name="modify_date" placeholder="Modify Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="version">Version</label>
                                <input type="text" id="version" class="form-control" value="" name="version" placeholder="Version" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form">
                                <label for="news">News</label>
                                <textarea type="text" id="news" class="form-control" name="news" rows="2" placeholder="News" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="download">Download</label>
                                <textarea type="text" id="download" class="form-control" name="download" rows="2" placeholder="download Url"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="/admin/dashboard?loc=update" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="event" value="update_create" class="btn btn-warning">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            }
        }
        ?>
        <?php
        if (isset($_GET["loc"])) {
            if ($_GET["loc"] == 'update_remove') {
                $sql_update_remove_id = stripcslashes($_GET["id"]);
                $sql_update_remove_id = mysqli_real_escape_string($mysql_connection, $sql_update_remove_id);
                $sql_update_remove = "SELECT * FROM `update` WHERE `id` = '" . $sql_update_remove_id . "' AND `author_id` = " . $row_1["id"];
                $sql_update_remove_result = mysqli_query($mysql_connection, $sql_update_remove);
                $sql_update_remove_row = mysqli_fetch_array($sql_update_remove_result, MYSQLI_ASSOC);
                $sql_update_remove_result_count = mysqli_num_rows($sql_update_remove_result);
                if ($sql_update_remove_result_count == 1) {
        ?>

                    <form action="/admin/events" method="POST" style="margin: 20px;">
                        <?php if (isset($_SESSION["message"])) {
                            if (isset($_SESSION["message"])) {
                                echo '<div class="mt-2 alert alert-' . $_SESSION["message_color"] . '">' . $_SESSION["message"] . '</div>';
                                unset($_SESSION["message"]);
                                unset($_SESSION["message_color"]);
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="update_id">Update ID</label>
                                    <input type="text" id="update_id" class="form-control" value="<?php echo $sql_update_remove_row["id"]; ?>" name="update_id" placeholder="Update ID" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="/admin/dashboard?loc=update" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" name="event" value="update_remove" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </form>
        <?php
                } else {
                    echo 'Data Not Found';
                }
            }
        }
        ?>
        </main>
            </div>

            <?php include 'router/footer.php'; ?>

        </body>

        </html>
<?php
    }
}
?>