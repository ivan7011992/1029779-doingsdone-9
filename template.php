<!DOCTYPE html>
<html>
<head>
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

        .table1 {
            border-style: solid;
            border-color: black;
            width: 83%;
            height: 280px;
            margin-top: 0px;
            border-width: 1px;
        }

        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        .table2 th {
            width: 10%;
            border: 1px solid black;
        }

        th {
            border: 1px solid black;
        }


        .table2 th:nth-child(3) {
            width: 30%;
        }

        .table2 th:nth-child(2) {
            width: 30%;
        }

        .list {
            float: left;
            margin: 0 -18px;
            line-height: 0.6;

        }

        li {
            list-style-type: none;
        }

        #footer {
            /*	position: fixed;*/
            left: 0;
            bottom: 0;
            padding: 10px;
            background: white;
            color: black;
            width: 100%;
            font-size: 12px;
            margin-top: 100px;
        }

        .block1 {
            width: 700px;
            display: inline-block;
            vertical-align: top;
        }

        .block2 {
            width: 700px;
            display: inline-block;
        }

        .table2 {

            width: 92%;
        }

        .caption {

            text-align: left;
        }

        .table3 {
            width: 54%;
            margin: 0px;
            display: inline-block;
        }

        .block4 {
            width: 352px;
            display: inline-block;
            /* float: right; */
            margin-right: 302px;
            padding: 0px;
            float: right;
        }

        .table4 {
            width: 106%;
        }

        table.no-border {
            border-width: 0;
        }
        table.no-border td,th{
            border-width: 0;
        }
    </style>
</head>
<body>

<div>
    <h1> ЕДИНЫЙ ПЛАТЕЖНЫЙ ДОКУМЕНТ по л/с #kod за #date </h1>
    <h2> для внесения платы за предоставленные коммунальные услуги </h2>
</div>

<table class="no-border">
    <tr>
        <td width="50%">
            <p style="margin: 0px;">Раздел 1. Сведения о плательщике и исполнителе услуг </p>
            <p style="border: 1px solid black">
                За #date____________(расчетный период)
                <br>
                Ф.И.О. (наименование) плательщика собственника/нанимателя:
                <br>
                #fio
                <br>
                Адрес помещения: #adres
                <br>
                Площадь помещения: #s
                <br>
                Количество проживающих: #count_p чел.
                <br>
                Организация – исполнитель услуг: МУП Г.НОВОСИБИРСКА «ГОРВОДОКАНАЛ»¬¬
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


        <td width="50%">
            <h3> 2.Информация для внесения платы получателю платежа (получателям платежей)</h3>

            <table class="table2">
                <tr>
                    <th>Наименование получателя платежа</th>
                    <th>Номер банковского счета и банковские реквизиты</th>
                    <th>№ лицевого счета (иной идентификатор плательщика)</th>
                    <th>Сумма к оплате за расчетный период, руб</th>
                </tr>
                <tr>
                    <td> МУП Г. НОВОСИБИРСКА «ГОРВОДОКАНАЛ»
                        ИНН: 5411100875
                        КПП: 540701001
                    </td>
                    <td> БИК 045004641
                        Р/С 40602810044020100003
                        Сибирский банк ПАО Сбербанк
                        К/С 30101810500000000641
                    </td>
                    <td>#ls</td>
                    <td> #itog_all</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <ul class="list">
                            <li>Справочно:</li>
                        </ul>

                        <ul class="list">
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
                        </ul>

                        <ul class="list">
                            <li>:#sum_dolg руб.</li>
                            <br>
                            <li>:#sum_avans руб.</li>
                            <br>
                            <li> :#date_last_opl</li>
                            <br>
                            <li> #sum_oplat руб</li>
                            <br>
                            <li> #itog_all руб.</li>
                            <br>
                            <li>#gosp руб.</li>
                            <br>
                        </ul>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


<div class="table3">
    <h3 class="caption">Раздел 3.РАСЧЕТ РАЗМЕРА ПЛАТЫ КОММУНАЛЬНЫЕ УСЛУГИ</h3>

    <table style="width: 64%">
        <tr>
            <th colspan="2" rowspan="2">Виды услуг</th>
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
            <td colspan="2">1</td>
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

        <tr style="height: 40px">
            <td colspan="2"> -</td>
            <td>-</td>
            <td> м(3).</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>

        </tr>

        <tr>
            <td colspan="2"> -</td>
            <td>-</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>

        </tr>
        <tr>
            <td colspan="2"></td>
            <td>-</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>

        </tr>
        <tr>
            <td colspan="2"></td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>
            <td> -</td>

        </tr>
    </table>

</div>

<div class="block4">
    <h3 style="text-align: left">Справочная информация</h3>


    <table class="table4">
        <tr>
            <th colspan="3"> Текущие показания приборов учета</th>
        </tr>
        <tr>
            <td> Номер ПУ</td>
            <td> Дата показаний</td>
            <td> Показания ПУ</td>
        </tr>
        <tr>
            <td> -</td>
            <td> -</td>
            <td> -</td>
        </tr>
    </table>

</div>

<div id="footer">
    Оплата услуг за текущий месяц должна производиться до 10-го числа следующего за истекшим месяцем. Показания
    индивидуальных приборов учета за текущий месяц, рекомендовано передавать в ресурсоснабжающую организацию до 23 числа
    ТЕКУЩЕГО месяца. При отсутствии показаний расчет производится по СРЕДНЕМУ ПОТРЕБЛЕНИЮ. (Постановление правительства
    РФ от 06.05.2011 №354).
    Производить оплату за услуги холодного водоснабжения и водоотведения без взимания комиссии возможно через: кассы
    предприятия (ул. Революции,5 с пн. по пт с 8-00 до 18-00, суб. с 8-00 до 16-00.; ул.Эйхе, 13 с пн. по пт. с 9-00 до
    18-00; ул.Ветлужская, 10 с пн по пт. с 9-00 до 18-00; ул.Вертковская,1А с пн. по пт. с 8-00 до 18-00; ул.Демьяна
    Бедного,45 с пн. по пт. с 9-00 до 18-00; д.п. Кудряшовский, ул.Октябрьская,11 с пн. по пт. с 10-00 до 19-00,суб. с
    9-00 до 16-00; г.Обь, ул.Шевченко,1А с пн. по пт. с 8-00 до 17-00); личный кабинет на сайте МУП г.Новосибирска
    «ГОРВОДОКАНАЛ» (www.gorvodokanal.com); в организациях, в том числе через личные кабинеты, согласно списку,
    размещенному на сайте МУП г.Новосибирска «ГОРВОДОКАНАЛ» (www.gorvodokanal.com) в разделе «Информация для абонентов»

</div>
</body>
</html>
