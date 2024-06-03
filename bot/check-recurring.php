<?php

if(!empty($_GET['token'])){
    echo Intratum\Facturas\Factura::checkRecurring($_GET['token']);
}else{
    echo "Token invalido";
}
    
