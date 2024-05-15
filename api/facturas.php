<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
        $data = Intratum\Facturas\Traffic::getEntryPOST();
        $autoC = $data["autoComp"];
        
        if($autoC == "false"){

            $dataCust = [
                'NIF' => $data['NIF'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'type' => $data['type'],
                'category' => $data['category'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address1' => $data['address_1'],
                'address2' => $data['address_2'] ?? "",
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'zip' => $data['zip'],
    
            ];

            $cust = Intratum\Facturas\Customer::insert($dataCust);
            $data["cust-id"] =  $cust;
            }

		    echo json_encode(Intratum\Facturas\Factura::insert($data));

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

		    echo json_encode(Intratum\Facturas\Factura::update($data));

        break;

    case 'DELETE':
        
        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $existingInvoice = Intratum\Facturas\Factura::get(["id2" => $data["id2"]]);
        if ($existingInvoice) {
            echo json_encode(Intratum\Facturas\Factura::delete($data));
        }

        break;
}
