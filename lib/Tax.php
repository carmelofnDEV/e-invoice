<?php

namespace Intratum\Facturas;

class Tax
{

    public static function insert(array $data){
        //$all = Environment::$db->get('tax');

        

        if (strlen($data["name"]) > 5) {
            $data["name"] =  substr($data["name"], 0, 5);
        }

        
        if (!is_numeric($data["value"])) {
            return ['success' => false];
        }


        

        $search = $data['name'] . '
' . $data['value'];

        $data = [
            'id2' => Util::genUUID(),
            
            'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
            'user_id' => Util::getSessionUser()["id"],
            'type' => $data['type'],
            'created' => Util::getDate(),
            "search" => $search,
            'name' => $data["name"],
            'value' => floatVal($data["value"]),
        ];

        Environment::$db->insert('tax', $data);

        return ['success' => true,
                "id2_response" => $data["id2"]];
    }

    public static function update(array $data)
    {
        $id2 = $data["id2"];
        $db2 = Environment::$db;

        $search = $data['name'] . '
' . $data['value'];

        $data = [
            'type' => $data['type'],
            'name' => $data["name"],
            'value' => floatVal($data["value"]),
        ];

        $data["search"] = $search;
        $data["updated"] = date("Y-m-d H:i:s");
        $data["user_id"] = Util::getSessionUser()["id"];

        $db2->where('id2', $id2);
        $db2->update('tax', $data);
        return ["success" => true];
    }

    public static function delete(array $data)
    {
        $db2 = Environment::$db;
        $db2->where('id2', $id2);
        if ($db2->delete('tax')) {
            echo 'successfully deleted';
        }

        return ['success' => true];
    }

    public static function all($parms = [])
    {
        $db2 = Environment::$db;


        $user = Util::getSessionUser();
		$acc = User::getUserAccount($user["id"]);
		$db2->where('account_id', $acc["id"]);
		$res = $db2->get('tax');

        return $res;
    }

    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('tax');

        return $all;
    }

}