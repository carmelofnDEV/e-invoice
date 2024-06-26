<?php

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
        $data = Intratum\Facturas\Traffic::getEntryPOST();

        echo json_encode(Intratum\Facturas\User::insert($data));

        break;

    case 'UPDATE':
        $data = Intratum\Facturas\Traffic::getEntryPOST();

        echo json_encode(Intratum\Facturas\User::update($data));

        break;        

    case 'GET':
        $url = $_SERVER['REQUEST_URI'];
        $urlExp = explode('/', $url);

        $data = Intratum\Facturas\Traffic::getEntryGET();

        if (empty($urlExp[3])) {

            $data = Intratum\Facturas\Product::all($data);
            $data = Intratum\Facturas\Util::sanizeExitData($data);

            echo json_encode($data);
        } else {
            $data = Intratum\Facturas\Util::getID2ByUUID("cust", $urlExp[3]);

            echo json_encode(Intratum\Facturas\Product::get([
                'id2' => $data,
            ]));
        }

        break;
    case 'DELETE':
        $data = Intratum\Facturas\Traffic::getEntryPOST();
        $existingUser = Intratum\Facturas\User::get(["id2" => $data["id2"]]);
        if ($existingUser) {
            echo json_encode(Intratum\Facturas\User::delete($data));
        }

        break;
}
