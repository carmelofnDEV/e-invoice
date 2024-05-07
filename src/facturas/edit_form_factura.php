<?php

Intratum\Facturas\Util::checkSession();

$allSerials = Intratum\Facturas\Serial::all();

$allTax = Intratum\Facturas\Tax::all();

?>





<?php

$item = $_GET['item'];

$id2 = Intratum\Facturas\Util::getID2ByUUID("inv_", $item);

$invoice = Intratum\Facturas\Factura::get($params = ["id2" => $id2]);


?>







<?php

$db2 = Intratum\Facturas\Environment::$db;

?>





<form action="lib/add_producto.php" id="form" class="mt-5" method="update">

    <div class="flex flex-col lg:flex-row justify-center gap-[5%] px-[35px]">



        <input type="hidden" name="id_invoice" value="<?=$invoice["id"]?>">



        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <h2 class="text-center font-[600] text-[20px]">Datos del cliente</h2>

            <div></div>

            <div id=" div-responsive-1" class="mb-5 relative">

                <!-- nombre particular  -->

                <label id="nombre-particular" for="first_name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>

                <!-- nombre fiscal  -->

                <label for="first_name" id="nombre-fiscal"
                    class=" hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>



                <input type="text" id="searchAccount" name="first_name" value="<?=$invoice["first_name"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Nombre" required />



                <div class="absolute top- left-0">

                    <ul id="lista"
                        class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    </ul>

                </div>

            </div>



            <input type="hidden" id="cust-id" name="cust-id" value="<?=$invoice["id"]?>">



            <div id="campo-apellidos" class="mb-5">

                <label for="last_name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>

                <input type="text" id="last_name" name="last_name" value="<?=$invoice["last_name"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Apellidos" />

            </div>



            <div>

                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>

                <input type="email" name="email" id="email" value="<?=$invoice["email"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="correo@email.com" required="">

            </div>



            <div>

                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>

                <input type="tel" name="phone" id="phone" value="<?=$invoice["phone"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="000-000-000" required="">

            </div>



            <div class="mb-5">

                <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 1

                    *</label>

                <input type="text" id="address_1" name="address_1" value="<?=$invoice["address1"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Direccion 1" required />

            </div>



            <div class="mb-5">

                <label for="address_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección

                    2</label>

                <input type="text" id="address_2" name="address_2" value="<?=$invoice["address2"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Direccion 1" />

            </div>



            <div class="mb-5">

                <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo

                    postal</label>

                <input type="number" id="zip" name="zip" value="<?=$invoice["zip"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Codigo postal" />

            </div>



            <div class="mb-5">

                <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>

                <input type="text" id="country" name="country" value="<?=$invoice["country"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="País" required />

            </div>



            <div class="mb-5">

                <label for="state"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>

                <input type="text" id="state" name="state" value="<?=$invoice["state"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Provincia" required />

            </div>



            <div class="mb-5">

                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>

                <input type="text" id="city" name="city" value="<?=$invoice["city"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Ciudad" required />

            </div>



            <input type="hidden" name="type" value="<?=$invoice["type"]?>">

            <input id="autoComp" type="hidden" name="autoComp" value="false">





            <div class="mb-5">

                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de

                    cliente</label>

                <select onchange="selectCategory(this)" name="category" id="category" value="<?=$invoice["category"]?>"
                    class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required>

                    <option value="f">Cliente Fiscal</option>

                    <option selected="selected" value="p">Cliente Particular</option>

                </select>

            </div>



            <div class="mb-5">

                <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>

                <input type="text" id="NIF" name="NIF" value="<?=$invoice["NIF"]?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="CIF / DNI" required />

            </div>

        </div>



        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->



        <div class="grid grid-cols-3 gap-5 mt-[50px] lg:mt-0">

            <div class="flex flex-col col-span-3">

                <h2 class="text-center font-[600] text-[20px] mb-5 col-span-3">Datos de la factura</h2>



                <div class="flex flex-row gap-5">

                    <input type="hidden" id="id-item">

                    <div class="mb-5 min-w-[10%] relative">

                        <label for="item"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item</label>

                        <input type="text" id="autocomp-item" name="item" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Item" />



                        <div class="absolute top- left-0">

                            <ul id="lista-item"
                                class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                            </ul>

                        </div>

                    </div>



                    <div class="mb-5 min-w-[35%]">

                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>

                        <textarea type="number" id="description" name="description" class="h-[50%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="Descripción del producto"></textarea>

                    </div>



                    <div class="mb-5 min-w-[10%]">

                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>

                        <input type="number" id="price" name="price" class="h-[50%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="0.00" step="0.01" />

                    </div>



                    <div class="mb-5 min-w-[10%]">

                        <label for="quantity"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>

                        <input type="number" id="quantity" name="quantity" class="h-[50%] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                dark:focus:border-blue-500" placeholder="X" value="" />

                    </div>



                    <div class="mb-5 flex justify-center items-center">

                        <button id="boton-tax" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                            class="min-w-[100px] text-[12px] text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg py-2 px-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">

                            Añadir impuesto

                        </button>

                    </div>



                    <div class="mb-5 min-w-[1px] border-[2px] border-[#362faa]">

                    </div>



                    <div class="mb-5">

                        <label for="tax"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Añadir</label>

                        <input type="button" id="add-item-btn" onclick="addItem()" value="+" class="font-[900] text-center text-[20px] bg-[#8cce79] border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400

                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

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

    $subtotalItem = $i["quantity"] * ($item[0]["price"]);

    $subtotalInvoice = $subtotalInvoice + ($subtotalItem / 100);

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
        echo '<input class="hidden_item_' . $contador . '" type="hidden" name="items[' . $contador . '][tax_' . $contador_taxs . ']" value="' . $tax_item[0]["type"] . '/' . $tax_item[0]["name"] . '/' . $tax_item[0]["value"] . '/' . $tax_item[0]["id2"] . '">';
        $contador_taxs += 1;
    }

    $contador = $contador + 1;

}

?>



                    </div>









                </div>

                <hr class="p-0 w-full h-1 mx-auto bg-[#362faa] border-0 rounded dark:bg-gray-700">

                <table id="itemTable" class="border-collapse w-full mt-5">

                    <thead>

                        <tr>

                            <th class="border border-gray-400 px-4 py-2">Item</th>

                            <th class="border border-gray-400 px-4 py-2">Descripción</th>

                            <th class="border border-gray-400 px-4 py-2">Precio</th>

                            <th class="border border-gray-400 px-4 py-2">Cantidad</th>

                            <th class="border border-gray-400 px-4 py-2">Subtotal</th>



                            <th class="border border-gray-400 px-4 py-2">Impuestos</th>

                            <th class="border border-gray-400 px-4 py-2">Eliminar </th>





                        </tr>

                    </thead>

                    <tbody id="itemTableBody">



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
            "tax_total" => ($i["subtotal"] * ($tax_item[0]["value"] / 100)),
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

    echo '<tr><td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2">' . $item[0]["title"] . '</td>';

    echo '<td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2">' . $item[0]["description"] . '</td>';

    echo '<td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2">' . $item[0]["price"] / 100 . '</td>';

    echo '<td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2">' . $i["quantity"] . '</td>';

    echo '<td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2">' . $i["quantity"] * $item[0]["price"] / 100 . '</td>';

    echo '<td class="hidden_item_' . $contador . ' border border-gray-400 px-4 py-2"><ul>' . $listaTaxs . '</ul></td>';

    echo '<td class="hidden_item_' . $contador . '  justify-center border border-gray-400  px-4 py-2">';

    echo '<button onclick="removeListItem(' . $contador . ')" type="button" class="mt-0 p-3 w-[100%] text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm   ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg><span class="sr-only">Close</span></button></td></tr>';

    $contador = $contador + 1;

}

?>



                    </tbody>

                </table>





            </div>



            <div id="total-div" class=" text-[20px] flex items-end flex-col col-span-3">

                <div class="min-w-[20%]">

                    <div class="flex gap-[10px]">

                        <h2>Subtotal</h2>

                        <h2 id="subtotal"><?=round(($invoice["subtotal"] / 100), 2)?> €</h2>



                    </div>

                    <hr class="w-full h-[2px] bg-[#362faa] border-0 rounded dark:bg-gray-700">

                    <ul id="totalMenu">
                    <?php foreach ($calcTaxs as $key) {?>
                        <li><?=$key["name"]?> -> <?=$key["tax_total"]?> €</li>
                    <?php }?>
                    </ul>

                    <hr class="w-full h-[2px] bg-[#362faa] border-0 rounded dark:bg-gray-700">

                    <div>

                        <h2>Total</h2>

                        <h2 id="total"><?=$invoice["total"] / 100?> €</h2>

                    </div>



                </div>

            </div>

        </div>



        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->

        <!-- ############################################################################################################################################################################ -->



        <div class="min-w-[15%] mt-[50px] lg:mt-0">

            <h2 class="text-center font-[600] text-[20px] mb-5">Datos de la factura</h2>



            <div class="mb-10">

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terminos y

                    condiciones</label>

                <textarea name="terms" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500

                 dark:focus:border-blue-500" placeholder="Escriba aquí..."><?=$invoice["invoice_terms"]?></textarea>

            </div>



            <?php if ($invoice["type"] == "1") {?>

            <div class="mb-10">

                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial y
                    numero de factura</label>

                <div class="flex mb-10">



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







            <div class="mb-10">

                <label for="invoice_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de
                    facturación</label>

                <div class="relative max-w-sm">

                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">

                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">

                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />

                        </svg>

                    </div>

                    <input datepicker datepicker-title="Fecha de facturación" value="<?= date('d/m/Y', strtotime($invoice["invoice_date"]))?>"
                        name="invoice_date" type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Selecciona una fecha">



                </div>

            </div>



        </div>



    </div>

    <!-- ############################################################################################################################################################################ -->

    <!-- ############################################################################################################################################################################ -->

    <!-- ############################################################################################################################################################################ -->

    <!-- ################ SUBMIT ################ -->

    <div class="flex justify-center">

        <button type="submit"
            class="text-white text-[20px] font-[600] bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>

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

                    Añadir impuesto

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

                    exit();



                }

            }

        });





    });

});




function recalcular(){


}

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
        alert("No puedes añadir dos impuestos del mismo tipo.");
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
        boton.innerHTML = "Añadir impuesto";
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



        var newRow = '<tr>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + item + '</td>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + description + '</td>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + price + '</td>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + quantity + '</td>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + subtotal + '</td>' +

            '<td class="hidden_item_' + keyitems + ' border border-gray-400 px-4 py-2">' + taxesList + '</td>' +

            '<td class="hidden_item_' + keyitems + '  justify-center border border-gray-400  px-4 py-2">' +

            '<button onclick="removeListItem(' + keyitems +
            ')" type="button" class="mt-0 p-3 w-[100%] text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm   ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"> <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg><span class="sr-only">Close</span></button>'

        '</td>' +

        '</tr>';







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

      //  invoice_total = invoice_total + parseFloat(element.tax_total)

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



// function removeListItem(index) {

//     $(".hidden_item_" + index).remove();

// }
</script>