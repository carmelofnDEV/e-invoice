<?php
Intratum\Facturas\Util::checkSession();
$title = 'Productos';

?>

<?php

$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id',$acc_id);
$all = Intratum\Facturas\Environment::$db->get('product');
$all = array_reverse($all)

?>



<div class=" flex items-center flex-col relative overflow-x-auto">

<a class="m-5 bg-[#638dee] px-[300px] py-[20px] rounded" href="nuevo/">
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
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    TÍTULO
                </th>
                <th scope="col" class="px-6 py-3">
                    DESCRIPCIÓN
                </th>
                <th scope="col" class="px-6 py-3">
                    PRECIO
                </th>
                <th scope="col" class="px-6 py-3">

                </th>
            </tr>
            <?php foreach ($all as $i) {?>
            <tr class=" ]bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <p class="text-[15px]"><?= Intratum\Facturas\Util::getUUIDByID2('prod', $i["id2"]) ?></p>

                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <p class="text-[20px]"><?=$i["title"]?></p>
                </th>
                <td class="px-6 py-4">
                <p class="text-[20px]"><?=$i["description"]?></p>

                </td>
                <td class="px-6 py-4">
                <p class="text-[20px]"><?=$i["price"] / 100?>€</p>

                    
                </td>

                <td class="flex flex-wrap gap-[5px] p-[20px]">
                <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('prod', $i["id2"]);?>" class=" select-none rounded-lg bg-green-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                        EDITAR</a>    
                
                <a href="del?item=<?=Intratum\Facturas\Util::getUUIDByID2('prod', $i["id2"]);?>" 
                class="select-none rounded-lg bg-red-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                        ELIMINAR</a>
                </td>

            </tr>
            <?php }?>

        </thead>
        <tbody>


        </tbody>
    </table>
</div>