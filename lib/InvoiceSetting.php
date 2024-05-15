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
        if(!empty($params['OPTION'])){

            $check = self::checkIfExistSetting($parent_id, $params);
            

            $setting_id = self::settingToId($params['OPTION']);
            
            if($check){

                $data = [
                    'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                    'user_id' => Util::getSessionUser()["id"],
                    'updated' => Util::getDate(),
                    'invoice_id' => $parent_id,
                    'setting' => $setting_id,
                    'value' => Util::getDate(),
                ];

                Environment::$db->where('id', $check[0]["id"]);
                return Environment::$db->update('invoice_setting', $data);


                return ["success"=>true];

            }else{

                $data = [
                    "id2" => Util::genUUID(),
                    'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
                    'user_id' => Util::getSessionUser()["id"],
                    'created' => Util::getDate(),
                    'updated' => Util::getDate(),
                    'invoice_id' => $parent_id,
                    'setting' => $setting_id,
                    'value' => Util::getDate(),
                ];

                
                Environment::$db->insert('invoice_setting', $data);

                return ["success"=>true];

            }
            return ["success"=>false];

        }
        
    }

    public static function delete($parent_id, $params){


        if(!empty($params['OPTION'])){

            $check = self::checkIfExistSetting($parent_id, $params);

            if ($check) {

                $setting_id = self::settingToId($params["OPTION"]);
                Environment::$db->where('setting', $setting_id);
                Environment::$db->where('invoice_id', $parent_id);
                Environment::$db->delete('invoice_setting');
                return ["success"=>true];
                
            }

        }

        return ["success"=>false];

    


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