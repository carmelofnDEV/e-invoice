<?php

Intratum\Facturas\Util::checkSession()

?>



<?php





$db2 = Intratum\Facturas\Environment::$db;
$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id',$acc_id);
$db2->where('type', 2 );

if(!empty($_GET['q']))
    $db2->where('search', '%'.$_GET['q'].'%', 'LIKE');

$all = $db2->get('invoice');



$all = array_reverse($all)



?>



<div class=" flex items-center flex-col relative overflow-x-auto">

    <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-5xl dark:text-white">PRESUPUESTOS</h1>

    <div class="w-[80%] flex justify-around">
        <a class="w-[30%] m-5 bg-[#7500c3] px-[5%] py-[20px] rounded flex justify-center" href="nuevo/">

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

        <div class="w-[30%] flex items-center">   
            <label for="searchInput" class="sr-only">Search</label>
            <div class="relative w-full">
                <input type="text" id="searchInput" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#7500c3] focus:border-[#7500c3] block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#7500c3] dark:focus:border-[#7500c3]" placeholder="Buscar presupuestos..." required />
            </div>
            <button onclick="buscar()" class="p-2.5 ms-2 text-sm font-medium text-white bg-[#7500c3] rounded-lg border border-[#7500c3] hover:bg-[#7500c3] focus:ring-4 focus:outline-none focus:ring-[#7500c3] dark:bg-[#7500c3] dark:hover:bg-[#7500c3] dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>



    </div>

</div>





<div class="relative flex justify-center overflow-x-auto   sm:rounded-lg">

    <table class="w-[80%] shadow-2xl text-[20px] text-left rtl:text-right text-gray-500 dark:text-gray-400">

        <thead class="text-[25px] text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

            <tr>

                <th scope="col" class="px-6 py-3">

                    ID

                </th>

                <th scope="col" class="px-6 py-3">

                    NÚMERO

                </th>

                <th scope="col" class="px-6 py-3">

                    EMAIL

                </th>

                <th scope="col" class="px-6 py-3">

                    SUBTOTAL

                </th>

                <th scope="col" class="px-6 py-3">

                    TOTAL

                </th>

                <th scope="col" class="px-6 py-3">

                    FECHA

                </th>

                <th scope="col" class="px-6 py-3">

                    

                </th>



            </tr>

        </thead>

        <tbody>

            <?php foreach ($all as $i) { ?>



                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">

                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                        <?= $i["id"] ?>

                    </th>

                    <td class="px-6 py-4">

                        <?= $i["name"] ?>

                    </td>

                    <td class="px-6 py-4">

                       <?= $i["email"] ?>

                    </td>

                    <td class="px-6 py-4">

                        <?= $i["subtotal"] /100?>€

                    </td>

                    <td class="px-6 py-4">

                        <?= $i["total"] /100?>€

                    </td>

                    <td class="px-6 py-4">

                        <?= $i["invoice_date"] ?>

                    </td>

                    <td class="px-6 py-4">

                    <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class=" select-none rounded-lg bg-green-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">EDITAR</a>    

                        <?php if ($i["invoice_state"] == 0) { ?>

                            <button onclick="publicar('<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>')" class="select-none rounded-lg bg-blue-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Publicar</button> 

                        <?php }else{ ?>

                            <a href="/pdf/<?= hash("sha256",$i["id2"]."50E7RQwnF050")?>.pdf" download class="select-none rounded-lg bg-red-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">PDF</a> 

                        <?php }?> 

                    </td>

                </tr>

            



            <?php } ?>

        </tbody>

    </table>

</div>

</div>



<script>

    function buscar(){
        let busqueda = `?q=${$('#searchInput').val()}`
        window.location.href = busqueda;
    }

    function publicar(id2){

        $.ajax({

                        type: 'POST',

                        url: '/html/publicar/?id='+id2,

                        dataType: 'json',

                        contentType: 'application/json',

                        success: function(d) {

                            console.log(d)

                            if(d.content == 1){

                               window.location.href = "/presupuestos/";

                            }

                        }

                    });

    }

</script>







