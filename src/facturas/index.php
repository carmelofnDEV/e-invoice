<?php

Intratum\Facturas\Util::checkSession();

$title = 'Facturas';




$db2 = Intratum\Facturas\Environment::$db;

$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id', $acc_id);
$db2->where('type', 1);

if (!empty($_GET['q'])) {
    $db2->where('search', '%' . $_GET['q'] . '%', 'LIKE');
}

if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {

    $start_date = DateTime::createFromFormat('Ymd', $_GET['start_date'])->format('Y/m/d');
    $end_date = DateTime::createFromFormat('Ymd', $_GET['end_date'])->format('Y/m/d');
    $db2->where('invoice_date', [$start_date, $end_date], 'BETWEEN');
}



$inv_settings = [];

$all = $db2->get('invoice');


if (!empty($_GET['is_recurring']) ) {

   $recurringInvoices = [];

    foreach ($all as $inv) {
        
        $recurring = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($inv["id"], $params = ["OPTION" => "REC"]);

        if ($recurring) {

            $recurringInvoices[] = $inv;
            
        }
    }

    $all = $recurringInvoices;
}

$pagado = 0;
$pendiente = 0;


foreach ($all as $inv) {
    
    $is_paid = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($inv["id"], $params = ["OPTION" => "PAYMENT_DATE"]);

    if ($is_paid) {

        $pagado += $inv["total"];

    }else{

        $pendiente += $inv["total"];

    }
}


$all = array_reverse($all);



?>

<div class="py-5 px-10">
	
	<?php if(!empty($_GET['success'])){ ?>
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
  <span class="font-medium">Cambios guardados correctamente.</span>
</div>
<?php } ?>

    <div class="w-full flex justify-end items-end mb-5 gap-2">



        <div date-rangepicker class="flex items-center">



            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input  id="start_date" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de inicio">
            </div>

            <span class="mx-4 text-gray-500 font-[700]">-</span>

            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input onchange="" id="end_date" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de fin">
            </div>


        </div>

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

    <div class="flex py-4 px-6 w-full justify-between rounded-xl border-[1px] bg-white">

        <div class="flex gap-10">
            <div class="flex gap-3 justify-center items-center">

                <div class="bg-[#61DFB2] bg-opacity-50 p-3 rounded-lg">
                    <svg  width="23px" height="23px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 230.453 230.453" style="enable-background:new 0 0 230.453 230.453;" xml:space="preserve"> <polygon points="177.169,43.534 177.169,58.534 204.845,58.534 135.896,127.479 92.36,83.947 0,176.312 10.606,186.918 92.361,105.16 135.896,148.691 215.453,69.14 215.453,96.784 230.453,96.784 230.453,43.534 "/> </svg>
                </div>

                <div>
                    <p class="text-[20px] font-[700]"><?=$pagado/100?>€</p>
                    <p class="text-[16px] text-gray-400 font-[500]">Facturadas</p>

                </div>

            </div>

            <div class="flex gap-3 justify-center items-center">

                <div class="bg-[#ffc17a] bg-opacity-50 p-3 rounded-lg">
                    <svg fill="#000000" width="23px" height="23px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"><path d="M15.09814,12.63379,13,11.42285V7a1,1,0,0,0-2,0v5a.99985.99985,0,0,0,.5.86621l2.59814,1.5a1.00016,1.00016,0,1,0,1-1.73242ZM12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Z"/></svg>
                </div>

                <div>
                    <p class="text-[20px] font-[700]"><?=$pendiente/100?>€</p>
                    <p class="text-[16px] text-gray-400 font-[500]">Pendientes</p>

                </div>

            </div>

        </div>

        <a href="/documento/nuevo?doc=factura" class="flex gap-2 items-center py-2 px-8 rounded-full bg-black text-white font-[600] hover:bg-[#707070] transition-colors duration-400"> 

            <svg fill="#fff" width="18px" height="18px" viewBox="0 0 35 35" data-name="Layer 2" id="ab635b81-4e6c-4835-8954-fd99216bc317" xmlns="http://www.w3.org/2000/svg"><path d="M33.5,18.75H1.5a1.25,1.25,0,0,1,0-2.5h32a1.25,1.25,0,0,1,0,2.5Z"/><path d="M17.5,34.75a1.25,1.25,0,0,1-1.25-1.25V1.5a1.25,1.25,0,0,1,2.5,0v32A1.25,1.25,0,0,1,17.5,34.75Z"/></svg>
            <span>Crear factura</span>

        </a>

    </div>




    <div class="w-full ">

        <div class="w-full flex mb-2 ">

            <a href="/facturas/" class="py-2 px-4 text-black text-[20px] font-[600] border-b-[3px] <?php if (empty($_GET['is_recurring']) ) { echo "border-black "; }?>"> Todas </a>
            
            <a class="py-2 px-4 text-black text-[20px] font-[600] border-b-[3px] <?php if (!empty($_GET['is_recurring']) ) { echo "border-black "; }?>" href=" <?php if (empty($_GET['is_recurring'])){ if (!empty(!empty($_GET['q']) || !empty($_GET['start_date'])) || !empty($_GET['end_date']) || !empty($_GET['success'])) { echo $_SERVER['REQUEST_URI']."&is_recurring=true"; }else{echo $_SERVER['REQUEST_URI']."?is_recurring=true"; }?>"   class="py-2 px-4 text-black border-b-[3px] text-[20px] font-[600] <?php if (!empty($_GET['is_recurring']) ) { echo " border-black "; }}?>" >Recurrentes</a>
            
        </div>





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

    

    $db2 = Intratum\Facturas\Environment::$db;

    $db2->where('invoice_id', $i["id"]);
    $inv_settings = $db2->get('invoice_setting');

    $settings_2 = array_values(array_filter($inv_settings, function ($item) {
        return $item['setting'] == 2;
    }));

    $settings_3 = array_values(array_filter($inv_settings, function ($item) {
        return $item['setting'] == 3;
    }));

    $settings_4 = array_values(array_filter($inv_settings, function ($item) {
        return $item['setting'] == 4;
    }));

    $is_paid = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($i["id"], $params = ["OPTION" => "PAYMENT_DATE"]);

    $is_recurring = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($i["id"], $params = ["OPTION" => "IS_RECURRING"]);

    ?>

            <div data-url="/documento/ed?doc=factura&item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="db_div cursor-pointer hover:bg-[#eee] bg-[#ffffff] border-[1px] mb-1 grid grid-cols-5 items-center p-2 rounded-xl">

                <h2 ><?=$i["first_name"]?></h2>
                <h2><?=$i["name"]?></h2>
                <h2><?=$i["invoice_date"]?></h2>

                <div>

                    <?php if ($is_paid) {?>

                        <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="w-[115px] justify-between pr-2  dropdownDefaul rounded-xl flex items-center bg-[#effbf7] text-[#1dd2a2] opacity-80 p-2" type="button">
                            <p class="">Pagado</p>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>

                    <?php } else {?>

                        <button id="dropdownDefaul<?=$i["id2"]?>" data-dropdown-toggle="dropdown<?=$i["id2"]?>" class="w-[115px] justify-between pr-2 dropdownDefaul rounded-xl flex items-center bg-[#fff7ec] text-[#ffb145] opacity-80 p-2" type="button">
                            <p class="">Pendiente</p>
                            <svg class="w-2.5 h-2.5 ms-3 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                        </button>

                    <?php }?>


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

                    <h2><?=$i["total"] / 100?>€</h2>

                    <div class="flex items-center gap-5   ">

                        <button data-popover-target="popover-<?=$i['id2']?>" data-popover-placement="bottom" type="button" class="popover-menu">
                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M960 1468.235c93.448 0 169.412 75.965 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.447 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.447-75.964 169.412-169.412 169.412-93.448 0-169.412-75.965-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Z" fill-rule="evenodd"></path> </g></svg>
                        </button>
                        <?php if ($is_recurring) {?>
                            <svg data-popover-target="popover-info-<?=$i["id2"]?>" data-popover-placement="left" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7 1C6.44772 1 6 1.44772 6 2V3H5C3.34315 3 2 4.34315 2 6V20C2 21.6569 3.34315 23 5 23H13.101C12.5151 22.4259 12.0297 21.7496 11.6736 21H5C4.44772 21 4 20.5523 4 20V11H20V11.2899C20.7224 11.5049 21.396 11.8334 22 12.2547V6C22 4.34315 20.6569 3 19 3H18V2C18 1.44772 17.5523 1 17 1C16.4477 1 16 1.44772 16 2V3H8V2C8 1.44772 7.55228 1 7 1ZM16 6V5H8V6C8 6.55228 7.55228 7 7 7C6.44772 7 6 6.55228 6 6V5H5C4.44772 5 4 5.44772 4 6V9H20V6C20 5.44772 19.5523 5 19 5H18V6C18 6.55228 17.5523 7 17 7C16.4477 7 16 6.55228 16 6Z" fill="#0F0F0F"></path> <path d="M17 16C17 15.4477 17.4477 15 18 15C18.5523 15 19 15.4477 19 16V17.703L19.8801 18.583C20.2706 18.9736 20.2706 19.6067 19.8801 19.9973C19.4896 20.3878 18.8564 20.3878 18.4659 19.9973L17.2929 18.8243C17.0828 18.6142 16.9857 18.3338 17.0017 18.0588C17.0006 18.0393 17 18.0197 17 18V16Z" fill="#0F0F0F"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M24 18C24 21.3137 21.3137 24 18 24C14.6863 24 12 21.3137 12 18C12 14.6863 14.6863 12 18 12C21.3137 12 24 14.6863 24 18ZM13.9819 18C13.9819 20.2191 15.7809 22.0181 18 22.0181C20.2191 22.0181 22.0181 20.2191 22.0181 18C22.0181 15.7809 20.2191 13.9819 18 13.9819C15.7809 13.9819 13.9819 15.7809 13.9819 18Z" fill="#0F0F0F"></path> </g></svg>
                            <div data-popover id="popover-info-<?=$i["id2"]?>"  role="tooltip" class="popover-menu absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <p class=" py-2 px-4 text-black font-[600]">Esta factura ha sido generada</p>
                                <div data-popper-arrow></div>
                            </div>
                        <?php }?>

                        <div data-popover id="popover-<?=$i['id2']?>" role="tooltip" class=" absolute z-10 invisible inline-block  text- text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div class="popover-link">
                                <ul class="p-2 flex flex-col justify-center items-center">

                                    <li class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] rounded-md text-[#000000]">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#000000"></path> </g></svg>
                                        <a href="/documento/ed?doc=factura&item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="">Editar</a>
                                    </li>

                                    <li class="w-full ">

                                        <?php if ($i["invoice_state"] == 0) {?>

                                            <button onclick="publicar('<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>')" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg width="20px" height="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 2.5 2 C 2.0900381 2 1.6984009 2.1441855 1.421875 2.4199219 C 1.1453491 2.6956582 1 3.0876653 1 3.5 L 1 4.5 A 0.50005 0.50005 0 0 0 1.5 5 L 3 5 L 3 12.375 C 3 13.199669 3.6105159 14 4.5 14 L 7.7617188 14 C 8.5704696 15.204592 9.94479 16 11.5 16 C 13.979359 16 16 13.979359 16 11.5 C 16 9.5487862 14.741637 7.8970971 13 7.2753906 L 13 3.5 C 13 3.0876653 12.854651 2.6956582 12.578125 2.4199219 C 12.317203 2.1597448 11.952946 2.0211755 11.568359 2.0058594 A 0.50005 0.50005 0 0 0 11.5 2 L 2.5 2 z M 2.5 3 L 10.232422 3 C 10.144686 3.2093287 10 3.3950674 10 3.625 L 10 4 L 2 4 L 2 3.5 C 2 3.3093347 2.0551821 3.2024201 2.1289062 3.1289062 C 2.2026306 3.0553926 2.3109619 3 2.5 3 z M 11.5 3 C 11.689038 3 11.79737 3.0553932 11.871094 3.1289062 C 11.944818 3.2024201 12 3.3093347 12 3.5 L 12 7.0507812 C 11.833538 7.0319923 11.67136 7 11.5 7 C 10.439612 7 9.4752104 7.381117 8.7089844 8 L 5 8 L 5 9 L 7.7929688 9 C 7.5842039 9.3106797 7.4033096 9.6416499 7.2753906 10 L 5 10 L 5 11 L 7.0507812 11 C 7.0319923 11.166462 7 11.32864 7 11.5 C 7 12.028145 7.1071101 12.528582 7.2753906 13 L 4.5 13 C 4.1914841 13 4 12.756331 4 12.375 L 4 5 L 10.5 5 A 0.50005 0.50005 0 0 0 11 4.5 L 11 3.625 C 11 3.2436694 11.191484 3 11.5 3 z M 5 6 L 5 7 L 10 7 L 10 6 L 5 6 z M 11.5 8 C 13.438919 8 15 9.5610811 15 11.5 C 15 13.438919 13.438919 15 11.5 15 C 9.5610811 15 8 13.438919 8 11.5 C 8 9.5610811 9.5610811 8 11.5 8 z M 11 9 L 11 11 L 9 11 L 9 12 L 11 12 L 11 14 L 12 14 L 12 12 L 14 12 L 14 11 L 12 11 L 12 9 L 11 9 z"/></svg>
                                                <p class="text-[#000000]">Generar factura</p>
                                            </button>

                                        <?php } else {?>

                                            <a href="/pdf/<?=hash("sha256", $i["id2"] . "50E7RQwnF050")?>.pdf" download="Factura - <?= $i["name"]?>.pdf" class="popover-link w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg  width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>file_pdf [#000000]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-340.000000, -1279.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M303.7144,1125.149 L298.2594,1119.364 C298.0704,1119.165 297.8034,1119.001 297.5294,1119.001 L285.9794,1119.001 C284.8744,1119.001 284.0004,1120.001 284.0004,1121.105 L284.0004,1128.105 C284.0004,1128.657 284.4374,1129.001 284.9894,1129.001 L284.9944,1129.001 C285.5474,1129.001 286.0004,1128.657 286.0004,1128.105 L286.0004,1122.105 C286.0004,1121.553 286.4274,1121.001 286.9794,1121.001 L296.0004,1121.001 L296.0004,1125.105 C296.0004,1126.21 296.8744,1127.001 297.9794,1127.001 L302.0004,1127.001 L302.0004,1128.105 C302.0004,1128.657 302.4374,1129.001 302.9894,1129.001 L302.9944,1129.001 C303.5474,1129.001 304.0004,1128.657 304.0004,1128.105 L304.0004,1125.838 C304.0004,1125.581 303.8914,1125.335 303.7144,1125.149 L303.7144,1125.149 Z M287.9794,1134.105 C287.9794,1133.553 287.5314,1133.105 286.9794,1133.105 L285.9794,1133.105 L285.9794,1135.105 L286.9794,1135.105 C287.5314,1135.105 287.9794,1134.657 287.9794,1134.105 L287.9794,1134.105 Z M289.9754,1133.839 C290.0654,1135.569 288.6894,1137.001 286.9794,1137.001 L286.0004,1137.001 L286.0004,1138.105 C286.0004,1138.657 285.5474,1139.001 284.9944,1139.001 L284.9894,1139.001 C284.4374,1139.001 284.0004,1138.657 284.0004,1138.105 L284.0004,1132.105 C284.0004,1131.553 284.4274,1131.001 284.9794,1131.001 L286.8094,1131.001 C288.4344,1131.001 289.8904,1132.217 289.9754,1133.839 L289.9754,1133.839 Z M295.0004,1134.105 C295.0004,1133.553 294.5314,1133.001 293.9794,1133.001 L293.0004,1133.001 L293.0004,1137.001 L293.9794,1137.001 C294.5314,1137.001 295.0004,1136.657 295.0004,1136.105 L295.0004,1134.105 Z M297.0004,1134.001 L297.0004,1136.001 C297.0004,1137.651 295.6504,1139.001 294.0004,1139.001 L291.8954,1139.001 C291.4004,1139.001 291.0004,1138.6 291.0004,1138.105 L291.0004,1131.98 C291.0004,1131.439 291.4384,1131.001 291.9794,1131.001 L294.0004,1131.001 C295.6504,1131.001 297.0004,1132.351 297.0004,1134.001 L297.0004,1134.001 Z M304.0004,1132.027 L304.0004,1132.053 C304.0004,1132.605 303.5314,1133.001 302.9794,1133.001 L300.0004,1133.001 L300.0004,1135.001 L302.9794,1135.001 C303.5314,1135.001 304.0004,1135.474 304.0004,1136.027 L304.0004,1136.053 C304.0004,1136.605 303.5314,1137.001 302.9794,1137.001 L300.0004,1137.001 L300.0004,1138.105 C300.0004,1138.657 299.5474,1139.001 298.9944,1139.001 L298.9894,1139.001 C298.4374,1139.001 298.0004,1138.657 298.0004,1138.105 L298.0004,1132.105 C298.0004,1131.553 298.4274,1131.001 298.9794,1131.001 L302.9794,1131.001 C303.5314,1131.001 304.0004,1131.474 304.0004,1132.027 L304.0004,1132.027 Z" id="file_pdf-[#000000]"> </path> </g> </g> </g> </g></svg>
                                                <p>Descargar PDF</p>
                                            </a>


                                            <a href="/einvoices/<?=hash("sha256", $i["id2"] . "50E7RQwnF050")?>.xsig" download="Factura - <?= $i["name"]?>.xsig" class="popover-link popover-link w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.44 7.47h5.26v1.25H5.44zm0 2.36h5.26v1.25H5.44zm0-4.76h5.26v1.25H5.44z"></path><path d="M11.34 1 9.64.28 8.08 1 6.41.28 4.84 1 2.46 0v16l2.38-1 1.57.69L8.08 15l1.56.69 1.7-.69 2.2 1V0zm.94 13.11-.92-.41-1.69.69-1.57-.72-1.68.69-1.55-.69-1.15.47V1.86l1.15.47 1.55-.69 1.68.69 1.57-.69 1.69.69.92-.41z"></path></g></svg>
                                                <p>Descargar factura electrónica</p>
                                            </a>


                                            <button data-modal-target="mail-modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" data-modal-toggle="mail-modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.5003 12H5.41872M5.24634 12.7972L4.24158 15.7986C3.69128 17.4424 3.41613 18.2643 3.61359 18.7704C3.78506 19.21 4.15335 19.5432 4.6078 19.6701C5.13111 19.8161 5.92151 19.4604 7.50231 18.7491L17.6367 14.1886C19.1797 13.4942 19.9512 13.1471 20.1896 12.6648C20.3968 12.2458 20.3968 11.7541 20.1896 11.3351C19.9512 10.8529 19.1797 10.5057 17.6367 9.81135L7.48483 5.24303C5.90879 4.53382 5.12078 4.17921 4.59799 4.32468C4.14397 4.45101 3.77572 4.78336 3.60365 5.22209C3.40551 5.72728 3.67772 6.54741 4.22215 8.18767L5.24829 11.2793C5.34179 11.561 5.38855 11.7019 5.407 11.8459C5.42338 11.9738 5.42321 12.1032 5.40651 12.231C5.38768 12.375 5.34057 12.5157 5.24634 12.7972Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                <p>Enviar factura</p>
                                            </button >



                                        <?php }?>



                                        <?php if (!$is_recurring) {?>

                                            <!-- Modal toggle -->
                                            <button data-modal-target="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" data-modal-toggle="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#000000] rounded-md" type="button">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 20H6C3.79086 20 2 18.2091 2 16V7C2 4.79086 3.79086 3 6 3H17C19.2091 3 21 4.79086 21 7V10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 2V4" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 2V4" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M2 8H21" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.5 15.6429L17 17.1429" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="17" cy="17" r="5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle> </g></svg>
                                                <p>Programar recurrencia</p>
                                            </button>
                                        <?php }?>




                                        <a href="/documento/del?item=<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i["id2"]);?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#FE0000] rounded-md">
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

<!-- Main modal -->
<div id="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">


        <div class="relative bg-white rounded-lg shadow-2xl dark:bg-gray-700 ">



        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h1 class="text-[20px] font-[600]">Programar recurrencia de <?=$i['name']?></h1>

                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
        </div>

            <form id="form_<?=$i['id2']?>" class="recurring flex flex-col justify-center items-center p-10">
                    <div class="p-5">
                        <div class="flex mb-5 gap-5">
                            <div class="w-full flex items-center mb-4">
                                <input <?php if (empty($settings_2)) {?>checked <?php }?> required  id="default-radio-0" type="radio" value="disabled" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-0" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Desactivado</label>
                            </div>

                            <div class="w-full flex items-center mb-4">
                                <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "1") {?> checked <?php }?> id="default-radio-1" type="radio" value="weekly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Semanalmente</label>
                            </div>

                            <div class="w-full flex items-center mb-4">
                                <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "2") {?> checked <?php }?> id="default-radio-2" type="radio" value="monthly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mensualmente</label>
                            </div>
                            <div class="w-full flex items-center mb-4">
                                <input <?php if (!empty($settings_2) && $settings_2[0]["value"] == "3") {?> checked <?php }?> id="default-radio-3" type="radio" value="yearly" name="OPTION[REC]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Anualmente</label>
                            </div>
                        </div>

                        <input type="hidden" name="id2" value="<?=$i['id2']?>">

                        <div>
                            <div date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                   <input <?php if (!empty($settings_4) && $settings_4[0]["value"] != "") {?> value="<?php echo date("m-d-Y", strtotime($settings_4[0]["value"])) ?>" <?php }?>   id="" name="OPTION[REC_START_DATE]" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de inicio">

                                </div>

                                <span class="mx-4 text-gray-500 font-[700]">-</span>

                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input <?php if (!empty($settings_3) && $settings_3[0]["value"] != "") {?> value="<?php echo date("m-d-Y", strtotime($settings_3[0]["value"])) ?>"  <?php } else {?> value="ss" <?php }?>    onchange="" id="" name="OPTION[REC_END_DATE]" type="text" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fecha de fin">
                                </div>
                            </div>
                        </div>


                        <div class="w-full flex justify-end items-end mt-10 ">
                            <button  class="bg-[#ECB176] text-[15px] px-3 py-1 rounded text-white" type="submit">Guardar</button>
                        </div>

                    </div>
                </form>
        </div>
    </div>
</div>



<!-- Modal mail  -->
<div id="mail-modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-2xl dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h1 class="text-[20px] font-[600]">Enviar por mail - <?=$i['name']?></h1>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="mail-modal-<?=Intratum\Facturas\Util::getUUIDByID2('inv', $i['id2'])?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form id="form_mail_<?=$i['id2']?>" class="inv_mail flex flex-col justify-center items-center p-10">
                <div class="w-full mb-5">
                    <label for="destinatario" class="block text-gray-700 text-sm font-bold mb-2">Destinatario</label>
                    <input type="email" value="<?=$i['email']?>" placeholder="destinatario@mail.com" id="destinatario" name="destinatario" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ECB176]" required>
                </div>

                <div class="w-full mb-5">
                    <label for="mensaje" class="block text-gray-700 text-sm font-bold mb-2">Cuerpo del mensaje</label>
                    <textarea id="mensaje"  name="mensaje" class=" border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ECB176]" rows="14" required>
Estimado/a <?=$i["first_name"]?>,

Espero que este mensaje le encuentre bien.

Adjunto encontrará la factura correspondiente a su reciente compra. A continuación, se detallan los datos de la misma:

    - Número de Factura: <?=$i["name"]?>

    - Fecha de Emisión: <?=$i["invoice_date"]?>


Por favor, revise la factura y no dude en ponerse en contacto con nosotros si tiene alguna pregunta o necesita más información.

Agradecemos su confianza y preferencia.</textarea>
                </div>

                <div class="w-full ">
                    <label class="flex items-center text-gray-700">
                        <input type="radio" id="factura_electronica" name="attach" value="electronica" class="mr-2 h-4 w-4 text-[#ECB176] border-gray-300 rounded focus:ring-[#ECB176]" required>
                        Mandar factura electrónica
                    </label>
                    <label class="flex items-center text-gray-700 mt-2">
                        <input type="radio" id="factura_pdf" name="attach" value="pdf" class="mr-2 h-4 w-4 text-[#ECB176] border-gray-300 rounded focus:ring-[#ECB176]" required>
                        Mandar factura en PDF
                    </label>
                    <label class="flex items-center text-gray-700 mt-2">
                        <input type="radio" id="factura_ambos" name="attach" value="ambos" class="mr-2 h-4 w-4 text-[#ECB176] border-gray-300 rounded focus:ring-[#ECB176]" required>
                        Mandar ambos
                    </label>
                </div>

                <input type="hidden" name="id" value="<?=$i["id2"]?>">

                <div class="w-full flex justify-end items-end mt-10">
                    <button class="bg-[#ECB176] text-[15px] px-3 py-1 rounded text-white" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <?php
}?>
    </div>
</div>


</div>

<script>
$('.dropdownDefaul, .popover-menu').click(function(e){
	e.preventDefault();
	
	return false;
	
});

    $(document).ready(function() {
        $('[id^="modal-"]').each(function() {
            var modal = $(this);
            var radioDesactivado = modal.find('input[type="radio"][value="disabled"]');
            var fechaInicio = modal.find('#start_date');
            var fechaFin = modal.find('#end_date');

            function actualizarEstadoFecha() {
                var isDesactivado = radioDesactivado.is(':checked');
                fechaInicio.prop('disabled', isDesactivado).val(isDesactivado ? '' : fechaInicio.val());
                fechaFin.prop('disabled', isDesactivado).val(isDesactivado ? '' : fechaFin.val());

                if (isDesactivado) {
                    fechaInicio.addClass('pointer-events-none bg-gray-300');
                    fechaFin.addClass('pointer-events-none bg-gray-300');
                } else {
                    fechaInicio.removeClass('pointer-events-none bg-gray-300');
                    fechaFin.removeClass('pointer-events-none bg-gray-300');
                }
            }

            radioDesactivado.on('change', function() {
                actualizarEstadoFecha();
            });

            actualizarEstadoFecha();

            modal.find('input[type="radio"]').not(radioDesactivado).on('change', function() {
                if (!radioDesactivado.is(':checked')) {
                    fechaInicio.prop('disabled', false);
                    fechaFin.prop('disabled', false);
                    fechaInicio.removeClass('pointer-events-none bg-gray-300');
                    fechaFin.removeClass('pointer-events-none bg-gray-300');
                }
            });
        });
    });


    $(document).ready(function(){
        $('.db_div, .popover-link').on('click', function() {

            console.log($(this))

            if ($(this).hasClass("popover-link")) {
                event.stopPropagation();
                
            }else{

                var id = $(this).data('id');
                var url = $(this).data('url');
                window.location.href = url;

            }



        });


        $('.recurring').submit(function(e){
            e.preventDefault();

            var data = $(this).serializeJSON();

            options=[]


            Object.entries(data.OPTION).forEach(function([clave, valor]) {
                options.push({
                    "OPTION":clave,
                    "VALUE":valor
                });
            });

            newData = {
                "id2":data.id2,
                "OPTIONS":options
            }

            console.log(newData)


            $.ajax({

                type: 'POST',

                url: '/ajax/invoice_setting',

                dataType: 'json',

                contentType: 'application/json',

                data: JSON.stringify(newData),

                success: function(d) {

                    if (d["success"] == true) {
                        window.location.href = '/facturas/?success=true';
                    }

                }

            });

        });

        $('.inv_mail').submit(function(e){
            e.preventDefault();


            var data = $(this).serializeJSON();



            $.ajax({

                type: 'POST',

                url: '/ajax/inv_mail',

                dataType: 'json',

                contentType: 'application/json',

                data: JSON.stringify(data),

                success: function(d) {

                    if (d == true) {
                        window.location.href = '/facturas/?success=true';
                    }

                }

            });

        });
    });

    function setPaid(id2){
        var timestamp = new Date().getTime();
        data = {
            "id2":id2,
            "OPTIONS":[{
                "OPTION":"PAYMENT_DATE",
                "VALUE":timestamp,
            }]
        }

        $.ajax({

            type: 'POST',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(data),

            success: function(d) {

                if (d["success"] == true) {
                    window.location.href = '/facturas/';
                }

            }

        });

    }

    function setUnPaid(id2){


        data = {
            "id2":id2,
            "OPTIONS":[{
                "OPTION":"PAYMENT_DATE",

            }]
        }

        $.ajax({

            type: 'DELETE',

            url: '/ajax/invoice_setting',

            dataType: 'json',

            contentType: 'application/json',

            data: JSON.stringify(data),

            success: function(d) {

                if (d["success"] == true) {
                    window.location.href = '/facturas/';
                }

            }

        });

    }

    function convertDateFormat(date) {
        let dateParts = date.split('/');
        let year = dateParts[2];
        let month = dateParts[0].padStart(2, '0');
        let day = dateParts[1].padStart(2, '0');
        return `${year}${month}${day}`;
    }

    function buscar(){
        let fecha_inicio=""
        let fecha_final=""
        let busqueda = ""
        let has_filter= <?= $_GET['is_recurring'] ?? "false" ?>

        if ($('#searchInput').val()) {

            console.log($('#searchInput').val())

            busqueda = `${$('#searchInput').val()}`
        }

        if ($('#start_date').val()) {
            console.log($('#start_date').val())
            fecha_inicio = `&start_date=${convertDateFormat($('#start_date').val())}`
            
        }

        if ($('#end_date').val()) {
            console.log($('#end_date').val())
            fecha_final = `&end_date=${convertDateFormat($('#end_date').val())}`
        }

        if ((busqueda+fecha_inicio+fecha_final) != "") {

            if (has_filter) {

                window.location.href = "?is_recurring=true&q="+busqueda+fecha_inicio+fecha_final;
                
            }else{

                window.location.href = "?q="+busqueda+fecha_inicio+fecha_final;

            }
        }
    }

    function publicar(id2){
       $.ajax({
            type: 'POST',

            url: '/html/publicar/?id='+id2,

            dataType: 'json',

            contentType: 'application/json',

            success: function(d) {
                console.log(d)
                if(d.content == "11"){
                   window.location.href = "/facturas/";
                }
            }
        });
    }

</script>