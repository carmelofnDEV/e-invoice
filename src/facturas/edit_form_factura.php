<?php

$user = Intratum\Facturas\Util::getSessionUser();
$profile = Intratum\Facturas\User::getUserAccount($user["id"]);

Intratum\Facturas\Util::checkSession();

if (isset($_GET['doc'])) {
    $doc = $_GET['doc'];
    if ($doc != 'factura' && $doc != 'presupuesto' && $doc != 'gasto' ) {
        $doc="factura";
    }
}else{
    $doc = 'factura';

}


if ($doc == 'gasto') {
    $title = "Editar gasto";
    
}else if ($doc == 'presupuesto'){
    $title = "Editar presupuesto";

}else{
    $title = "Editar factura";

}

$allSerials = Intratum\Facturas\Serial::all();

$allTax = Intratum\Facturas\Tax::all();

$item = $_GET['item'];

$id2 = Intratum\Facturas\Util::getID2ByUUID("inv_", $item);

$invoice = Intratum\Facturas\Factura::get($params = ["id2" => $id2]);
$db2 = Intratum\Facturas\Environment::$db;

$customer = false;

$discount = Intratum\Facturas\InvoiceSetting::checkIfExistSetting($invoice["id"],$params = ["OPTION" => "DISCOUNT",]);
if ($discount) {
    $discount=$discount[0];
}

?>




<form action="lib/add_producto.php" id="form" class=" bgmt-5" method="post" autocomplete="off">
<div class="border-[1px] my-5 rounded-lg flex flex-col justify-center gap-[5%]  mx-[20%]">
    <div class="grid grid-cols-1  pt-10 bg-gray-100 px-[35px] pb-5">

        <div class="grid grid-cols-3 mb-5">

            <div class="col-span-2  flex flex-col justify-between h-full">
                <div class=" flex  items-center  w-full">
                    <?php if ($_SERVER['SERVER_PORT'] == '80') { ?>
                        <img class="max-w-[300px] max-h-[70px] w-[50%] object-cover" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if ($profile["hash_logo"] != "") { echo $profile["hash_logo"]; } else { echo "default.png"; } ?>" alt="Logo" />
                    <?php } else if ($_SERVER['SERVER_PORT'] == '443') { ?>
                        <img class="max-w-[300px] max-h-[70px] w-[50%] object-cover" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if ($profile["hash_logo"] != "") { echo $profile["hash_logo"]; } else { echo "default.png"; } ?>" alt="Logo" />
                    <?php } else if ($_SERVER['SERVER_PORT'] == '8086') { ?>
                        <img class="max-w-[300px] max-h-[70px] w-[50%] object-cover" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if ($profile["hash_logo"] != "") { echo $profile["hash_logo"]; } else { echo "default.png"; } ?>" alt="Logo" />
                    <?php } ?>
                </div>

            </div>

            <input type="hidden" name="id_invoice" value="<?=$invoice["id"]?>">


            <div class="flex flex-col justify-around ">

                <div class="mb-4">
                    <div class="flex flex-col">

                        <?php

                            if ($doc == "presupuesto") { 
                                
                            Intratum\Facturas\Environment::$db->where('account_id',$profile["id"]);  
                            Intratum\Facturas\Environment::$db->where('type',2);  
                            $num_presupuesto = Intratum\Facturas\Environment::$db->get('invoice');  
                            $num_presupuesto = count($num_presupuesto)+1
                            
                        ?>

                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de presupuesto</label>

                            <input type="number" name="name" required value="<?=$invoice["name"]?>"  class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            
                            
                            <input type="hidden" name="invoice_serial" value="0" />
                            <input type="hidden" name="invoice_number" value="0" />
                                
                        <?php }else if ($doc == "gasto") { ?>

                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de gasto</label>

                            <input type="text" name="name" required value="<?=$invoice["name"]?>" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            
                            <input type="hidden" name="invoice_serial" value="0" />

                            <input type="hidden" name="invoice_number" value="0" />

                        <?php } else{ ?>

                            <?php if(count($allSerials) > 1){ ?>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial y número de factura</label>

                                <select onchange="updateInvoiceNumber()" name="invoice_serial" id="select_serials" class="w-[30%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <?php foreach ($allSerials as $i) { 
                                        if(empty($i["serial_tag"]))
                                            $i["serial_tag"] = '';
                                    ?>
                                    <option <?php if ($invoice['serial_id'] == $i["id"]) {echo ' selected ';}?> value="<?= $i["id"] ?>"><?= $i["serial_tag"] ?></option>
                                    <?php } ?>
                                </select>
                            <?php }else{ ?>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de factura</label>

                                <input type="hidden" name="invoice_serial" value="<?= $invoice['serial_id'] ?>" />
                            <?php } ?>
                            <input type="number" name="invoice_number" id="invoice_number" value="<?= $invoice['invoice_number'] ?>" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <?php } ?>
                    </div>
                </div>






                <div class="">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de
                    facturación</label>
                    <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input datepicker datepicker-title="Fecha de facturación" value="<?=  date('m-d-Y',strtotime($invoice["invoice_date"])) ?>"
                        name="invoice_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Selecciona una fecha">
                    </div>
                </div>
            </div>

        </div>




        <div class="flex justify-between">


            <div>
                <p class="text-[20px] font-[600]">Datos fiscales</p>
                <p><?= $profile["first_name"] ?>&nbsp;<?= $profile["last_name"] ?></p>
                <p><?= $profile["NIF"] ?></p>
                <p><?= $profile["address1"] ?></p>
                <p><?= $profile["country"] ?><?= ", " . $profile["state"] ?><?= ", " . $profile["city"] ?><?= " " . $profile["zip"] ?></p>
                <p><?= $profile["email"] ?></p>
                <p><?= $profile["phone"] ?></p>
            </div>

                    
            <div>
                <div id="buscador-div" class="relative">
                    <label id="buscador-contact"  class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar cliente:</label>
                    <input type="text" id="searchAccount" autocomplete="off" class="!col-span-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar..."  />
                    <div class=" w-full absolute top- left-0">
                        <ul id="lista" class="hidden w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </ul>
                    </div>
                </div>


                
                <div class="flex">

                    <div id="cont_cliente" class="col-span-3">


                    </div>

                    <div id="boton-cont" class="hidden  mt-5">
                        <button  data-modal-target="modal-contact" data-modal-toggle="modal-contact" class="" type="button">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10 3-3zM14 7.414l-9 9V19h2.586l9-9L14 7.414zm4 1.172L19.586 7 17 4.414 15.414 6 18 8.586z" fill="#0D0D0D"/></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Cotact modal -->
        <div id="modal-contact" tabindex="-1" aria-hidden="false" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h2 class="mb-2  font-[600] col-span-2 text-[20px]">Datos del receptor</h2>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-contact">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div>
                        <div class="grid grid-cols-3 gap-5 p-5">
                            <div id="div-responsive-1" class="mb-2 ">
                                <!-- nombre particular -->
                                <label id="nombre-particular" for="first_name" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <!-- nombre fiscal -->
                                <label for="first_name" id="nombre-fiscal" class=" hidden !col-span-2  mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>
                                <input value="<?=$invoice["first_name"]?>" <?php if ($customer) { echo ' value="' . $customer["first_name"] . '" '; } ?> type="text" id="first_name" name="first_name" class="!col-span-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre"  />

                            </div>
                            <input type="hidden" id="cust-id" name="cust-id" value="<?=$invoice["recipient_id"]?>">
                            <div id="campo-apellidos" class="mb-2">
                                <label for="last_name" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                                <input value="<?=$invoice["last_name"]?>" <?php if ($customer) { echo ' value="' . $customer["last_name"] . '" '; } ?> type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Apellidos" />
                            </div>

                            <div class="mb-2 flex flex-col justify-center items-center">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de cliente</label>
                                <div class="flex">
                                    <div class="flex items-center">
                                        <input type="radio" id="cliente_fiscal" name="category" value="f" <?php if($invoice["category"] == "f"){ echo "checked";}?> class="hidden">
                                        <label id="fiscal" for="cliente_fiscal" class="w-20 text-center  rounded-l-lg  py-1 px-3 border-[1px] text-sm text-gray-900 dark:text-white <?php if($invoice["category"] == "f"){ echo " bg-blue-300";}?>" onclick="highlightBackground(this.id)">Fiscal</label>
                                    </div>
                                    <div class="flex items-center ">
                                        <input type="radio" id="cliente_particular" name="category" value="p"  <?php if($invoice["category"] == "p"){ echo "checked";}?> class="hidden">
                                        <label id="particular" for="cliente_particular" class="w-20 text-center rounded-r-lg border-[1px] border-l-none py-1 px-3   text-sm text-gray-900 dark:text-white <?php if($invoice["category"] == "p"){ echo " bg-blue-300";}?>" onclick="highlightBackground(this.id)">Particular</label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="email" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                                <input  value="<?=$invoice["email"]?>" <?php if ($customer) { echo ' value="' . $customer["email"] . '" '; } ?> type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="correo@email.com" >
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                                <input value="<?=$invoice["phone"]?>"  <?php if ($customer) { echo ' value="' . $customer["phone"] . '" '; } ?> type="tel" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="000-000-000" >
                            </div>
                            <div class="mb-2">
                                <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección  *</label>
                                <input value="<?=$invoice["address1"]?>"  <?php if ($customer) { echo ' value="' . $customer["address1"] . '" '; } ?> type="text" id="address_1" name="address_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Direccion "  />
                            </div>

                            <div class="mb-2">
                                <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo postal</label>
                                <input value="<?=$invoice["zip"]?>"  <?php if ($customer) { echo ' value="' . $customer["zip"] . '" '; } ?> type="number" id="zip" name="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Codigo postal" />
                            </div>
                            <div class="mb-2">
                                <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
                                <input  value="<?=$invoice["country"]?>" type="text" <?php if ($customer) { echo ' value="' . $customer["country"] . '" '; } ?> id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="País"  />
                            </div>
                            <div class="mb-2">
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
                                <input value="<?=$invoice["state"]?>"  <?php if ($customer) { echo ' value="' . $customer["state"] . '" '; } ?> type="text" id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Provincia"  />
                            </div>
                            <div class="mb-2">
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
                                <input value="<?=$invoice["city"]?>" <?php if ($customer) { echo ' value="' . $customer["city"] . '" '; } ?> type="text" id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ciudad"  />
                            </div>
                            <input type="hidden" name="type"  value="<?=$invoice["type"]?>" >

                            <input id="autoComp" type="hidden" name="autoComp"  value="true" >






                            <div class="mb-">
                                <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>
                                <input value="<?=$invoice["NIF"]?>"  <?php if ($customer) { echo ' value="' . $customer["NIF"] . '" '; } ?> type="text" id="NIF" name="NIF" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CIF / DNI"  />
                            </div>
                        </div>

                        
                    </div>
                    <div class="flex items-end justify-end p-4 rounded-t dark:border-gray-600">
                        <button onclick="updateContact()" type="button" class="flex  items-center bg-[#afafaf]  bg-opacity-10 transition-all duration-200 hover:bg-opacity-30 py-1 px-3 rounded-lg" data-modal-hide="modal-contact">
                            <p class="font-[500]">Hecho</p>
                            <svg width="20px" height="20px" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="okIconTitle" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000"> <title id="okIconTitle">Ok</title> <polyline points="4 13 9 18 20 7"/> </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




      <!-- ############################################################################################################################################################################ -->
      <!-- ############################################################################################################################################################################ -->
      <!-- ############################################################################################################################################################################ -->
      <div class="flex flex-col gap-5 px-[35px] pb-5 pt-5">
         <div class="flex flex-col justify-around">
            <h2 class=" font-[600] text-[20px] mb-5 col-span-3">Productos</h2>






            <div id="items_container" class="flex flex-col">

            <?php

                $db2->where('invoice_id', $invoice["id"]);
                $allItems = $db2->get('invoice_item');
                $indexItems = 0;
                $taxes=[];
                foreach ($allItems as $item) {

                    $db2->where('id', $item["id_item"]);
                    $product = $db2->get('product')[0];

                    $db2->where('invoice_item_id', $item["id"]);
                    $item_taxs = $db2->get('invoice_item_tax');
                    $taxes[] = $item_taxs;

                    $button_tax = "";

                    foreach ($item_taxs as $tax) {


                        $db2->where('id', $tax["tax_id"]);
                        $real_tax = $db2->get('tax')[0];

                        $button_tax = $button_tax.'<span>'.$real_tax["name"].'/'.$tax["tax_value"].'</span> ';

                    }

                    if ($button_tax == "") {
                        $button_tax='<span>Añadir impuesto</span>';
                    }

                    $container =

                    '<div id="item-container-'.$indexItems.'" class="w-full flex gap-5 item-group">
                        
                        <input type="hidden" class="id-item" name="items['.$indexItems.'][id]" value="'.$item["id_item"].'">

                        

                        <input type="hidden" class="subtotal" name="items['.$indexItems.'][subtotal]" value="'.$item["subtotal"].'">

                        
                        <div class="mb-5 w-full min-w-[10%] relative clista-item" data-key="'.$indexItems.'">
                            <input type="text" required value="'.$product["title"].'" name="items['.$indexItems.'][title]" class="autocomp-item item-input title h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Producto" />
                            <div class="absolute top- left-0 w-full">
                                <ul class="lista-item hidden w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </ul>
                            </div>
                        </div>

                        

                        <div class="mb-5 min-w-[10%]">
                            <input type="number" required value="'.($item["subtotal"]/$item["quantity"]).'"  name="items['.$indexItems.'][price]" class="price item-input h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.00" step="0.01" />
                        </div>

                        <div class="mb-5 min-w-[10%]">
                            <input type="number" required value="'.$item["quantity"].'"  name="items['.$indexItems.'][quantity]" class="item-input quantity h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="X" value="" />
                        </div>

                        <div class="mb-5 flex flex-col w-full">


                            <button id="boton-tax-'.$indexItems.'" onClick="openItemTaxs('.$indexItems.')" class="flex gap-1 items-center justify-center text-[12px] rounded-lg  py-1.5 px-6 bg-black text-white hover:bg-opacity-80 transition-all" type="button">
                            '.$button_tax.'
                            </button>

                        </div>

                        <div class="mb-5  ">

                                <button type="button" onClick="deleteItem('.$indexItems.')"  class="delete_button flex w-full justify-center" >                
                                    <svg fill="#ff0601" width="30px" height="30px" viewBox="0 0 24 24" version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg"><path d="M12 4c-4.419 0-8 3.582-8 8s3.581 8 8 8 8-3.582 8-8-3.581-8-8-8zm3.707 10.293c.391.391.391 1.023 0 1.414-.195.195-.451.293-.707.293s-.512-.098-.707-.293l-2.293-2.293-2.293 2.293c-.195.195-.451.293-.707.293s-.512-.098-.707-.293c-.391-.391-.391-1.023 0-1.414l2.293-2.293-2.293-2.293c-.391-.391-.391-1.023 0-1.414s1.023-.391 1.414 0l2.293 2.293 2.293-2.293c.391-.391 1.023-.391 1.414 0s.391 1.023 0 1.414l-2.293 2.293 2.293 2.293z"/></svg>
                                </button>
                        </div>
                        

                    </div> ';

                    echo $container;



                    $indexItems++;
                }
                
            
            ?>
                

            </div>

            <div class="flex flex-row gap-5">
                <button type="button" onclick="addItemRow()" class="w-full py-1 px-4 bg-black text-white rounded-lg">Añadir otro producto</button>
            </div>


            <div id="itemsTaxes" class="">

            <?php 
                $indexTaxs = 0;

                foreach ($taxes as $itemTaxs) {

                    foreach ($itemTaxs as $tax ) {
                        $db2->where('id', $tax["tax_id"]);
                        $real_tax = $db2->get('tax')[0];

                        echo '<input type="hidden" name="items['.$indexTaxs.'][tax_'.$real_tax["type"].']" value="'.$real_tax["type"].'/'.$real_tax["name"].'/'.$tax["tax_value"].'/'.$real_tax['id2'].'">';


                    }
                    $indexTaxs++;
            } ?>

                            
            

            </div>





            


            <div id="total-div" class="text-[20px] flex items-end flex-col col-span-3">
            <div class="min-w-[20%]">
               <div class="flex gap-[10px]">
                  <h2 class="font-[600]" >Subtotal</h2>
                  <h2 id="subtotal">0€</h2>
               </div>
               <hr class="w-full h-[2px] bg-black  border-0 rounded dark:bg-gray-700">
               <div>
                    <input onchange="checkDiscount()" type="checkbox" id="discount-check" name="discount" <?php if ($discount) { echo " checked ";}?>  />
                    <label for="discount">¿Descuento?</label>
                </div>

                <div id="discount-div" class="<?php if (!$discount) { echo " hidden ";}?> flex items-center ">
                <input type="number" onchange="updateTotalMenu()" <?php if ($discount) { echo "value='".$discount["value"]."'";}?>  name="discount" id="discount" min="1" class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" min="0" max="99" placeholder="Descuento" value="">
                <p class="font-[800]">(%)</p>
                </div>


               <ul id="totalMenu"></ul>
               <hr class="w-full h-[2px] bg-black  border-0 rounded dark:bg-gray-700">
               <div class="flex gap-[10px]">
                  <h2 class="font-[600]">Total</h2>
                  <h2 id="total">0€</h2>
               </div>
            </div>
         </div>
      </div>
            <!-- ############################################################################################################################################################################ -->
            <!-- ############################################################################################################################################################################ -->
            <!-- ############################################################################################################################################################################ -->




   </div>
   <div class="min-w-[15%] bg-gray-100 px-[35px] pb-5">
         <h2 class="pt-10  font-[600] text-[20px] mb-5">Detalles</h2>
            <div class="flex  gap-5 w-full mb-10">
                <div class="w-full">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terminos y
                    condiciones</label>
                    <textarea name="terms" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                    dark:focus:border-blue-500" placeholder="Escriba aquí..."></textarea>
                </div>



            </div>



         <div id="notifications ">
         </div>

            <!-- ################ SUBMIT ################ -->
            <div class="flex justify-center w-full items-end justify-end">
                <button type="submit" class="flex  items-center justify-center bg-black py-2 px-4 rounded-lg">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span class="font-[600] text-white">Guardar</span>
                </button>
            </div>
      </div>



</form>


<!-- ############################################################################################################################################################################ -->

<!-- ############################################################################################################################################################################ -->

<!-- ############################  MODAL ############################ -->



<!-- Main modal -->



<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden flex bg-black bg-opacity-30 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-md max-h-full">

        <!-- Modal content -->

        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <!-- Modal header -->

            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">

                    Añadir impuesto

                </h3>

                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                   onClick="closeItemTaxs()">

                    <svg class="w-3 h-3"  xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">

                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />

                    </svg>

                    <span class="sr-only">Close modal</span>

                </button>

            </div>

            <!-- Modal body -->


            <div class="border-b dark:border-gray-600">
                <ul id="lista-modal-taxs">

                </ul>
            </div>

            <div class="p-5">

                <div class="flex items-center justify-center mt-5 gap-[10px] mb-5">
                    <label for="select_tax">Impuesto:</label>
                    <select onchange="handleSelectChange()" name="select_tax" id="select_tax"
                        class="block  p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">

                        <option  value="new" class="py-2 bg-gray-100 border-b-[1px] flex items-center text-center"><span class="">Crear +</span></option>

                        <?php $index = 0; foreach ($allTax as $tax){ 
                            $index++;
                            ?>

                            <option <?php if ($index == 1) {echo "selected";} ?>

                            value="<?=$tax['type']?>/<?=$tax['name']?>/<?=$tax['value']?>/<?=$tax['id2']?>"
                                class="py-2">
                                <?=$tax['name']?> / <?=$tax['value']?>
                            </option>


                        <?php } ?>


                    </select>
                </div>


                <script>
                    function handleSelectChange() {
                        var select = document.getElementById('select_tax');
                        var value = select.value;

                        if (value === 'new') {
                            $("#modal-new-tax").removeClass("hidden")
                            $("#modal-new-tax").addClass("flex")
                            select.selectedIndex = 0;
                        }
                    }
                </script>



                <!-- Modal Impuestos -->

                <div id="modal-new-tax" tabindex="-1" aria-hidden="true" class="hidden   overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Crear nuevo impuesto
                                </h3>
                                <button onclick="closeCreateTax()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-new-tax">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                            <form id="form-new-tax" method="UPDATE" class="max-w-md mx-auto">
                                <div class="flex flex-col gap-5">

                                    <div class="relative">
                                        <input type="text" id="name" name="name" 
                                            class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <label for="name"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Nombre</label>
                                    </div>

                                    <div class="relative">
                                        <input type="text" id="value" name="value"
                                            class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder="" />
                                        <label for="value"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Valor</label>
                                    </div>

                                    <div class="mb-5">

                                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>

                                        <select name="type" id="type" class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>

                                            <option value="1">IVA</option>

                                            <option selected="selected" value="0">IRPF</option>

                                        </select>

                                    </div>



                                    <input type="hidden" name="id2">

                                    <div class="flex w-full items-end justify-end">
                                        <button type="submit" class="bg-black text-white py-1 px-4 rounded-lg ">
                                            Añadir
                                        </button>
                                    </div>

                                </div>

                            </form>


                            </div>

                        </div>
                    </div>
                </div>


                


                <!-- Fin modal -->




                <button type="button" id="boton-value-tax" item-value="" onclick="addTax(this)" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg py-2 text-sm px-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Añadir +
                </button>
            </div>

        </div>

    </div>

</div>


<button data-modal-target="modal-new-tax" data-modal-toggle="modal-new-tax" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>

<button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  Toggle modal
</button>

<!-- ############################################################################################################################################################################ -->

<!-- ############################################################################################################################################################################ -->



<!--

   *

   *

   * Inicio scripts

   *

   *

   * Formulario facturas, impuestos, autocompletado (items, clientes y taxs)

   *

   *

    -->



<!-- ############################################################################################################################################################################ -->

<!-- ############ NUEVO IMPUESTO ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->


<script>
function closeCreateTax(){
    $("#select_tax").val("<?=$allTax[0]['type']?>/<?=$allTax[0]['name']?>/<?=$allTax[0]['value']?>/<?=$allTax[0]['id2']?>")
}



$(document).ready(function() {
    
    updateTotalMenu()

    $('#form-new-tax').submit(function(e) {
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);

        $.ajax({
            type: 'POST',
            url: '/ajax/tax',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d) {
                if (d.success == true) {

                    console.log("AÑADIRDO ",data," id2 ", d.id2_response)

                    var newOption = document.createElement("option");

                    newOption.value = `${data.type}/${data.name}/${data.value}/${d.id2_response}`;

                    newOption.text = `${data.name} / ${data.value}`;
                    
                    newOption.className = "py-2";

                    var select = document.getElementById('select_tax');
                    select.add(newOption);
                    select.value = newOption.value

                    $("#modal-new-tax").addClass("hidden")

                    document.getElementById('form-new-tax').reset();


                }else{

                    setNotification([{"error":"cant_create_tax","message":"Ha habido un error al crear el impuesto."}])

                }
            }
        });


    });
});
</script>

<!-- ############################################################################################################################################################################ -->

<!-- ############   FORMULARIO FACTURA ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->

<style>
    @keyframes slideOutLeft {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(100%);
            opacity: 0;
        }

    }

  .slide-out-left {
    animation: slideOutLeft 0.3s ease-out forwards;
  }
</style>

<script>
let qItems = <?=$indexItems?>

let invoice_subtotal = 0

let invoice_total = 0


$(document).ready(function() {

    selectCategory(
        <?php if ( $customer) {
            echo '"'.$customer["category"].'"';
            
        }else{
            echo "'f'";
        } ?>
    )

    updateContact()


    $('#form').submit(function(e) {

        e.preventDefault();

        if(addCustInfo()){

            var data = $(this).serializeJSON();

            data["invoice_total"] = invoice_total



            data["invoice_subtotal"] = invoice_subtotal

            data.invoice_date = moment(data.invoice_date, 'MM/DD/YYYY').format('YYYY-MM-DD');
            console.log(data)
            $.ajax({

                type: 'UPDATE',             

                url: '/ajax/facturas',

                dataType: 'json',

                contentType: 'application/json',

                data: JSON.stringify(data),

                success: function(d) {

                    if (d.success == true) {

                        if (<?php echo $invoice["type"]; ?> == 0) {
                            window.location.href = '/gastos/?success=true';
                        } else if (<?php echo $invoice["type"]; ?> == 2) {
                            window.location.href = '/presupuestos/?success=true';
                        } else {
                            window.location.href = '/facturas/?success=true';
                        }




                    }if (d.success == false && d.errors) {

                        setNotification(d.errors)

                    }

                }

            });
        }

        });

});


function setNotification(errors) {
    errors.forEach(e => {
        console.log(e.error);

        const toast = document.createElement('div');
        toast.className = 'flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800';
        toast.setAttribute('role', 'alert');

        const iconContainer = document.createElement('div');
        iconContainer.className = 'inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200';
        const icon = document.createElement('div');
        icon.setAttribute('viewBox', '0 0 20 20');
        icon.innerHTML = '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>';
        iconContainer.appendChild(icon);

        const message = document.createElement('div');
        message.className = 'ms-3 text-sm font-normal';
        message.textContent = e.message;

        const button = document.createElement('button');
        button.className = 'ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700';
        button.setAttribute('type', 'button');
        button.setAttribute('aria-label', 'Close');
        button.innerHTML = '<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>';
        
        button.addEventListener('click', () => {
            toast.classList.add('slide-out-left');
            setTimeout(() => {
                toast.remove();
            });
        });

        toast.appendChild(iconContainer);
        toast.appendChild(message);
        toast.appendChild(button);

        toast.style.position = 'fixed';
        toast.style.zIndex = '100';
        toast.style.top = '20px'; 
        toast.style.right = '20px'; 

        const notificationsContainer = document.getElementById('notifications');
        if (notificationsContainer) {
            notificationsContainer.appendChild(toast);
        } else {
            document.body.appendChild(toast);
        }

        setTimeout(() => {
            toast.classList.add('slide-out-left');
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 3000);
    });
}


function selectCategory(option) {
    console.log(option)
    if (option == 'f') {

        $("#nombre-fiscal").removeClass("hidden")

        $("#nombre-particular").addClass("hidden")

        $("#div-responsive-1").addClass("col-span-2")

        $("#campo-apellidos").addClass("hidden")

    } else if (option == 'p') {

        $("#nombre-particular").removeClass("hidden")

        $("#nombre-fiscal").addClass("hidden")

        $("#campo-apellidos").removeClass("hidden")

        $("#div-responsive-1").removeClass("col-span-2")

    }



}



function deleteItem(key){


    let items = $('input[name^="items"]')

    console.log(items.length)
    if (items.length < 8) {

        setNotification([{"error":"less_items","message":"Debe haber al menos un item."}])

    }else{

        $('input[name^="items[' + key + ']"]').each(function () {$(this).remove()});

        $(`#item-container-${key}`).remove()
        
    }

    updateTotalMenu()


}



function addItemRow() {

    $('.lista-item').addClass("hidden"); 

    var newItemGroup = $('.item-group').first().clone();
    
    
    qItems++

    var newIndex = qItems
    console.log
    newItemGroup.attr('id',`item-container-${newIndex}`)

    console.log(newItemGroup.attr('id') )

    newItemGroup.find('input, button, ul').each(function() {
        var id = $(this).attr('id');
        if (id) {
            $(this).attr('id', id.replace(/\d+/, newIndex));
        }

        var name = $(this).attr('name');
        if (name) {
            $(this).attr('name', name.replace(/\[\d+\]/, '[' + newIndex + ']'));
        }

        let lista = $(this).hasClass("lista-item");
        console.log("tiene?",lista)
        if(lista){
            $(this).addClass("hidden");

        }



        var value = $(this).val();
        if (value != "") {

             $(this).val("")
        }


        var onClick = $(this).attr('onClick');

        if (onClick) {

            $(this).attr('onClick', onClick.replace(/\d+/, newIndex));

            if (!$(this).hasClass('delete_button')) {

                $(this).text('Añadir');
                
            }
        }
    });

    $('#items_container').append(newItemGroup);
    newItemGroup.find('*[data-key]').attr('data-key', newIndex);

}

function openItemTaxs(item_num){

    

    $("#boton-value-tax").attr('item-value', item_num);

    $("#crud-modal").removeClass("hidden")
    $("#crud-modal").addClass("flex")


    $("#lista-modal-taxs").empty()

    let input0 = $("#itemsTaxes input[name='items\\[" + item_num + "\\]\\[tax_0]']").val();
    let input1 = $("#itemsTaxes input[name='items\\[" + item_num + "\\]\\[tax_1]']").val();

    if (input0) {

        let tax0 = input0.split("/");

        let itemTax0 = {
            name: tax0[1],
            type: tax0[0],
            value: tax0[2],
            id: tax0[3],
        }
        console.log(itemTax0)

        let listItem = document.createElement("li");

        listItem.textContent = itemTax0.name + " / " + itemTax0.value;
        listItem.id = ("item-"+item_num+"tax-" + itemTax0.type);
        listItem.classList.add("flex", "text-center", "items-center", "justify-center", "border-b-2",
            "border-gray-200", "py-2", "gap-[50%]");
        let deleteButton = document.createElement("button");
        deleteButton.textContent = "Eliminar";
        deleteButton.type = "button";

        deleteButton.classList.add("bg-red-500", "text-white", "px-4", "py-1", "rounded", "hover:bg-red-600",
            "focus:outline-none", "focus:ring-2", "focus:ring-red-600", "focus:ring-opacity-50");
            
        deleteButton.addEventListener("click", function() {
            deleteItemTax(item_num,itemTax0.type);
        });

        listItem.appendChild(deleteButton);

        $("#lista-modal-taxs").append(listItem)
    }

    if (input1) {
        let tax1 = input1.split("/");

        let itemTax1 = {
            name: tax1[1],
            type: tax1[0],
            value: tax1[2],
            id: tax1[3],
        }
        console.log(itemTax1)


        let listItem = document.createElement("li");

        listItem.textContent = itemTax1.name + " / " + itemTax1.value;
        listItem.id = ("item-"+item_num+"tax-" + itemTax1.type);
        listItem.classList.add("flex", "text-center", "items-center", "justify-center", "border-b-2",
            "border-gray-200", "py-2", "gap-[50%]");
        let deleteButton = document.createElement("button");
        deleteButton.textContent = "Eliminar";
        deleteButton.type = "button";

        deleteButton.classList.add("bg-red-500", "text-white", "px-4", "py-1", "rounded", "hover:bg-red-600",
            "focus:outline-none", "focus:ring-2", "focus:ring-red-600", "focus:ring-opacity-50");
        deleteButton.addEventListener("click", function() {
            deleteItemTax(item_num,itemTax1.type);
        });

        listItem.appendChild(deleteButton);

        $("#lista-modal-taxs").append(listItem)
    }

    



}



function addTax(e) {

    console.log($(e).attr('item-value'));

    let keyitems = $(e).attr('item-value')

    let price = $(`input[name='items[${keyitems}][price]']`).val();
    let quantity = $(`input[name='items[${keyitems}][quantity]']`).val();

    console.log(price," - ",quantity)

    let tax = $("#select_tax").val().split("/");

    let itemTax = {
        name: tax[1],
        type: tax[0],
        value: tax[2],
        id: tax[3],
    }

    console.log("1",itemTax)

    if ($("#itemsTaxes input[name='items\\[" + keyitems + "\\]\\[tax_" + itemTax.type + "\\]']").length == 0) {
    
        let taxInput = `<input type="hidden"  name="items[${keyitems}][tax_${itemTax.type}]" value="${itemTax.type}/${itemTax.name}/${itemTax.value}/${itemTax.id}" />`

        $("#itemsTaxes").append(taxInput)
        console.log($(`#boton-tax-${keyitems}`).html().trim())
        if ($(`#boton-tax-${keyitems}`).html().trim() == "<span>Añadir impuesto</span>") {

            $(`#boton-tax-${keyitems}`).html( `<span>${itemTax.name} / ${itemTax.value}</span>`)

        }else{

            $(`#boton-tax-${keyitems}`).html( $(`#boton-tax-${keyitems}`).html()+ `<span>${itemTax.name} / ${itemTax.value}</span>`)

        }

        let listItem = document.createElement("li");

        listItem.textContent = itemTax.name + " / " + itemTax.value;
        
        listItem.id = ("item-"+keyitems+"tax-" + itemTax.type);
        listItem.classList.add("flex", "text-center", "items-center", "justify-center", "border-b-2", "border-gray-200", "py-2", "gap-[50%]");
        let deleteButton = document.createElement("button");
        deleteButton.textContent = "Eliminar";
        deleteButton.type = "button";

        deleteButton.classList.add("bg-red-500", "text-white", "px-4", "py-1", "rounded", "hover:bg-red-600",
            "focus:outline-none", "focus:ring-2", "focus:ring-red-600", "focus:ring-opacity-50");
        deleteButton.addEventListener("click", function() {
            deleteItemTax(keyitems,itemTax.type);
        });

        listItem.appendChild(deleteButton);
        console.log("lista item  ",listItem)
        $("#lista-modal-taxs").append(listItem)


    }else{

        errors = [{
            "error":"repeat_tax",
            "message":"No puedes añadir dos impuestos del mismo tipo.",
        }];

        setNotification(errors)
        
    }

    

    updateTotalMenu()
closeItemTaxs();



}

function deleteItemTax(keyitem,type){

    $(`#boton-tax-${keyitem}`).text("")

    $("#itemsTaxes input[name='items\\[" + keyitem + "\\]\\[tax_" + type + "\\]']").remove()

    $(`#item-${keyitem}tax-${type}`).remove()

    let input0 = $("#itemsTaxes input[name='items\\[" + keyitem + "\\]\\[tax_0]']").val();
    let input1 = $("#itemsTaxes input[name='items\\[" + keyitem + "\\]\\[tax_1]']").val();


    if (input0) {
        let tax0 = input0.split("/");

        let itemTax0 = {
            name: tax0[1],
            type: tax0[0],
            value: tax0[2],
            id: tax0[3],
        }

        $(`#boton-tax-${keyitem}`).text(`${itemTax0.name}/${itemTax0.value}`)


    }else if (input1) {
        let tax1 = input1.split("/");

        let itemTax1 = {
            name: tax1[1],
            type: tax1[0],
            value: tax1[2],
            id: tax1[3],
        }

        $(`#boton-tax-${keyitem}`).text(`${itemTax1.name}/${itemTax1.value}`)

        
    }else{

        $(`#boton-tax-${keyitem}`).html("<span>Añadir impuesto</span>") 

    }

    updateTotalMenu()



}





function closeItemTaxs(){

    $("#crud-modal").removeClass("flex")
    $("#crud-modal").addClass("hidden")



}




$(document).on('change', '.item-input', function() {
    let keyitems = $(this).attr('name').match(/\d+/)[0]; 
    let title = $(`input[name='items[${keyitems}][title]']`).val();
    let price = $(`input[name='items[${keyitems}][price]']`).val();
    let quantity = $(`input[name='items[${keyitems}][quantity]']`).val();

    let tax_0 = $(`input[name='items[${keyitems}][tax_0]']`).val();
    let tax_1 = $(`input[name='items[${keyitems}][tax_1]']`).val();

    let subtotal = price * quantity

    $(`input[name='items[${keyitems}][subtotal]']`).val(subtotal);

    console.log("Producto:", title, "Precio:", price, "Cantidad:", quantity);

    updateTotalMenu()


});

function checkDiscount(){

        
    if ($("#discount-check").is(":checked")) {

        $("#discount-div").removeClass("hidden")

    }else{

        $("#discount-div").addClass("hidden")

        $("#discount").val("") 

    }

    updateTotalMenu()

}
function updateTotalMenu() {

    

let total = 0

let subtotal = 0
let totalTaxs = 0
let discTotal = 0;

let taxes = [];




const values = {};

$('input[name^="items"]').each(function () {
const name = $(this).attr('name');
const match = name.match(/items\[(\d+)\]\[(price|quantity|subtotal|tax_0|tax_1)\]/);

if (match) {
    const index = match[1];
    const field = match[2];

    if (!values[index]) {
        values[index] = {};
    }

    const valor = $(this).val().trim() !== '' ? $(this).val() : 0;
    values[index][field] = valor;
}
});

console.log(values)
$.each(values, function(index, item) {

    console.log("---------------------------------------- SUB",item.subtotal);
    if (item.subtotal > 0) {

        subtotal += parseFloat(item.subtotal)

        // aplico el descuento al subtotal de cada item 
        if ($("#discount").val() > 0) {

            discTotal = discTotal +  (item.subtotal * ($("#discount").val()/100))


        }

            console.log("+++++++++++++++++++++ ITESM TAX",item.tax_1);





        if (item.tax_0 != undefined) {
            
            let tax0 = item.tax_0.split("/");

            let itemTax0 = {
                name: tax0[1],
                type: tax0[0],
                value: tax0[2],
                id: tax0[3],
            }

            addedTax = {
                name: itemTax0.name,
                value: itemTax0.value,
                total: ((parseFloat(item.subtotal))*(itemTax0.value /100))


            }

            updateOrAddTax(itemTax0, item.subtotal);


            

            
        }


        if (item.tax_1 != undefined) {
            console.log("ENTRA",item.tax_1 );
            let tax_1 = item.tax_1.split("/");

            let itemTax1 = {
                name: tax_1[1],
                type: tax_1[0],
                value: tax_1[2],
                id: tax_1[3],
            }


            
            addedTax = {

                name: itemTax1.name,
                value: itemTax1.value,
                total: ((parseFloat(item.subtotal))*(itemTax1.value /100))
            }

            updateOrAddTax(itemTax1, item.subtotal);
            
            
            
        }


        if (item.tax_1 != undefined || item.tax_0 != undefined) {
            totalTaxs= 0
            taxes.forEach(element => {
                console.log("elemento",element)
                totalTaxs += element.total
                
            });
        }

        console.log("taxes -",totalTaxs)



        invoice_subtotal = subtotal
        
        
        invoice_total =  (invoice_subtotal + totalTaxs) - discTotal;




    }
});


function updateOrAddTax(tax, subtotal) {


    let found = false;


    for (let i = 0; i < taxes.length; i++) {
        if (taxes[i].name === tax.name && taxes[i].value === tax.value) {
            taxes[i].total += (parseFloat(subtotal) * (tax.value / 100));
            found = true;
            break;
        }
    }

    if (!found) {
        taxes.push({
            name: tax.name,
            value: tax.value,
            total: (parseFloat(subtotal) * (tax.value / 100))
        });
    }
}

if (parseFloat(subtotal) > 0) {

    $("#subtotal").text(`${parseFloat(invoice_subtotal).toFixed(2)}€`)
    $("#total").text(`${parseFloat(invoice_total).toFixed(2)}€`)


    $("#totalMenu").empty()
    taxes.forEach(element => {
        $("#totalMenu").append(`<li>${element.name} - ${element.value}%  =  ${parseFloat(element.total).toFixed(2)}€`)
        console.log(element)
    });
    
}else{
    

    
    $("#subtotal").text(`0€`)
    $("#total").text(`0€`)
}





}





function updateInvoiceNumber() {

    var serial_id = $("#select_serials").val()

    $.ajax({

        type: 'GET',

        url: '/html/invoice_number/?id=' + serial_id,

        dataType: 'json',

        contentType: 'application/json',

        success: function(d) {

            $("#invoice_number").val(parseInt(d.content) + 1)

        }

    });

}

</script>

<!-- ############################################################################################################################################################################ -->

<!-- ############ FORMULARIO IMPUESTOS (MODAL) ########################################################################################################################################################## -->

 <!-- ############################################################################################################################################################################ -->



<!-- ############################################################################################################################################################################ -->

<!-- ############ AUTOCOMPLETADO CLIENTES FACTURA ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->

<script>

function highlightBackground(id) {
    

    if (id == "fiscal") {
        selectCategory("f")
        $("#fiscal").addClass("bg-blue-300")
        $("#particular").removeClass("bg-blue-300")
    }else{
        selectCategory("p")
        $("#particular").addClass("bg-blue-300")
        $("#fiscal").removeClass("bg-blue-300")

    }


}

var delay = 200;
var timerId;



function openModal(id=null){

    $('#lista').addClass("hidden");



    console.log(id)
    if (id == "newCust") {
        
        $('#NIF').val('');

        $('#boton-cont').addClass('hidden');


        $('#first_name').val($('#searchAccount').val());

        $('#last_name').val('');

        $('#email').val('');

        $('#phone').val('');

        $('#address_1').val('');


        $('#zip').val('');

        $('#country').val('');

        $('#state').val('');

        $('#city').val('');

        $('#category').val('');

        $('#cust-id').val('');

        $('#autoComp').val(false);
        
    }



    $("#modal-contact").removeClass("hidden")
    $("#modal-contact").addClass("flex")
    $("#modal-contact").addClass("flex")
    $("#modal-contact").addClass("bg-black bg-opacity-30")


    $("#modal-contact").attr("role", "dialog");

    $("#modal-contact").attr("aria-modal", "true");
}
function search(value) {

    $.ajax({

        url: '/ajax/customer',

        type: 'GET',

        dataType: 'json',

        data: {

            q: value

        },

        success: function(response) {

            $('#lista').empty();

            $('#lista').removeClass("hidden");

            setTimeout(function() {

                $('#lista').addClass("hidden");


            }, 5000);
            
            console.log(response)
            $.each(response, function(index, element) {
                
                $('#lista').append('<li data-id="' + element.id + '"' +
                    'class="cursor-pointer  element-li w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">' +
                    element.first_name + '</li>');

            });


            $('#lista').append('<li><button id="newCust" onClick="openModal(this.id)" type="button" class="cursor-pointer   w-full px-4 py-2 border-b bg-gray-500 bg-opacity-20 border-gray-200 dark:border-gray-600"> <span class="font-[700]" >Añadir contacto: </span> '+ value +'</button></li>');
           
        },

    });




}




$(document).on('click', '.element-li', function() {

    $('#lista').empty();



    

    $('#lista').addClass("hidden");


    $.ajax({

        url: '/ajax/customer/' + $(this).data('id'),

        type: 'GET',

        dataType: 'json',

        success: function(response) {

            autocompleteForm(response)

        },

    });

});


function autocompleteForm(response) {

  console.log(response);

  $("#NIF").val(response.NIF);

  $("#first_name").val(response.first_name);

  $("#last_name").val(response.last_name);

  $("#email").val(response.email);

  $("#phone").val(response.phone);

  $("#address_1").val(response.address1);

  $("#zip").val(response.zip);

  $("#country").val(response.country);

  $("#state").val(response.state);

  $("#city").val(response.city);

  $("#category").val(response.category);

  $("#cust-id").val(response.id);

  $("#autoComp").val(true);





  updateContact();

}

function addCustInfo(){

    var camposVacios = $('#first_name, #email, #phone, #address_1, #zip, #country, #state, #city, #NIF').filter(function() {
            return $(this).val().trim() === '';
        });

        if (camposVacios.length > 0) {
            setNotification([{"error":"bad_contact_info","message":"Debes completar los datos del cliente."}])
            return false
        }else{
            return true

        }
}

function updateContact(){

    $('#searchAccount').val("");


    $('#boton-cont').removeClass('hidden');

    $('#buscador-div').addClass('hidden');






    $("#cont_cliente").html(
        "<h2 class='font-[600] col-span-2 text-[20px]'>Datos del cliente</h2>" +
        $("#first_name").val() +
    " <br> " +
    $("#NIF").val() +
    " <br> " +
    $("#address_1").val() +
    " <br> " +
    $("#country").val() +
    " " +
    $("#state").val() +
    " " +
    $("#city").val() +
    " " +
    $("#zip").val() +
    " <br> " +
    $("#email").val() +
    " <br> " +
    $("#phone").val());

    $('#buscador-div').addClass("hidden");


}



</script>

<!-- ############################################################################################################################################################################ -->

<!-- ############ AUTOCOMPLETADO ITEMS ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->
<script>

var delay = 200;
var timerId;

$("#searchAccount").eq(0).bind("keyup paste", function() {

clearTimeout(timerId);

var value = $(this).val();



timerId = setTimeout(function() {

    after = null;

    initLoad = true;

    search(value);

}, delay);

});

$(document).on("keyup paste", ".autocomp-item", function() {


    clearTimeout(timerId);

    var parent = $(this).parents('.clista-item');
    
    var key = $(this).closest('.item-group').index();

    var value = $(this).val();

    timerId = setTimeout(function() {

        after = null;

        initLoad = true;

        searchItem(key,value);

    }, delay);

});

function searchItem(key,value) {

    $.ajax({

        url: '/ajax/products',

        type: 'GET',

        dataType: 'json',

        data: {

            q: value

        },

        success: function(response) {

            $('.lista-item').eq(key).empty();
            console.log($('.lista-item').eq(key))
            $('.lista-item').eq(key).removeClass("hidden");
            var html = '';
            
            $.each(response, function(index, element) {
                html += '<li data-id="' + element.id + '"' +
                    'class="element-li-item w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">' +
                    element.title + '</li>';


            });

            $('.lista-item').eq(key).html(html);


            setTimeout(() => {
                $('.lista-item').eq(key).addClass("hidden"); 
            }, 2000);

        },

    });

}

$(document).on('click', '.element-li-item', function() {



    let parent = $('.element-li-item').parent().parent().parent().parent()
    let lista = $('.element-li-item').parent()



    $(lista).empty();

    $(lista).addClass("hidden");



    

    $.ajax({

        url: '/ajax/products/' + $(this).data('id'),

        type: 'GET',

        dataType: 'json',

        success: function(response) {

            autocompleteFormItems(parent,response)

        },

    });

});



function autocompleteFormItems(parent,response) {

    console.log("PADREee",parent)

    var inputs = parent.find('input');

    console.log("PADREee",inputs)


    inputs.each(function() {
        var input = $(this);
        if (input.hasClass('price')) {
          input.val((response.price/100))
        }
        if (input.hasClass('quantity')) {
          input.val(1)

        }
        if (input.hasClass('title')) {
          input.val(response.title)

        }
        if (input.hasClass('id-item')) {
          input.val(response.id)

        }

        if (input.hasClass('subtotal')) {

          input.val((response.price/100))

        }
    });

    updateTotalMenu()



}



</script>