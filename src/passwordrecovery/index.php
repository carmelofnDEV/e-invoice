<?php

$exp = explode('/',$_SERVER['REQUEST_URI']);
$res = Intratum\Facturas\User::checkValidToken(end($exp));
if(!$res){
    die('Token expirado.');
}
?>

<div class="flex flex-col justify-center items-center bg-white  ">

    <div class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/static/logo.png" class="h-8" alt="Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">e-Invoice</span>
    </div>
    <div class="w-full bg-gray rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold text-center leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Cambiar contraseña
            </h1>
            <form id="form" class="flex flex-col items-center justify-center gap-5" action="">
                
                <div class="flex flex-col gap-8">

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="repeat_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Repetir Contraseña</label>
                        <input type="password" name="repeat_password" id="repeat_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                </div>

                <div class="w-full flex justify-end items-end">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cambiar </button>
                </div>
            </form>

            <div id="error-message" class="text-red-500"></div>

        </div>
    </div>

</div>

<script>
    
$(document).ready(function(){
    $('#form').submit(function (e){
        e.preventDefault();


        var data = $(this).serializeJSON();
        data["id2"] = "<?=$res?>"
        console.log(data);

        $.ajax({
            type: 'UPDATE',
            url: '/ajax/user',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d){
                if(d.success == true){
                    window.location.href = '/';
                }else{

                    if (d.errors) {

                        d.errors.forEach(function(elemento) {
                            var p = $("<p>").text(elemento.message);
                            $("#error-message").append(p);
                        });

                    }
                    
                }
            }
        });

    });
});
</script>
