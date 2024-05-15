<?php
Intratum\Facturas\Util::checkSession();
$title = 'Gastos';

?>

<?php


$db2 = Intratum\Facturas\Environment::$db;
$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id',$acc_id);
$db2->where('type', 0 );

if(!empty($_GET['q']))
    $db2->where('search', '%'.$_GET['q'].'%', 'LIKE');

$all = $db2->get('invoice');

?>


<div class="py-5 px-10">


    <div class="w-full flex justify-end items-end mb-5">   
        <div class="flex ">
            <label for="searchInput" class="sr-only">Search</label>
            <div class="relative w-full">
                    <input type="text" id="searchInput" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar facturas..." required />
            </div>
            <button onclick="buscar()" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>
    </div>


    <div class="w-full ">
        <div class="mb-3 grid grid-cols-5 bg-[#ffffff] border-[1px] p-2 font-[700]">
            <h2>Nombre</h2>
            <h2>Número</h2>
            <h2>Fechas</h2>
            <h2>Estado</h2>
            <h2>Importe</h2>
            <h2></h2>

        </div>

        <?php

            foreach ($all as $i) {

                $is_paid = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($i["id"],$params = ["OPTION" => "PAYMENT_DATE",])
        ?>
            <div data-url="/facturas/ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="db_div bg-[#ffffff] border-[1px] mb-1 grid grid-cols-5 items-center p-2 rounded-xl">

                <h2 ><?= $i["first_name"]?></h2>
                <h2><?= $i["name"]?></h2>
                <h2><?= $i["invoice_date"]?></h2>
                <div>
                  
                    <?php if ($is_paid) {?>

                        <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="rounded-xl flex items-center bg-[#effbf7] text-[#1dd2a2] opacity-80 p-2" type="button">
                            <p class="">Pagado</p>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>


                    <?php }else{ ?>

                        <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="rounded-xl flex items-center bg-[#fff7ec] text-[#ffb145] opacity-80 p-2" type="button">
                            <p class="">Pendiente</p>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>

                    <?php } ?>


                    <div id="dropdown<?=$i["id2"]?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-1 text-md text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton<?=$i["id2"]?>">

                            <li class="border-l-4 border-[#1dd2a2]">
                                <button onclick="setPaid('<?=$i['id2']?>')" class="p-3 w-full hover:bg-[#effbf7]">Pagada</button>
                            </li>

                            <li class="border-l-4 border-[#ffb145]">
                                <button onclick="setUnPaid('<?=$i['id2']?>')" class="p-3 w-full hover:bg-[#fff7ec]">Pendiente</button>
                            </li>

                        </ul>
                    </div>


                </div>

                <div class="items-center grid grid-cols-2 gap-[50%]">

                    <h2><?= $i["total"]/100?>€</h2>

                    <div class="flex items-center">

                        <button data-popover-target="popover-<?=$i['id2']?>" data-popover-placement="bottom" type="button" class="bg-blak">
                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M960 1468.235c93.448 0 169.412 75.965 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.447 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.447-75.964 169.412-169.412 169.412-93.448 0-169.412-75.965-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Z" fill-rule="evenodd"></path> </g></svg>
                        </button>
                        <div data-popover id="popover-<?=$i['id2']?>" role="tooltip" class="absolute z-10 invisible inline-block  text- text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div class="">
                                <ul class="p-2 flex flex-col justify-center items-center">

                                    <li class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] rounded-md text-[#000000]">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#000000"></path> </g></svg>
                                        <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="">Editar</a>    
                                    </li>

                                    <li class="w-full ">
 
                                        <?php if ($i["invoice_state"] == 0) { ?>

                                            <button onclick="publicar('<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>')" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 2.5 2 C 2.0900381 2 1.6984009 2.1441855 1.421875 2.4199219 C 1.1453491 2.6956582 1 3.0876653 1 3.5 L 1 4.5 A 0.50005 0.50005 0 0 0 1.5 5 L 3 5 L 3 12.375 C 3 13.199669 3.6105159 14 4.5 14 L 7.7617188 14 C 8.5704696 15.204592 9.94479 16 11.5 16 C 13.979359 16 16 13.979359 16 11.5 C 16 9.5487862 14.741637 7.8970971 13 7.2753906 L 13 3.5 C 13 3.0876653 12.854651 2.6956582 12.578125 2.4199219 C 12.317203 2.1597448 11.952946 2.0211755 11.568359 2.0058594 A 0.50005 0.50005 0 0 0 11.5 2 L 2.5 2 z M 2.5 3 L 10.232422 3 C 10.144686 3.2093287 10 3.3950674 10 3.625 L 10 4 L 2 4 L 2 3.5 C 2 3.3093347 2.0551821 3.2024201 2.1289062 3.1289062 C 2.2026306 3.0553926 2.3109619 3 2.5 3 z M 11.5 3 C 11.689038 3 11.79737 3.0553932 11.871094 3.1289062 C 11.944818 3.2024201 12 3.3093347 12 3.5 L 12 7.0507812 C 11.833538 7.0319923 11.67136 7 11.5 7 C 10.439612 7 9.4752104 7.381117 8.7089844 8 L 5 8 L 5 9 L 7.7929688 9 C 7.5842039 9.3106797 7.4033096 9.6416499 7.2753906 10 L 5 10 L 5 11 L 7.0507812 11 C 7.0319923 11.166462 7 11.32864 7 11.5 C 7 12.028145 7.1071101 12.528582 7.2753906 13 L 4.5 13 C 4.1914841 13 4 12.756331 4 12.375 L 4 5 L 10.5 5 A 0.50005 0.50005 0 0 0 11 4.5 L 11 3.625 C 11 3.2436694 11.191484 3 11.5 3 z M 5 6 L 5 7 L 10 7 L 10 6 L 5 6 z M 11.5 8 C 13.438919 8 15 9.5610811 15 11.5 C 15 13.438919 13.438919 15 11.5 15 C 9.5610811 15 8 13.438919 8 11.5 C 8 9.5610811 9.5610811 8 11.5 8 z M 11 9 L 11 11 L 9 11 L 9 12 L 11 12 L 11 14 L 12 14 L 12 12 L 14 12 L 14 11 L 12 11 L 12 9 L 11 9 z"/></svg>
                                                <p class="text-[#000000]">Generar PDF</p>
                                            </button> 

                                        <?php }else{ ?>

                                            <a href="/pdf/<?= hash("sha256",$i["id2"]."50E7RQwnF050")?>.pdf" download class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Interface / Download"> <path id="Vector" d="M6 21H18M12 3V17M12 17L17 12M12 17L7 12" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
                                                <p>Descargar PDF</p>
                                            </a> 

                                        <?php }?> 

                                        <a href="del?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#FE0000] rounded-md">
                                            <svg width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#FE0000" stroke="#FE0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#FE0000" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"></path></g></svg>
                                            <p>Eliminar</p>
                                        </a> 

                                    </li>

                                </ul>
                            </div>
                            <div class="place-self-end" data-popper-arrow></div>
                        </div>  

                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>


</div>


<script>

    $(document).ready(function(){
    $('.db_div').on('dblclick', function() {
        var id = $(this).data('id');
        var url = $(this).data('url');
        window.location.href = url;
    });
    });

    function setPaid(id2){

        $.ajax({

            type: 'POST',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(id2),

            success: function(d) {

                if (d["success"] == true) {
                    window.location.href = '/facturas/';
                }

            }

        });

    }

    function setUnPaid(id2){

        $.ajax({

            type: 'DELETE',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(id2),

            success: function(d) {

                if (d["success"] == true) {
                    window.location.href = '/facturas/';
                }

            }

        });

    }

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
                   window.location.href = "/facturas/";
                }
            }
        });
    }

</script>