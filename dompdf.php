<?php

require_once 'vendor/autoload.php';
require_once "helpers.php";


use Dompdf\Dompdf;


$html = include_template('template.php', [
    'title' => 'He, world1'
]);

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$output = $dompdf->output();

file_put_contents('output.pdf', $output);
