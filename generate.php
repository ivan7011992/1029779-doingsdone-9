<?php

require_once 'vendor/autoload.php';

require_once 'Student.php';

// создаем объект класса PhpOffice\PhpWord\PhpWord
$phpWord = new \PhpOffice\PhpWord\PhpWord();

// вызываем метод addSection у созданного объекта
$section = $phpWord->addSection();

//вызвваем метод addtext этого объекта в качестве аргумента передают текст
$section->addText(
    '"Learn from yesterday, live for today, hope for tomorrow. '
    . 'The important thing is not to stop questioning." '
    . '(Albert Einstein)'
);
//вызываем статический метод createwriter и в качестве аргумента передаем объект phpword
// второй аргумент -это фрмат в ктором его нужно сохранять
// метод createwriter сохдаст объект, который положится в objwriter
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

//вызываем метод save у этога объекта ,куда сохранить
$objWriter->save('helloWorld.docx');
