<?php
Intratum\Facturas\Util::checkSession();
$title = "Crear producto";

$allTaxs = Intratum\Facturas\Tax::all()

?>



<div class="w-full h-full flex justify-center pt-[10%] ">
    <div class="w-full ">
        <h2 class="text-center font-[600] text-[20px]">Nuevo producto</h2>

        <form action="lib/add_producto.php" id="form"method="post" class="max-w-xl mx-auto rounded-xl p-10 bg-[#fafafa] border-[1px]">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                <input type="text" id="name" name="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nombre del producto" required />
            </div>

            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
            <textarea id="message" name="description" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Descripción del producto"></textarea>


            <div class="mb-5">
                <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                <input type="number" id="precio" name="price" step="0.01"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="0.00€" required />
            </div>

            <div class="mb-5">

                <label for="default_tax" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Impuesto predeterminado</label>

                <select name="default_tax" id="default_tax" class="block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

                    <option value="0">Ninguno</option>
                    <?php foreach ($allTaxs as $tax) {
                    echo ' <option value="'.$tax["id"].'">'.$tax["name"]." / ".$tax["value"].'</option>';

                } ?>

                </select>

            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#form').submit(function (e){
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);
        

        $.ajax({
            type: 'POST',
            url: '/ajax/products',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d){
                if(d.success == true){
                    console.log("trueeeee")
                    window.location.href = '/productos/?success=true';
                    exit();
  

                }
            }
        });


    });
});
</script>
