<?php

namespace Intratum\Facturas;

class Account
{

//     public static function insert(array $data)
//     {
//         //$all = Environment::$db->get('account');

//         $search = $data['first_name'] . ' ' . $data['last_name'] . '
// ' . $data['NIF'] . '
// ' . $data['address1'] . '
// ' . $data['zip'] . ' ' . $data['city'] . '
// ' . $data['country'] . '
// ';

//         $data = [

//             'id2' => Util::genUUID(),
//             'account_id' => Util::getSessionUser()["id"],
//             'user_id' => Util::getSessionUser()["id"],
//             'created' => Util::getDate(),
//             'updated' => null,
//             'NIF' => $data['NIF'],
//             'first_name' => $data['first_name'],
//             'last_name' => $data['last_name'],
//             'type' => $data['type'],
//             'category' => $data['category'],
//             'email' => $data['email'],
//             'phone' => $data['phone'],
//             'search' => $search,
//             'address1' => $data['address1'],
//             'address2' => $data['address2'] ?? "",
//             'country' => $data['country'],
//             'state' => $data['state'],
//             'city' => $data['city'],
//             'zip' => $data['zip'],

//         ];

//         $id = Environment::$db->insert('account', $data);
     
//         return $id ;
//     }

    public static function update(array $data)
    {

        $db2 = Environment::$db;




        $newData=[

            "NIF" => $data["NIF"],
            "address1" => $data["address_1"],
            "address2" => $data["address_2"],
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

    // public static function delete(array $data)
    // {
    //     $db2 = Environment::$db;
    //     $db2->where('id2', $data["id2"]);
    //     if ($db2->delete('account')) {
    //         echo 'successfully deleted';
    //     }

    //     return ['success' => true];
    // }

    // public static function all($parms = [])
    // {
    //     $db2 = Environment::$db;

    //     if (!empty($parms['q'])) {
    //         $db2->where('search', '%' . $parms['q'] . '%', 'LIKE');
    //     }

    //     $all = $db2->get('account', 10, 'id, id2 as _id, email');

    //     foreach ($all as $k => $a) {
    //         $all[$k]['_id'] = ['cust', 0, $a['_id']];
    //     }

    //     $res = [
    //         'data' => $all,
    //     ];

    //     return $all;
    // }

    public static function get(array $parms = [])
    {

        $db2 = Environment::$db;

        $db2->where('id2', $parms['id2']);
        $all = $db2->getOne('account');

        return $all;
    }

}
