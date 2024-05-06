<?php

class Invoice{
	
	public static $Table  = [
		'column' => [
			'type' => [
				'type' => 'enum',
				'enum_list' => ['invoice', 'expense', 'corrective']
			]
			]
	];
	
};

