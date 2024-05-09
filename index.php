<?php

require('vendor/autoload.php');
require 'pdodb.php';
	
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

// $enc = new \Intratum\Facturas\Encryption();
// $enc->setKey('private');
// $codi = $enc->encode(json_encode([30,20240504]));
// echo $enc->decode($codi);

// exit();

// // API endpoint
// $url = 'https://api.postmarkapp.com/email';

// // Request headers
// $headers = array(
//     'Accept: application/json',
//     'Content-Type: application/json',
//     'X-Postmark-Server-Token: e1282fbd-c4ab-4355-b41e-b3e7e5093aa9'
// );

// // Request data
// $data = array(
//     'From' => 'facturas@intratum.com',
//     'To' => 'pencho@intratum.com',
//     'Subject' => 'Hello from Postmark',
//     'HtmlBody' => '<strong>Hello</strong> dear Postmark user.',
//     'MessageStream' => 'outbound'
// );

// // Initialize cURL session
// $ch = curl_init();

// // Set cURL options
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // Execute cURL request
// $response = curl_exec($ch);

// // Close cURL session
// curl_close($ch);

// // Handle response
// if ($response === false) {
//     // Request failed
//     echo 'Error: ' . curl_error($ch);
// } else {
//     // Request successful
//     echo 'Response: ' . $response;
// }

$Traffic = Intratum\Facturas\Traffic::get($_SERVER['REQUEST_URI']);



$urlpath = explode('?', $_SERVER['REQUEST_URI']);
$urlpath2 = explode('/', $urlpath[0]);
		
if($urlpath2[1] == 'static'){
$filename = basename($Traffic);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpeg"; break;
    case "svg": $ctype="image/svg+xml"; break;
    case "js": $ctype="application/javascript"; break;
    case "php": exit(); break;
    default:
}

header('Content-type: ' . $ctype);
	
require($Traffic);
}else if($urlpath2[1] == 'ajax'){
	Intratum\Facturas\Environment::connectDB();
	
	header('Content-type: application/json' );
	require($Traffic);

}else if($urlpath2[1] == 'pdf'){
   header('Content-type: application/pdf' );

    ob_start();
    include $Traffic;
    $buffer = ob_get_clean();

    echo $buffer;
}else if($urlpath2[1] == 'logout'){
	Intratum\Facturas\Environment::connectDB();

require($Traffic);
}else if($urlpath2[1] == 'html'){
	Intratum\Facturas\Environment::connectDB();
    
    header('Content-type: application/json' );
    ob_start();
    include $Traffic;
    $buffer = ob_get_clean();

    echo json_encode([
        'content' => $buffer
    ]);
}else{
    Intratum\Facturas\Environment::connectDB();



ob_start();
require $Traffic;
$buffer = ob_get_clean();

require('templates/header.php');
echo $buffer;

//echo $Traffic;
// require('templates/footer.php');	
}
