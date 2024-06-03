<?php
Intratum\Facturas\Util::checkSession();
$title = "Editar cliente";
?>

<?php
$item = $_GET['item'];
$id2 = Intratum\Facturas\Util::getID2ByUUID("cust_",$item);
$customer = Intratum\Facturas\Customer::get($params = ["id2"=>$id2]);
?>


<div class="pt-[10%]">
    <h2 class="text-center font-[600] text-[20px] mb-2">Editar</h2>

    <div class="flex justify-center ">

        <form action="lib/add_producto.php" id="form" method="post" class="flex grid grid-cols-2 gap-5 p-10 border-[1px] rounded-xl">

        <div class="flex gap-5">


                <div id="div-responsive-1" class="mb-5 relative ">
                    <!-- nombre particular  -->
                    <label id="nombre-particular" for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>

                    <!-- nombre fiscal  -->
                    <label for="name" id="nombre-fiscal" class=" hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>

                    <input type="text" id="searchAccount" value="<?=$customer["first_name"]?>" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombre" required />

                    <div class="absolute top- left-0 ">
                        <ul id="lista" class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </ul>
                    </div>
                </div>

                
                <div id="campo-apellidos" class="mb-5">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                    <input value="<?=$customer["last_name"]?>" type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Apellidos" />
                </div>

            </div>

            <div class="flex gap-5">


                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                    <input  value="<?= $customer["email"]?>" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="correo@email.com" required="">
                </div>

                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                    <input  value="<?= $customer["phone"]?>" type="tel" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="000-000-000" required="">
                </div>

        </div>

        <div class="flex gap-5">


                <div class="mb-5">
                    <label for="address1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 1 *</label>
                    <input  value="<?= $customer["address1"]?>" type="text" id="address1" name="address1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Direccion 1" required />
                </div>

                <div class="mb-5">
                    <label for="address2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 2</label>
                    <input value="<?= $customer["address2"]?>" type="text" id="address2" name="address2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Direccion 1"  />
                </div>

            </div>

            <div class="flex gap-5">

                <div class="mb-5">
                    <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo postal</label>
                    <input value="<?= $customer["zip"]?>" type="number" id="zip" name="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Codigo postal"  />
                </div>

                <div class="mb-5">
                    <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
                    <input value="<?= $customer["country"]?>" type="text" id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="País" required />
                </div>

            </div>

            <div class="flex gap-5">


                <div class="mb-5">
                    <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
                    <input value="<?= $customer["state"]?>" type="text" id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Provincia" required />
                </div>

                <div class="mb-5">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
                    <input value="<?= $customer["city"]?>" type="text" id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Ciudad" required />
                </div>

            </div>

            <div class="flex gap-5">


                <div class="mb-5">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de proveedor</label>
                    <select oninput="selectCategory(this)" value="<?=$customer["category"]?>" name="category" id="category" class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="f" <?= ($customer["category"] == "f") ? "selected" : "" ?>>Cliente Fiscal</option>
                        <option value="p" <?= ($customer["category"] == "p") ? "selected" : "" ?>>Cliente Particular</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>
                    <input value="<?= $customer["NIF"]?>" type="text" id="NIF" name="NIF" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="CIF / DNI" required />
                </div>

            </div>

            <input type="hidden" id="id2" name="id2" value="<?= $customer["id2"]?>" />

            <div class="col-span-2 flex justify-end items-end p-3">
                <button type="submit" class="text-white text-[17px] font-[500] bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300  rounded-lg  w-full sm:w-auto px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>
            </div>

        </form>
    </div>
</div>
<script>
$(document).ready(function(){
    selectCategory('#category');

    $('#form').submit(function (e){
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);

        $.ajax({
            type: 'UPDATE',
            url: '/ajax/customer',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d){
                if(d == true){
                    console.log("trueeeee")
                    window.location.href = '/contactos/';
                    exit();
                }
            }
        });

    });
});

function selectCategory(item) {
            if ($(item).val() == 'f') {
                console.log(item)
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
</script>

