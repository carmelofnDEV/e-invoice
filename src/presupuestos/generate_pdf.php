<?php
$pdf = new \mikehaertl\wkhtmlto\Pdf;
ob_start();
include("./templates/pdf/template_1.php");
$template = ob_get_clean();
$pdf->addPage($template);
if (!$pdf->saveAs('./tmp/invoices/'.$name.'.pdf')) {
	//$error = $pdf->getError();
}