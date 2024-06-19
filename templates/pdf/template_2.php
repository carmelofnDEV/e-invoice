<?php
    $invoiceTaxsList = []
?>

<style>

    body{
        padding-top: 50px;
        padding-bottom: 30px;
        padding-left: 100px; 
        padding-right: 100px; 


    }

    .num_td{
        background-color:green;
        text-align:center;
        padding-left:5px;
        padding-right:5px;
        color:white;

    }

    
    .num_td_data{
        text-align:center;
        font-weight:900;

    }

    .num_div{
        min-width:500px;
    }

    #logo_img{
        width:40%;
    }

    .name_cust{
        font-weight:900;
        font-size:20px;

    }

    #main_table{
        width:100%;
        border:1px solid #C5C5C5;

    }

    #main_table {
            border-spacing: 0; 
            width: 100%; 
        }

    #main_table td, #main_table th {
        border-right: 1px solid #C5C5C5; 
        padding: 8px;
        text-align: left; 
    }

    #main_table th:last-child, #main_table td:last-child {
        border-right: none; /* No aplicar borde a la última columna */
    }

    .header_table {
        background-color: green;
        text-align: center !important; 
        color: white;
    }

    .head_last_table{
        background-color: green;
        text-align: center !important; 
        color: white;
    }

    .data_last_table{
        text-align:center;
        font-weight:900;
        border:1px solid #C5C5C5;


    }

    .terms{
        font-size:15px;
        margin-bottom:20px;
    }

</style>

<body>
  <div>
    <?php if ($_SERVER['SERVER_PORT'] == '80') { ?>
      <div>
        <img id="logo_img" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo">
      </div>
    <?php } elseif ($_SERVER['SERVER_PORT'] == '443') { ?>
      <div>
        <img id="logo_img" src="https://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo">
      </div>
    <?php } elseif ($_SERVER['SERVER_PORT'] == '8086') { ?>
      <div>
        <img id="logo_img" src="http://<?= $_SERVER['HTTP_HOST'] ?>/static/images/<?=$acc["hash_logo"]?>" alt="Logo">
      </div>
    <?php } ?>

    <div>

        <p><?=$acc["first_name"]?> <?php if(!empty($acc["last_name"])){echo ", ".$acc["last_name"];}?>
            <br>
            <?=$acc["address1"]?>
            <br>
        <?=$acc["NIF"]?>

    </div>

    <div style="display: flex; justify-content: space-between; align-items: flex-start;">

        
    <table style="width: 100%;">
        
        <tr>

            <td  style="width: 87%;" >&nbsp;</td>

            <td class="num_td">

                <?php if ($factura["type"] == 1 || $factura["type"] == 3) { ?>
                    Num Factura:
                <?php } elseif ($factura["type"] == 2) { ?>
                    Num Presupuesto:
                <?php } ?>

            </td>

        </tr>

        <tr>

            <td  class="name_cust"><?=$factura["first_name"]?> <?php if(!empty($factura["last_name"])){echo ", ".$factura["last_name"];}?></td>

            <td class="num_td_data">

                <?php if ($factura["type"] == 1 || $factura["type"] == 3) { ?>

                    <?php if($factura["type"] == 3){echo "R";}?><?php if (strlen($serial[0]["serial_tag"]) != 0) { echo $serial[0]["serial_tag"] . "-"; } ?><?=$factura["invoice_number"]?>
                    
                <?php } elseif ($factura["type"] == 2) { ?>

                    <?=$factura["name"]?>

                <?php } ?>

            </td>

        </tr>

        <tr>

            <td><?=$factura["address1"]?></td>

            <td class="num_td">

                Fecha:


            </td>

        </tr>

        <tr >

            <td><?=$factura["zip"]?> <?=$factura["state"]?></td>

            <td class="num_td_data">

              <?=DateTime::createFromFormat('Y-m-d H:i:s', $factura["created"])->format('Y-m-d')?>

            </td>

        </tr>


        <tr>

            <td><?=$factura["NIF"]?></td>


            <td></td>

        </tr>

        <?php if( $factura["type"] == 3 ){ ?>
        
            <tr>

                <td></td>


                <td class="num_td">Rectifica Nº:</td>

            </tr>

                
            <tr>

                <td></td>


                <td class="num_td_data"><?= $invoice_ref[0]["value"]?></td>

            </tr>

            <tr>

                <td></td>


                <td >&nbsp;</td>

            </tr>
        <?php } ?>

    </table>



        <table  id="main_table">
            <tr >
                <th  class="header_table"><span>Cantidad</span></th>
                <th style="width:70%;" class="header_table">Descripción</th>
                <th class="header_table">Importe</th>
                <th class="header_table">Total</th>
            </tr>
            <tbody style="min-height: 800px !important;" >
                <?php
                    $subtotalWithoutDisc = 0;
                    for ($i=0; $i < 21; $i++) { 

                   // foreach ($items as $key) {
                   if(!empty($items[$i])){
                    $key = $items[$i];

                    $db2 = Intratum\Facturas\Environment::$db;    
                    $subtotalWithoutDisc += $key["subtotal"];
                    $db2->where('id', $key["id_item"]);
                    $item = $db2->get('product')[0];
                    $db2->where('type', $key["id_item"]);
                    $serial = $db2->get('invoice');
                    $db2->where('invoice_item_id', $key["id"]);
                    $taxs = $db2->get('invoice_item_tax');
                    foreach ($taxs as $tax) {
                        $db2->where('id', $tax["tax_id"]);
                        $db2->where('state', 1);
                        $tax_name = $db2->get('tax')[0]["name"];
                        $item_tax = [
                        "tax_id" => $tax["tax_id"],
                        "tax_value" => $tax["tax_value"],
                        "tax_total" => $tax["value"],
                        "tax_name" => $tax_name,
                        ];
                        $existe = false;
                        foreach ($invoiceTaxsList as $index => $invTax) {
                        if ($invTax["tax_id"] == $item_tax["tax_id"]) {
                            $invoiceTaxsList[$index]["tax_total"] += $item_tax["tax_total"];
                            $existe = true;
                        }
                        }
                        if (!$existe) {
                        $invoiceTaxsList[] = $item_tax;
                        }
                    }
                ?>
                <tr>
                    <td style="text-align:center; font-weight:800;"><?= $key["quantity"]?></td>
                    <td style="text-align:start; font-weight:800;"><?= $item["title"]?></td>
                    <td style="text-align:right; font-weight:800;"><?= ($key["subtotal"] / $key["quantity"]) * (-1)?></td>
                    <td style="text-align:right; font-weight:800;"><?= $key["subtotal"] * (-1) ?></td>
                </tr>
                <?php }else{
                    ?>
                <tr>
                    <td style="text-align:center; font-weight:800;"></td>
                    <td style="text-align:start; font-weight:800;"></td>
                    <td style="text-align:right; font-weight:800;"></td>
                    <td style="text-align:right; font-weight:800;">&nbsp;</td>
                </tr>
                    <?php
                }
            
            } ?>


                


            </tbody>
        </table>

<div class="terms">
    <?= $factura["invoice_terms"] ?>
</div>

<div style="width: 100%;">

<table style=" width: 100%;">

    <tr>

        <!-- Primera columna -->
        <td style="vertical-align: top; width: 33.33%; padding-right: 25px;">

            <table style="text-align: center; width: 100%;">
                <tr>
                    <td class="head_last_table">Subtotal</td>
                </tr>
                <tr>
                    <td class="data_last_table"><?=( $factura["subtotal"] / 100)*(-1) ?>€</td>
                </tr>
                <?php if ($discount) { ?>
                    <tr>
                        <td class="head_last_table">Descuento (<?= $discount[0]["value"] ?>%)</td>
                    </tr>
                    <tr>
                        <td class="data_last_table">- <?= ($subtotalWithoutDisc * ($discount[0]["value"] / 100))*(-1) ?>€</td>
                    </tr>
                <?php } ?>
            </table>

        </td>

        <!-- Segunda columna -->
        <td style="vertical-align: top; width: 33.33%; padding-right: 25px;">

            <table style="text-align: center; width: 100%;">
                <?php foreach ($invoiceTaxsList as $invoice_tax) { ?>
                    <tr>
                        <td class="head_last_table"><?= $invoice_tax["tax_name"] ?> (<?= $invoice_tax["tax_value"] ?>%)</td>
                    </tr>
                    <tr>
                        <td class="data_last_table"><?= ($invoice_tax["tax_total"])*(-1) ?>€</td>
                    </tr>
                <?php } ?>
            </table>

        </td>

        <!-- Tercera columna -->
        <td style="vertical-align: top; width: 33.33%;">

            <table style="text-align: center; width: 100%;">
                <tr>
                    <td class="head_last_table">Total</td>
                </tr>
                <tr>
                    <td class="data_last_table"><?= ($factura["total"] / 100)*(-1) ?>€</td>
                </tr>
            </table>

        </td>

    </tr>

</table>

</div>




</body>
