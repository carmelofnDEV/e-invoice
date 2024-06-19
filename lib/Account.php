<?php

namespace Intratum\Facturas;

class Account
{

    

    public static function update(array $data)
    {

        $db2 = Environment::$db;


        $newData=[

            "NIF" => $data["NIF"],
            "address1" => $data["address_1"],
            "address2" => $data["address_2"] ?? "",
            "category" => $data["category"],
            "city" => $data["city"],
            "country" => $data["country"],
            "email" => $data["email"],
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "phone" => $data["phone"],
            "state" => $data["state"],
            "zip" => $data["zip"],
        ];





        $newData["updated"] = date("Y-m-d H:i:s");
        $db2->where('id2', $data["acc_id2"]);
        $a = $db2->update('account', $newData);
        return true;
    }


    public static function setCert($id,$extension){

        $hash_logo = "jjj6d9qus,%z8@;|km#bp9".$id;

        $hash_logo = hash("sha256",$hash_logo);

        $hash_logo = $hash_logo.'.'.$extension;


        $newData=[
            "hash_cert"=>$hash_logo,

        ];

        $db2 = Environment::$db;
        $db2->where('id', $id);
        $db2->update('account', $newData);


        return $hash_logo;
    }
    
    public static function saveCert($data,$pass){


        $account = Util::getSessionUser();

        $file_info = pathinfo($data["name"]);

        $id = $account["id"];

        if(move_uploaded_file($data['tmp_name'], './certs/'.self::setCert($id=$id,$extension=$file_info['extension']))) {
            
            $cert_pass = $pass;

            $enc = new \Intratum\Facturas\Encryption();
            $enc->setKey('private');
            $codi = $enc->encode(json_encode($cert_pass));


            $acc_id= User::getUserAccount($id)["id"];

            $parms["OPTIONS"] = [
                ["VALUE" => $codi,
                    "OPTION" => "CERT_PASS"]
                ];
                
            AccountSetting::save($parent_id=$acc_id,$params=$parms);
            

            $response = true;

        }else{
            $response = false;
        }

        return $response;
    }


    public static function setLogo($id,$extension){

        $hash_logo = "jjj6d9qus,%z8@;|km#bp9".$id;

        $hash_logo = hash("sha256",$hash_logo);

        $hash_logo = $hash_logo.'.'.$extension;


        $newData=[
            "hash_logo"=>$hash_logo,

        ];

        $db2 = Environment::$db;
        $db2->where('id', $id);
        $db2->update('account', $newData);


        return $hash_logo;
    }
    
    public static function saveLogo($data){
        $account = Util::getSessionUser();

        $file_info = pathinfo($data["name"]);

        $id = $account["id"];

        if(move_uploaded_file($data['tmp_name'], './assets/images/'.self::setLogo($id=$id,$extension=$file_info['extension']))) {
            $response = true;
        }else{
            $response = false;
        }

        return $response;
    }

    
    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('account');

        return $all;
    }

    public static function setPreferencies($data){
        $user = Util::getSessionUser();
        $acc = User::getUserAccount($user["id"]);


        foreach ($data as $pref => $val) {


            switch ($pref) {
                case 'terms':

                    $parms["OPTIONS"] = [
                        ["VALUE" => $val,
                            "OPTION" => "TERMS"]
                        ];
                        
                    AccountSetting::save($parent_id=$acc["id"],$params=$parms);

                    break;

                case 'def-iva':
                    $parms["OPTIONS"] = [
                        ["VALUE" => $val,
                            "OPTION" => "DEF_IVA"]
                        ];
                        
                    AccountSetting::save($parent_id=$acc["id"],$params=$parms);

                    break;

                case 'def-irpf':
                    
                    $parms["OPTIONS"] = [
                        ["VALUE" => $val,
                            "OPTION" => "DEF_IRPF"]
                        ];
                        
                    AccountSetting::save($parent_id=$acc["id"],$params=$parms);

                    break;
                
                case 'def-iva-expense':
                    $parms["OPTIONS"] = [
                        ["VALUE" => $val,
                            "OPTION" => "DEF_IVA_EXPENSE"]
                        ];
                        
                    AccountSetting::save($parent_id=$acc["id"],$params=$parms);

                    break;
    
                case 'def-irpf-expense':
                    
                    $parms["OPTIONS"] = [
                        ["VALUE" => $val,
                            "OPTION" => "DEF_IRPF_EXPENSE"]
                        ];
                        
                    AccountSetting::save($parent_id=$acc["id"],$params=$parms);

                    break;
                
                default:
                    break;
            }
        
        }
        return true;

    }

}
