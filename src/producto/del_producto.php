<?php
Intratum\Facturas\Util::checkSession()
?>
<?php
$item = $_GET['item'];
$id2 = Intratum\Facturas\Util::getID2ByUUID("prod_",$item);
$product = Intratum\Facturas\Product::get($params = ["id2"=>$id2]);

?>
<div class="flex flex-col justify-center items-center">
<h2 class="text-center font-[600] text-[20px]">¿Este seguro que desea eliminar este <strong>producto</strong>?</h2>
<hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

<div class="flex flex-col  max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
    <div class="flex flex-col pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Titulo</dt>
        <dd class="text-lg font-semibold"><?= $product["title"]?></dd>
    </div>
    <div class="flex flex-col py-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Descripción</dt>
        <dd class="text-lg font-semibold"><?= $product["description"]?></dd>
    </div>
    <div class="flex flex-col pt-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Precio
        </dt>
        <dd class="text-lg font-semibold"><?= $product["price"]/100?>€</dd>
    </div>
    
</div>
<hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
<form action="" id="form" method="delete" class="max-w-md mx-auto">
    <input type="hidden" id="id2" name="id2" value="<?= $product["id2"]?>" />

    <button type="sumbit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">SI</button>
    
    <a class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" href="/clientes/">NO</a>
</form>
</div>

<script>
$(document).ready(function(){
    $('#form').submit(function (e){
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);
        $.ajax({
            type: 'DELETE',
            url: '/ajax/products',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(d){
                if(d.success == true){
                    console.log("trueeeee")
                    window.location.href = '/productos/';
                    exit();
                }
            }
        });

    });
});
</script>