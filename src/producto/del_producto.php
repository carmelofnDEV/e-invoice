<?php
Intratum\Facturas\Util::checkSession()
?>
<?php
$item = $_GET['item'];
$id2 = Intratum\Facturas\Util::getID2ByUUID("prod_",$item);
$product = Intratum\Facturas\Product::get($params = ["id2"=>$id2]);

$title = "Eliminar producto ".$product["title"]
?>

<div class="flex flex-col justify-center items-center pt-[10%]">

    <h2 class="text-center font-[600] text-[20px] mb-2">¿Este seguro que desea eliminar este <strong>producto</strong>?</h2>

    <div class="flex flex-col border-[1px] p-5 rounded-xl" >
        <div class="flex justify-center items-center text-[20px]">

            <div class="flex flex-col p-3">
                <p class="font-[700]">Nombre</p>
                <p class="ml-2"><?= $product["title"]?></p>
            </div>

            <div class="flex flex-col p-3">
                <p class="font-[700]">Descripción</p>
                <p class="ml-2"><?= $product["description"]?></p>
            </div>

            <div class="flex flex-col p-3">
                <p class="font-[700]">Precio</p>
                <p class="ml-2"><?= $product["price"]/100?>€</p>
            </div>

        </div>

        <form action="" id="form" method="delete" class="w-full mx-auto flex items-end justify-end gap-2 pt-5">
            <input type="hidden" id="id2" name="id2" value="<?= $product["id2"]?>" />
            <button type="sumbit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-4 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Si</button>
            <a class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" href="/productos/">No</a>
        <form>

    </div>

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
