<?php
Intratum\Facturas\Util::checkSession()
?>



<h2 class="text-center mb-5 font-[600] text-[20px]">Nuevo impuesto</h2>

<form id="form" method="UPDATE" class="max-w-md mx-auto">
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

            <select name="type" id="type"
                class="block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                required>

                <option value="1">IVA</option>

                <option selected="selected" value="0">IRPF</option>

            </select>

        </div>



        <input type="hidden" name="id2">

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Añadir
        </button>

    </div>

</form>

<script>
$(document).ready(function() {
    $('#form').submit(function(e) {
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
                    console.log("trueeeee")
                    window.location.href = '/configuracion/impuestos/';
                    exit();


                }
            }
        });


    });
});
</script>