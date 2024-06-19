<?php

namespace Intratum\Facturas;


class AccountSetting{



    public static function save($parent_id, $params){
        $res =  ["success"=>false];


        if(!empty($params['OPTIONS'])){

            foreach ($params['OPTIONS'] as $i) {

                $check = self::checkIfExistSetting($parent_id, $i);

                $setting_id = self::settingToId($i['OPTION']);

                
                if($check){

                    $newData = [

                        "setting" => $setting_id,
                        "value"=>$i["VALUE"],
                        'id2' => Util::genUUID(),
                        'account_id' => $parent_id,
                        'target_account_id' =>$parent_id,
                        'user_id' => Util::getSessionUser()["id"],
                        'created' => Util::getDate(),
                        'updated' => null,
            
                    ];
    
    
                    Environment::$db->where('id', $check[0]["id"]);
                    Environment::$db->update('account_setting', $newData);
    
                    $res = ["success"=>true];
    
                }else{
    
                    $newData = [

                        "setting" => $setting_id,
                        "value"=>$i["VALUE"],
                        'id2' => Util::genUUID(),
                        'account_id' => $parent_id,
                        'target_account_id' =>$parent_id,
                        'user_id' => Util::getSessionUser()["id"],
                        'created' => Util::getDate(),
                        'updated' => null,
            
                    ];
    
                    
                    Environment::$db->insert('account_setting', $newData);
                    $res =  ["success"=>true];
    
                }
            }

        }

        return $res;
        
    }

    

    public static function delete($parent_id, $params){


        if(!empty($params['OPTIONS'])){
            
            foreach ($params["OPTIONS"] as $i ) {

                $check = self::checkIfExistSetting($parent_id, $i);

                if ($check) {

                    $setting_id = self::settingToId($i["OPTION"]);
                    Environment::$db->where('setting', $setting_id);
                    Environment::$db->where('target_account_id', $parent_id);
                    Environment::$db->delete('account_setting');
                    return ["success"=>true];
                    
                }
            }

        }

        return ["success"=>false];

    }


    

    public static function checkIfExistSetting($parent_id, $params){

        $db = Environment::$db;


        if(!empty($params['OPTION'])){

            $setting_id = self::settingToId($params["OPTION"]);

            Environment::$db->where('setting', $setting_id);
            Environment::$db->where('target_account_id', $parent_id);
            $results = $db->get('account_setting');
            
            return $results;

        }else{

            return false;
            
        }
    }


    private static function settingToId($setting){

        if($setting){

            switch ($setting) {
                case "CERT_PASS":

                    return 1;

                case "TERMS":

                    return 2;

                case "DEF_IVA":

                    return 3;

                case "DEF_IRPF":

                    return 4;

                case "DEF_IVA_EXPENSE":

                    return 5;

                case "DEF_IRPF_EXPENSE":

                    return 6;
                case 'DEFAULT_TEMPLATE':
                    return 7;

            }

        
        }else{

            return false;

        }


    }


    private static function idToSetting($setting_id){

        if($setting_id > 0){

            switch ($setting_id) {
                case 1:

                    return "CERT_PASS";

                case 2:

                    return "TERMS";

                case 3:

                    return "DEF_IVA";

                case 4:

                    return "DEF_IRPF";
                case 5:

                    return "DEF_IVA_EXPENSE";

                case 6:

                    return "DEF_IRPF_EXPENSE";
                case 7:
                    return 'DEFAULT_TEMPLATE';

            }

        
        }else{

            return false;

        }


    }


    public static function all(){

        $db = Environment::$db;

        $user = Util::getSessionUser();

        $acc_id= User::getUserAccount($user["id"])["id"];

        $db->where("target_account_id", $acc_id);
        $resp = $db->get("account_setting");

        $settings = [];

        foreach ($resp as $key) {

            if ($key["setting"] != 1) {

                $settings[self::idToSetting($key["setting"])] = $key["value"];
            }
            
        }
        return $settings;


    }




}