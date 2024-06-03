<?php
Intratum\Facturas\Util::checkSession();
$user = Intratum\Facturas\Util::getSessionUser();
$acc = Intratum\Facturas\User::getUserAccount($user["id"]);
$title = 'Cuenta';

?>



    <h2 class="text-center font-[600] text-[20px] mb-5">Mi empresa </h2>

    <form action="" id="form" method="post" class="max-w-[50%] mx-auto grid grid-cols-1 md:grid-cols-2 gap-5" enctype="multipart/form-data">

                <input type="hidden" name="acc_id2" value="<?=$acc["id2"]?>">


                <div id="div-responsive-1" class="mb-5 relative ">
                    <!-- nombre particular  -->
                    <label id="nombre-particular" for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                    <!-- nombre fiscal  -->
                    <label for="first_name" id="nombre-fiscal" class=" hidden block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Fiscal</label>

                    <input type="text" id="searchAccount" name="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombre" required value="<?=$acc["first_name"]?>" />

                    <div class="absolute top- left-0 ">
                        <ul id="lista" class="hidden w-60 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </ul>
                    </div>
                </div>


                <div id="campo-apellidos" class="mb-5">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                    <input type="text" id="last_name" name="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Apellidos" value="<?=$acc["last_name"]?>" />
                </div>

    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="correo@email.com" required value="<?=$acc["email"]?>">
    </div>

    <div>
        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
        <input type="tel" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="000-000-000" required value="<?=$acc["phone"]?>">
    </div>

    <div class="mb-5">
        <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 1 *</label>
        <input type="text" id="address_1" name="address_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Direccion 1" required value="<?=$acc["address1"]?>"/>
    </div>

    <div class="mb-5">
        <label for="address_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección 2</label>
        <input type="text" id="address_2" name="address_2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Direccion 2" value="<?=$acc["address2"]?>" />
    </div>

    <div class="mb-5">
        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Codigo postal</label>
        <input type="number" id="zip" name="zip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Codigo postal" value="<?=$acc["zip"]?>" />
    </div>

    <div class="mb-5">
        <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
        <input type="text" id="country" name="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="País" required value="<?=$acc["country"]?>" />
    </div>

    <div class="mb-5">
        <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Provincia</label>
        <input type="text" id="state" name="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Provincia" required value="<?=$acc["state"]?>"/>
    </div>

    <div class="mb-5">
        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
        <input type="text" id="city" name="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Ciudad" required value="<?=$acc["city"]?>"/>
    </div>

    <div class="mb-5">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de empresa</label>
                    <select name="category" onchange="selectCategory(this)" id="category" class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="f" <?php if ($acc["category"] === "f") echo 'selected="selected"'; ?>>Empresa Fiscal</option>
                        <option value="p" <?php if (empty($acc["category"]) || $acc["category"] === "p") echo 'selected="selected"'; ?>>Empresa Particular</option>
                    </select>
    </div>

    <div class="mb-5">
        <label for="NIF" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIF</label>
        <input type="text" id="NIF" name="NIF" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="CIF / DNI" required value="<?=$acc["NIF"]?>"/>
    </div>
    

    <div class="col-span-2 mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Logo</label>
        <input name="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo" type="file">
    </div>

    
    <div class=" mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cert">Firma electronica</label>
        <input name="cert" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert" type="file">
    </div>

    <div class="mb-5">
        <label for="cert_pass" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
        <input type="password" id="cert_pass" name="cert_pass" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="La contraseña de tu firma digital"  value=""/>
    </div>

    <button type="submit" class=" col-span-2 text-white text-[20px] font-[700] bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
</form>
    <script>
        $(document).ready(function() {

            selectCategory($("#category"))

            $('#form').submit(function(e) {
                e.preventDefault();

                var data = $(this).serializeJSON();

                
                var fileInput = document.getElementById('logo');

                var formData = new FormData();
                formData.append('imagen', fileInput.files[0]);
                formData.append('action', 'upload_logo');
                console.log(formData)

                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
            
                    data: formData,
                    success: function(d) {
                    }
                });

                var certFileInput = document.getElementById('cert');
                var certPass = document.getElementById('cert_pass');

                
                var certFormData = new FormData();
                certFormData.append('cert_pass', certPass.value);
                certFormData.append('cert', certFileInput.files[0]);
                certFormData.append('action', 'upload_cert');


                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
            
                    data: certFormData,
                    success: function(d) {
                    }
                });

               
                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(d) {
                        console.log(d)
                        if (d == true) {
                            window.location.href = '/';   
                            
                        }
                    }
                });


            });
        });

        function selectCategory(item) {
            console.log($(item).val())
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
