<?php


switch($_SERVER["REQUEST_METHOD"]){
	case 'POST':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		echo json_encode(Intratum\Facturas\Product::insert($data));
		
	break;

	case 'UPDATE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		$existingProduct = Intratum\Facturas\Product::get(["id2" => $data["id2"]]);
		if ($existingProduct) {
			echo json_encode(Intratum\Facturas\Product::update($data));
		} else {
			echo json_encode(Intratum\Facturas\Product::insert($data));
		}
		
	break;

	case 'DELETE':
		$data = Intratum\Facturas\Traffic::getEntryPOST();
		$existingProduct = Intratum\Facturas\Product::get(["id2" => $data["id2"]]);
		if ($existingProduct) {
			echo json_encode(Intratum\Facturas\Product::delete($data));
		} 
		
	break;

	case 'GET':
        $url = $_SERVER['REQUEST_URI'];
        $urlExp = explode('/', $url);

        $data = Intratum\Facturas\Traffic::getEntryGET();

        if (empty($urlExp[3])) {
            $user = Intratum\Facturas\Util::getSessionUser();
            $acc = Intratum\Facturas\User::getUserAccount($user["id"]);
            $data["acc_id"] = $acc["id"];
            $data = Intratum\Facturas\Product::all($data);
            $data = Intratum\Facturas\Util::sanizeExitData($data);

            echo json_encode($data);
        } else {
            $data = Intratum\Facturas\Util::getID2ByUUID("prod",$urlExp[3]);

			echo json_encode(Intratum\Facturas\Product::get([
				'id2' => $data,
			]));
        }


        break;
}





