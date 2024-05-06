<?php
    $invoiceTaxsList = []
?>

    <style>
        body {
            font-family: "Gill Sans", sans-serif;
        }
        
        * {
            margin: 0px;
            padding: 0px;
        }
        
        header {
            background-color: rgb(120, 132, 233);
            text-align: start;
            margin-bottom:20px;

        }
        
        h1 {
            font-size: 80px;
            padding: 10px;
            
            border-bottom:5px solid rgb(80, 88, 156);
        }
        
        h2 {
            margin-bottom: 10px;
        }

        #emisor-table {
        }

        #emisor-div {
            margin-left: 20px;
        }
        
        #first-div {
            margin-left: 20px;
        }
        
        #central {
            width: 200px;
        }
        
        #sec-div {
            margin-right: 40px;
        }

        .hr-blue{
            background-color:rgb(80, 88, 156);
            height:5px;  
            margin-top:20px;
            margin-bottom:20px;

        }


        .total-menu{

            text-align:end;

        }



        /* css tabla  */
        .factura-table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid rgb(120, 132, 233);
        }

        .factura-table th, .factura-table td {
            border: 1px solid rgb(120, 132, 233);
            padding: 12px;
            text-align: left;
        }

        .factura-table th {
            background-color: rgb(120, 132, 233);
            color: white;
            font-weight: bold;
        }

        .factura-table tr:nth-child(even) {
            background-color: rgba(120, 132, 233, 0.1);
        }

        .factura-table tr:hover {
            background-color: rgba(120, 132, 233, 0.2);
        }

        .factura-table .total-menu {
            font-weight: bold;
            color: rgb(120, 132, 233);
        }



        .factura-div {
            border: 2px solid rgb(120, 132, 233);
            padding: 10px;
            margin-top: 20px; /* Ajusta el margen según sea necesario */
        }

        .factura-div table {
            width: 100%;
            border-collapse: collapse;
        }

        .factura-div th, .factura-div td {
            border: 1px solid rgb(120, 132, 233);
            padding: 12px;
            text-align: left;
        }

        .factura-div th {
            background-color: rgb(120, 132, 233);
            color: white;
            font-weight: bold;
        }

        .factura-div th:first-child, .factura-div td:first-child {
            width: 200px; /* Ajusta el ancho según sea necesario */
        }
    </style>

    <body>
        <header>
            <?php if ($factura["type"] == 1) {?>
                <h1>FACTURA </h1>
            <?php }else if ($factura["type"] == 2) {?>
                <h1>PRESUPUESTO </h1>
            <?php }?>
        </header>

        <main>
        <table id="emisor-table">
                <tbody>
                    <tr>
                        <td>
                            <div id="emisor-div">
                                <h2>EMISOR:</h2>
                                <h3>
                                    <?=$acc["first_name"]?>
                                        <?=$acc["last_name"]?>
                                </h3>
                                <h3>NIF:
                                    <?=$acc["NIF"]?>
                                </h3>
                                <h3>
                                    <?=$acc["address1"]?>
                                        <?=$acc["address2"]?>
                                </h3>
                                <h3>
                                    <?=$acc["zip"]?>,
                                        <?=$acc["country"]?>,
                                            <?=$acc["state"]?>
                                </h3>

                            </div>
                        </td>
                </tbody>
            </table>
            <hr class="hr-blue">

            <table >
                <tbody>
                    <tr>
                        <td>
                            <div id="first-div">
                                <h2>RECEPTOR:</h2>
                                <h3>

                                </h3>
                                <h3>NIF:
                                    <?=$factura["NIF"]?>
                                </h3>
                                <h3>

                                </h3>
                                <h3>
                                    <?=$factura["zip"]?>,
                                        <?=$factura["country"]?>,
                                            <?=$factura["state"]?>
                                </h3>

                            </div>
                        </td>
                        <td>
                            <div id="central"></div>
                        </td>
                        <td>
                            <div id="sec-div">

                                
                            <?php if ($factura["type"] == 1) {?>
                                <h2>NUM FACTURA:</h2>

                                <h2>FECHA FACTURA:</h2>

                            <?php }else if ($factura["type"] == 2) {?>
                                <h2>NUM PRESUPUESTO:</h2>

                                <h2>FECHA PRESUPUESTO:</h2>

                            <?php }?>
                                

                            </div>
                        </td>
                        <td>

                            <?php if ($factura["type"] == 1) {?>
                                <h2><?=$serial[0]["serial_tag"]?>-<?=$factura["invoice_number"]?></h2>
                                
                            <?php }else if ($factura["type"] == 2) {?>

                                <h2><?=$factura["name"]?></h2>
                            
                            <?php } ?>

                            <h2><?=DateTime::createFromFormat('Y-m-d H:i:s', $factura["created"])->format('Y-m-d')?></h2>


                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr class="hr-blue">
            <table class="factura-table">
                <tbody>
                    <tr>
                        <td>NOMBRE</td>
                        <td>DESCRIPCIÓN</td>
                        <td>PRECIO UNITARIO</td>
                        <td>CANTIDAD</td>
                        <td>IMPORTE</td>
                    </tr>
                                
                    <?php 
                        foreach ($items as $key) {
                            $db2 = Intratum\Facturas\Environment::$db;     
                            
                            $db2->where('id', $key["id_item"]);
                            $item = $db2->get('product');
                            $item = $item[0] ;



                            $db2->where('type', $key["id_item"]);
                            $serial = $db2->get('invoice');


                            $db2->where('invoice_item_id', $key["id"]);
                            $taxs = $db2->get('invoice_item_tax');

                            foreach ($taxs as $tax) {

                                $db2->where('id', $tax["tax_id"]);
                                $tax_name = $db2->get('tax');
                                $tax_name = $tax_name[0]["name"]; 

                                $item_tax = [
                                    "tax_id" => $tax["tax_id"],
                                    "tax_value"=> $tax["tax_value"],
                                    "tax_total"=> $tax["value"],
                                    "tax_name"=> $tax_name,

                                ];

                                $existe = false;
                                foreach ($invoiceTaxsList as $index => $invTax) {
                                    if($invTax["tax_id"] == $item_tax["tax_id"]){
                                        $invoiceTaxsList[$index]["tax_total"] += $item_tax["tax_total"];
                                        $existe = true;

                                    }
                                }

                                if($existe == false){
                                    $invoiceTaxsList[] = $item_tax;
                                }
                            }

                    ?>

                    <tr>
                        <td><?= $item["title"]?></td>
                        <td><?= $item["description"]?></td>
                        <td><?= $key["subtotal"] / $key["quantity"]?></td>
                        <td><?= $key["quantity"]?></td>
                        <td><?= $key["subtotal"] * $key["quantity"]?></td>
                    </tr>

                    <?php } ?>
                    
                    <?php 
                        foreach ($invoiceTaxsList as $invoice_tax) {
                    ?>

                    <tr>
                        <td colspan="4"><p class="total-menu"><?=$invoice_tax["tax_name"]?> <?=$invoice_tax["tax_value"]?>%</p></td>
                        <td ><p class="total-menu"><?=$invoice_tax["tax_total"]?>€</p></td>
                    </tr>

                    <?php } ?>



                    <tr>
                        <td colspan="4"><p class="total-menu">SUBTOTAL: </p></td>
                        <td ><p class="total-menu"><?=$factura["subtotal"]/100?>€</p></td>
                    </tr>

                    <tr>
                        <td colspan="4"><p class="total-menu">TOTAL: </p></td>
                        <td ><p class="total-menu"><?=$factura["total"]/100?>€</p></td>
                    </tr>





                </tbody>    
            </table>
            <div class="factura-div">
                <table>
                    <tbody>
                        <tr>
                            <th>Terminos y condiciones:</th>
                        </tr>
                        <tr>
                            <td><?=$factura["invoice_terms"]?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>


        <footer></footer>
    </body>