<?php

$user = Intratum\Facturas\Util::getSessionUser();
$profile = Intratum\Facturas\User::getUserAccount($user["id"]);

Intratum\Facturas\Util::checkSession();
$title = "Editar";

$allSerials = Intratum\Facturas\Serial::all();

$allTax = Intratum\Facturas\Tax::all();

$item = $_GET['item'];

$id2 = Intratum\Facturas\Util::getID2ByUUID("inv_", $item);

$invoice = Intratum\Facturas\Factura::get($params = ["id2" => $id2]);

$db2 = Intratum\Facturas\Environment::$db;

?>

<form action="lib/add_producto.php" id="form" class="mt-5" method="update">


<div class="border-[1px] my-5 rounded-lg flex flex-col justify-center gap-[5%]  mx-[18%]">
        <div class="grid grid-cols-2 pt-10 bg-gray-100 px-[35px] pb-5">
            <div>


                <div class=" pl-10 flex flex-col justify-between h-full">

                    <div class=" flex  items-center  w-full">
                        <?php if ($_SERVER['SERVER_PORT'] == '80') {?>
                            <img class="w-64" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if($profile["hash_logo"] != ""){ echo $profile["hash_logo"]; }else{ echo "default.png"; }?>" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '443') {?>
                            <img class="w-64" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if($profile["hash_logo"] != ""){ echo $profile["hash_logo"]; }else{ echo "default.png"; }?>" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '8086') {?>
                            <img class=" w-[50%] object-cover" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?php if($profile["hash_logo"] != ""){ echo $profile["hash_logo"]; }else{ echo "default.png"; }?>" alt="Logo" />
                        <?php }?>
                    </div>

                        <div>
                            <p class="text-[20px] font-[600]">Datos fiscales</p>
                            <p><?=$profile["first_name"]?> &nbsp; <?=$profile["last_name"]?></p>
                            <p><?=$profile["NIF"]?></p>
                            <p><?=$profile["address1"]?></p>
                            <p><?=$profile["country"]?><?=", ".$profile["state"]?><?=", ".$profile["city"]?><?=" ".$profile["zip"]?></p>
                            <p><?=$profile["email"]?></p>
                            <p><?=$profile["phone"]?></p>
                            



                        </div>



                </div>
            </div>

            <div>
                <h2 class="mb-2  font-[600] col-span-2 text-[20px]">Datos del receptor</h2>
                <div class="grid grid-cols-3 gap-5">
                    <div id="div-responsive-1" class="mb-2 relative">
                        <!-- nombre particular  -->
                        <label id="nombre-particular" for="first_name"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <!-- nombre fiscal  -->
                        <label for="first_name" id="nombre-fiscal"
                        class=" hidden !col-span-2  mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>
                        <input value="<?=$invoice["first_name"]?>" type="text" id="searchAccount" name="first_name" class="!col-span-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Nombre" required />
                        <div class="absolute top- left-0">
                        <ul id="lista"
                            class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </ul>
                        </div>
                    </div>
                    <input type="hidden" id="cust-id" name="cust-id" value="<?=$invoice["issuer_id"]?>">
                    
                    <div id="campo-apellidos" class="mb-2">
                        <label for="last_name"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                        <input value="<?=$invoice["last_name"]?>" type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Apellidos" />
                    </div>
                    <div>
                        <label for="email" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                        <input value="<?=$invoice["email"]?>" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="correo@email.com" required="">
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                        <input value="<?=$invoice["phone"]?>"  type="tel" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="000-000-000" required="">
                    </div>
                    <div class="mb-2">
                        <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 1
                        *</label>
                        <input value="<?=$invoice["address1"]?>"  type="text" id="address_1" name="address_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Direccion 1" required />
                    </div>
                    <div class="mb-2">
                        <label for="address_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección
                        2</label>
                        <input value="<?=$invoice["address2"]?>"  type="text" id="address_2" name="address_2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Direccion 1" />
                    </div>
                    <div class="mb-2">
                        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo
                        postal</label>
                        <input  value="<?=$invoice["zip"]?>"  type="number" id="zip" name="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Codigo postal" />
                    </div>
                    <div class="mb-2">
                        <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
                        <input  value="<?=$invoice["country"]?>"  type="text" id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="País" required />
                    </div>
                    <div class="mb-2">
                        <label for="state"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
                        <input value="<?=$invoice["state"]?>"  type="text" id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Provincia" required />
                    </div>
                    <div class="mb-2">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
                        <input  value="<?=$invoice["city"]?>"  type="text" id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="Ciudad" required />
                    </div>
                    <input type="hidden" name="type"  value="<?=$invoice["type"]?>" >
                    <input id="autoComp" type="hidden" name="autoComp" value="false">
                    <div class="mb-2">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
                        cliente</label>
                        <select  value="<?=$invoice["category"]?>" onchange="selectCategory(this)" name="category" id="category"
                        class="block w-full py-1.5 px-2.5 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="f">Cliente Fiscal</option>
                        <option selected="selected" value="p">Cliente Particular</option>
                        </select>
                    </div>
                    <div class="mb-">
                        <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>
                        <input  value="<?=$invoice["NIF"]?>" type="text" id="NIF" name="NIF" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-1.5 px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                        dark:focus:border-blue-500" placeholder="CIF / DNI" required />
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






            <div class="flex flex-row gap-5">
               <input type="hidden" id="id-item">
               <div class="mb-5 w-full min-w-[10%] relative">
                  <label for="item"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>
                  <input type="text" id="autocomp-item" name="item" class="h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Item" />
                  <div class="absolute top- left-0">
                     <ul id="lista-item" class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                     </ul>
                  </div>
               </div>
               <div class="mb-5 min-w-[35%]">
                  <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                  <input type="text" id="description" name="description" class="h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción del producto">
               </div>
               <div class="mb-5 min-w-[10%]">
                  <label for="price"
                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                  <input type="number" id="price" name="price" class="h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0.00" step="0.01" />
               </div>
               <div class="mb-5 min-w-[10%]">
                  <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                  <input type="number" id="quantity" name="quantity" class="h-[40%] py-4 px-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="X" value="" />
               </div>
               <div class="mb-5 flex flex-col w-full">
               <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impuestos</label>

                <button id="boton-tax" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class=" text-sm rounded-lg  py-1.5 px-6 bg-black text-white hover:bg-opacity-80 transition-all" type="button">
                    Añadir 
                </button>
               </div>

               <div class="mb-5  ">
                   <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Añadir</label>

                    <button type="button" id="add-item-btn" onclick="addItem()"  class="font-[900] text-sm rounded-lg flex py-1.5 px-6 bg-black text-white hover:bg-opacity-80 transition-all" >                
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 12L12 12M12 12L17 12M12 12V7M12 12L12 17" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>

               </div>

        <div id="lineitems">

            <?php
            $db2->where('invoice_id', $invoice["id"]);
            $results = $db2->get('invoice_item');

            $taxs_id = [];

            $contador = 0;

            $invoice_taxs = [];

            $subtotalInvoice = 0;

            foreach ($results as $i) {
                $db2->where('id', $i["id_item"]);

                $item = $db2->get('product');

                $subtotalItem = $i["quantity"] * $item[0]["price"];

                $subtotalInvoice = $subtotalInvoice + $subtotalItem / 100;

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][type]" value="' . $item[0]["title"] . '">';

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][id]" value="' . $item[0]["id"] . '">';

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][description]" value="' . $item[0]["description"] . '">';

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][price]" value="' . $item[0]["price"] / 100 . '">';

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][quantity]" value="' . $i["quantity"] . '">';

                echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][subtotal]" value="' . $subtotalItem / 100 . '">';

                $contador_taxs = 0;

                $db2->where('invoice_item_id', $i["id"]);
                $taxs_id = $db2->get('invoice_item_tax');

                foreach ($taxs_id as $key) {
                    $db2->where('id', $key["tax_id"]);
                    $tax_item = $db2->get('tax');
                    echo '<input class="hidden_item_' .
                        $contador .
                        '" type="hidden" name="items[' .
                        $contador .
                        '][tax_' .
                        $contador_taxs .
                        ']" value="' .
                        $tax_item[0]["type"] .
                        '/' .
                        $tax_item[0]["name"] .
                        '/' .
                        $tax_item[0]["value"] .
                        '/' .
                        $tax_item[0]["id2"] .
                        '">';
                    $contador_taxs += 1;
                }

                $contador = $contador + 1;
            }
            ?>
        </div>

    </div>


            <div id="itemTable" class="flex flex-col w-full mt-5">
        <div class="font-[600] grid grid-cols-7 border-[1px] rounded-lg py-2 px-5 gap-5 w-full mt-5 justify-around">
            <p class="w-full">Item</p>
            <p class="w-full">Descripción</p>
            <p class="w-full">Precio</p>
            <p class="w-full">Cantidad</p>
            <p class="w-full">Subtotal</p>
            <p class="w-full">Impuestos</p>
            <p class="w-full">Eliminar</p>
        </div>

        <div class="flex flex-col w-full mt-5" id="itemTableBody">



            <?php
            $calcTaxs = [];
            $aftertax = [];
            $aftertaxOk = [];
            $total = 0;
            $subtotal = 0;

            $db2->where('invoice_id', $invoice["id"]);

            $results = $db2->get('invoice_item');

            $contador = 0;

            foreach ($results as $i) {
                $db2->where('id', $i["id_item"]);

                $item = $db2->get('product');

                $subtotal = $subtotal + $i["subtotal"];

                $listaTaxs = "";

                $db2->where('invoice_item_id', $i["id"]);
                $taxs_id = $db2->get('invoice_item_tax');

                $encontrado = false;

                foreach ($taxs_id as $key) {
                    $db2->where('id', $key["tax_id"]);
                    $tax_item = $db2->get('tax');

                    $itemTax = [
                        "name" => $tax_item[0]["name"],
                        "type" => $tax_item[0]["type"],
                        "tax_total" => $i["subtotal"] * ($tax_item[0]["value"] / 100),
                        "id" => $tax_item[0]["id2"],
                    ];

                    $total = $total + $itemTax["tax_total"];

                    $exist = false;
                    $itemIndex = "";

                    foreach ($calcTaxs as $index => $key) {
                        if ($key["id"] == $itemTax["id"]) {
                            $exist = true;
                            $itemIndex = $index;
                        }
                    }

                    if ($exist) {
                        $calcTaxs[$itemIndex]["tax_total"] += $itemTax["tax_total"];
                    } else {
                        $calcTaxs[] = $itemTax;
                        $aftertax_item = [
                            "id" => $tax_item[0]["id2"],
                            "name" => $tax_item[0]["name"],
                            "value" => $tax_item[0]["value"],
                            "type" => $tax_item[0]["type"],
                        ];
                        $aftertax[] = $aftertax_item;
                    }

                    $listaTaxs = $listaTaxs . "<li>" . $tax_item[0]["name"] . " " . $tax_item[0]["value"] . "%</li>";
                    $contador_taxs += 1;
                }

                echo '<div class="hidden_item_'. $contador . ' font-[400] grid grid-cols-7 border-[1px] rounded-lg py-2 px-5 gap-5 w-full mt-5 justify-around">'. 
                
                '<p class="hidden_item_' . $contador . '  w-full">' . $item[0]["title"] . '</p>';

                echo '<p class="hidden_item_' . $contador . '  w-full">' . $item[0]["description"] . '</p>';

                echo '<p class="hidden_item_' . $contador . '  w-full">' . $item[0]["price"] / 100 . '</p>';

                echo '<p class="hidden_item_' . $contador . '  w-full">' . $i["quantity"] . '</p>';

                echo '<p class="hidden_item_' . $contador . '  w-full">' . ($i["quantity"] * $item[0]["price"]) / 100 . '</p>';

                echo '<div class="hidden_item_' . $contador . '  w-full"><ul>' . $listaTaxs . '</ul></div>';

                echo '<div class="hidden_item_' . $contador . '   w-full">';

                echo '<button onclick="removeListItem(' .
                    $contador .
                    ')" type="button" class="mt-0 p-3 w-[100%] text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm   ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg><span class="sr-only">Close</span></button></div></div>';

                $contador = $contador + 1;
            }
            ?>

        </div>
    </div>


</div>


<div id="total-div" class="text-[20px]  flex items-end flex-col col-span-3">

    <div class="min-w-[20%]">

        <div class="flex gap-[10px]">

        <h2 class="font-[600]" >Subtotal</h2>

            <h2 id="subtotal"><?= round($invoice["subtotal"] / 100, 2) ?> €</h2>

        </div>

        <hr class="w-full h-[2px] bg-[#362faa] border-0 rounded dark:bg-gray-700">

        <ul id="totalMenu">
        <?php foreach ($calcTaxs as $key) { ?>
            <li><?= $key["name"] ?> -> <?= $key["tax_total"] ?> €</li>
        <?php } ?>
        </ul>

        <hr class="w-full h-[2px] bg-[#362faa] border-0 rounded dark:bg-gray-700">

        <div>

            <h2 class="font-[600]" >Total</h2>

            <h2 id="total"><?= $invoice["total"] / 100 ?> €</h2>

        </div>

    </div>

</div>

</div>

        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->
        <div class="min-w-[15%] bg-gray-100 px-[35px] pb-5">
         <h2 class="pt-10  font-[600] text-[20px] mb-5">Detalles</h2>
            <div class="flex gap-5 w-full mb-10">
                <div class="w-[60%]">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terminos y
                    condiciones</label>
                    <textarea name="terms" value="" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                    dark:focus:border-blue-500" placeholder="Escriba aquí..."><?=$invoice["invoice_terms"]?></textarea>
                </div>
                <div class="flex flex-col justify-around w-[40%]">
                    <?php if ($invoice["type"] == "1") {?>

                    <div class="">

                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial y
                            numero de factura</label>

                        <div class="flex ">

                            <select onchange="" value="<?=$invoice["serial_id"]?>" name="invoice_serial"
                                id="select_serials" class="w-[30%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white

                            dark:focus:ring-primary-500 dark:focus:border-primary-500">

                                <?php foreach ($allSerials as $i) {?>

                                <option value="<?=$i["id"]?>"><?=$i["serial_tag"]?></option>

                                <?php }?>

                            </select>

                            <input type="number" value="<?=$invoice["invoice_number"]?>" name="invoice_number"
                                id="invoice_number" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                            dark:focus:border-blue-500">

                        </div>

                    </div>

                    <?php } else {?>

                    <div class="mb-10">

                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero
                            gasto</label>

                        <div class="flex mb-10">

                            <input type="text" name="name" id="name" value="<?=$invoice["name"]?>" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                                dark:focus:border-blue-500">

                        </div>

                        <input type="hidden" name="invoice_serial" value="0">

                        <input type="hidden" name="invoice_number" value="0">

                    </div>

                    <?php }?>
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
                        <input datepicker datepicker-title="Fecha de facturación" value="<?php echo date('m-d-Y'); ?>"
                            name="invoice_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Selecciona una fecha">
                        </div>
                    </div>
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



   </div>



</form>



<!-- ############################################################################################################################################################################ -->

<!-- ############################################################################################################################################################################ -->

<!-- ############################  MODAL ############################ -->

<!-- Main modal -->

<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-md max-h-full">

        <!-- Modal content -->

        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <!-- Modal header -->

            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">

                    Añadir 

                </h3>

                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal">

                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
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
                    <select name="select_tax" id="select_tax"
                        class="block  p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <?php foreach ($allTax as $tax): ?>
                        <option value="<?=$tax['type']?>/<?=$tax['name']?>/<?=$tax['value']?>/<?=$tax['id2']?>"
                            class="py-2">
                            <?=$tax['name']?> / <?=$tax['value']?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </div>

                <button onclick="addTax()"
                    class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg py-2 text-sm px-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Añadir +
                </button>
            </div>

        </div>

    </div>

</div>

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

<!-- ############   FORMULARIO FACTURA ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->







<script>

$(document).ready(function() {


    addTaxText()

    $('#form').submit(function(e) {

        e.preventDefault();

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
                        window.location.href = '/gastos/';
                    } else if (<?php echo $invoice["type"]; ?> == 2) {
                        window.location.href = '/presupuestos/';
                    } else {
                        window.location.href = '/facturas/';
                    }




                }if (d.success == false && d.errors) {

                    setNotification(d.errors)

                }

            }

        });

    });

});

function selectCategory(item) {

    if ($(item).val() == 'f') {

        $("#nombre-fiscal").removeClass("hidden")

        $("#nombre-particular").addClass("hidden")

        $("#div-responsive-1").addClass("col-span-2")

        $("#campo-apellidos").addClass("hidden")

    } else {

        $("#nombre-particular").removeClass("hidden")

        $("#nombre-fiscal").addClass("hidden")

        $("#campo-apellidos").removeClass("hidden")

        $("#div-responsive-1").removeClass("col-span-2")

    }
}

var aftertax =<?=json_encode($aftertax)?>;

var keyitems = <?=count($results)?>;

var invoice_taxs = [];

var invoice_subtotal = (<?=$invoice["subtotal"]?>/100);

var invoice_total = (<?=$invoice["total"]?>/100);

var calcTaxs = <?=json_encode($calcTaxs)?>


function addTax() {


    let tax = $("#select_tax").val().split("/");
    let itemTax = {
        name: tax[1],
        type: tax[0],
        value: tax[2],
        id: tax[3],

    }

    let taxValid = checkTaxs(itemTax.type);

    if (taxValid) {

        aftertax.push(itemTax)


        addTaxText()
        
    } else {

        errors = [{
            "error":"repeat_tax",
            "message":"No puedes añadir dos impuestos del mismo tipo.",
        }]
        setNotification(errors)

    }

}

function checkTaxs(type) {
    let valid = true;

    aftertax.forEach(element => {

        if (element.type.toString() == type.toString()) {
            valid = false;
        }
    });
    return valid
}

function addTaxText() {

    let boton = document.getElementById("boton-tax");
    let listaTax = document.getElementById("lista-modal-taxs");
    listaTax.innerHTML = "";
    let buttonTitle = "<ul>";

    aftertax.forEach(element => {

        if (true) {
            buttonTitle += "<li>" + element.name + " / " + element.value + "</li>";

            let listItem = document.createElement("li");

            listItem.textContent = element.name + " / " + element.value;
            listItem.id = ("tax-" + element.type);
            listItem.classList.add("flex", "text-center", "items-center", "justify-center", "border-b-2",
                "border-gray-200", "py-2", "gap-[50%]");
            let deleteButton = document.createElement("button");
            deleteButton.textContent = "Eliminar";
            deleteButton.classList.add("bg-red-500", "text-white", "px-4", "py-1", "rounded", "hover:bg-red-600",
                "focus:outline-none", "focus:ring-2", "focus:ring-red-600", "focus:ring-opacity-50");
            deleteButton.addEventListener("click", function() {
                deleteItemTax(listItem);
            });

            listItem.appendChild(deleteButton);

            listaTax.appendChild(listItem);
        }
    });

    buttonTitle += "</ul>";

    if (aftertax.length != 0) {
        boton.innerHTML = buttonTitle;
    } else {
        boton.innerHTML = "Añadir";
    }

}

function deleteItemTax(e) {

    let itemId = e.id
    let ul = e.parentNode;
    ul.removeChild(e);

    aftertax.forEach((element, index) => {
        let type = element.type;
        let id = e.id;

        if ((type == 1 && id == "tax-1") || (type == 0 && id == "tax-0")) {
            aftertax.splice(index, 1);
        }

    });

    addTaxText()
}

function addItem() {


    var item = $('#autocomp-item').val();

    var description = $('#description').val();

    var price = $('#price').val();

    var quantity = $('#quantity').val();

    var id_item = $('#id-item').val();

    if (item != "" && quantity != "") {

        let subtotal = price * quantity

        invoice_subtotal += subtotal

        var lista = 0;



        var taxesList = '<ul>';

        aftertax.forEach(tax => {


            taxesList += '<li>' + tax.name + '  ' + tax.value + '%</li>';

        });

        taxesList += '</ul>';
        var newRow = '<div  class="hidden_item_' + keyitems + ' font-[400] grid grid-cols-7 border-[1px] rounded-lg py-2 px-5 gap-5 w-full mt-5 justify-around">'+

            '<p class="hidden_item_' + keyitems + ' w-full">' + item + '</p>' +

            '<p class="hidden_item_' + keyitems + ' w-full">' + description + '</p>' +

            '<p class="hidden_item_' + keyitems + ' w-full">' + price + '</p>' +

            '<p class="hidden_item_' + keyitems + ' w-full">' + quantity + '</p>' +

            '<p class="hidden_item_' + keyitems + ' w-full">' + subtotal + '</p>' +

            '<div class="hidden_item_' + keyitems + ' w-full">' + taxesList + '</div>' +

            '<p class="hidden_item_' + keyitems + ' w-full">' +

            '<button onclick="removeListItem(' + keyitems +
            ')" type="button" class="mt-0 p-3 w-[100%] text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm   ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg><span class="sr-only">Close</span></button>'

        '</p>'+'</div>' ;

        $('#itemTableBody').append(newRow);

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][type]" value="' + item + '">');

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][id]" value="' + id_item + '">');

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][description]" value="' + description + '">');

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][price]" value="' + price + '">');

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][quantity]" value="' + quantity + '">');

        $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' + keyitems +
            '][subtotal]" value="' + subtotal + '">');

        aftertax.forEach(element => {
            $('#lineitems').append('<input class="hidden_item_' + keyitems + '" type="hidden" name="items[' +
                keyitems + '][tax_' + element.type + ']" value="' + element.type + "/" + element.name +
                "/" + element.value + "/" + element.id + '">');

        });

        $('#autocomp-item').val("");

        $('#description').val("");

        $('#price').val("");

        $('#id_item').val("");

        $('#quantity').val("");

        keyitems++;

        aftertax.forEach(element => {

            let existe = calcTaxs.findIndex(elemento => elemento.id == element.id);
            if (existe == -1) {
                invoiceTax = {
                    id: element.id,
                    name: element.name,
                    tax_value: element.value,
                    tax_total: ((element.value / 100) * subtotal),
                }
                calcTaxs.push(invoiceTax)
            } else {
                calcTaxs[existe].tax_total += ((element.value / 100) * subtotal)
            }
        });

        updateTotalMenu();

    }

}

function updateTotalMenu() {

    if ($("#total-div").hasClass("hidden")) {

        $("#total-div").removeClass("hidden")

    }

    $("#totalMenu").empty();
    console.log("calculados",calcTaxs)
    calcTaxs.forEach(element => {

        if (element.tax_total != 0) {
            $('#totalMenu').append('<li>' + element.name + ' -> ' + (element
                    .tax_total).toFixed(2) +
                '€</li>');

        }

    });

    $("#subtotal").text(invoice_subtotal.toFixed(2) + "€")

    invoice_total = invoice_subtotal;

    var tex_total2 = 0;
    calcTaxs.forEach(element => {

        tex_total2 += element.tax_total;

    });
    tex_total2 = tex_total2.toFixed(2)


    let finalTotal = (invoice_total + parseFloat(tex_total2))

    $("#total").text(finalTotal.toFixed(2) + "€")

    if (invoice_total == 0) {

        $("#total-div").addClass("hidden")

    }

}

// <!-- ############################################################################################################################################################################ -->

// <!-- ############ FORMULARIO IMPUESTOS (MODAL) ########################################################################################################################################################## -->

// <!-- ############################################################################################################################################################################ -->
</script>
<!-- ############################################################################################################################################################################ -->

<!-- ############ AUTOCOMPLETADO CLIENTES FACTURA ########################################################################################################################################################## -->

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

            $.each(response, function(index, element) {

                $('#lista').append('<li data-id="' + element.id + '"' +
                    'class="element-li w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">' +
                    element.email + '</li>');

            });

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


    $('#NIF').val(response.NIF);

    $('#searchAccount').val(response.first_name);

    $('#last_name').val(response.last_name);

    $('#email').val(response.email);

    $('#phone').val(response.phone);

    $('#address_1').val(response.address1);

    $('#address_2').val(response.address2);

    $('#zip').val(response.zip);

    $('#country').val(response.country);

    $('#state').val(response.state);

    $('#city').val(response.city);

    $('#category').val(response.category);

    $('#cust-id').val(response.id);

    $('#autoComp').val(true);

}
</script>

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

<!-- ############################################################################################################################################################################ -->

<!-- ############ AUTOCOMPLETADO ITEMS ########################################################################################################################################################## -->

<!-- ############################################################################################################################################################################ -->

<script>
var delay = 200;

var timerId;

$("#autocomp-item").eq(0).bind("keyup paste", function() {

    clearTimeout(timerId);

    var value = $(this).val();

    timerId = setTimeout(function() {

        after = null;

        initLoad = true;

        searchItem(value);

    }, delay);

});

function searchItem(value) {

    $.ajax({

        url: '/ajax/products',

        type: 'GET',

        dataType: 'json',

        data: {

            q: value

        },

        success: function(response) {

            $('#lista-item').empty();

            $('#lista-item').removeClass("hidden");

            $.each(response, function(index, element) {

                $('#lista-item').append('<li data-id="' + element.id + '"' +
                    'class="element-li-item w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">' +
                    element.title + '</li>');
            });

        },

    });

}

$(document).on('click', '.element-li-item', function() {

    $('#lista-item').empty();

    $('#lista-item').addClass("lista-item");

    $.ajax({

        url: '/ajax/products/' + $(this).data('id'),

        type: 'GET',

        dataType: 'json',

        success: function(response) {

            autocompleteFormItems(response)
        },

    });

});

function autocompleteFormItems(response) {

    $('#autocomp-item').val(response.title);

    $('#description').val(response.description);

    $('#price').val(response.price / 100);

    $('#id-item').val(response.id);

    $('#quantity').val(1);

}

function removeListItem(index) {

    let itemSubtotalClass = ".hidden_item_" + index + "[name='items[" + index + "][subtotal]']"

    let subTotalItem = $(itemSubtotalClass).val() //Sub total calculado (ej. 399.9)

    console.log(calcTaxs)
    console.log(aftertax)

    aftertax.forEach(element => {
        let existe = calcTaxs.findIndex(elemento => elemento.id == element.id);

        if (calcTaxs[existe].tax_total != 0) {

            if (existe == -1) {
                invoiceTax = {
                    id: element.id,
                    name: element.name,
                    tax_value: element.value,
                    tax_total: ((element.value / 100) * subtotal),
                }
                calcTaxs.push(invoiceTax)
            } else {

                calcTaxs[existe].tax_total = Math.abs(calcTaxs[existe].tax_total) - ((Math.abs(element.value) / 100) * subTotalItem);

            }
        }
    });

    invoice_subtotal = invoice_subtotal - subTotalItem;

    updateTotalMenu();

    $(".hidden_item_" + index).remove();

}


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
</script>