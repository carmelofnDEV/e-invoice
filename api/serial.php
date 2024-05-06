<?php


switch($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		echo json_encode(Intratum\Facturas\Serial::insert($data));
		
	break;

	case 'UPDATE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		$existingSerial = Intratum\Facturas\Serial::get(["id2" => $data["id2"]]);
		if ($existingSerial) {
			echo json_encode(Intratum\Facturas\Serial::update($data));
		} else {
			echo json_encode(Intratum\Facturas\Serial::insert($data));
		}
		
	break;

	case 'DELETE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		$existingSerial = Intratum\Facturas\Serial::get(["id2" => $data["id2"]]);
		if ($existingSerial) {
			echo json_encode(Intratum\Facturas\Serial::delete($data));
		} 
		
	break;

	case 'GET':
        $url = $_SERVER['REQUEST_URI'];
        $urlExp = explode('/', $url);

        $data = Intratum\Facturas\Traffic::getEntryGET();

        if (empty($urlExp[3])) {

            $data = Intratum\Facturas\Serial::all($data);
            $data = Intratum\Facturas\Util::sanizeExitData($data);

            echo json_encode($data);
        } else {
            $data = Intratum\Facturas\Util::getID2ByUUID("se",$urlExp[3]);

			echo json_encode(Intratum\Facturas\Serial::get([
				'id2' => $data,
			]));
        }


        break;
}





