<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
        $data = Intratum\Facturas\Traffic::getEntryPOST();
        echo json_encode(Intratum\Facturas\Customer::insert($data));

        break;

    case 'GET':
        $url = $_SERVER['REQUEST_URI'];
        
        $urlExp = explode('/', $url);

        $data = Intratum\Facturas\Traffic::getEntryGET();

        if (empty($urlExp[3])) {

            $data = Intratum\Facturas\Customer::all($data);
            $data = Intratum\Facturas\Util::sanizeExitData($data);

            echo json_encode($data);
        } else {
            $data = Intratum\Facturas\Util::getID2ByUUID("cust",$urlExp[3]);

			echo json_encode(Intratum\Facturas\Customer::get([
				'id2' => $data,
			]));
        }


        break;
    case 'UPDATE':
        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $existingCustomer = Intratum\Facturas\Customer::get(["id2" => $data["id2"]]);
        if ($existingCustomer) {
            echo json_encode(Intratum\Facturas\Customer::update($data));
        } else {
            echo json_encode(Intratum\Facturas\Customer::insert($data));
        }

        break;

    case 'DELETE':
        $data = Intratum\Facturas\Traffic::getEntryPOST();
        $existingCustomer = Intratum\Facturas\Customer::get(["id2" => $data["id2"]]);
        if ($existingCustomer) {
            echo json_encode(Intratum\Facturas\Customer::delete($data));
        }

        break;
}
