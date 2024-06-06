<?php

namespace Intratum\Facturas;

class Customer
{

    public static function insert(array $data)
    {
        //$all = Environment::$db->get('customer');

        if  (!isset($data['last_name']) ) {
            $data['last_name'] = "";
        }

        $search = $data['first_name'] . ' ' . $data['last_name'] . '
' . $data['NIF'] . '
' . $data['address1'] . '
' . $data['zip'] . ' ' . $data['city'] . '
' . $data['country'] . '
';

        $data = [

            'id2' => Util::genUUID(),
            'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
            'user_id' => Util::getSessionUser()["id"],
            'created' => Util::getDate(),
            'updated' => null,
            'NIF' => $data['NIF'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'type' => $data['type'],
            'category' => $data['category'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'search' => $search,
            'address1' => $data['address1'],
            'address2' => $data['address2'] ?? "",
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'zip' => $data['zip'],

        ];

        $id = Environment::$db->insert('customer', $data);
     
        return $id ;
    }

    public static function update(array $data)
    {
        $db2 = Environment::$db;

        $search = $data['first_name'] . ' ' . $data['last_name'] . '
' . $data['NIF'] . '
' . $data['address1'] . '
' . $data['zip'] . ' ' . $data['city'] . '
' . $data['country'] . '
';

        $data["search"] = $search;

        $data["updated"] = date("Y-m-d H:i:s");
        $db2->where('id2', $data["id2"]);
        $db2->update('customer', $data);

        return true;
    }

    public static function delete(array $data)
    {
        $db2 = Environment::$db;
        $db2->where('id2', $data["id2"]);
        if ($db2->delete('customer')) {
            echo 'successfully deleted';
        }

        return ['success' => true];
    }

    public static function all($parms = [])
    {
        $db2 = Environment::$db;

        if (!empty($parms['q'])) {
            $db2->where('search', '%' . $parms['q'] . '%', 'LIKE');
        }

        $db2->where('account_id', $parms['acc_id']);

        $all = $db2->get('customer', 10, 'id, id2 as _id, first_name');

        foreach ($all as $k => $a) {
            $all[$k]['_id'] = ['cust', 0, $a['_id']];
        }

        $res = [
            'data' => $all,
        ];

        return $all;
    }

    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('customer');

        return $all;
    }

}
