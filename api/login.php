<?php

switch ($_SERVER["REQUEST_METHOD"] == "POST") {
    case 'POST':
        $data = Intratum\Facturas\Traffic::getEntryPOST();
        $data["password"] = hash("sha256",$data["password"]);
        echo json_encode(Intratum\Facturas\User::login($data));

        break;
}


