<?php
    $cookie = $_COOKIE['SSID'];

    Intratum\Facturas\User::expireSessionToken($cookie);
	setcookie('SSID', "", null, '/', null, false, true);
    setcookie('SID', "", null, '/', null, false, true);
    $cookie = $_COOKIE['SSID'];
    echo json_encode($cookie);

    header("Location: /login/");

    exit();

?>