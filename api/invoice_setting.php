<?php

switch ($_SERVER["REQUEST_METHOD"]) {

    case 'POST':

        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $invoice = Intratum\Facturas\Factura::get($params = ["id2" => $data["id2"]]);

        $result = Intratum\Facturas\InvoiceSetting::save($invoice["id"],$data);

        echo json_encode($result);
     
        
        break;
        
    case 'DELETE':

        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $invoice = Intratum\Facturas\Factura::get($params = ["id2" => $data["id2"]]);

        $result = Intratum\Facturas\InvoiceSetting::delete($invoice["id"],$data);

        echo json_encode($result);
     
        
        break;


}
