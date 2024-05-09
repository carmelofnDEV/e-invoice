<?php
Intratum\Facturas\Util::checkSession();
$title = "Proveedores";
?>

<?php

$user = Intratum\Facturas\Util::getSessionUser();

$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id',$acc_id);
Intratum\Facturas\Environment::$db->where('type','p');

$all = Intratum\Facturas\Environment::$db->get('customer');


$all = array_reverse($all)

?>



<div class=" flex items-center flex-col relative overflow-x-auto">
<h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">PROVEEDORES</h1>

<a class="m-5 bg-[#638dee] px-[5%] py-[20px]  rounded" href="nuevo/">
<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="15px" height="15px" viewBox="0 0 45.402 45.402"
	 xml:space="preserve">
<g>
	<path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141
		c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27
		c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435
		c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"/>
</g>
</svg>
</a>

    <div class="flex gap-5 flex-wrap">
    <?php foreach ($all as $i) { ?>
        <div class="max-w-xs rounded overflow-hidden shadow-lg bg-gray-50 dark:bg-gray-800">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2"><?= $i["first_name"] ?> <?= $i["last_name"] ?></div>
                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $i["email"] ?></p>
                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $i["NIF"] ?></p>

                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $i["phone"] ?></p>
                <p class="text-gray-700 dark:text-gray-300 text-sm"><?= $i["city"] ?>, <?= $i["country"] ?></p>
            </div>
            <div class="px-6 py-4">
            <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $i["id2"]);?>" class=" select-none rounded-lg bg-green-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                        EDITAR</a>    
                
                <a href="del?item=<?=Intratum\Facturas\Util::getUUIDByID2('cust', $i["id2"]);?>" 
                class="select-none rounded-lg bg-red-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                        ELIMINAR</a>
            </div>
        </div>
    <?php } ?>
    
    </div>
</div>
</div>