<?php

namespace Intratum\Facturas;

use josemmo\Facturae\Facturae;
use josemmo\Facturae\FacturaeParty;
use josemmo\Facturae\FacturaeItem;
use josemmo\Facturae\Common\FacturaeSigner;



class Factura
{

    public static function insert(array $data){
        
        $subtotal = 0;
        $totaltaxs = 0;
        $errors = [];
        $discount = $data["discount"];

        $db = Environment::$db;

        if(!empty($data["items"])){
            foreach ($data["items"] as $i) {

                $subtotal += floatVal($i["price"]) * $i["quantity"];
    
                if (array_key_exists('tax_0', $i)) {
                    $tax = explode("/", $i["tax_0"]);
    
                    $db->where('id2', $tax[3]);
                    $results = $db->get('tax');
    
                    $totaltaxs += round($i["subtotal"] * ($tax[2] / 100), 2);
    
                }
    
                if (array_key_exists('tax_1', $i)) {
                    $tax = explode("/", $i["tax_1"]);
    
                    $db->where('id2', $tax[3]);
                    $results = $db->get('tax');
    
                    $totaltaxs += round($i["subtotal"] * ($tax[2] / 100), 2);
    
                }
            }
        }else{

            $errors[] = [
                "error" => "no_items",
                "message" => "Debes añadir al menos un item.",
            ];

            return [
                'success' => false,
                'errors' => $errors,
            ];
        }


        //$all = Environment::$db->get('customer');

        $invoice_items = $data["items"];

        if (!empty($data["invoice_ref"])) {

            $invoice_ref = $data["invoice_ref"];

            
        }


        $search = $data['first_name'] . ' ' . $data['last_name'] . '
' . $data['email'] . '
' . $data['NIF'] . '
' . $data['address_1'] . '
' . $data['zip'] . ' ' . $data['city'] . '
' . $data['country'] . '
' . $data['invoice_number'] . '
' . $data['invoice_serial'] . '

';
        if (empty($data["name"])) {
            $db = Environment::$db;
            $db->where('id', $data['invoice_serial']);
            $prefix = $db->getOne('serial', 'serial_tag');
            $data["name"] = $prefix['serial_tag'] . $data['invoice_number'];

        }

        $data = [
            'id2' => Util::genUUID(),
            'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
            'user_id' => Util::getSessionUser()["id"],
            'issuer_id' => Util::getSessionUser()["id"],
            'created' => Util::getDate(),
            'updated' => null,
            'recipient_id' => $data["cust-id"],
            'NIF' => $data['NIF'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'type' => $data['type'],
            'category' => $data['category'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'search' => $search,
            'address1' => $data['address_1'],
            'address2' => $data['address_2'] ?? "",
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'subtotal' => $data['invoice_subtotal'] * 100,
            'total' => $data['invoice_total'] * 100,
            'invoice_state' => 0,
            'serial_id' => $data["invoice_serial"],
            'invoice_number' => $data["invoice_number"],
            'invoice_date' => $data["invoice_date"],
            'invoice_terms' => $data["terms"],
            'name' => $data["name"],
        ];

        $id_invoice = Environment::$db->insert('invoice', $data);

        

        foreach ($invoice_items as $i) {

            if ($i["id"] == "") {
                if (!isset($i['description'])) {
                    $i['description'] = "";
                }
                

                $search = $i['title'] . '
' . $i['description'] . '
' . $i['price'];

                $data = [
                    'id2' => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                    'title' => $i['title'] ?? '',
                    'created' => Util::getDate(),
                    'search' => $search,
                    'description' => $i["description"] ?? '',
                    'price' => floatVal($i["price"]) * 100 ?? 0,
                    'state' => 1,
                ];

                $i["id"] = Environment::$db->insert('product', $data);

            }

            $invoice_item = [
                "id2" => Util::genUUID(),
                'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                'user_id' => Util::getSessionUser()["id"],
                'created' => Util::getDate(),
                'updated' => Util::getDate(),
                "id_item" => $i["id"],
                "quantity" => $i["quantity"],
                "subtotal" => $i["subtotal"],
                "invoice_id" => $id_invoice,
            ];

            $id_item = Environment::$db->insert('invoice_item', $invoice_item);

            if (array_key_exists('tax_0', $i)) {
                $tax = explode("/", $i["tax_0"]);

                Environment::$db->where('id2', $tax[3]);
                $results = $db->get('tax');

                $item_tax_data = [
                    "id2" => Util::genUUID(),
                    "created" => Util::getDate(),
                    "invoice_item_id" => $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"] * ($tax[2] / 100), 2),
                    "tax_value" => $tax[2],

                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            if (array_key_exists('tax_1', $i)) {
                $tax = explode("/", $i["tax_1"]);

                Environment::$db->where('id2', $tax[3]);
                $results = $db->get('tax');

                $item_tax_data = [
                    "id2" => Util::genUUID(),
                    "created" => Util::getDate(),
                    "invoice_item_id" => $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"] * ($tax[2] / 100), 2),
                    "tax_value" => $tax[2],

                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }

        }


        if ($discount != "") {
            $parms["OPTIONS"] = [
                ["VALUE" => $discount,
                    "OPTION" => "DISCOUNT"]
                ];
                InvoiceSetting::save($parent_id=$id_invoice,$params=$parms);
        }
        
        if (isset($invoice_ref) && $invoice_ref != "") {
            $parms["OPTIONS"] = [
                ["VALUE" => $invoice_ref,
                    "OPTION" => "RECT_REF"]
                ];
                InvoiceSetting::save($parent_id=$id_invoice,$params=$parms);
        }

        return ['success' => true];
    }

    public static function delete($data){


        
        $db = Environment::$db;

        Environment::$db->where('id2', $data["id2"]);
        $invoice = Environment::$db->get('invoice');

        $invoice = $invoice[0];

        Environment::$db->where('id2', $invoice["id"]);
        $items = Environment::$db->get('invoice_item');

        foreach ($items as $i) {

            Environment::$db->where('invoice_item_id', $i["id"]);
            Environment::$db->delete('invoice_item_tax');
            
        }
        
        Environment::$db->where('invoice_id', $invoice["id"]);
        Environment::$db->delete('invoice_item');

        Environment::$db->where('id', $invoice["id"]);
        Environment::$db->delete('invoice');

        Environment::$db->where('invoice_id', $invoice["id"]);
        Environment::$db->delete('invoice_setting');

        return ["success" => true];

    }

    public static function update(array $data)
    {

        //calcular total
        $subtotal = 0;
        $totaltaxs = 0;

        $discount = $data["discount"];

        $db = Environment::$db;


        if(!empty($data["items"])){
            
            foreach ($data["items"] as $i) {

                $subtotal += floatVal($i["price"]) * $i["quantity"];

                if (array_key_exists('tax_0', $i)) {
                    $tax = explode("/", $i["tax_0"]);

                    $db->where('id2', $tax[3]);
                    $results = $db->get('tax');

                    $totaltaxs += round($i["subtotal"] * ($tax[2] / 100), 2);

                }

                if (array_key_exists('tax_1', $i)) {
                    $tax = explode("/", $i["tax_1"]);

                    $db->where('id2', $tax[3]);
                    $results = $db->get('tax');

                    $totaltaxs += round($i["subtotal"] * ($tax[2] / 100), 2);

                }
            }
            
        }else{

            $errors[] = [
                "error" => "no_items",
                "message" => "Debes añadir al menos un item.",
            ];

            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        $main_id = $data["id_invoice"];
                
        if (!empty($data["invoice_ref"])) {

            $invoice_ref = $data["invoice_ref"];

            
        }else{
            $invoice_ref = "";
        }

        $invoice_items = $data["items"];
        $invoice_id_items = $data["id_invoice"];
        $search = $data['first_name'] . ' ' . $data['last_name'] . '
' . $data['NIF'] . '
' . $data['address_1'] . '
' . $data['zip'] . ' ' . $data['city'] . '
' . $data['country'] . '
' . $data['invoice_number'] . '
' . $data['invoice_serial'] . '

';

        $db->where('id', $data['invoice_serial']);
        $prefix = $db->getOne('serial', 'serial_tag');

        if (empty($data["name"])) {
            $db = Environment::$db;
            $db->where('id', $data['invoice_serial']);
            $prefix = $db->getOne('serial', 'serial_tag');
            $data["name"] = $prefix['serial_tag'] . $data['invoice_number'];

        }


        $data = [

            'user_id' => Util::getSessionUser()["id"],
            'updated' => Util::getDate(),
            'recipient_id' => $data["cust-id"],

            'NIF' => $data['NIF'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'type' => $data['type'],
            'category' => $data['category'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'search' => $search,
            'address1' => $data['address_1'],
            'address2' => $data['address_2'] ?? "",
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'subtotal' => $data['invoice_subtotal'] * 100,
            'total' => $data['invoice_total'] * 100,

            'invoice_state' => 0,

            'serial_id' => $data["invoice_serial"],
            'invoice_number' => $data["invoice_number"],
            'invoice_date' => $data["invoice_date"],
            'invoice_terms' => $data["terms"],
            'name' => $data["name"],

        ];

        Environment::$db->where('id', $invoice_id_items);
        Environment::$db->update('invoice', $data);

        Environment::$db->where('invoice_id', $invoice_id_items);
        Environment::$db->delete('invoice_item');

        foreach ($invoice_items as $i) {

            if ($i["id"] == "") {

                $search = $i['type'] . '
' . $i['description'] . '
' . $i['price'];

                $data = [
                    'id2' => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'title' => $i['type'] ?? '',
                    'created' => Util::getDate(),
                    'search' => $search,
                    'description' => $i["description"] ?? '',
                    'price' => floatVal($i["price"]) * 100 ?? 0,
                ];

                $i["id"] = Environment::$db->insert('product', $data);

            }

            if (isset($i["deleted"]) && $i["deleted"] == "1") {
                $id_item = $i["id"];

            } else {
                $invoice_item = [
                    "id2" => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'created' => Util::getDate(),
                    'updated' => Util::getDate(),
                    "id_item" => $i["id"],
                    "quantity" => $i["quantity"],
                    "subtotal" => $i["subtotal"],
                    "invoice_id" => $main_id,
                ];

                $id_item = Environment::$db->insert('invoice_item', $invoice_item);
            }

            Environment::$db->where('invoice_item_id', $id_item);
            Environment::$db->delete('invoice_item_tax');

            if (array_key_exists('tax_0', $i)) {
                $tax = explode("/", $i["tax_0"]);

                Environment::$db->where('id2', $tax[3]);
                $results = $db->get('tax');

                $item_tax_data = [
                    "id2" => Util::genUUID(),
                    "created" => Util::getDate(),
                    "invoice_item_id" => $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"] * ($tax[2] / 100), 2),
                    "tax_value" => $tax[2],

                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            if (array_key_exists('tax_1', $i)) {
                $tax = explode("/", $i["tax_1"]);

                Environment::$db->where('id2', $tax[3]);
                $results = $db->get('tax');

                $item_tax_data = [
                    "id2" => Util::genUUID(),
                    "created" => Util::getDate(),
                    "invoice_item_id" => $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"] * ($tax[2] / 100), 2),
                    "tax_value" => $tax[2],

                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }

        }

        $parms["OPTIONS"] = [
            ["VALUE" => $discount,
            "OPTION" => "DISCOUNT"]
        ];






        if ($discount == "") {
            $parms["OPTIONS"] = [
                ["VALUE" => $discount,
                "OPTION" => "DISCOUNT"]
            ];
    
            $exist = InvoiceSetting::delete($parent_id=$main_id,$params=$parms); 
        }else if ($discount != "") {

            $parms["OPTIONS"] = [
                ["VALUE" => $discount,
                "OPTION" => "DISCOUNT"]
            ];
    
            $exist = InvoiceSetting::save($parent_id=$main_id,$params=$parms); 

        }

        if ($invoice_ref != "") {
            $parms["OPTIONS"] = [
                ["VALUE" => $invoice_ref,
                    "OPTION" => "RECT_REF"]
                ];
                InvoiceSetting::save($parent_id=$main_id,$params=$parms);
        }


        return ['success' => true];
    }

    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('invoice');

        return $all;
    }

    
    public static function generarFacturae($id2,$acc) {
        
        $db2 = Environment::$db;
    
        $hash = hash('sha256', $id2 . '50E7RQwnF050');
    
        $db2->where('id2', $id2);
        $factura = $db2->getOne('invoice');
        if (!$factura) {
            echo "Factura no encontrada";
            return;
        }

        if ($factura["type"] != 1) {
            return true;
        }
    
        $db2->where('id', $factura["serial_id"]);
        $serial = $db2->get('serial');
        if (empty($serial)) {
            echo "Serial no encontrado";
            return;
        }
    
        $db2->where('invoice_id', $factura["id"]);
        $items = $db2->get('invoice_item');
        if (empty($items)) {
            echo "Items de factura no encontrados";
            return;
        }
    
        $db2->where('id', $factura["recipient_id"]);
        $buyer = $db2->get('customer');
        if (empty($buyer)) {
            echo "Comprador no encontrado";
            return;
        }
        $buyer = $buyer[0];
    
        $fac = new Facturae();

        $fac->setNumber($serial[0]["serial_tag"], $factura["invoice_number"]);

        $fac->setIssueDate($factura["invoice_date"]);
    

    
        $fac->setSeller(new FacturaeParty([
            "taxNumber" => $acc["NIF"],
            "name"      => $acc["first_name"],
            "address"   => ($acc["address1"] . $acc["address2"]),
            "postCode"  => $acc["zip"],
            "town"      => $acc["city"],
            "province"  => $acc["state"]
        ]));
    
        $fac->setBuyer(new FacturaeParty([
            "isLegalEntity" => false,
            "taxNumber"     => $buyer["NIF"],
            "name"          => $buyer["first_name"],
            "firstSurname"  => $buyer["last_name"],
            "address"       => ($buyer["address1"]),
            "postCode"      => $buyer["zip"],
            "town"          => $buyer["city"],
            "province"      => $buyer["state"]
        ]));

        $discount = InvoiceSetting::checkIfExistSetting($parent_id=$factura["id"],$params = ["OPTION" => "DISCOUNT",]);

    
        foreach ($items as $item) {
            $db2->where('id', $item["id_item"]);
            $product = $db2->getOne('product');
            if (!$product) {
                echo "Producto no encontrado para el item " . $item["id"];
                continue;
            }
    
            $db2->where('invoice_item_id', $item["id"]);
            $taxs = $db2->get('invoice_item_tax');
            
            $taxes = [];

            $withheld = [];
            foreach ($taxs as $i) {
                $db2->where('id', $i["tax_id"]);
                $tax = $db2->getOne('tax');

                

                if (!$tax) {
                    echo "Impuesto no encontrado para el tax_id " . $i["tax_id"];
                    continue;
                }

                if ($tax["type"] == 1) {
                 
                    $taxes[Facturae::TAX_IVA] = $i["tax_value"];


                }
    
                if ($tax["type"] == 0) {
                    $taxes[Facturae::TAX_IRPF] = ($i["tax_value"] * (-1));

                }
            }


            if ($discount) {

                $disc_rate = $discount[0]["value"];
                $disc_reason = "Descuento del " . $disc_rate . "%";
                
                $unitPriceWithoutTax = $item["subtotal"] / $item["quantity"];

                $discountAmount = $item["subtotal"] * ($disc_rate / 100);




                
                $facturaeItem = new FacturaeItem([
                    "name" => $product["title"],
                    "description" => $product["description"],
                    "quantity" => $item["quantity"],
                    "unitPriceWithoutTax" => $unitPriceWithoutTax,
                    "taxes" => $taxes, // Deja que la librería maneje los cálculos del IVA
                    "discounts" => [
                        ["reason" => $disc_reason, "rate" => $disc_rate, "hasTaxes" => 0]
                    ]
                ]);

                
                $fac->addItem($facturaeItem);
                
                
            }else{

                $fac->addItem(new FacturaeItem([
                    "name" => $product["title"],
                    "description" => $product["description"],
                    "quantity" => $item["quantity"],
                    "unitPriceWithoutTax" => ($item["subtotal"] / $item["quantity"]),
                    "taxes" =>  $taxes,
                ]));

            }




           
        }

        
        $db2->where('setting', 1);
        $db2->where('target_account_id', $acc["id"]);
        $setting = $db2->get('account_setting')[0];

        

        $enc = new \Intratum\Facturas\Encryption();

        $enc->setKey('private');
        $pass = $enc->decode($setting["value"]);
        $pass = str_replace('"','',$pass);

        $cert_file = $_SERVER['DOCUMENT_ROOT'] ;

        $cert_file = str_replace("index.php",('certs/' . $acc['hash_cert']),$cert_file);

        
        $resp = $fac->sign($storeOrCertificate = $cert_file, $privateKey=null, $passphrase=$pass);

        $fac->export("einvoices/$hash.xsig");
    }

    public static function generarPDF($id2){

        $db2 = Environment::$db;

        $user = Util::getSessionUser();

        $acc = User::getUserAccount($user["id"]);

        $db2->where('id2', $id2);
        $factura = $db2->getOne('invoice');



        if ($factura["type"] == 1 || $factura["type"] == 3  ) {

            $db2->where('id', $factura["serial_id"]);
            $serial = $db2->get('serial');
        }

        $db2->where('invoice_id', $factura["id"]);
        $items = $db2->get('invoice_item');

        $discount = InvoiceSetting::checkIfExistSetting($parent_id=$factura["id"],$params = ["OPTION" => "DISCOUNT",]);

        $invoice_ref = InvoiceSetting::checkIfExistSetting($parent_id=$factura["id"],$params = ["OPTION" => "RECT_REF",]);


        $db2->where('invoice_item_id', $factura["id"]);
        $taxs = $db2->get('invoice_item_tax');

        $hash = hash('sha256', $id2 . '50E7RQwnF050');

        $allSettings = AccountSetting::all();


        $pdf = new \mikehaertl\wkhtmlto\Pdf([
            'no-outline',
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
            'encoding' => 'UTF-8',
        ]);

        ob_start();
        

        if (!empty($allSettings["DEFAULT_TEMPLATE"])) {

            include ("./templates/pdf/".$allSettings["DEFAULT_TEMPLATE"].".php");

        }else{

            include "./templates/pdf/template_1.php";

        }
        $template = ob_get_clean();
        $pdf->addPage($template);
        if (!$pdf->saveAs('./pdf/' . $hash . '.pdf')) {
            echo "ERROR";
        }
    }

    public static function publicarFactura($id2)
    {

        $acc = User::getUserAccount(Util::getSessionUser()["id"]);


        if ($acc["hash_cert"] != "") {
            self::generarFacturae($id2,$acc);
        }


        self::generarPDF($id2);

        $db2 = Environment::$db;

        $db2->where('id2', $id2);
        $data = [
            'invoice_state' => 1,
        ];

        $all = $db2->update('invoice', $data);

        return true;
    }

    public static function getAnalitycs($year = 0)
    {
        if ($year == 0) {
            $year = date('Y');
        }

        $user = Util::getSessionUser();
		$acc = User::getUserAccount($user["id"]);

        $trimestres = [];

        //iva

        //Ingresos
        //Trimestre 1
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 1);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-01-01")), date('Y-m-d', strtotime("{$year}-03-31"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre1_ingresos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 2
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 1);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-04-01")), date('Y-m-d', strtotime("{$year}-06-30"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre2_ingresos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 3trimestre
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 1);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-07-01")), date('Y-m-d', strtotime("{$year}-09-30"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre3_ingresos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 4
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 1);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-10-01")), date('Y-m-d', strtotime("{$year}-12-31"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre4_ingresos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Gastos
        //Trimestre 1
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 0);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-01-01")), date('Y-m-d', strtotime("{$year}-03-31"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre1_gastos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 2
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 0);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-04-01")), date('Y-m-d', strtotime("{$year}-06-30"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre2_gastos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 3
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 0);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-07-01")), date('Y-m-d', strtotime("{$year}-09-30"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre3_gastos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');

        //Trimestre 4
        $db = Environment::$db;
        $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        $db->join('invoice i', 'i.id = ii.invoice_id');
        $db->join('tax t', 'o.tax_id = t.id');
		$db->where('i.account_id', $acc["id"]);
        $db->where('t.type', 1);
        $db->where('i.type', 0);
        $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-10-01")), date('Y-m-d', strtotime("{$year}-12-31"))], 'BETWEEN');
        $db->groupBy('o.tax_value');
        $trimestre4_gastos = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value, SUM(ii.subtotal) AS subtotal');
        //irpf

        //modalidad 1
        // $db->join('invoice_item ii', 'ii.id = o.invoice_item_id');
        // $db->join('invoice i', 'i.id = ii.invoice_id');
        // $db->join('tax t', 'o.tax_id = t.id');
        // $db->where('t.type', 1);
        // $db->where('i.type', 0);
        // $db->where('i.invoice_date', [date('Y-m-d', strtotime("{$year}-01-01")), date('Y-m-d', strtotime("{$year}-03-31"))], 'BETWEEN');
        // $db->groupBy('o.tax_value');
        // $data = $db->get('invoice_item_tax o', null, 'SUM(o.value) AS total_iva, tax_value');

        // foreach($data as $k => $d){
        //     $subtotal = (100 * doubleVal($d['total_iva'])) / $d['tax_value'];
        //     $data[$k]['subtotal'] = $subtotal;
        // }
        // echo json_encode($data);

        // $ingresos = [];
        // $gastos = [];

        // foreach ($trimestres as $index => $trimestre) {

        //     foreach ($trimestre as $factura) {

        //         #facturas
        //         if($factura["type"] == 1){
        //             $db->where('invoice_id', $factura["id"] );
        //             $items = $db->get('invoice_item');
        //             echo json_encode($items);
        //             foreach ($items as $key) {
        //                 $db->join('tax t', 't.id = o.tax_id');
        //                 $db->where('o.invoice_item_id', $key["id"] );
        //                 $db->where('t.type', 1 );
        //                 $db->groupBy("o.tax_value");
        //                 $tax = $db->get('invoice_item_tax o', null, 'SUM(o.value) suma, o.tax_value');

        //                 $ingresos["trimestre_".($index+1)][] = $tax;
        //             }

        //         }

        //         #gastos
        //         if($factura["type"] == 0){
        //             $db->where('invoice_id', $factura["id"] );
        //             $items = $db->get('invoice_item');
        //             foreach ($items as $key) {
        //                 $db->where('invoice_item_id', $key["id"] );
        //                 $tax = $db->get('invoice_item_tax');
        //                 $ingresos["trimestre_".($index+1)][] = $key["id"];
        //             }

        //         }

        //     }
        // }

        return [
            "ingresos" => ["t1" => $trimestre1_ingresos, "t2" => $trimestre2_ingresos, "t3" => $trimestre3_ingresos, "t4" => $trimestre4_ingresos],
            "gastos" => ["t1" => $trimestre1_gastos, "t2" => $trimestre2_gastos, "t3" => $trimestre3_gastos, "t4" => $trimestre4_gastos],
        ];

    }


    public static function checkRecurring($token) {
        if ($token === "token1") {

            $db = Environment::$db;
            $db->where('operation', 1);
            $db->where('status', "planned");
            $allTask = $db->get('task', 10);
    
            $resp_tasks = [];
    
            foreach ($allTask as $task) {


                if (date('Y-m-d') >= $task["release_date"]) {

                    $data["status"] = "in_progres";
                    $db->where('id', $task["id"]);
                    $allTask = $db->update('task',$data);
    
                    $db->where('id', $task["object_id"]);
                    $invoice = $db->get('invoice')[0];
    
                    $current_id = $invoice['id'];
                    unset($invoice['id']);
                    $invoice['created'] = Util::getDate();
                    $invoice['updated'] = Util::getDate();
                    $invoice['invoice_date'] = $task["release_date"];
                    $invoice['id2'] = Util::genUUID();

                    if ($invoice["type"] == 1) {
                        $serial_options = self::getSerialNum($invoice["serial_id"]);

                        $invoice['name'] = ($serial_options["tag"].$serial_options["number"]);
                        $invoice['invoice_number'] = $serial_options["number"];


                    }
                    
                    if ($invoice["type"] == 0) {

                        $invoice['name'] = "xxxxxxxxxx";


                    }

    
                    $invoice_id = $db->insert('invoice', $invoice);



                    $parms["OPTIONS"] = [
                    ["VALUE" => true,
                        "OPTION" => "IS_RECURRING"]
                    ];
                    InvoiceSetting::save($parent_id=$invoice_id,$params=$parms);
    
                    $db->where('invoice_id', $current_id);
                    $invoice_items = $db->get('invoice_item');
    
                    
                    foreach ($invoice_items as $item) {

                        $db->where('invoice_item_id', $item["id"]);
                        $invoice_items_taxs = $db->get('invoice_item_tax');
                        $current_item_id = $item['id'];
                        unset($item['id']);
    
                        $item['created'] = Util::getDate();
                        $item['updated'] = Util::getDate();
                        $item['invoice_id'] = $invoice_id;

                        $item['id2'] = Util::genUUID();
                        $invoice_item_id = $db->insert('invoice_item', $item);
    
                        foreach ($invoice_items_taxs as $item_tax) {

                            unset($item_tax['id']);
                            $item_tax['invoice_item_id'] = $invoice_item_id;
                            $item_tax['created'] = Util::getDate();
                            $item_tax['updated'] = Util::getDate();
                            $item_tax['id2'] = Util::genUUID();
    
                            $db->insert('invoice_item_tax', $item_tax);
                        }
                    }

                    $data["status"] = "finished";
                    $db->where('id', $task["id"]);
                    $allTask = $db->update('task',$data);

                    $resp_tasks[] = $task["object_id"];
                }
            }
            return json_encode($resp_tasks);
        }
        return false;
    }
    
    public static function getSerialNum($serial_id) {

        $db = Environment::$db;
        $db->where('id', $serial_id);
        $serial = $db->get('serial')[0];

        if ($serial) {

            $db->where('serial_id', $serial_id);
            $invoices = $db->get('invoice');

            $num_invoices = count($invoices);

            $number = $serial["serial_number"];

            return ["tag"=> $serial["serial_tag"],"number"=>$number + $num_invoices +1];

        }else{
            return false;
        }

    }
    

}
