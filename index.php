<?php

require('vendor/autoload.php');
require 'pdodb.php';
	
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;


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
}else if($urlpath2[1] == 'einvoices'){
    header('Content-Disposition: attachment' );
 
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
