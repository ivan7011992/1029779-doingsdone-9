<?php
$end = end($table3);
$sumall = 0;
$vsego_nachis= $end['VSEGO_NACHIS'] + $end['SUMMA_PERER'] + $table3[0]['SUM_ODN'] +  $end['SUM_POVISH'];
$ALL  = $vsego_nachis +  $table3[0]['SALDO_PRED'] -  $table3[0]['SUMMA_OPLAT'];
if ($ALL > 0){
    $ALL  = $vsego_nachis +  $table3[0]['SALDO_PRED'] -  $table3[0]['SUMMA_OPLAT'];
    }else{
    $ALL = 0;
}
$ALL1 = $ALL;

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 8px;

        }

        h1 {
            text-align: center;
            font-size: 15px;
            font-weight: 200;
        }

        h2 {
            text-align: center;
            font-size: 15px;
            margin-top: -7px;
            word-spacing: 4px;
        }



        table {
            border-collapse: collapse;
        }

        .table2 th {
            width: 10%;
            border: 1px solid black;
            font-size: 8px;

        }


        .table3 td {

            border: 1px solid black;
        }

        th {
            border: 1px solid black;
        }

        .table2 td {
            border: 1px solid black;
        }

        .table2 th:nth-child(3) {
            width: 30%;
        }

        .table2 th:nth-child(2) {
            width: 30%;
        }


        li {
            list-style-type: none;
        }

        #footer {
            	position: absolute;
            left: 0;
            bottom: 0;
            padding: 10px;
            background: white;
            color: black;
            width: 100%;
            font-size: 9px;
            text-align: justify;
        }

        .table4 {
            width: 50%;

        }

        .table4 td {

            border: 1px solid black;
        }

        .table3 td {

            border: 1px solid black;
        }
        .table3 th{

            padding: 5px;

        }

        .no-border {
            border-width: 0!important;
        }

        table.table3 tr td  {
            padding: 5px;
        }


    </style>
</head>
<body>

<div>
    <h1> ЕДИНЫЙ ПЛАТЕЖНЫЙ ДОКУМЕНТ по л/с <?= $kod ?? '' ?> за <?= $date ?? ''?>  </h1>
    <h2> для внесения платы за предоставленные коммунальные услуги </h2>
</div>

<table  >
    <tr>
        <td width="45%" >
            <h3>Раздел 1. Сведения о плательщике и исполнителе услуг </h3>
            <p style="border: 1px solid black;
             font-size: 8px!important; padding: 5px;">
                За <?=$date ?? '' ?>  (расчетный период)
                <br>
                Ф.И.О. (наименование) плательщика собственника/нанимателя:
                <br>
                <?=$FIO ?? ''?>
                <br>
                Адрес помещения: <?= $ADDRESS ?? ''?>
                <br>
                Площадь помещения: <?= $S ?? '' ?>
                <br>
                Количество проживающих: <?= $CountTenants ?? '' ?> чел.
                <br>
                Организация – исполнитель услуг: МУП Г.НОВОСИБИРСКА «ГОРВОДОКАНАЛ»
                <br>
                ИНН 5411100875 КПП 540701001
                <br>
                Адрес:630099, г.Новосибирск, ул.Революции,5
                <br>
                Телефон, факс, адрес электронной почты, адрес сайта в сети Интернет:
                <br>
                Сайт: www.gorvodokanal.com
                <br>
                Телефон +7(383)204-99-19; Факс +7(383)210-14-23; Email:gorvoda@mail.ru
            </p>
        </td>

        <td valign="top"
            style="padding-left: 10px">
            <h3> 2.Информация для внесения платы получателю платежа (получателям платежей)</h3>

            <table style="border: 1px solid black">
                <tr>
                    <th>Наименование получателя платежа</th>
                    <th>Номер банковского счета и банковские реквизиты</th>
                    <th>№ лицевого счета (иной идентификатор плательщика)</th>
                    <th>Сумма к оплате за расчетный период, руб</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black"> МУП Г. НОВОСИБИРСКА «ГОРВОДОКАНАЛ»
                        ИНН: 5411100875
                        КПП: 540701001
                    </td>
                    <td style="border: 1px solid black"> БИК 045004641
                        Р/С 40602810044020100003
                        Сибирский банк ПАО Сбербанк
                        К/С 30101810500000000641
                    </td>
                    <td style="border: 1px solid black"><?= $kod ?></td>
                    <td style="border: 1px solid black"> <?= $ALL1 ?> </td>
                </tr>
                <tr>
                <td colspan="4" style="border: 1px solid black">
                        <table class="no-border">
                            <tr>
                                <td class="no-border" valign="top"> Справочно</td>

                                <td class="no-border">
                                    <li>Задолженность за предыдущие периоды:</li>
                                    <br>
                                    <li> Аванс на начало расчетного периода:</li>
                                    <br>
                                    <li> Дата последней поступившей оплаты:</li>
                                    <br>
                                    <li> Оплачено (в расчетном периоде):</li>
                                    <br>
                                    <li> Итого к оплате:</li>
                                    <br>
                                    <li>Начисления по судебным расходам</li>
                                    <br>
                                </td>

                                <td class="no-border" style="margin-left: 10px">
                                    <li style=" margin-left: 19px"><?=$DEPT ?? '' ?></li>
                                    <br>
                                    <li style=" margin-left: 19px"><?=$OVERPAY  ?? ''  ?></li>
                                    <br>
                                    <li style=" margin-left: 19px"><?=date('d-m-Y', strtotime($DATE))?></li>
                                    <br>
                                    <li style=" margin-left:19px"><?=$SUMMA_OPLAT?> </li>
                                    <br>

                                    <li style=" margin-left: 19px"><?=$ALL1  ?></li>
                                    <br>

                                    <li style=" margin-left: 19px"><?=$GOSP?></li>
                                    <br>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td style="font-size: 8px">

            <h3>Расчёт размера платы коммунальные услуги</h3>

            <table class="table3">
                <tr>
                    <th colspan="2" rowspan="2"> Виды услуг</th>
                    <th rowspan="2">Ед. изм</th>
                    <th colspan="2">Объем коммун. услуг</th>
                    <th rowspan="2">Тариф</th>
                    <th colspan="2"> Размер платы за коммун.услуги</th>
                    <th rowspan="2"> Всего начисл. за период</th>
                    <th rowspan="2"> Перерасчеты всего, руб.</th>
                    <th rowspan="2">Размер повышающего коэфициента</th>
                    <th colspan="3"> Итого к оплате за расчетный период, руб.</th>

                </tr>
                <tr>

                    <td>индив. потреб.</td>
                    <td>общедом. нужды</td>
                    <td> индив. потреб.</td>
                    <td> общедом. нужды</td>
                    <td> всего</td>
                    <td> индив. потреб</td>
                    <td> общедом .нужды</td>

                </tr>
                <tr>
                    <td colspan="2" class="pl">1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                    <td>13</td>
                </tr>
                <?php foreach ($table3 as $table) {
                    $ALL = $table['SUMMA_PERER']+ $table['SUM_POVISH'] + $table['SUM_ODN'] + $table['VSEGO_NACHIS'];
                    $INDIV_CONSUMPTION = $table['SUMMA_PERER'] + $table['SUM_POVISH'] + $table['VSEGO_NACHIS'] - $table['IS_POVISH_ODN'];
                    $COMMON_HOUSE_NEEDS =  $table['SUM_ODN'] +  $table['IS_POVISH_ODN'];

                    $sumall += $table['SUM_POVISH'];
                ?>

                <tr style="height: 40px">
                    <td colspan="2"><?= $table['USL'] ?></td>
                    <td>м(3)</td>
                    <td><?=$table['VOL']?> </td>
                    <td> <?=$table['VOLUME_ODN']?></td>
                    <td><?= $table['TARIF'] ?> </td>
                    <td><?= $table['VSEGO_NACHIS']?></td>
                    <td><?= $table['SUM_ODN']?></td>
                    <td><?= $table1=$table['VSEGO_NACHIS'] + $table['SUM_ODN'] ?></td>
                    <td><?= $table['SUMMA_PERER']?></td>
                    <td><?= $table['SUM_POVISH'] ?></td>
                    <td><?=  $ALL ?></td>
                    <td><?=  $INDIV_CONSUMPTION ?></td>
                    <td><?=  $COMMON_HOUSE_NEEDS ?></td>
                </tr>
                <?php } ?>
            </table>
        </td>

        <td valign="top" style="padding-left: 10px;">

            <h3>Справочная информация</h3>

            <table class="table4" style="width: 100%">
                <tr>
                    <th colspan="3"> Текущие показания приборов учета</th>
                </tr>
                <tr>
                    <td style="white-space: nowrap"> Номер ПУ</td>
                    <td> Дата показаний</td>
                    <td> Показания ПУ</td>
                </tr>
                <?php foreach ($vodomers as $vodomer): ?>
                <tr>
                    <td> <?= $vodomer['N_VODOMER']  ?></td>

                    <td> <?=  date('d-m-Y', strtotime( $vodomer['DAT_POKAZ']))?></td>

                    <td> <?= $vodomer['POKAZ'] ?></td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty( $vodomers)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center"> Нет данных </td>
                    </tr>
                <?php endif ?>
            </table>

        </td>
    </tr>

</table>
<div id="footer">
    Оплата услуг за текущий месяц должна производиться до 10-го числа следующего за истекшим месяцем. Показания
    индивидуальных приборов учета за текущий месяц, рекомендовано передавать в ресурсоснабжающую организацию до 25 числа
    ТЕКУЩЕГО месяца. При отсутствии показаний расчет производится по СРЕДНЕМУ ПОТРЕБЛЕНИЮ. (Постановление правительства
    РФ от 06.05.2011 №354).
    Производить оплату за услуги холодного водоснабжения и водоотведения без взимания комиссии возможно через: кассы
    предприятия (ул. Революции,5 с пн. по пт с 8-00 до 18-00, суб. с 8-00 до 16-00.; ул.Эйхе, 13 с пн. по пт. с 9-00 до
    18-00; ул.Ветлужская, 10 с пн по пт. с 9-00 до 18-00; ул.Вертковская,1А с пн. по пт. с 8-00 до 18-00; ул.Демьяна
    Бедного,45 с пн. по пт. с 9-00 до 18-00; д.п. Кудряшовский, ул.Октябрьская,11 с пн. по пт. с 09-00 до 18-00(обед с 13.00 до 14.00),
    суб.с 9-00 до 16-00; г.Обь, ул.Шевченко,1А с пн. по пт. с 8-00 до 17-00); личный кабинет на сайте МУП г.Новосибирска
    «ГОРВОДОКАНАЛ» (www.gorvodokanal.com); в организациях, в том числе через личные кабинеты, согласно списку,
    размещенному на сайте МУП г.Новосибирска «ГОРВОДОКАНАЛ» (www.gorvodokanal.com) в разделе «Информация для абонентов»

</div>
</body>
</html>
