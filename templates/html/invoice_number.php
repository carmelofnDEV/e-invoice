<?php
$data = Intratum\Facturas\Traffic::getEntryGET();
$db2 = Intratum\Facturas\Environment::$db;

$db2->where('serial_id', $data["id"]);
$results = $db2->get('invoice');

$db2->where('id', $data["id"]);
$serial = $db2->get('serial');
$serialNum = $serial[0];

echo $serialNum["serial_number"]+count($results);