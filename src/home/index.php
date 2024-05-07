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

    <div class="flex flex-col justify-center items-center m-10">

        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h3 class="mb-1 text-xl text-center font-medium text-gray-900 dark:text-white p-3">
                Tu perfil
            </h3>
            <hr class="w-full h-[2px] bg-red">
            <div class="flex justify-end px-4 pt-4">
                <button data-modal-target="crypto-modal" data-modal-toggle="crypto-modal" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                    type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentBASE IMPONIBLE"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </button>
            </div>
            <div class="flex flex-col items-center pb-10">
                <?php if ($_SERVER['SERVER_PORT'] == '80') {?>
                <img class="w-[50%] h-[50%] mb-3 " src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo" />

                <div class="tm_logo"><img alt="Logo"></div>

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

        <?php
         $data = Intratum\Facturas\Factura::getAnalitycs();
        ?>

        <div class="mt-10 flex flex-row gap-3 w-full">

            <div class="w-full shadow-xl">

                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>INGRESOS</h1>
                </div>

                <div class="relative overflow-x-auto ">
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


                            foreach ($data["ingresos"]["t1"] as $key) { 
                                $ingresost1 +=  ($key["subtotal"] + $key["total_iva"]);
                                $baseint1 +=  $key["subtotal"];

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


            <div class="w-full shadow-xl">

                <div class="flex bg-[#c8c8c8] justify-center p-3 border-x-4 border-t-4 border-[#949494] rounded-t-lg border-dashed">
                    <h1>GASTOS</h1>
                </div>

                <div class="relative overflow-x-auto ">
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
                                foreach ($data["gastos"]["t3"] as $key) { 
                                    $gastost1 +=  ($key["subtotal"] + $key["total_iva"]);
                                    $basegast1 +=  $key["subtotal"];
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

                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE IVA <span class="ml-4"><?= max($baseint1 - $basegast1, 0) ?>€</span></h1>
                <h1 class="text-black text-[15px] font-[600] p-3">PAGO TRIMESTRAL DE IVA <span class="ml-4">???€</span></h1>
                

                                
                
            </div>

            <div class="w-full rounded flex justify-center">
                                
                <div class="py-6" id="pie-chart"></div>
                
            </div>



        </div>

    </div>

</div>

<script>

    let gastos = <?= round(100 * ($gastost1 / ($ingresost1 + $gastost1)),2)?>;
    let ingresos = <?= round(100 * ($ingresost1 / ($ingresost1 + $gastost1)),2)?>;

    const getChartOptions = () => {
  return {
    series: [ingresos,gastos],
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
          return value  + "%"
        },
      },
      axisTicks: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
    },
  }
}

if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
  chart.render();
}
</script>