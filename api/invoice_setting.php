<?php

switch ($_SERVER["REQUEST_METHOD"]) {

    case 'POST':

        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $invoice = Intratum\Facturas\Factura::get($params = ["id2" => $data]);

        $params=[
            "OPTION" => "PAYMENT_DATE"
        ];

        $result = Intratum\Facturas\InvoiceSetting::save($invoice["id"],$params);

        echo json_encode($result);
     
        
        break;
        
    case 'DELETE':

        $data = Intratum\Facturas\Traffic::getEntryPOST();

        $invoice = Intratum\Facturas\Factura::get($params = ["id2" => $data]);

        $params=[
            "OPTION" => "PAYMENT_DATE"
        ];

        $result = Intratum\Facturas\InvoiceSetting::delete($invoice["id"],$params);

        echo json_encode($result);
     
        
        break;


}
