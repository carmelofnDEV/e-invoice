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

        if(move_uploaded_file($data['tmp_name'], './assets/certs/'.self::setCert($id=$id,$extension=$file_info['extension']))) {
            
            $cert_pass = $pass;

            $enc = new \Intratum\Facturas\Encryption();
            $enc->setKey('private');
            $codi = $enc->encode(json_encode($cert_pass));
    
            $db2 = Environment::$db;

            $acc_id= User::getUserAccount(Util::getSessionUser()["id"])["id"];

            $newData = [

                "setting" => 1,
                "value"=>$codi,
                'id2' => Util::genUUID(),
                'account_id' => $acc_id,
                'target_account_id' =>$acc_id,
                'user_id' => Util::getSessionUser()["id"],
                'created' => Util::getDate(),
                'updated' => null,
    
            ];

            $db2->where('target_account_id', $acc_id);
            $db2->where('setting',1);
            $exist=$db2->get('account_setting');

            if($exist){
                $db2->update('account_setting', $newData);
            }else{
                $db2->insert('account_setting', $newData);

            }


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

}
