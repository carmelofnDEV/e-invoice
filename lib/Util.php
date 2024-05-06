<?php

namespace Intratum\Facturas;

class Util
{

    public static function genUUID($min = 18, $max = 24)
    {
        $len = rand($min, $max);

        $hex = md5("XcoMCl3_1S5zzCD2zm_RsSCT0jKaWF" . uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp = base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

        $len = max(4, min(128, $len));

        while (strlen($uid) < $len) {
            $uid .= self::genUUID(22);
        }

        return substr($uid, 0, $len);
    }

    public static function getDate($timestamp = null)
    {
        if ($timestamp == 'now') {
            //$res = date('Y-m-d H:i:s', time());
            $res = gmdate("Y-m-d H:i:s", time());
        } else {
            $time = time();
            if ($timestamp != null) {
                $time = strtotime($timestamp);
            }

            $res = gmdate("Y-m-d H:i:s", $time);
        }

        return $res;
    }

    public static function sanizeExitData($data){
        $res = [];
        foreach($data as $k => $d){
            foreach($d as $k2 => $d2){
                if (strpos($k2, '_') === 0){
                    if($k2 == '_id'){
                        $res[$k]['id'] = self::getUUIDByID2( $d['_id'][0], $d['_id'][2]);
                    }
                }else{
                    $res[$k][$k2] = $d2;
                }
            }
        }

        $res = array_values($res);

        return $res;
    }

    public static function getUUIDByID2(string $table_prefix, string $id2)
    {
        //$id2 = strtolower($id2);
        $res = $table_prefix . '_' . base64_encode('0:' . $id2);
        $res = str_replace('=', '', $res);

        return $res;

    }

    public static function getID2ByUUID(string $table_prefix, string $UUID)
    {

        $id2_raw = str_replace($table_prefix, "", $UUID);
        $res = base64_decode($id2_raw);
        $res = explode("0:", $res)[1];
        return $res;

    }

    public static function generateChecker($uuid)
    {
        $hash = hash('sha256', $uuid);

        $checker = substr($hash, 0, 50);

        return $checker;
    }

    public static function generateTradeName($seed)
    {
        $uniqueString = uniqid($seed, true);

        $randomString = substr($uniqueString, 0, 10);

        return $randomString;
    }

    public static function checkSession()
    {

        if (isset($_COOKIE['SSID'])) {
			$db2 = Environment::$db;
			$db2->where('id2', $_COOKIE['SSID']);
			$token_valid = $db2->getOne('access_token', 'token_valid');
			if($token_valid["token_valid"] == 0){
				require_once('src/login/logout.php');
				exit();
			}

            $cookie =User::checksession();
            $user = User::checkSesionToken($cookie);
        }

        if (!isset($user)) {
            header("Location: /login/");
        }
    }

    public static function getSessionUser()
    { if (isset($_COOKIE['SSID'])) {
            $cookie = User::checksession();
            $user = User::checkSesionToken($cookie);
        }

        if (isset($user)) {
            return $user;
        }else{
			return null;
		}
    }

}
