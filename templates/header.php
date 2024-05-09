<?php
    date_default_timezone_set('Europe/Madrid');
    $user = Intratum\Facturas\Util::getSessionUser();


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/static/logo.png" type="image/x-icon ">

    <meta name="viewport " content="width=device-width, initial-scale=1.0 ">
    <script src="https://cdn.tailwindcss.com "></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="/static/script.js"></script>
    
    <title>e-Invoice</title>
</head>



<body class="flex">

<?php 
    if ($user != null) {
    
    $profile = Intratum\Facturas\User::getUserAccount($user["id"])
?>

    <header class=" pl-[15%] bg-white shadow-lg fixed top-0 left-0 w-full z-10">
        <!-- Contenido del encabezado aquí -->
        <div class="flex justify-between container mx-auto px-4 py-4">

            <?php if (!isset($title)) { ?>
                <div class="flex w-[30%] text-[20px] justify-start items-end font-medium text-center text-gray-500 gap-3">

                    <label for="countries" class="block mb-2 font-[700] text-[20px] font-medium text-gray-900 dark:text-white">Resultados</label>
                    <select id="valor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="1">1º Trimestres de <?= date("Y") ?></option>
                        <option value="2">2º Trimestres de <?= date("Y") ?></option>
                        <option value="3">3º Trimestres de <?= date("Y") ?></option>
                        <option value="4">4º Trimestres de <?= date("Y") ?></option>
                    </select>

                </div>
            <?php } ?>

            <div class="flex justify-center items-center">
                <h1 class="text-3xl font-bold"><?php if(!empty($title)) echo $title; else echo ''; ?></h1>
            </div>


            <div class="flex gap-10 justify-center items-center">


                <button data-popover-target="popover-settings" data-popover-placement="bottom" type="button" class="text-white">
                    <svg class="transform hover:rotate-180 transition-transform duration-1000 ease-in-out" fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1703.534 960c0-41.788-3.84-84.48-11.633-127.172l210.184-182.174-199.454-340.856-265.186 88.433c-66.974-55.567-143.323-99.389-223.85-128.415L1158.932 0h-397.78L706.49 269.704c-81.43 29.138-156.423 72.282-223.962 128.414l-265.073-88.32L18 650.654l210.184 182.174C220.39 875.52 216.55 918.212 216.55 960s3.84 84.48 11.633 127.172L18 1269.346l199.454 340.856 265.186-88.433c66.974 55.567 143.322 99.389 223.85 128.415L761.152 1920h397.779l54.663-269.704c81.318-29.138 156.424-72.282 223.963-128.414l265.073 88.433 199.454-340.856-210.184-182.174c7.793-42.805 11.633-85.497 11.633-127.285m-743.492 395.294c-217.976 0-395.294-177.318-395.294-395.294 0-217.976 177.318-395.294 395.294-395.294 217.977 0 395.294 177.318 395.294 395.294 0 217.976-177.317 395.294-395.294 395.294" fill-rule="evenodd"></path> </g></svg>
                </button>
                <div data-popover id="popover-settings" role="tooltip" class="absolute z-10 invisible inline-block  text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">

                    <ul class="flex flex-col justify-between px-5 py-7 gap-3">

                        <li class="">
                            <a class="flex justify-start items-center gap-2 hover:text-black" href="/configuracion/seriales">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Layer_2" data-name="Layer 2"> <g id="Layer_1-2" data-name="Layer 1"> <path d="M1,.5v15a.5.5,0,0,1-.5.5.5.5,0,0,1-.5-.5V.5A.5.5,0,0,1,.5,0,.5.5,0,0,1,1,.5ZM3.5,0h-1A.5.5,0,0,0,2,.5v15a.5.5,0,0,0,.5.5h1a.5.5,0,0,0,.5-.5V.5A.5.5,0,0,0,3.5,0Zm9,0h-3A.5.5,0,0,0,9,.5v15a.5.5,0,0,0,.5.5h3a.5.5,0,0,0,.5-.5V.5A.5.5,0,0,0,12.5,0Zm-7,0A.5.5,0,0,0,5,.5v15a.5.5,0,0,0,1,0V.5A.5.5,0,0,0,5.5,0Zm10,0a.5.5,0,0,0-.5.5v15a.5.5,0,0,0,1,0V.5A.5.5,0,0,0,15.5,0Z"></path> </g> </g> </g></svg>
                                <p>Seriales</p>
                            </a>
                        </li>

                        <li class="">
                            <a class="flex justify-start items-center gap-2 hover:text-black" href="/configuracion/impuestos">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M51.2 544.963C51.2 272.267 272.267 51.2 544.963 51.2c11.311 0 20.48-9.169 20.48-20.48s-9.169-20.48-20.48-20.48C249.646 10.24 10.24 249.645 10.24 544.963c0 11.311 9.169 20.48 20.48 20.48s20.48-9.169 20.48-20.48zm562.958-426.23c208.123 33.264 363.312 213.599 363.312 426.62 0 238.617-193.439 432.056-432.056 432.056-210.972 0-390.126-152.273-425.7-357.827-1.929-11.145-12.527-18.616-23.672-16.688s-18.616 12.527-16.688 23.672c38.958 225.108 235.079 391.802 466.06 391.802 261.238 0 473.016-211.778 473.016-473.016 0-233.225-169.886-430.637-397.807-467.066-11.169-1.785-21.67 5.822-23.456 16.991s5.822 21.67 16.991 23.456z"></path><path d="M524.483 37.947V552.19c0 11.311 9.169 20.48 20.48 20.48s20.48-9.169 20.48-20.48V37.947c0-11.311-9.169-20.48-20.48-20.48s-20.48 9.169-20.48 20.48z"></path><path d="M30.72 572.67h514.243c11.311 0 20.48-9.169 20.48-20.48s-9.169-20.48-20.48-20.48H30.72c-11.311 0-20.48 9.169-20.48 20.48s9.169 20.48 20.48 20.48zm252.62-297.741c0-12.844-9.881-23.02-21.76-23.02s-21.76 10.175-21.76 23.02c0 12.844 9.881 23.02 21.76 23.02s21.76-10.175 21.76-23.02zm40.96 0c0 35.201-27.945 63.98-62.72 63.98s-62.72-28.778-62.72-63.98c0-35.201 27.945-63.98 62.72-63.98s62.72 28.778 62.72 63.98zm111.104 134.834c0-12.844-9.881-23.02-21.76-23.02s-21.76 10.175-21.76 23.02c0 12.844 9.881 23.02 21.76 23.02s21.76-10.175 21.76-23.02zm40.96 0c0 35.201-27.945 63.98-62.72 63.98s-62.72-28.778-62.72-63.98c0-35.201 27.945-63.98 62.72-63.98s62.72 28.778 62.72 63.98zm-77.412-162.151L229.992 421.59c-7.88 8.114-7.69 21.08.424 28.96s21.08 7.69 28.96-.424l168.96-173.978c7.88-8.114 7.69-21.08-.424-28.96s-21.08-7.69-28.96.424z"></path></g></svg>

                                <p>Impuestos</p>
                            </a>
                        </li>

                    </ul>

                    <div data-popper-arrow></div>
                </div>


                <?php if ($_SERVER['SERVER_PORT'] == '80') {?>
                    <div class="rounded-full border-black border-[1px]" >
                        <a href="/empresa/">
                            <img class="w-10 h-10 rounded-full transition-all duration-4 hover:opacity-50 hover:blur-[1px] blur-none" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$profile["hash_logo"]?>" alt="Logo" />
                        </a>
                    </div>
                <?php } else if ($_SERVER['SERVER_PORT'] == '443') {?>
                    <div class="rounded-full border-black border-[1px]" >
                        <a href="/empresa/">
                            <img class="w-10 h-10 rounded-full transition-all duration-4 hover:opacity-50 hover:blur-[1px] blur-none" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$profile["hash_logo"]?>" alt="Logo" />
                        </a>
                    </div>
                <?php } else if ($_SERVER['SERVER_PORT'] == '8086') {?>
                    <div class="rounded-full border-black border-[1px]" >
                        <a href="/empresa/">
                            <img class="w-10 h-10 rounded-full transition-all duration-4 hover:opacity-50 hover:blur-[1px] blur-none" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$profile["hash_logo"]?>" alt="Logo" />
                        </a>
                    </div>
                <?php }?>
                
            </div>
        </div>
    </header>

    <div class="w-[15%] z-20 min-h-screen top-0 bg-[#1A1917]">
        <ul class="w-[13%] fixed  py-3 font-medium text-[#FAFAFA] ">

            <!-- Pop Pover -->
            <li class="pl-5 pr-10 pb-5 13 border-[#c8c8c8] !border-b-[1px]">

                <div class="flex justify-center items-center flex-col">

                    <div class="mb-4 flex jutify-center items-center gap-3">
                        <img src="/static/logo.png" alt="logo-header" class="max-w-[50px]">
                        <p class="text-[20px]">E-invoice</p>
                    </div>

                    <button data-popover-target="popover-bottom" data-popover-placement="bottom" type="button" class=" flex justify-center items-center w-12 h-12 rounded-full text-black bg-white">
                        <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="13px" height="13px" viewBox="0 0 45.402 45.402" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M41.267,18.557H26.832V4.134C26.832,1.851,24.99,0,22.707,0c-2.283,0-4.124,1.851-4.124,4.135v14.432H4.141 c-2.283,0-4.139,1.851-4.138,4.135c-0.001,1.141,0.46,2.187,1.207,2.934c0.748,0.749,1.78,1.222,2.92,1.222h14.453V41.27 c0,1.142,0.453,2.176,1.201,2.922c0.748,0.748,1.777,1.211,2.919,1.211c2.282,0,4.129-1.851,4.129-4.133V26.857h14.435 c2.283,0,4.134-1.867,4.133-4.15C45.399,20.425,43.548,18.557,41.267,18.557z"></path> </g> </g></svg>
                    </button>
                        <div data-popover id="popover-bottom" role="tooltip" class="mt-10 absolute z-10 invisible  transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 ">
                            <ul class="p-1 w-[150px] text-black flex flex-col justify-center items-center  gap-1">

                                <li class="w-full hover:bg-[#c3c3c3] m-1 text-center rounded">
                                    <a class="flex gap-2 justify-start items-center transition-all hover:opacity-100  opacity-60 p-1 " href="/facturas/nuevo">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.55281 1.60553C7.10941 1.32725 7.77344 1 9 1C10.2265 1 10.8906 1.32722 11.4472 1.6055L11.4631 1.61347C11.8987 1.83131 12.2359 1.99991 13 1.99993C14.2371 1.99998 14.9698 1.53871 15.2141 1.35512C15.5944 1.06932 16.0437 1.09342 16.3539 1.2369C16.6681 1.38223 17 1.72899 17 2.24148L17 13H20C21.6562 13 23 14.3415 23 15.999V19C23 19.925 22.7659 20.6852 22.3633 21.2891C21.9649 21.8867 21.4408 22.2726 20.9472 22.5194C20.4575 22.7643 19.9799 22.8817 19.6331 22.9395C19.4249 22.9742 19.2116 23.0004 19 23H5C4.07502 23 3.3148 22.7659 2.71092 22.3633C2.11331 21.9649 1.72739 21.4408 1.48057 20.9472C1.23572 20.4575 1.11827 19.9799 1.06048 19.6332C1.03119 19.4574 1.01616 19.3088 1.0084 19.2002C1.00194 19.1097 1.00003 19.0561 1 19V2.24146C1 1.72899 1.33184 1.38223 1.64606 1.2369C1.95628 1.09341 2.40561 1.06931 2.78589 1.35509C3.03019 1.53868 3.76289 1.99993 5 1.99993C5.76415 1.99993 6.10128 1.83134 6.53688 1.6135L6.55281 1.60553ZM3.00332 19L3 3.68371C3.54018 3.86577 4.20732 3.99993 5 3.99993C6.22656 3.99993 6.89059 3.67269 7.44719 3.39441L7.46312 3.38644C7.89872 3.1686 8.23585 3 9 3C9.76417 3 10.1013 3.16859 10.5369 3.38643L10.5528 3.39439C11.1094 3.67266 11.7734 3.9999 13 3.99993C13.7927 3.99996 14.4598 3.86581 15 3.68373V19C15 19.783 15.1678 20.448 15.4635 21H5C4.42498 21 4.0602 20.8591 3.82033 20.6992C3.57419 20.5351 3.39761 20.3092 3.26943 20.0528C3.13928 19.7925 3.06923 19.5201 3.03327 19.3044C3.01637 19.2029 3.00612 19.1024 3.00332 19ZM19.3044 20.9667C19.5201 20.9308 19.7925 20.8607 20.0528 20.7306C20.3092 20.6024 20.5351 20.4258 20.6992 20.1797C20.8591 19.9398 21 19.575 21 19V15.999C21 15.4474 20.5529 15 20 15H17L17 19C17 19.575 17.1409 19.9398 17.3008 20.1797C17.4649 20.4258 17.6908 20.6024 17.9472 20.7306C18.2075 20.8607 18.4799 20.9308 18.6957 20.9667C18.8012 20.9843 18.8869 20.9927 18.9423 20.9967C19.0629 21.0053 19.1857 20.9865 19.3044 20.9667Z" fill="#000000"></path> <path d="M5 8C5 7.44772 5.44772 7 6 7H12C12.5523 7 13 7.44772 13 8C13 8.55229 12.5523 9 12 9H6C5.44772 9 5 8.55229 5 8Z" fill="#000000"></path> <path d="M5 12C5 11.4477 5.44772 11 6 11H12C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13H6C5.44772 13 5 12.5523 5 12Z" fill="#000000"></path> <path d="M5 16C5 15.4477 5.44772 15 6 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H6C5.44772 17 5 16.5523 5 16Z" fill="#000000"></path> </g></svg>
                                        <p>Factura</p>
                                    </a>

                                    
                                </li>

                                <li class="w-full hover:bg-[#c3c3c3] m-1 text-center rounded">
                                    <a class="flex gap-2 justify-start items-center transition-all hover:opacity-100  opacity-60 p-1 " href="/gastos/nuevo">
                                        <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 8.94444C15.1834 7.76165 13.9037 7 12.4653 7C9.99917 7 8 9.23858 8 12C8 14.7614 9.99917 17 12.4653 17C13.9037 17 15.1834 16.2384 16 15.0556M7 10.5H11M7 13.5H11M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                        <p>Gasto</p>
                                    </a>
                                </li>


                                <li class="w-full hover:bg-[#c3c3c3] m-1 text-center rounded">
                                    <a class="flex gap-2 justify-start items-center transition-all hover:opacity-100  opacity-60 p-1 " href="/presupuestos/nuevo">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#000000" d="M9 3h6v2h-6v-2z"></path> <path fill="#000000" d="M9 11h6v2h-6v-2z"></path> <path fill="#000000" d="M5 1h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path> <path fill="#000000" d="M7 10.4l-1.4-1.4-1.6 1.6-1.6-1.6-1.4 1.4 1.6 1.6-1.6 1.6 1.4 1.4 1.6-1.6 1.6 1.6 1.4-1.4-1.6-1.6z"></path> <path fill="#000000" d="M13 14.5c0 0.552-0.448 1-1 1s-1-0.448-1-1c0-0.552 0.448-1 1-1s1 0.448 1 1z"></path> <path fill="#000000" d="M13 9.5c0 0.552-0.448 1-1 1s-1-0.448-1-1c0-0.552 0.448-1 1-1s1 0.448 1 1z"></path> </g></svg>
                                        <p>Presupuesto</p>
                                    </a>
                                </li>

    

                            </ul>
                        <div data-popper-arrow></div>
                    </div>
                </div>

            </li>

            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/" class="flex gap-2 ">
                    <svg fill="#FAFAFA" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="home" class="icon glyph" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M21.71,12.71a1,1,0,0,1-1.42,0L20,12.42V20.3A1.77,1.77,0,0,1,18.17,22H16a1,1,0,0,1-1-1V15.1a1,1,0,0,0-1-1H10a1,1,0,0,0-1,1V21a1,1,0,0,1-1,1H5.83A1.77,1.77,0,0,1,4,20.3V12.42l-.29.29a1,1,0,0,1-1.42,0,1,1,0,0,1,0-1.42l9-9a1,1,0,0,1,1.42,0l9,9A1,1,0,0,1,21.71,12.71Z"></path></g></svg>
                    <p>Inicio</p>
                </a>
            </li>

            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/facturas/" class="flex gap-2">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.55281 1.60553C7.10941 1.32725 7.77344 1 9 1C10.2265 1 10.8906 1.32722 11.4472 1.6055L11.4631 1.61347C11.8987 1.83131 12.2359 1.99991 13 1.99993C14.2371 1.99998 14.9698 1.53871 15.2141 1.35512C15.5944 1.06932 16.0437 1.09342 16.3539 1.2369C16.6681 1.38223 17 1.72899 17 2.24148L17 13H20C21.6562 13 23 14.3415 23 15.999V19C23 19.925 22.7659 20.6852 22.3633 21.2891C21.9649 21.8867 21.4408 22.2726 20.9472 22.5194C20.4575 22.7643 19.9799 22.8817 19.6331 22.9395C19.4249 22.9742 19.2116 23.0004 19 23H5C4.07502 23 3.3148 22.7659 2.71092 22.3633C2.11331 21.9649 1.72739 21.4408 1.48057 20.9472C1.23572 20.4575 1.11827 19.9799 1.06048 19.6332C1.03119 19.4574 1.01616 19.3088 1.0084 19.2002C1.00194 19.1097 1.00003 19.0561 1 19V2.24146C1 1.72899 1.33184 1.38223 1.64606 1.2369C1.95628 1.09341 2.40561 1.06931 2.78589 1.35509C3.03019 1.53868 3.76289 1.99993 5 1.99993C5.76415 1.99993 6.10128 1.83134 6.53688 1.6135L6.55281 1.60553ZM3.00332 19L3 3.68371C3.54018 3.86577 4.20732 3.99993 5 3.99993C6.22656 3.99993 6.89059 3.67269 7.44719 3.39441L7.46312 3.38644C7.89872 3.1686 8.23585 3 9 3C9.76417 3 10.1013 3.16859 10.5369 3.38643L10.5528 3.39439C11.1094 3.67266 11.7734 3.9999 13 3.99993C13.7927 3.99996 14.4598 3.86581 15 3.68373V19C15 19.783 15.1678 20.448 15.4635 21H5C4.42498 21 4.0602 20.8591 3.82033 20.6992C3.57419 20.5351 3.39761 20.3092 3.26943 20.0528C3.13928 19.7925 3.06923 19.5201 3.03327 19.3044C3.01637 19.2029 3.00612 19.1024 3.00332 19ZM19.3044 20.9667C19.5201 20.9308 19.7925 20.8607 20.0528 20.7306C20.3092 20.6024 20.5351 20.4258 20.6992 20.1797C20.8591 19.9398 21 19.575 21 19V15.999C21 15.4474 20.5529 15 20 15H17L17 19C17 19.575 17.1409 19.9398 17.3008 20.1797C17.4649 20.4258 17.6908 20.6024 17.9472 20.7306C18.2075 20.8607 18.4799 20.9308 18.6957 20.9667C18.8012 20.9843 18.8869 20.9927 18.9423 20.9967C19.0629 21.0053 19.1857 20.9865 19.3044 20.9667Z" fill="#FAFAFA"></path> <path d="M5 8C5 7.44772 5.44772 7 6 7H12C12.5523 7 13 7.44772 13 8C13 8.55229 12.5523 9 12 9H6C5.44772 9 5 8.55229 5 8Z" fill="#FAFAFA"></path> <path d="M5 12C5 11.4477 5.44772 11 6 11H12C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13H6C5.44772 13 5 12.5523 5 12Z" fill="#FAFAFA"></path> <path d="M5 16C5 15.4477 5.44772 15 6 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H6C5.44772 17 5 16.5523 5 16Z" fill="#FAFAFA"></path> </g></svg>
                    <p>Facturas</p>
                </a>
            </li>

            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/presupuestos/" class="flex gap-2 ">
                    <svg width="20px" height="20px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FAFAFA"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#FAFAFA" d="M9 3h6v2h-6v-2z"></path> <path fill="#FAFAFA" d="M9 11h6v2h-6v-2z"></path> <path fill="#FAFAFA" d="M5 1h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path> <path fill="#FAFAFA" d="M7 10.4l-1.4-1.4-1.6 1.6-1.6-1.6-1.4 1.4 1.6 1.6-1.6 1.6 1.4 1.4 1.6-1.6 1.6 1.6 1.4-1.4-1.6-1.6z"></path> <path fill="#FAFAFA" d="M13 14.5c0 0.552-0.448 1-1 1s-1-0.448-1-1c0-0.552 0.448-1 1-1s1 0.448 1 1z"></path> <path fill="#FAFAFA" d="M13 9.5c0 0.552-0.448 1-1 1s-1-0.448-1-1c0-0.552 0.448-1 1-1s1 0.448 1 1z"></path> </g></svg>
                    <p>Presupuestos</p>
                </a>
            </li>

            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/gastos/" class="flex gap-2 ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 8.94444C15.1834 7.76165 13.9037 7 12.4653 7C9.99917 7 8 9.23858 8 12C8 14.7614 9.99917 17 12.4653 17C13.9037 17 15.1834 16.2384 16 15.0556M7 10.5H11M7 13.5H11M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#FAFAFA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <p>Gastos</p>
                </a>
            </li>
            
            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/clientes/" class="flex gap-2 ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#FAFAFA"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="9" cy="9" r="4" fill="#FAFAFA" stroke="#FAFAFA" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle><path fill="#FAFAFA" stroke="#FAFAFA" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13c-3.866 0-7 2.686-7 6h14c0-3.314-3.134-6-7-6z"></path><path stroke="#FAFAFA" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a4 4 0 1 0-3-6.646m0 5.411c.897.942 2.193 1.235 3 1.235 3.866 0 7 2.686 7 6h-6"></path></g></svg>
                    <p>Clientes</p>
                </a>
            </li>
                        
            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/proveedores/" class="flex gap-2 ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#FAFAFA"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#FAFAFA;stroke-miterlimit:10;stroke-width:1.89px;}</style></defs><circle class="cls-1" cx="3.5" cy="19.61" r="1.89"></circle><circle class="cls-1" cx="12.97" cy="19.61" r="1.89"></circle><path class="cls-1" d="M14.87,11.08v8.53a1.9,1.9,0,1,0-3.79,0H5.39a1.89,1.89,0,1,0-3.78,0V13.92h8.52A2.85,2.85,0,0,1,13,11.08Z"></path><path class="cls-1" d="M14.87,11.08H13a2.85,2.85,0,0,0-2.84,2.84H1.61V3.5H7.29A7.58,7.58,0,0,1,14.87,11.08Z"></path><line class="cls-1" x1="4.45" y1="10.13" x2="4.45" y2="13.92"></line><line class="cls-1" x1="11.5" y1="11.5" x2="9.66" y2="9.66"></line><line class="cls-1" x1="11.08" y1="8.24" x2="8.71" y2="10.61"></line><rect class="cls-1" x="14.87" y="13.92" width="3.79" height="5.68"></rect><polyline class="cls-1" points="18.66 19.61 18.66 13.92 18.66 3.5"></polyline><line class="cls-1" x1="23.39" y1="19.61" x2="18.66" y2="19.61"></line></g></svg>
                    <p>Proveedores</p>
                </a>
            </li>
            
            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d] border-[#c8c8c8] !border-b-[1px]">
                <a href="/productos/" class="flex gap-2 ">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4856 1.12584C12.1836 0.958052 11.8164 0.958052 11.5144 1.12584L2.51436 6.12584L2.5073 6.13784L2.49287 6.13802C2.18749 6.3177 2 6.64568 2 7V16.9999C2 17.3631 2.19689 17.6977 2.51436 17.874L11.5022 22.8673C11.8059 23.0416 12.1791 23.0445 12.4856 22.8742L21.4856 17.8742C21.8031 17.6978 22 17.3632 22 17V7C22 6.64568 21.8125 6.31781 21.5071 6.13813C21.4996 6.13372 21.4921 6.12942 21.4845 6.12522L12.4856 1.12584ZM5.05923 6.99995L12.0001 10.856L14.4855 9.47519L7.74296 5.50898L5.05923 6.99995ZM16.5142 8.34816L18.9409 7L12 3.14396L9.77162 4.38195L16.5142 8.34816ZM4 16.4115V8.69951L11 12.5884V20.3004L4 16.4115ZM13 20.3005V12.5884L20 8.69951V16.4116L13 20.3005Z" fill="#FAFAFA"></path> </g></svg>
                    <p>Productos</p>
                </a>
            </li>

            <li class="pl-5 pr-10 py-4 hover:bg-[#201f1d]">
                <a href="/logout" class="flex gap-2 ">
                    <svg fill="#FAFAFA" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M7.707,8.707,5.414,11H17a1,1,0,0,1,0,2H5.414l2.293,2.293a1,1,0,1,1-1.414,1.414l-4-4a1,1,0,0,1,0-1.414l4-4A1,1,0,1,1,7.707,8.707ZM21,1H13a1,1,0,0,0,0,2h7V21H13a1,1,0,0,0,0,2h8a1,1,0,0,0,1-1V2A1,1,0,0,0,21,1Z"></path></g></svg>
                    <p>Cerrar sesión</p>
                </a>
            </li>

        </ul>

    </div>

    
<script>
    if(window.location.pathname == "/register/"|| window.location.pathname == "/login/"){
        window.location.pathname = "/"
    }
</script>

<?php }else{ ?>

<script>
    if(window.location.pathname != "/register/" && window.location.pathname != "/login/"){
        window.location.pathname = "/login/"
    }
</script>

<?php } ?>


<div class="mt-[80px] w-full">