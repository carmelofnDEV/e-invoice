<?php
$data = Intratum\Facturas\Traffic::getEntryGET();
$id2 = Intratum\Facturas\Util::getID2ByUUID("inv_",$data["id"]);
echo Intratum\Facturas\Factura::publicarFactura($id2);

