<?php

namespace Intratum\Facturas;

class Factura
{

    public static function insert(array $data)
    {



        $subtotal = 0;
        $totaltaxs = 0;

        $db = Environment::$db;

        foreach ($data["items"] as  $i) {
            
            $subtotal += floatVal($i["price"]) * $i["quantity"];

            if (array_key_exists( 'tax_0',$i)) {
                $tax = explode("/", $i["tax_0"]);

                $db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $totaltaxs += round($i["subtotal"]*($tax[2] / 100),2);

            }

            if (array_key_exists( 'tax_1',$i)) {
                $tax = explode("/", $i["tax_1"]);

                $db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $totaltaxs += round($i["subtotal"]*($tax[2] / 100),2);

            }
        }

        $data['total'] = $subtotal + $totaltaxs;

        //$all = Environment::$db->get('customer');
        $invoice_items = $data["items"];

        $search = $data['first_name'] . ' ' . $data['last_name'] . '
' . $data['NIF'] . '
' . $data['address_1'] . '
' . $data['zip'] . ' ' . $data['city'] . '
' . $data['country'] . '
' . $data['invoice_number'] . '
' . $data['invoice_serial'] . '

';      


        if(empty($data["name"])){
            $db = Environment::$db;
            $db->where('id', $data['invoice_serial']);
            $prefix =  $db->getOne('serial', 'serial_tag');
            $data["name"] = $prefix['serial_tag'].$data['invoice_number'];

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
            'subtotal' => $data['invoice_subtotal']*100,
            'total' => $data['total']*100,
            'invoice_state' => 0,
            'serial_id' => $data["invoice_serial"],
            'invoice_number' => $data["invoice_number"],
            'invoice_date' => $data["invoice_date"],
            'invoice_terms' => $data["terms"],
            'name' => $data["name"],
        ];

        $id_invoice = Environment::$db->insert('invoice', $data);



        foreach ($invoice_items as  $i) {

            if ($i["id"] == "") {


                        $search = $i['type'].'
' . $i['description'] . '
' . $i['price'];

                $data = [
                    'id2' => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'title' => $i['type'] ?? '',
                    'created' => Util::getDate(),
                    'search'=> $search,
                    'description'=> $i["description"] ?? '',
                    'price'=> floatVal($i["price"]) * 100 ?? 0,
                ];

                $i["id"] = Environment::$db->insert('product', $data);
                  
            }

            $invoice_item = [
                "id2" => Util::genUUID(),
			    'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                'user_id' => Util::getSessionUser()["id"],
                'created' => Util::getDate(),
                'updated' => Util::getDate(),
                "id_item"=> $i["id"],
                "quantity"=> $i["quantity"],
                "subtotal"=> $i["subtotal"],
                "invoice_id"=>  $id_invoice,
            ];

            $id_item = Environment::$db->insert('invoice_item', $invoice_item);



            if (array_key_exists( 'tax_0',$i)) {
                $tax = explode("/", $i["tax_0"]);

                Environment::$db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $item_tax_data = [
                    "id2" =>Util::genUUID() ,	
                    "created"=> Util::getDate(),
                    "invoice_item_id"=> $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"]*($tax[2] / 100),2),
                    "tax_value" => $tax[2],


                
                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            if (array_key_exists( 'tax_1',$i)) {
                $tax = explode("/", $i["tax_1"]);

                Environment::$db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $item_tax_data = [
                    "id2" =>Util::genUUID() ,	
                    "created"=> Util::getDate(),
                    "invoice_item_id"=> $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"]*($tax[2] / 100),2),
                    "tax_value" => $tax[2],
               
                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            
            
        }

        return ['success' => true];
    }




    public static function update(array $data)
    {

        //calcular total
        $subtotal = 0;
        $totaltaxs = 0;

        $db = Environment::$db;

        foreach ($data["items"] as  $i) {
            
            $subtotal += floatVal($i["price"]) * $i["quantity"];

            if (array_key_exists( 'tax_0',$i)) {
                $tax = explode("/", $i["tax_0"]);

                $db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $totaltaxs += round($i["subtotal"]*($tax[2] / 100),2);

            }

            if (array_key_exists( 'tax_1',$i)) {
                $tax = explode("/", $i["tax_1"]);

                $db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $totaltaxs += round($i["subtotal"]*($tax[2] / 100),2);

            }
        }

        $data['total'] = $subtotal + $totaltaxs;

        $main_id = $data["id_invoice"];

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
$prefix =  $db->getOne('serial', 'serial_tag');

            if(empty($data["name"])){
                $db = Environment::$db;
                $db->where('id', $data['invoice_serial']);
                $prefix =  $db->getOne('serial', 'serial_tag');
                $data["name"] = $prefix['serial_tag'].$data['invoice_number'];

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
            'subtotal' => $subtotal*100,
            'total' => $data['total']*100,

            'invoice_state' => 0,

            'serial_id' => $data["invoice_serial"],
            'invoice_number' => $data["invoice_number"],
            'invoice_date' => $data["invoice_date"],
            'invoice_terms' => $data["terms"],
            'name' => $data["name"],





        ];

        
        Environment::$db->where('id', $invoice_id_items );
        Environment::$db->update('invoice', $data);

        Environment::$db->where('invoice_id', $invoice_id_items);
        Environment::$db->delete('invoice_item');


        foreach ($invoice_items as  $i) {

            if ($i["id"] == "") {


                        $search = $i['type'].'
' . $i['description'] . '
' . $i['price'];

                $data = [
                    'id2' => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'title' => $i['type'] ?? '',
                    'created' => Util::getDate(),
                    'search'=> $search,
                    'description'=> $i["description"] ?? '',
                    'price'=> floatVal($i["price"]) * 100 ?? 0,
                ];

                $i["id"] = Environment::$db->insert('product', $data);
                  
            }




            if (isset($i["deleted"]) && $i["deleted"] == "1") {
                $id_item = $i["id"];


            }else{
                $invoice_item = [
                    "id2" => Util::genUUID(),
                    'user_id' => Util::getSessionUser()["id"],
                    'created' => Util::getDate(),
                    'updated' => Util::getDate(),
                    "id_item"=> $i["id"],
                    "quantity"=> $i["quantity"],
                    "subtotal"=> $i["subtotal"],
                    "invoice_id"=>  $main_id ,
                ];

                $id_item = Environment::$db->insert('invoice_item', $invoice_item);
           }


            Environment::$db->where('invoice_item_id', $id_item );
            Environment::$db->delete('invoice_item_tax');

            if (array_key_exists( 'tax_0',$i)) {
                $tax = explode("/", $i["tax_0"]);

                Environment::$db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $item_tax_data = [
                    "id2" =>Util::genUUID() ,	
                    "created"=> Util::getDate(),
                    "invoice_item_id"=> $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"]*($tax[2] / 100),2),
                    "tax_value" => $tax[2],


                
                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            if (array_key_exists( 'tax_1',$i)) {
                $tax = explode("/", $i["tax_1"]);

                Environment::$db->where('id2',$tax[3] );
                $results = $db->get('tax');
               
                $item_tax_data = [
                    "id2" =>Util::genUUID() ,	
                    "created"=> Util::getDate(),
                    "invoice_item_id"=> $id_item,
                    "tax_id" => $results[0]["id"],
                    "value" => round($i["subtotal"]*($tax[2] / 100),2),
                    "tax_value" => $tax[2],
               
                ];

                Environment::$db->insert('invoice_item_tax', $item_tax_data);

            }
            
            
        }

        return ['success' => true];
    }

    public static function get(array $parms = []){

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('invoice');

        return $all;
    }

    public static function generarPDF($id2){

        
        $db2 = Environment::$db;


        $user = Util::getSessionUser();

        $acc = User::getUserAccount($user["id"]);

        $db2->where('id2', $id2);
        $factura = $db2->getOne('invoice');

        $db2->where('id', $factura["serial_id"]);
        $serial = $db2->get('serial');


        $db2->where('invoice_id', $factura["id"]);
        $items = $db2->get('invoice_item');

        $db2->where('invoice_item_id', $factura["id"]);
        $taxs = $db2->get('invoice_item_tax');
        

        

        $hash = hash('sha256', $id2.'50E7RQwnF050');

        $pdf = new \mikehaertl\wkhtmlto\Pdf([
            'no-outline',         
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,
            'encoding' => 'UTF-8', 
        ]);
        ob_start();
        include("./templates/pdf/template_1.php");
        $template = ob_get_clean();
        $pdf->addPage($template);
        if (!$pdf->saveAs('./pdf/'.$hash.'.pdf')) {
            echo "ERROR";
        }
    }

    public static function publicarFactura($id2)
    {

        self::generarPDF($id2);
        $db2 = Environment::$db;

        $db2->where('id2', $id2);
        $data = [
            'invoice_state' => 1,
        ];

        $all = $db2->update('invoice',$data);

        return true;
    }

}