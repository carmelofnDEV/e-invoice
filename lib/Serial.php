<?php

namespace Intratum\Facturas;

class Serial{
	
	public static function insert(array $data){
		
		//$all = Environment::$db->get('serial');

	
		$data = [
			'id2' => Util::genUUID(),
			'account_id' => User::getUserAccount(Util::getSessionUser()["id"])["id"],
			'user_id' => Util::getSessionUser()["id"],
			'serial_tag' => $data['serial_tag'] ,
			'serial_number' => $data['serial_number'] ,

			'created' => Util::getDate(),
			'updated' => Util::getDate(),

		];
		

		Environment::$db->insert('serial', $data);
		
		

		return ['success' => true];
	}

	public static function update(array $data){
		$db2 = Environment::$db;

		$data["updated"]=date("Y-m-d H:i:s");

		$db2->where('id2', $data["id2"]);
		$db2->update('serial', $data);
		
		
		return ["success"=>true];
	}

	public static function delete(array $data){
		$db2 = Environment::$db;
		$db2->where('id2', $data["id2"]);
		if($db2->delete('serial')) echo 'successfully deleted';

		return ['success' => true];
	}


	public static function all(){
		$db2 = Environment::$db;
		
		$user = Util::getSessionUser();
		$acc = User::getUserAccount($user["id"]);
		$db2->where('account_id', $acc["id"]);
        $all = $db2->get('serial');


        $res = [
            'data' => $all,
        ];

        return $res["data"];
	}

	public static function get(array $parms = []){

		$db2 = Environment::$db;

		if (!empty($parms['id2'])) {

			$db2->where('id2', $parms['id2']);
			
		}

		$all = $db2->getOne('serial');


		return $all;
	}


}