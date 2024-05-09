<?php

namespace Intratum\Facturas;

class User
{

    public static function insert(array $data){

        


        $password = hash("sha256", $data["password"]);
        $email = $data['email'];

        $errors = [];


        if (strlen($data["password"]) < 5) {
            $errors[] = [
                'params' => "password",
                'message' => "La contraseña debe tener al menos 5 caracteres.",
            ];
        }

        if (self::emailExists($email)) {
            $errors[] = [
                'params' => "email",
                'message' => "Ese correo ya existe! <a class='!text-[#4e44f6]' href='/login/'> Haz login </a>",
            ];
        }


        if ($data["password"] != $data["repeat_password"]) {
            $errors[] = [
                'params' => "repeat_password",
                'message' => "Las  contraseñas deben ser iguales!",
            ];
        }

        if(count($errors) != 0 ){
            return $errors;
        }


        $date = Util::getDate();
        $user_name = $data["first_name"] ?? "";
        $data = [
            'id2' => Util::genUUID(),
            'email' => $email ?? '',
            'created' => $date,
            'password' => $password,
            'first_name' => $data["first_name"] ?? "",
            'last_name' => $data["last_name"] ?? "",

        ];

        $user_id = Environment::$db->insert('user', $data);

        $data = [
            
            'id2' => Util::genUUID(),
            'created' => $date,
            'tradename' => Util::generateTradeName($user_id),
            'name' => $user_name,
        ];

        $account_id = Environment::$db->insert('account', $data);

        $data = [
            'id2' => Util::genUUID(),
            'created' => Util::getDate(),
            'user_id' => $user_id,
            'account_id' => $account_id,
        ];

        Environment::$db->insert('accountuser', $data);

        self::login([
            'email' => $email,
            'password' => $password,
        ]);

    }

    public static function login(array $args)
    {

        $db2 = Environment::$db;

        $db2->where('email', $args['email']);
        $user = $db2->getOne('user', 'id,password');

        if (empty($user['id']) || $user['password'] != $args['password']) {
            return ['success' => false];

        }

        $db2->where('user_id', $user['id']);
        $account_id = $db2->getOne('accountuser', 'id');
        $uuid = Util::genUUID();
        $checker = Util::generateChecker($uuid);

        $data = [
            'id2' => $uuid,
            'created' => Util::getDate(),
            'checker' => $checker,
            'user_id' => $user["id"],
            'account_id' => $account_id['id'],
            "token_valid"=> 1,
        ];

        $db2->insert('access_token', $data);

        setcookie('SSID', $uuid, null, '/', null, false, true);
        setcookie('SID', $checker, null, '/', null, false, true);
        return ['success' => true];

    }

    public static function checksession()
    {
        $cookie = isset($_COOKIE['SSID']) ? $_COOKIE['SSID'] : null;
        return $cookie;
    }

    public static function checkSesionToken($uuid)
    {
        $db2 = Environment::$db;
        $db2->where('id2', $uuid);
        $session_user_id = $db2->getOne('access_token', "user_id");

        if ($session_user_id != false) {
            $db2->where('id', $session_user_id["user_id"]);
            $user = $db2->getOne('user');
        }else{
            $user = null;

        }

        return $user;
    }

    public static function update(array $data)
    {
        $db2 = Environment::$db;

        $data["price"] = $data["price"] * 100;
        $db2->where('id2', $data["id2"]);
        if ($db2->update('product', $data)) {

        } else {
        }

        return ['success' => true];
    }

    public static function delete(array $data)
    {
        $db2 = Environment::$db;
        $db2->where('id2', $data["id2"]);
        if ($db2->delete('product')) {
            echo 'successfully deleted';
        }

        return ['success' => true];
    }

    public static function all($parms = [])
    {

        $all = Environment::$db->get('product');

        $res = [
            'data' => $all,
        ];

        return $all;
    }

    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;
        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('product');
        return $all;
    }

    public static function emailExists($email){
        $db2 = Environment::$db;
        $db2->where('email', $email);
        $user = $db2->getOne('user', 'id');

        return !empty($user['id']);
    }

    public static function expireSessionToken($cookie){
        $db2 = Environment::$db;
        
        $data = [
            "token_valid"=> 0,
        ];

		$db2->where('id2', $cookie);
		$db2->update('access_token', $data);

		return true;
    }


    public static function getUserAccount($id){

        $db2 = Environment::$db;
        $db2->where('user_id', $id);
        $acc_id = $db2->getOne('accountuser');


        $db2 = Environment::$db;
        $db2->where('id', $acc_id["account_id"]);
        $acc = $db2->getOne('account');
        return $acc;

    }

    public static function forgotPassword($user_id){

        $enc = new \Intratum\Facturas\Encryption();


        $enc->setKey('private');
        $codi = $enc->encode(json_encode([$user_id,time()]));

        $urlExp = end(explode('/', $url));
        if ($_SERVER['HTTPS'] == "on") {
            return 'https://'.$_SERVER['HTTP_HOST'].'/passwordrecovery/'.$codi;
        }else{
            return 'http://'.$_SERVER['HTTP_HOST'].'/passwordrecovery/'.$codi;
        }
       
    }



}


