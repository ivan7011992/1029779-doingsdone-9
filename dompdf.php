<?php

require_once 'vendor/autoload.php';
require_once "helpers.php";


use Dompdf\Dompdf;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
?>

<html>
<head>
    <meta charset="utf-8">

</head>

<body>

<form method="POST" enctype="multipart/form-data" action="dompdf.php">

    <button type="submit">Submit</button>
</form>
</body>

</html>