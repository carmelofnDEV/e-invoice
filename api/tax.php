<?php


switch($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		echo json_encode(Intratum\Facturas\Tax::insert($data));
		
	break;

	case 'UPDATE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		echo json_encode(Intratum\Facturas\Tax::update($data));
		
	break;

	case 'DELETE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		$existingTax = Intratum\Facturas\Tax::get(["id2" => $data["id2"]]);
		if ($existingTax) {
			echo json_encode(Intratum\Facturas\Tax::delete($data));
		} 
		
	break;

	case 'GET':
        $url = $_SERVER['REQUEST_URI'];
        $urlExp = explode('/', $url);

        $data = Intratum\Facturas\Traffic::getEntryGET();

        if (empty($urlExp[3])) {

            $data = Intratum\Facturas\Tax::all($data);
            $data = Intratum\Facturas\Util::sanizeExitData($data);

            echo json_encode($data);
        } else {
            $data = Intratum\Facturas\Util::getID2ByUUID("tax",$urlExp[3]);

			echo json_encode(Intratum\Facturas\Tax::get(['id2' => $data,]));
        }

        break;
}





