<?php
$all=["1"=>1];
Intratum\Facturas\Environment::$db->where('state',1);
$allTaxs = Intratum\Facturas\Environment::$db->get('tax');

?>
<option value="" selected>Selecciona el tipo de impuesto</option>

<?php foreach ($allTaxs as $tax) {?>

<option value="<?=$tax["type"] . "/" . $tax["value"]?>">
<?=$tax["type"] . ":" . $tax["value"] . "%"?>
</option>
:
<?php }?>