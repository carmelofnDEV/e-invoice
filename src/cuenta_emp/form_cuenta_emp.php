<?php
Intratum\Facturas\Util::checkSession();
$user = Intratum\Facturas\Util::getSessionUser();
$acc = Intratum\Facturas\User::getUserAccount($user["id"]);
$title = 'Cuenta';

$allSettings = Intratum\Facturas\AccountSetting::all();


$taxesList =Intratum\Facturas\Tax::all()

?>


<div class="container mx-auto px-3 mt-8">

<?php if(!empty($_GET['success'])){ ?>
<div id="alert" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
  <span class="font-medium">Cambios guardados correctamente.</span>
</div>
<?php } ?>
</div>

    <h2 class="text-center font-[600] text-[20px] mb-5">Mi empresa </h2>

    <div class="w-full flex flex-col justify-center items-center">
    
        <div class="w-[50vw] flex flex-col justify-center items-center">
            
            <div class="w-full flex mb-2">

                <button id="btn-emp" onclick="optionEmpresa()" class="py-2 px-4 border-black border-b-[2px] fonr-[600] text-[20px] ">Empresa</button>
                <button id="btn-pref" onclick="optionPref()"  class="py-2 px-4 border-black  fonr-[600] text-[20px] ">Preferencias</button>
                <button id="btn-plantilla" onclick="optionPlantilla()"  class="py-2 px-4 border-black  fonr-[600] text-[20px] ">Plantillas</button>



            </div>


            <!-- formulario datos empresa -->
            <form  id="form" method="post" class="w-full  grid grid-cols-1 md:grid-cols-2 gap-5" enctype="multipart/form-data">

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
                    <label for="address_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección  *</label>
                    <input type="text" id="address_1" name="address_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Direccion " required value="<?=$acc["address1"]?>"/>
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
                
                <?php if ($acc["hash_logo"]) { ?>

                    <div id="photo-div" class="  group">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Logo</label>
                    <div class="flex flex-col justify-center items-center ">
                        <?php if ($_SERVER['SERVER_PORT'] == '80') { ?>
                            <img class="w-[60%] max-h-[50px] object-scale-down" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?= $acc["hash_logo"] ?>" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '443') { ?>
                            <img class="w-[60%] max-h-[50px] object-scale-down" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?= $acc["hash_logo"] ?>" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '8086') { ?>
                            <img class="  max-h-[50px] object-scale-down" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?= $acc["hash_logo"] ?>" alt="Logo" />
                        <?php } ?>
                    </div>


                        <div class="w-full flex justify-end bottom-0 left-0 px-4  transition duration-300 opacity-0 group-hover:opacity-100">

                            <button type="button" onclick="changePhotoInput()">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10 3-3zM14 7.414l-9 9V19h2.586l9-9L14 7.414zm4 1.172L19.586 7 17 4.414 15.414 6 18 8.586z" fill="#0D0D0D"/></svg>
                            </button>            
                        </div>
                    </div>

                    
                    <div id="photo-input" class="hidden mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Logo</label>
                        <input name="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo" type="file">
                    </div>

                <?php }else{ ?>

                    <div class=" mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="logo">Logo</label>
                        <input name="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo" type="file">
                    </div>

                <?php } ?>


                    
                <?php if ($acc["hash_logo"]) { ?>

                    <div id="cert-div" class=" mb-5 group">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cert">Firma electrónica</label>

                        <div class="flex flex-col justify-center items-center bg-green-200 rounded-lg py-2">
                            <p class="text-green-500">Ya hay firma electrónica. </p>
                        </div>
                        <div class="w-full flex justify-end bottom-0 left-0 px-4  transition duration-300 opacity-0 group-hover:opacity-100">

                            <button type="button" onclick="changeCertInput()">
                                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13A1 1 0 0 1 8 21H4a1 1 0 0 1-1-1v-4a1 1 0 0 1 .293-.707l10-10 3-3zM14 7.414l-9 9V19h2.586l9-9L14 7.414zm4 1.172L19.586 7 17 4.414 15.414 6 18 8.586z" fill="#0D0D0D"/></svg>
                            </button>            
                        </div>
                    </div>



                    <div  id="cert-input" class="hidden mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cert">Firma electrónica</label>
                            <input  name="cert" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert" type="file">
                    </div>

                <?php }else{ ?>

                    <div class=" mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="cert">Firma electrónica</label>
                        <input  name="cert" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert" type="file">
                    </div>

                <?php } ?>


                


                <div class="mb-5">
                    <label for="cert_pass" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                    <input type="password" id="cert_pass" name="cert_pass" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="La contraseña de tu firma digital"  <?php if ($acc["hash_cert"] != null) { echo 'value="******"'; } ?>/>
                </div>

                <button type="submit" class=" col-span-2 text-white text-[20px] font-[700] bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>

            </form>

            <!-- formulario PREFERENCIAS -->
            <form  id="form-pref" method="post" class="hidden w-full " enctype="multipart/form-data">

                        <input type="hidden" name="acc_id2" value="<?=$acc["id2"]?>">

                        <div class="mb-5 flex flex-col">
                            <label for="NIF" class="block mb-2 text-lg font-[600] text-gray-900 dark:text-white">Terminos y condiciones de la empresa</label>
                            <textarea type="text" id="terms" name="terms" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Terminos y condiciones para las facturas."  ><?= $allSettings["TERMS"] ?? ""?></textarea>
                        </div>
                        <div class="w-full flex justify-center items-center gap-5">

                            <div class="w-full flex-col items-center justify-center gap-5">

                                <p class="text-[20px] font-[600] py-2 text-center ">Impuestos predeterminado para factura</p>

                                <div class="w-full flex items-center justify-center gap-5">

                                    <div>
                                        <label for="def-iva" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">IVA</label>
                                        <select name="def-iva" id="def-iva" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                            <option <?php if(empty($allSettings["DEF_IVA"])) { echo 'selected'; } ?> value="">Ninguno</option>
                                            <?php foreach ($taxesList as $tax) { 
                                                if ($tax["type"] == 1) { ?>
                                                    <option <?php if(!empty($allSettings["DEF_IVA"]) && $allSettings["DEF_IVA"] == $tax['id2']) { echo ' selected '; } ?> value="<?= $tax["id2"] ?>"><?= $tax["name"]." / ".$tax["value"] ?>%</option>
                                            <?php } 
                                            } ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="def-irpf" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">IRPF</label>
                                        <select name="def-irpf" id="def-irpf" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                            <option <?php if(empty($allSettings["DEF_IRPF"])) { echo 'selected'; } ?> value="">Ninguno</option>
                                            <?php foreach ($taxesList as $tax) { 
                                                if ($tax["type"] == 0) { ?>
                                                    <option <?php if(!empty($allSettings["DEF_IRPF"]) && $allSettings["DEF_IRPF"] == $tax['id2']) { echo ' selected '; } ?> value="<?= $tax["id2"] ?>"><?= $tax["name"]." / ".$tax["value"] ?>%</option>
                                            <?php } 
                                            } ?>
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="w-full flex-col items-center justify-center gap-5">


                                <p class="text-[20px] font-[600] py-2 text-center ">Impuestos predeterminado para gastos </p>

                                <div class="w-full flex items-center justify-center gap-5">

                                    <div>
                                        <label for="def-iva-expense" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">IVA</label>
                                        <select name="def-iva-expense" id="def-iva-expense" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                            <option <?php if(empty($allSettings["DEF_IVA_EXPENSE"])) { echo 'selected'; } ?> value="">Ninguno</option>
                                            <?php foreach ($taxesList as $tax) { 
                                                if ($tax["type"] == 1) { ?>
                                                    <option <?php if(!empty($allSettings["DEF_IVA_EXPENSE"]) && $allSettings["DEF_IVA_EXPENSE"] == $tax['id2']) { echo ' selected '; } ?> value="<?= $tax["id2"] ?>"><?= $tax["name"]." / ".$tax["value"] ?>%</option>
                                            <?php } 
                                            } ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="def-irpf-expense" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">IRPF</label>
                                        <select name="def-irpf-expense" id="def-irpf-expense" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                            <option <?php if(empty($allSettings["DEF_IRPF_EXPENSE"])) { echo 'selected'; } ?> value="">Ninguno</option>
                                            <?php foreach ($taxesList as $tax) { 
                                                if ($tax["type"] == 0) { ?>
                                                    <option <?php if(!empty($allSettings["DEF_IRPF_EXPENSE"]) && $allSettings["DEF_IRPF_EXPENSE"] == $tax['id2']) { echo ' selected '; } ?> value="<?= $tax["id2"] ?>"><?= $tax["name"]." / ".$tax["value"] ?>%</option>
                                            <?php } 
                                            } ?>
                                        </select>
                                    </div>

                                </div>

                            </div>

                        </div>






                        <button type="submit" class=" col-span-2 text-white text-[20px] font-[700] bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                        </div>

            </form>


            <!-- formulario PLANTILLA -->
            <form  id="form-plantilla" method="post" class="hidden w-full flex flex-col justify-center items-center" enctype="multipart/form-data">
                <input type="hidden" name="acc_id2" value="<?=$acc["id2"]?>">

                <div class="flex justify-center items-center gap-10 py-10">

                    <div class="flex flex-col items-center  justify-center">
                        <a href="/pdf/Ejemplo_plantilla_1.pdf" download class="flex w-[60%] justify-end "><svg class="bg-black  rounded" width="20px" height="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve"> <line fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" x1="25" y1="28" x2="7" y2="28"/> <line fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" x1="16" y1="23" x2="16" y2="4"/> <polyline fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" points="9,16 16,23 23,16 "/> </svg></a>
                        <?php if ($_SERVER['SERVER_PORT'] == '80') { ?>
                            <img id="template_1" class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_1"){echo " border-[2px]";} ?>" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/template_1.png" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '443') { ?>
                            <img id="template_1" class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_1"){echo " border-[2px]";} ?>" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/template_1.png" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '8086') { ?>
                            <img id="template_1"  class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_1"){echo " border-[2px]";} ?>" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/template_1.png" alt="Logo" />
                        <?php } ?>

                    </div>
                    
                    <div class="flex flex-col items-center  justify-center">
                        <a href="/pdf/Ejemplo_plantilla_2.pdf" download class="flex w-[60%] justify-end "><svg class="bg-black  rounded" width="20px" height="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve"> <line fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" x1="25" y1="28" x2="7" y2="28"/> <line fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" x1="16" y1="23" x2="16" y2="4"/> <polyline fill="none" stroke="#fff" stroke-width="2" stroke-miterlimit="10" points="9,16 16,23 23,16 "/> </svg></a>

                        <?php if ($_SERVER['SERVER_PORT'] == '80') { ?>
                            <img id="template_2" class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_2"){echo " border-[2px]";} ?>" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/template_2.png" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '443') { ?>
                            <img id="template_2" class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_2"){echo " border-[2px]";} ?>" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/template_2.png" alt="Logo" />
                        <?php } else if ($_SERVER['SERVER_PORT'] == '8086') { ?>
                            <img id="template_2" class="template w-[60%] object-cover border-black <?php if(!empty($allSettings["DEFAULT_TEMPLATE"]) && $allSettings["DEFAULT_TEMPLATE"] == "template_2"){echo " border-[2px]";} ?>" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/template_2.png" alt="Logo" />
                        <?php } ?>
                    </div>

                        <input type="hidden" id="template_option" name="template_option">
                        

                </div>

                <button type="submit" class="py-1 px-4 bg-black text-white rounded">Guardar</button>



            </form>

        </div>

    </div>





    <script>
        
            

        function optionPref(){
            $("#form").addClass("hidden");
            $("#alert").addClass("hidden");
            $("#form-plantilla").addClass("hidden");

            $("#form-pref").removeClass("hidden");

            $("#btn-pref").addClass("border-b-[2px]");
            $("#btn-emp").removeClass("border-b-[2px]");
            $("#btn-plantilla").removeClass("border-b-[2px]");

        }

        function optionEmpresa(){
            $("#form-pref").addClass("hidden");
            $("#alert").addClass("hidden");
            $("#form").removeClass("hidden");
            $("#form-plantilla").addClass("hidden");

            $("#btn-emp").addClass("border-b-[2px]");
            $("#btn-pref").removeClass("border-b-[2px]");
            $("#btn-plantilla").removeClass("border-b-[2px]");

        }

        function optionPlantilla(){

            $("#form-pref").addClass("hidden");
            $("#form").addClass("hidden");

            $("#alert").addClass("hidden");

            $("#form-plantilla").removeClass("hidden");

            $("#btn-plantilla").addClass("border-b-[2px]");
            $("#btn-pref").removeClass("border-b-[2px]");
            $("#btn-emp").removeClass("border-b-[2px]");

        }

        

        function changePhotoInput(){
            $("#photo-div").addClass("hidden");
            $("#photo-input").removeClass("hidden");

            
        }

        function changeCertInput(){
            $("#cert-div").addClass("hidden");
            $("#cert-input").removeClass("hidden");

            
        }

        $(document).ready(function() {

            $(".template").on( "click", function() {

                $(".template").removeClass("border-[2px]")
                $(this).addClass("border-[2px]")

                $("#template_option").val(this.id)

            } );

            selectCategory($("#category"))


            $('#form-plantilla').submit(function(e) {

                e.preventDefault();

                var data = $(this).serializeJSON();

                data["action"] = "set-template"
                
               
                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(d) {
                        if (d.success == true) {
                            window.location.href = '/empresa/?success=true';   
                        }
                    }
                });


            });

            
            $('#form-pref').submit(function(e) {
                e.preventDefault();

                var data = $(this).serializeJSON();

                data["action"] = "set-preferencies"
                

               
                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(d) {
                        if (d == true) {
                            window.location.href = '/empresa/?success=true';   
                        }
                    }
                });


            });

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
                console.log(certPass.value,certFileInput.files[0])

                $.ajax({
                    type: 'POST',
                    url: '/ajax/account',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
            
                    data: certFormData,
                    success: function(d) {
                        console.log("subido")
                    }
                });

               
                // $.ajax({
                //     type: 'POST',
                //     url: '/ajax/account',
                //     dataType: 'json',
                //     contentType: 'application/json',
                //     data: JSON.stringify(data),
                //     success: function(d) {
                //         console.log(d)
                //         if (d == true) {
                //             window.location.href = '/empresa/';   
                            
                //         }
                //     }
                // });


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
