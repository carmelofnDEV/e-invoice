<?php

namespace Intratum\Facturas;


class InvoiceSetting{

    //$parent_id = id factura
    /*
        $params['OPTION'] [
            'TIME_UPDATED_IS_PAID'
        ];
    */

    public static function save($parent_id, $params){


        if(!empty($params['OPTIONS'])){

            foreach ($params['OPTIONS'] as $i) {

                $check = self::checkIfExistSetting($parent_id, $i);

                $setting_id = self::settingToId($i['OPTION']);
                
                if($setting_id == 1){

                    $i["VALUE"] = date("Y-m-d H:i:s", ($i["VALUE"]/1000));

                }

                if($setting_id == 3 && $i["VALUE"] != "" ){

                    $i["VALUE"] = str_replace('\/', '-', $i["VALUE"]); 
                    $fecha = new \DateTime($i["VALUE"]);
                    $i["VALUE"] = $fecha->format("Y-m-d");
                }


                if($setting_id == 4 && $i["VALUE"] != "" ){

                    $i["VALUE"] = str_replace('\/', '-', $i["VALUE"]); 
                    $fecha = new \DateTime($i["VALUE"]);
                    $i["VALUE"] = $fecha->format("Y-m-d");

                }

                



                if($setting_id == 2){
                    $i["VALUE"] = self::parseRecurring($i["VALUE"]) ;

                    if ($i["VALUE"] === false) {
                        $res = ["success"=>false];
                        break;

                    }



                    if($i["VALUE"] == 0){

                        if ($check) {
                            Environment::$db->where('invoice_id', $parent_id);
                            Environment::$db->where('setting', 2);
                            Environment::$db->delete('invoice_setting');

                            Environment::$db->where('invoice_id', $parent_id);
                            Environment::$db->where('setting', 3);
                            Environment::$db->delete('invoice_setting');

                            Environment::$db->where('invoice_id', $parent_id);
                            Environment::$db->where('setting', 4);
                            Environment::$db->delete('invoice_setting');

                            return ["success"=>true];  
                        }
                    }else{

                        Environment::$db->where('object_id', $parent_id);
                        Environment::$db->where('operation', 1);
                        Environment::$db->delete('task');
                        
                        $recurrent_dates = self::getRecurringDates($parent_id,$params['OPTIONS']);
                        
                       foreach ($recurrent_dates as $date) {



                            $data = [
                                "id2" => Util::genUUID(),
                                'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                                'user_id' => Util::getSessionUser()["id"],
                                'created' => Util::getDate(),
                                "object_id" => $parent_id,
                                "release_date" => $date,
                                "status" => "planned",
                                "operation" => 1,
                            ];

                            $resp = Environment::$db->insert('task', $data);

                        }


                    }
                }

                
                if($check){
    
                    $data = [
                        'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                        'user_id' => Util::getSessionUser()["id"],
                        'updated' => Util::getDate(),
                        'invoice_id' => $parent_id,
                        'setting' => $setting_id,
                        'value' => $i["VALUE"],
                    ];
    
                    Environment::$db->where('id', $check[0]["id"]);
                    Environment::$db->update('invoice_setting', $data);
    
                    $res = ["success"=>true];
    
                }else{
    
                    $data = [
                        "id2" => Util::genUUID(),
                        'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                        'user_id' => Util::getSessionUser()["id"],
                        'created' => Util::getDate(),
                        'updated' => Util::getDate(),
                        'invoice_id' => $parent_id,
                        'setting' => $setting_id,
                        'value' => $i["VALUE"],
                    ];
    
                    
                    Environment::$db->insert('invoice_setting', $data);
                    $res =  ["success"=>true];
    
                }
            }

        }

        return $res;
        
    }
    public static function getRecurringDates($parent_id, $params){

        $raw_data = [];

        foreach ($params as $param) {
            if ($param["OPTION"] == "REC") {
                $param["VALUE"] =  self::parseRecurring($param["VALUE"]); 
            }else{
                if($param["VALUE"] != ""){
                    $param["VALUE"] = str_replace('\/', '-', $param["VALUE"]); 
                    $param["VALUE"] = new \DateTime($param["VALUE"]);
                    
                }
            }

            $raw_data[$param["OPTION"]]= $param["VALUE"];
        }
        

        
        if(empty($raw_data["REC_END_DATE"]) || $raw_data["REC_END_DATE"] == ""  ){
            $raw_data["REC_END_DATE"] = new \DateTime();

            $raw_data["REC_END_DATE"]->modify('+3 years');
        }else{

            if (empty($raw_data["REC_START_DATE"])) {
                $end_date = $raw_data["REC_END_DATE"];
            }else{

                if($raw_data["REC_START_DATE"] == $raw_data["REC_END_DATE"] ){

                    $raw_data["REC_END_DATE"] = new \DateTime();
                    $raw_data["REC_END_DATE"]->modify('+3 years');

                }else{
                    $end_date = $raw_data["REC_END_DATE"];
                }

            }
        }


        if(empty($raw_data["REC_END_DATE"]) || $raw_data["REC_END_DATE"] == ""  ){

            $raw_data["REC_END_DATE"] = new \DateTime();

            $raw_data["REC_END_DATE"]->modify('+3 years');

            $end_date =  $raw_data["REC_END_DATE"];
        }else{
            $end_date = $raw_data["REC_END_DATE"];
        }

        
        if(empty($raw_data["REC_START_DATE"]) || $raw_data["REC_START_DATE"] == "" || strtotime($raw_data["REC_START_DATE"]->format("Y-m-d")) < strtotime("1970-01-01")) {

            $start_date = new \DateTime();
        
        }else{
            $start_date = $raw_data["REC_START_DATE"];

        }



        if ($raw_data["REC"] == 1) {
            
            $period = "+1 week";

        } elseif ($raw_data["REC"] == 2) {

            $period = "+1 month";
            
        } elseif ($raw_data["REC"] == 3) {

            $period = "+1 year";
            
        }


        $recurrent_dates = [];
        $today = new \DateTime();
        $valid_date=true;
        
        if($today >= $start_date){

            $fecha = $start_date;
            while ($valid_date) {


                $fecha->modify($period);

                if ($fecha <= $end_date) {

                    $recurrent_dates[] = $fecha->format('Y-m-d');
                }else{
                    $valid_date=false;
                }
            
            

            }
        }


        return $recurrent_dates;


    }

    

    public static function delete($parent_id, $params){


        if(!empty($params['OPTIONS'])){
            
            foreach ($params["OPTIONS"] as $i ) {

                $check = self::checkIfExistSetting($parent_id, $i);

                if ($check) {

                    $setting_id = self::settingToId($i["OPTION"]);
                    Environment::$db->where('setting', $setting_id);
                    Environment::$db->where('invoice_id', $parent_id);
                    Environment::$db->delete('invoice_setting');
                    return ["success"=>true];
                    
                }
            }

        }

        return ["success"=>false];

    }

    public static function parseRecurring($value){
        

        if($value){

            switch ($value) {
                case "disabled":

                    return 0;

                case "weekly":

                    return 1;

                case "monthly":

                    return 2;

                case "yearly":

                    return 3;
            }

        
        }else{

            return false;

        }

    }

    

    public static function checkIfExistSetting($parent_id, $params){

        $db = Environment::$db;


        if(!empty($params['OPTION'])){

            $setting_id = self::settingToId($params["OPTION"]);

            Environment::$db->where('setting', $setting_id);
            Environment::$db->where('invoice_id', $parent_id);
            $results = $db->get('invoice_setting');
            
            return $results;

        }else{

            return false;
            
        }
    }


    private static function settingToId($setting){

        if($setting){

            switch ($setting) {
                case "PAYMENT_DATE":

                    return 1;

                case "REC":

                    return 2;

                case "REC_END_DATE":

                    return 3;

                case "REC_START_DATE":

                    return 4;
                case "IS_RECURRING":

                    return 5;
                case "DISCOUNT":

                    return 6;

                    

            }

        
        }else{

            return false;

        }


    }


    private static function idToSetting($setting_id){

        if($setting_id > 0){

            switch ($setting_id) {
                case 1:

                    return "PAYMENT_DATE";

                case 2:

                    return "REC";

                case 3:

                    return "REC_END_DATE";

                case 4:

                    return "REC_START_DATE";
                case 5:

                    return "IS_RECURRING";
                case 6:

                    return "DISCOUNT";

            }

        
        }else{

            return false;

        }


    }

    // private static function getSettingID($setting_name){
	// 	$res = '';
		
	// 	switch($setting_name){
	// 		case 'is_out_stock':
	// 			$res = 1;
	// 		break;
	// 	}
		
	// 	return $res;
	// }
	
	// private static function getSettingName($setting_name_id){
	// 	$res = '';
		
	// 	switch($setting_name_id){
	// 		case 1:
	// 			$res = 'IS_OUT_STOCK';
	// 		break;
			
	// 	}
		
	// 	return $res;
	// }

    // private static function checkExit($parent_id, $setting){
    //         $parent_real = \Intratum\Core\DB::getRealID($parent_id, 'account_id');
            
    //         $query = \Intratum\Core\DB::get()->selectOne('SELECT id FROM '.\Intratum\Core\DB::get()->getPrefix().'ticket_settings WHERE ticket_id = ? AND setting = ? ', [
    //             $parent_real, self::getSettingID($setting)
    //         ]);	
            
    //         $res = true;
    //         if(empty($query['id']))
    //             $res = false;
        
    //         return $res;
    //     }

    // public static function save($parent_id, array $parms, array $opts = null){
    //         if(isset($parms['option']['TICKETS_PER_ORDER'])){
    //             if(Event::$env['rol'] != 'owner')
    //                 throw new Exceptions\ServiceException('invalid_role', 'Rol inválido');
                
    //             if (!is_numeric($parms['option']['TICKETS_PER_ORDER']))
    //                 die();
                
    //             $numeroEntero = (int)$parms['option']['TICKETS_PER_ORDER'];
    //             if ($numeroEntero != $parms['option']['TICKETS_PER_ORDER'])
    //                 die();
                
    //             if ($numeroEntero >= 1 && $numeroEntero <= 5) {
                    
    //             }else{
    //                 die();
    //             }
                
    //             if(self::checkExit($parent_id, 'tickets_per_order')){
    //                 $parent_real = \Intratum\Core\DB::getRealID($parent_id, 'account_id');
                    
    //                 \Intratum\Core\DB::get()->queryOne('UPDATE '.\Intratum\Core\DB::get()->getPrefix().'ticket_settings SET value = ?, updated = ? WHERE ticket_id = ? AND setting = ?', [
    //                     $parms['option']['TICKETS_PER_ORDER'], \Intratum\Core\DB::getDate(), $parent_real, self::getSettingID('tickets_per_order')
    //                 ]);
    //             }else{
    //                 self::create($parent_id, [
    //                     'setting' => self::getSettingID('tickets_per_order'),
    //                     'value' => $parms['option']['TICKETS_PER_ORDER']
    //                 ], ['nosetObject' => false]);
    //             }
    //         }
    //     }

    // public static function all($parent_id, array $parms = null){
    //         $parent_id_real = \Intratum\Core\DB::getRealID($parent_id, 'event');
    //         $query = \Intratum\Core\DB::get()->selectMany('SELECT setting,value FROM '.\Intratum\Core\DB::get()->getPrefix().'ticket_settings WHERE ticket_id = ?', [
    //             $parent_id_real
    //         ]);
            
    //         $key = array_search(1, array_column($query, 'setting'));
            
    //         $data = [];
    //         if(!empty($key) || empty($key) && $key === 0){
    //             $value = $query[$key]['value'];
                
    //             if($value == 1)
    //                 $valueRes = true;
    //             else
    //                 $valueRes = false;
                
    //             $data[] = [
    //                 'setting' => self::getSettingName(1),
    //                 'value' => $valueRes
    //             ];
    //         }else{
                
    //             $data[] = [
    //                 'setting' => self::getSettingName(1),
    //                 'value' => false
    //             ];
    //         }
    //     }



}