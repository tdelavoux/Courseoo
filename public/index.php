<?php
    header('Content-type: text/html; charset=UTF-8');
    const PRODUCTION = false;
    const LOGIN_INTERFACE = true;
    const MAINTENANCE = false;
    const CGI_DIR = '../cgi-bin/';


    require __DIR__ . '/' . CGI_DIR . 'lib/core.php';
?>
