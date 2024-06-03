<?php

switch($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$data = Intratum\Facturas\Traffic::getEntryPOST();

		echo json_encode(Intratum\Facturas\User::forgotPassword($data["email"]));
		
	break;

}


