<?php
Intratum\Facturas\Util::checkSession();
$title="Impuestos";
?>

<?php

$acc_id = Intratum\Facturas\Util::getUserAccountID();
Intratum\Facturas\Environment::$db->where('account_id',$acc_id);
$all = Intratum\Facturas\Environment::$db->get('tax');
$all = array_reverse($all)

?>


<div class="py-5 px-10">


    <div class="w-full flex justify-between items-end mb-5 gap-2">   

        <a href="nuevo/" id="dropdownCust" class="flex bg-[#1A1917] rounded-md px-3 py-1 justify-center items-center gap-3 " >
            <p class="text-white text-[20px]">Nuevo</p>
            <svg class="" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
        </a>

    </div>


    <div class="w-full ">

        <div class="mb-3 grid grid-cols-3 bg-[#ffffff] border-[1px] p-2 font-[700]">
            <h2>Nombre</h2>
            <h2>Valor</h2>
            <h2>Tipo</h2>
            <h2></h2>
        </div>

        <?php
            foreach ($all as $i) {
        ?>
            <div data-url="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('prod', $i["id2"]);?>" class="db_div bg-[#ffffff] border-[1px] mb-1 grid grid-cols-3 items-center p-2 rounded-xl">

                <h2 ><?= $i["name"]?></h2>
                <h2><?= $i["value"]?>%</h2>


                <div class="items-center grid grid-cols-2 gap-[50%]">

                    <?php if ($i["type"] == 1) {?>
                        <h2 class="py-1 px-2 text-[#258cd4] bg-[#55a8e2] bg-opacity-20 text-center rounded-2xl">IVA</h2>
                    <?php }else{ ?>
                        <h2 class="py-1 px-0.5 text-[#3cc93c] bg-[#70d870] bg-opacity-20 text-center  rounded-2xl">IRPF</h2>
                    <?php } ?>
                    
                    <div class="flex items-center">

                        <button data-popover-target="popover-<?=$i['id2']?>" data-popover-placement="bottom" type="button" class="bg-blak">
                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M960 1468.235c93.448 0 169.412 75.965 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.447 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.448-75.964 169.412-169.412 169.412-93.448 0-169.412-75.964-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Zm0-677.647c93.448 0 169.412 75.964 169.412 169.412 0 93.447-75.964 169.412-169.412 169.412-93.448 0-169.412-75.965-169.412-169.412 0-93.448 75.964-169.412 169.412-169.412Z" fill-rule="evenodd"></path> </g></svg>
                        </button>
                        <div data-popover id="popover-<?=$i['id2']?>" role="tooltip" class="absolute z-10 invisible inline-block  text- text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div class="">
                                <ul class="p-2 flex flex-col justify-center items-center">

                                    <li class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] rounded-md text-[#000000]">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#000000"></path> </g></svg>
                                        <a href="ed?item=<?=Intratum\Facturas\Util::getUUIDByID2('tax', $i["id2"]);?>" class="">Editar</a>    
                                    </li>

                                    <li class="w-full ">

                                        <a href="del?item=<?=Intratum\Facturas\Util::getUUIDByID2('tax', $i["id2"]);?>" class="w-full flex gap-3 p-2 hover:bg-[#fafafafa] text-[#FE0000] rounded-md">
                                            <svg width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#FE0000" stroke="#FE0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#FE0000" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"></path></g></svg>
                                            <p>Eliminar</p>
                                        </a> 

                                    </li>

                                </ul>
                            </div>
                            <div class="place-self-end" data-popper-arrow></div>
                        </div>  

                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

