<?php
Intratum\Facturas\Util::checkSession();
$user = Intratum\Facturas\Util::getSessionUser();


$acc = Intratum\Facturas\User::getUserAccount($user["id"]);
?>

    <h1 class="text-[30px] text-center">
        HOME
    </h1>

    <h1 class="text-[30px] text-center">
        Bienvinido
        <?= $user["first_name"]?>.
    </h1>


    <div class="flex justify-center m-10">



        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h3 class="mb-1 text-xl text-center font-medium text-gray-900 dark:text-white p-3">
                Tu perfil
            </h3>
            <hr class="w-full h-[2px] bg-red">
            <div class="flex justify-end px-4 pt-4">
                <button data-modal-target="crypto-modal" data-modal-toggle="crypto-modal" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                    type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </button>
                <!-- Dropdown menu -->

            </div>
            <div class="flex flex-col items-center pb-10">
            <?php if ($_SERVER['SERVER_PORT'] == '80') {?>
                <img class="w-[50%] h-[50%] mb-3 " src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo" />

              <div class="tm_logo"><img  alt="Logo"></div>

            <?php }else if ($_SERVER['SERVER_PORT'] == '443') {?>
                <img class="w-[50%] h-[50%] mb-3 " src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo" />

            
            <?php }else if ($_SERVER['SERVER_PORT'] == '8086') {?>
                <img class="w-[50%] h-[50%] mb-3 " src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo" />

            <?php }?>
                <h3 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                    <?= $user["first_name"]?>,
                        <?= $user["last_name"]?>
                </h3>
                <h4>
                    <?= $user["email"]?>
                </h4>

                <a href="#" class="m-3 py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cambiar contraseña</a>

            </div>
        </div>

    </div>