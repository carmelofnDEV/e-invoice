<?php

namespace Intratum\Facturas;

class Product{
	
	public static function insert(array $data){
		
		//$all = Environment::$db->get('product');
        $search = $data['title'].'
' . $data['description'] . '
' . $data['price'];
	
		$data = [
			'id2' => Util::genUUID(),
			'user_id' => Util::getSessionUser()["id"],
			'title' => $data['title'] ?? '',
			'created' => Util::getDate(),
			"search"=> $search,
			'description'=> $data["description"] ?? '',
			'price'=> floatVal($data["price"]) * 100 ?? 0,
		];
		

		Environment::$db->insert('product', $data);
		
		

		return ['success' => true];
	}

	public static function update(array $data){
		$db2 = Environment::$db;

        $search = $data['title'].'
' . $data['description'] . '
' . $data['price'];

        $data["search"] = $search;
		
		$data["updated"]=date("Y-m-d H:i:s");
		$data["price"] = $data["price"]*100;
		$data["user_id"] = Util::getSessionUser()["id"];

		$db2->where('id2', $data["id2"]);
		if ($db2->update('product', $data)) {	
		} else {
		}
		

		return ["success"=>true];
	}

	public static function delete(array $data){
		$db2 = Environment::$db;
		$db2->where('id2', $data["id2"]);
		if($db2->delete('product')) echo 'successfully deleted';

		return ['success' => true];
	}


	public static function all($parms = []){
		$db2 = Environment::$db;

        if (!empty($parms['q'])) {
            $db2->where('search', '%' . $parms['q'] . '%', 'LIKE');
        }

        $all = $db2->get('product', 10, 'id, id2 as _id,title');
        foreach ($all as $k => $a) {
            $all[$k]['_id'] = ['prod', 0, $a['_id']];
        }

        $res = [
            'data' => $all,
        ];

        return $res["data"];
	}

	public static function get(array $parms = []){

		$db2 = Environment::$db;
		$db2->where('id2', $parms['id2']);
		$all = $db2->getOne('product');
		
		return $all;
	}

	public static function getItem($id){

		$db2 = Environment::$db;
		$db2->where('id', $id);
		$all = $db2->getOne('product');
		
		return $all;
	}

	

}