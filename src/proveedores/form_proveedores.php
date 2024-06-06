<?php
Intratum\Facturas\Util::checkSession();

$title = "Crear proveedor"
?>



<h2 class="text-center font-[600] text-[20px] mb-5">Nuevo proveedor</h2>

<form action="" id="form" method="post" class="max-w-md mx-auto grid grid-cols-1 md:grid-cols-2 gap-5">
    <div id="div-responsive-1" class="mb-5 relative ">
        <!-- nombre particular  -->
        <label id="nombre-particular" for="name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
        <!-- nombre fiscal  -->
        <label for="first_name" id="nombre-fiscal"
            class=" hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>

        <input type="text" id="searchAccount" name="first_name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Nombre" required />

        <div class="absolute top- left-0 ">
            <ul id="lista"
                class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </ul>
        </div>
    </div>


    <div id="campo-apellidos" class="mb-5">
        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
        <input type="text" id="last_name" name="last_name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Apellidos" />
    </div>

    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
        <input type="email" name="email" id="email"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="correo@email.com" required="">
    </div>

    <div>
        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
        <input type="tel" name="phone" id="phone"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="000-000-000" required="">
    </div>

    <div class="mb-5 col-span-2" >
        <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 1
            *</label>
        <input type="text" id="address_1" name="address1"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Direccion 1" required />
    </div>



    <div class="mb-5">
        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo postal</label>
        <input type="number" id="zip" name="zip"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Codigo postal" />
    </div>

    <div class="mb-5">
        <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
        <input type="text" id="country" name="country"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="País" required />
    </div>

    <div class="mb-5">
        <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
        <input type="text" id="state" name="state"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Provincia" required />
    </div>

    <div class="mb-5">
        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
        <input type="text" id="city" name="city"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Ciudad" required />
    </div>

    <input type="hidden" name="type" value="p">


    <div class="mb-5">
        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
            proveedor</label>
        <select onchange="selectCategory(this)" name="category" id="category"
            class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
            required>
            <option value="f">Proveedor Fiscal</option>
            <option selected="selected" value="p">Proveedor Particular</option>
        </select>
    </div>

    <div class="mb-5">
        <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>
        <input type="text" id="NIF" name="NIF"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="CIF / DNI" required />
    </div>

    <button type="submit"
        class="text-white text-[20px] font-[900] bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">+</button>
</form>
<script>
$(document).ready(function() {
    $('#form').submit(function(e) {
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);


        $.ajax({
            type: 'POST',
            url: '/ajax/customer',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d) {
                if (d) {
                    console.log("trueeeee")
                    window.location.href = '/contactos/';


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
</script>