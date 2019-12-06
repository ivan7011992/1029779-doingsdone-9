<?php

use PhpOffice\PhpWord\TemplateProcessor;

require_once 'vendor/autoload.php';

$a ='1';

$templateProcessor = new TemplateProcessor('shablon_payment.docx');
$templateProcessor->setValue('date', $a);
$templateProcessor->setValue('kod','ivan');



$templateProcessor->saveAs('result.docx');