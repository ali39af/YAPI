const urlsToCheck = [
    '/router/admin/',
    '/router/admin/index.php',
    '/router/admin/login.php',
    '/router/admin/events.php',
    '/router/admin/logout.php',
    '/router/admin/setup.php',
    '/router/admin/dashboard.php',
    '/router/api/data/check.php',
    '/router/api/data/get.php',
    '/router/api/license/check.php',
    '/router/api/license/eval.php',
    '/router/api/redirect/check.php',
    '/router/api/redirect/get.php',
    '/router/api/update/check.php',
    '/router/api/update/download.php',
    '/router/api/index.php',
    '/router/api/',
];

function checkUrls() {
    document.getElementById('security_loading').style.display = 'block';

    let errorDetected = false;

    urlsToCheck.forEach(url => {
        if (!errorDetected) {
            fetch(document.location.origin + url)
                .then(response => {
                    if (response.status !== 403) 
                        errorDetected = true;
                    if (errorDetected) {
                        document.getElementById('security_loading').style.display = 'none';
                        document.getElementById('security_alert').style.display = 'block';
                        document.getElementById('security_success').style.display = 'none';
                    } else if (url === urlsToCheck[urlsToCheck.length - 1]) {
                        document.getElementById('security_loading').style.display = 'none';
                        document.getElementById('security_alert').style.display = 'none';
                        document.getElementById('security_success').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
}

window.addEventListener('load', checkUrls);