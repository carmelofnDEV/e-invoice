<?php
Intratum\Facturas\Util::checkSession();
?>

<?php
$item = $_GET['item'];
$id2 = Intratum\Facturas\Util::getID2ByUUID("prod_",$item);
$product = Intratum\Facturas\Product::get($params = ["id2"=>$id2]);
$title = "Editar producto ".$product["title"]

?>
<h2 class="text-center font-[600] text-[20px]">Editar</h2>
<hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

<form action="" id="form" method="update" class="max-w-md mx-auto">
    <div class="mb-5">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
        <input type="text" id="name" name="title" value="<?= $product['title']?>"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="" required />
    </div>

    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
    <textarea id="message" name="description" rows="4" 
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Write your thoughts here..."><?= $product['description']?></textarea>


    <div class="mb-5">
        <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio €</label>
        <input type="number" id="precio" name="price" step="0.01" value="<?= $product['price']/100?>"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="0.00€" required />
    </div>

    <input type="hidden" id="id2" name="id2" value="<?= $product["id2"]?>" />
    <button type="submit"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">Editar</button>

    </form>

<script>
$(document).ready(function(){
    $('#form').submit(function (e){
        e.preventDefault();

        var data = $(this).serializeJSON();
        console.log(data);

        $.ajax({
            type: 'UPDATE',
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

