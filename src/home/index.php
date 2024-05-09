<?php
    $isLoggin = Intratum\Facturas\Util::checkSession();
    $user = Intratum\Facturas\Util::getSessionUser();
    $acc = Intratum\Facturas\User::getUserAccount($user["id"]);
?>


<h1 class="text-[30px] text-center mt-10">
    Bienvinido <?= $user["first_name"]?>.
</h1>

<div class="flex flex-col justify-center items-center m-10">

    <?php
        $data = Intratum\Facturas\Factura::getAnalitycs();
    ?>

    <!-- Trimestre 1 -->
    <div id="t1" class="w-full">
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>INGRESOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#add9ac] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ingresost1 = 0;
                                $baseint1 = 0;
                                $ivaingt1 = 0;
                                foreach ($data["ingresos"]["t1"] as $key) { 
                                    $ingresost1 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $baseint1 +=  $key["subtotal"];
                                    $ivaingt1 += $key["total_iva"];
                            ?>
                            <tr class="bg-[#caffcc] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>GASTOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#FF6D60] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $gastost1 = 0;
                                $basegast1 = 0;
                                $ivagastt1=0; 
                                foreach ($data["gastos"]["t3"] as $key) { 
                                    $gastost1 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $basegast1 +=  $key["subtotal"];
                                    $ivagastt1 += $key["total_iva"];
                            ?>   
                            <tr class="bg-[#ff8c75] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-[50%] h-[50%] bg-[#c8c8c8] rounded flex flex-col shadow-xl justify-center p-3">
                <h1 class="p-3 text-white text-[20px] font-[700] border-b-2">Resultados <span>T1</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE <strong>IRPF</strong> <span class="ml-4"><?= max(0.20*($baseint1 - $basegast1), 0) ?>€</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE  <strong>IVA</strong> <span class="ml-4"><?= max($ivagastt1 + $ivaingt1, 0) ?>€</span></h1>
            </div>
            <div class="w-full rounded flex justify-center">
                <div class="py-6" id="pie-chart-t1"></div>
            </div>
        </div>
    </div>

    <!-- Trimestre 2 -->
    <div id="t2" class="w-full">
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>INGRESOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#add9ac] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ingresost2 = 0;
                                $baseint2 = 0;
                                $ivaingt2 = 0;
                                foreach ($data["ingresos"]["t2"] as $key) { 
                                    $ingresost2 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $baseint2 +=  $key["subtotal"];
                                    $ivaingt2 += $key["total_iva"];
                            ?>
                            <tr class="bg-[#caffcc] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>GASTOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#FF6D60] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $gastost2 = 0;
                                $basegast2 = 0;
                                $ivagastt2=0; 
                                foreach ($data["gastos"]["t2"] as $key) { 
                                    $gastost2 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $basegast2 +=  $key["subtotal"];
                                    $ivagastt2 += $key["total_iva"];
                            ?>   
                            <tr class="bg-[#ff8c75] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-[50%] h-[50%] bg-[#c8c8c8] rounded flex flex-col shadow-xl justify-center p-3">
                <h1 class="p-3 text-white text-[20px] font-[700] border-b-2">Resultados <span>T2</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE <strong>IRPF</strong> <span class="ml-4"><?= max(0.20*($baseint2 - $basegast2), 0) ?>€</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE  <strong>IVA</strong> <span class="ml-4"><?= max($ivagastt2 + $ivaingt2, 0) ?>€</span></h1>
            </div>
            <div class="w-full rounded flex justify-center">
                <div class="py-6" id="pie-chart-t2"></div>
            </div>
        </div>
    </div>

    <!-- Trimestre 3 -->
    <div id="t3" class="w-full">
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>INGRESOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#add9ac] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ingresost3 = 0;
                                $baseint3 = 0;
                                $ivaingt3 = 0;
                                foreach ($data["ingresos"]["t3"] as $key) { 
                                    $ingresost3 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $baseint3 +=  $key["subtotal"];
                                    $ivaingt3 += $key["total_iva"];
                            ?>
                            <tr class="bg-[#caffcc] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>GASTOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#FF6D60] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $gastost3 = 0;
                                $basegast3 = 0;
                                $ivagastt3=0; 
                                foreach ($data["gastos"]["t3"] as $key) { 
                                    $gastost3 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $basegast3 +=  $key["subtotal"];
                                    $ivagastt3 += $key["total_iva"];
                            ?>   
                            <tr class="bg-[#ff8c75] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-[50%] h-[50%] bg-[#c8c8c8] rounded flex flex-col shadow-xl justify-center p-3">
                <h1 class="p-3 text-white text-[20px] font-[700] border-b-2">Resultados <span>T3</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE <strong>IRPF</strong> <span class="ml-4"><?= max(0.20*($baseint3 - $basegast3), 0) ?>€</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE  <strong>IVA</strong> <span class="ml-4"><?= max($ivagastt3 + $ivaingt3, 0) ?>€</span></h1>
            </div>
            <div class="w-full rounded flex justify-center">
                <div class="py-6" id="pie-chart-t3"></div>
            </div>
        </div>
    </div>

    <!-- Trimestre 4 -->
    <div id="t4" class="w-full">
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>INGRESOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#add9ac] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ingresost4 = 0;
                                $baseint4 = 0;
                                $ivaingt4 = 0;
                                foreach ($data["ingresos"]["t4"] as $key) { 
                                    $ingresost4 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $baseint4 +=  $key["subtotal"];
                                    $ivaingt4 += $key["total_iva"];
                            ?>
                            <tr class="bg-[#caffcc] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full">
                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>GASTOS</h1>
                </div>
                <div class="relative overflow-x-auto shadow-xl rounded-b-xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                        <thead class="text-[15px] text-black uppercase bg-[#FF6D60] dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    TIPO IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BASE IMPONIBLE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CUOTA IVA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $gastost4 = 0;
                                $basegast4 = 0;
                                $ivagastt4=0; 
                                foreach ($data["gastos"]["t4"] as $key) { 
                                    $gastost4 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $basegast4 +=  $key["subtotal"];
                                    $ivagastt4 += $key["total_iva"];
                            ?>   
                            <tr class="bg-[#ff8c75] !text-black !text-[15px] border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $key["tax_value"]?>%
                                </th>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["total_iva"]?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $key["subtotal"] + $key["total_iva"]?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10 flex flex-row gap-3 w-full">
            <div class="w-[50%] h-[50%] bg-[#c8c8c8] rounded flex flex-col shadow-xl justify-center p-3">
                <h1 class="p-3 text-white text-[20px] font-[700] border-b-2">Resultados <span>T4</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE <strong>IRPF</strong> <span class="ml-4"><?= max(0.20*($baseint4 - $basegast4), 0) ?>€</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE  <strong>IVA</strong> <span class="ml-4"><?= max($ivagastt4 + $ivaingt4, 0) ?>€</span></h1>
            </div>
            <div class="w-full rounded flex justify-center">
                <div class="py-6" id="pie-chart-t4"></div>
            </div>
        </div>
    </div>




</div>

<!-- Pestañas Trimestres -->
<script>
    $('[id^="t"]').hide();

    $(document).ready(function() {

        var today = new Date();

        var month = today.getMonth();

        var trimestreActual = Math.floor(month / 3) + 1;
        $('#valor').val(trimestreActual);
        $('#t' + trimestreActual).show(); 

        $('#valor').change(function(){
            var trimestreId = $(this).val();
            $('[id^="t"]').hide();

            $('#t' + trimestreId).show();
        });

    });
</script>


<!-- Trimestre 1 -->
<script>    
    <?php
        if ($ingresost1 + $gastost1 > 0) {
            $gastost1_percentage = round(100 * ($gastost1 / ($ingresost1 + $gastost1)), 2);
            $gastost1_percentage = max($gastost1_percentage, 0);
        } else {
            $gastost1_percentage = 0;
        }

        if ($ingresost1 + $gastost1 > 0) {
            $ingresost1_percentage = round(100 * ($ingresost1 / ($ingresost1 + $gastost1)), 2);
            $ingresost1_percentage = max($ingresost1_percentage, 0);
        } else {
            $ingresost1_percentage = 0;
        }
    ?>


    let ingresost1 = <?= $ingresost1_percentage ?>;
    let gastost1 = <?= $gastost1_percentage ?>;

    if (ingresost1 != 0 || gastost1 != 0 ) {
        const getChartOptions = () => {
            return {
                series: [ingresost1, gastost1],
                colors: ["#add9ac", "#FF6D60"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Ingresos", "Gastos"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            };
        };

        if (document.getElementById("pie-chart-t1") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart-t1"), getChartOptions());
            chart.render();
        }
    }
</script>


<!-- Trimestre 2 -->
<script>    
    <?php
        if ($ingresost2 + $gastost2 > 0) {
            $gastost2_percentage = round(100 * ($gastost2 / ($ingresost2 + $gastost2)), 2);
            $gastost2_percentage = max($gastost2_percentage, 0);
        } else {
            $gastost2_percentage = 0;
        }

        if ($ingresost2 + $gastost2 > 0) {
            $ingresost2_percentage = round(100 * ($ingresost2 / ($ingresost2 + $gastost2)), 2);
            $ingresost2_percentage = max($ingresost2_percentage, 0);
        } else {
            $ingresost2_percentage = 0;
        }
    ?>


    let ingresost2 = <?= $ingresost2_percentage ?>;
    let gastost2 = <?= $gastost2_percentage ?>;

    if (ingresost2 != 0 || gastost2 != 0 ) {
        console.log(ingresost2," === ",gastost2)

        const getChartOptions = () => {
            return {
                series: [ingresost2, gastost2],
                colors: ["#add9ac", "#FF6D60"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Ingresos", "Gastos"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            };
        };

        if (document.getElementById("pie-chart-t2") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart-t2"), getChartOptions());
            chart.render();
        }
    }
</script>





<!-- Trimestre 3 --> 
<script>    
    <?php
        if ($ingresost3 + $gastost3 > 0) {
            $gastost3_percentage = round(100 * ($gastost3 / ($ingresost3 + $gastost3)), 2);
            $gastost3_percentage = max($gastost3_percentage, 0);
        } else {
            $gastost3_percentage = 0;
        }

        if ($ingresost3 + $gastost3 > 0) {
            $ingresost3_percentage = round(100 * ($ingresost3 / ($ingresost3 + $gastost3)), 2);
            $ingresost3_percentage = max($ingresost3_percentage, 0);
        } else {
            $ingresost3_percentage = 0;
        }
    ?>


    let ingresost3 = <?= $ingresost3_percentage ?>;
    let gastost3 = <?= $gastost3_percentage ?>;

    if (ingresost3 != 0 || gastost3 != 0 ) {
        console.log(ingresost3," === ",gastost3)

        const getChartOptions = () => {
            return {
                series: [ingresost3, gastost3],
                colors: ["#add9ac", "#FF6D60"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Ingresos", "Gastos"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            };
        };

        if (document.getElementById("pie-chart-t3") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart-t3"), getChartOptions());
            chart.render();
        }
    }
</script>


<!-- Trimestre 4 -->

<script>    
    <?php
        if ($ingresost4 + $gastost4 > 0) {
            $gastost4_percentage = round(100 * ($gastost4 / ($ingresost4 + $gastost4)), 2);
            $gastost4_percentage = max($gastost4_percentage, 0);
        } else {
            $gastost4_percentage = 0;
        }

        if ($ingresost4 + $gastost4 > 0) {
            $ingresost4_percentage = round(100 * ($ingresost4 / ($ingresost4 + $gastost4)), 2);
            $ingresost4_percentage = max($ingresost4_percentage, 0);
        } else {
            $ingresost4_percentage = 0;
        }
    ?>


    let ingresost4 = <?= $ingresost4_percentage ?>;
    let gastost4 = <?= $gastost4_percentage ?>;

    if (ingresost4 != 0 || gastost4 != 0 ) {
        console.log(ingresost4," === ",gastost4)

        const getChartOptions = () => {
            return {
                series: [ingresost4, gastost4],
                colors: ["#add9ac", "#FF6D60"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Ingresos", "Gastos"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + "%"
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            };
        };

        if (document.getElementById("pie-chart-t4") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart-t4"), getChartOptions());
            chart.render();
        }
    }
</script>


