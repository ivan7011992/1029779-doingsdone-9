<?php

require_once 'vendor/autoload.php';
require_once "helpers.php";


$login = '11-0040372';
$today = '01.11.2019';
$period = '11.2019';
$db = oci_connect("SYTE", "SYTE80", "NAS2", "CL8MSWIN1251");

if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $sql2 = " SELECT 
    n_vodomer,
   DECODE(pr_vod,1,'ХВ',2,'ГВ') vod,
   (SELECT SUM(pokaz2) keep(dense_rank first ORDER BY dat2 desc)  FROM t1.uchet  u WHERE idv=v.id AND u.kod=v.kod  )pokaz,
   (SELECT max(dat2) keep(dense_rank first ORDER BY dat2 desc)  FROM t1.uchet  u WHERE idv=v.id AND u.kod=v.kod  )dat_pokaz
  FROM t1.vodomer v 
  WHERE  kod= '$login' AND neispr=0
";

    $result = oci_parse($db, $sql2);

    oci_execute($result, OCI_DEFAULT);


    $vodomers = [];

    while ($row = oci_fetch_array($result, OCI_BOTH)) {
        $vodomers[] = $row;

    }

    $sql4 = "SELECT  A1.CITY,A1.NAIMUL,A.DOM,A.KVARTIRA FROM t1.spr_abon a, t1.SPR_Ulic a1  WHERE a.KOD ='$login'
AND a1.kodul=a.ULICA 
";
    $result = oci_parse($db, $sql4);
    oci_execute($result, OCI_DEFAULT);
    $row = oci_fetch_array($result, OCI_BOTH);

    $adrres = toUtf($row['CITY']) . ',' . toUtf($row['NAIMUL']) . ' ' . 'Д' . '.' . toUtf($row['DOM']) . ' ' . 'КВ' . '.' . $row['KVARTIRA'];


    $sql3 = "SELECT       
       grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/) id_gr,
         kod1,
         (SELECT (SELECT nvl(trim(city),trim(punct))||','||nvl(trim(naimul_new),naimul) FROM t1.SPR_Ulic WHERE kodul=a.ulica)
         ||' д.'||a.dom||' кв.'||a.KVARTIRA||a.B FROM t1.spr_abon a WHERE a.kod=kod1)adres,
         (SELECT fio  FROM t1.spr_abon a WHERE a.kod=kod1) fio,
       (SELECT koljil  FROM t1.spr_abon a WHERE a.kod=kod1) koljil,
         (SELECT NVL(s,0)  FROM t1.spr_abon a WHERE a.kod=kod1) s,
       DECODE( grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/),7,'Итого по всем услугам',decode(vid_uslugi,1,'Холодное водоснабжение',3,'Водоотведение',19,'Повышающий коэфициент','Холодное водоснабжение')) usl,
       --DECODE( grouping_id(kod1,vid_uslugi ,tarif,spos_opred),7,null,decode(vid_uslugi,3,decode(spos_opred,'Норматив',spos_opred,'Иное'),spos_opred))spos_opred,
       SUM(volume_uslugi) vol,   
       NVL(tarif,0) tarif,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(sum_woda),0),3,NVL(SUM(sum_stoki),0),NVL(SUM(sum_woda),0)),0) sum_odn,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(volume_woda),0),3,NVL(sum(volume_stoki),0),NVL(sum(volume_woda),0)),0) volume_odn,
       NVL(SUM(summa_uslugi)-NVL(SUM(summa_perer),0),0) vsego_nachis,       
      (SELECT decode(vid_uslugi,1,koeff,0) FROM t1.koeff WHERE to_date('$today','dd.mm.yyyy') BETWEEN date_begin AND date_end) povish_koef,
       sum(NVL(DECODE(vid_uslugi,1,(SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19),3,0,(SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19)),0)) sum_povish,
       --sum(5) sum_povish,
         NVL((SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19 AND id_uslugi=22),0) is_povish_odn,
       NVL(SUM(summa_perer),0) summa_perer,
         T1.SUM_D_GOSP_SYTE(TO_DATE('$today','dd.mm.yyyy'),kod1) gosp,
       NVL((select sum(sumo) from t1.saldo where kodab=kod1 and dats=to_date('$today','dd.mm.yyyy')),t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),1)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),3)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),19))
       +NVL((SELECT SUM(sumo) FROM t1.pretenz WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       +NVL((SELECT SUM(sumo) FROM t1.pereoc WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       saldo_pred ,
       
      nvl((SELECT sum(nvl(sumop,0))
                          FROM t1.packa
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17)
                          AND kod =a.kod1),0) 
                          
       + 
       nvl((SELECT sum(nvl(sumo,0)) 
                          FROM t1.kassa  
                          WHERE data>=to_date('$today','dd.mm.yyyy')
                          AND data<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17)
                          AND kod =a.kod1),0)
                                       
       +
       nvl((SELECT sum(nvl(sumop,0)) 
                          FROM t1.spravki s
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                         AND  vid_uslugi not in (2,17)
                          AND s.kod1=a.kod1
                         ) ,0) summa_oplat,


   GREATEST(NVL((SELECT max(datop)
                          FROM t1.packa
                          WHERE  vid_uslugi not in (2,17)
                                     AND  datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND kod=a.kod1),TO_DATE('01.01.1999','dd.mm.yyyy')),
                          
   nvl((SELECT max(k.data) 
                          FROM t1.kassa   k
                          WHERE   vid_uslugi not in (2,17)
                                     AND  data<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND kod=a.kod1),to_date('01.01.1999','dd.mm.yyyy')),
                                       
  nvl((SELECT MAX(datop) 
                          FROM t1.spravki s
                          WHERE  vid_uslugi not in (2,17)
                                     AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND s.kod1=a.kod1
                          ),TO_DATE('01.01.1999','dd.mm.yyyy')) ) date_last_oplat                            
      
         
FROM 
(SELECT
               a.kod kod1,              
               (SELECT DECODE( a.vid_uslugi,1,MAX(zenwoda),MAX(zenstok)) 
                FROM t1.cena WHERE kod=a.grzen   
                 AND vid_uslugi=a.vid_uslugi
                 AND to_date('$today','dd.mm.yyyy') BETWEEN DATA AND data2
                GROUP BY kod) tarif, 
               nachisl_tek.*, nachisl_odn.*     
           FROM  (select kod,v.id vid_uslugi ,grzen from t1.spr_abon,t1.spr_vid_uslug  v 
                 WHERE dubyt= TO_DATE('31.12.9999','dd.mm.yyyy') and kod ='$login' AND v.id IN(1,3,19)  
                  AND  not(kujkx in (128991,1396,31838,31885))
                        AND t1.F_IS_EPD(kod)<>0
                        ) a ,
              (SELECT sum(nvl(n.sumo,0)) summa_uslugi,
                      DECODE(vid_uslugi,1,SUM(woda+NVL(wodpol,0)),3,SUM(stoki),19,SUM(woda+NVL(wodpol,0))) volume_uslugi,
                      vid_uslugi,
                 --     DECODE(prvod,'n','Норматив','v','Прибор учета','o','Прибор учета','d','Норматив','p','Норматив') spos_opred,                      
                      DECODE(prvod,'p',sum(nvl(n.sumo,0)),
                      'v',
                      CASE WHEN MAX(date_end)<MAX(date_ot) 
                           then sum(nvl(n.sumo,0)) 
                           ELSE 0 end) summa_perer,
                      prvod ,
                      kod
               from t1.nachis n,t1.nachpol p
               WHERE date_ot=to_date('$today','dd.mm.yyyy')
               AND kod ='$login'
               AND  n.id=p.idn(+)
               AND vid_uslugi IN(1,3)
               and prvod<>'u' 
               GROUP  BY  kod,vid_uslugi,prvod ) nachisl_tek,
               (SELECT sum(nvl(n.sum_woda,0)) sum_woda,
                       sum(nvl(n.sum_stok,0)) sum_stoki,
                       SUM(woda) volume_woda,
                       SUM(stoki) volume_stoki,
                       kod
               from t1.nachis n
               WHERE date_ot=to_date('$today','dd.mm.yyyy')
               AND vid_uslugi=4
               and prvod<>'u'
               AND kod ='$login'
               GROUP  BY  kod ) nachisl_odn

         WHERE nachisl_tek.kod(+)=a.kod
          AND  nachisl_tek.vid_uslugi(+)=a.vid_uslugi
          AND nachisl_odn.kod(+)=a.kod
      )a      
        WHERE tarif <>0 
  GROUP BY ROLLUP(kod1,vid_uslugi ,tarif/*,spos_opred*/)  
  HAVING grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/) IN(0,7)
  ORDER BY kod1,NVL(vid_uslugi,10),tarif DESC
";


    $result = oci_parse($db, $sql3);

    oci_execute($result, OCI_DEFAULT);


    $table3 = [];

    while ($row = oci_fetch_array($result, OCI_BOTH)) {
        $table3[] = $row;
        $str2 = 'тест';
        $str1 = $row['FIO'];
        $str = mb_convert_encoding($str2, "WINDOWS-1251");
        echo mb_detect_encoding($str);

    }


    $sql = "SELECT       
       grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/) id_gr,
         kod1,
         (SELECT (SELECT nvl(trim(city),trim(punct))||','||nvl(trim(naimul_new),naimul) FROM t1.SPR_Ulic WHERE kodul=a.ulica)
         ||' д.'||a.dom||' кв.'||a.KVARTIRA||a.B FROM t1.spr_abon a WHERE a.kod=kod1)adres,
         (SELECT fio  FROM t1.spr_abon a WHERE a.kod=kod1) fio,
       (SELECT koljil  FROM t1.spr_abon a WHERE a.kod=kod1) koljil,
         (SELECT NVL(s,0)  FROM t1.spr_abon a WHERE a.kod=kod1) s,
       DECODE( grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/),7,'Итого по всем услугам',decode(vid_uslugi,1,'Холодное водоснабжение',3,'Водоотведение',19,'Повышающий коэфициент','Холодное водоснабжение')) usl,
       --DECODE( grouping_id(kod1,vid_uslugi ,tarif,spos_opred),7,null,decode(vid_uslugi,3,decode(spos_opred,'Норматив',spos_opred,'Иное'),spos_opred))spos_opred,
       SUM(volume_uslugi) vol,   
       NVL(tarif,0) tarif,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(sum_woda),0),3,NVL(SUM(sum_stoki),0),NVL(SUM(sum_woda),0)),0) sum_odn,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(volume_woda),0),3,NVL(sum(volume_stoki),0),NVL(sum(volume_woda),0)),0) volume_odn,
       NVL(SUM(summa_uslugi)-NVL(SUM(summa_perer),0),0) vsego_nachis,       
      (SELECT decode(vid_uslugi,1,koeff,0) FROM t1.koeff WHERE to_date('$today','dd.mm.yyyy') BETWEEN date_begin AND date_end) povish_koef,
       sum(NVL(DECODE(vid_uslugi,1,(SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19),3,0,(SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19)),0)) sum_povish,
       --sum(5) sum_povish,
         NVL((SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot=to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19 AND id_uslugi=22),0) is_povish_odn,
       NVL(SUM(summa_perer),0) summa_perer,
         T1.SUM_D_GOSP_SYTE(TO_DATE('$today','dd.mm.yyyy'),kod1) gosp,
       NVL((select sum(sumo) from t1.saldo where kodab=kod1 and dats=to_date('$today','dd.mm.yyyy')),t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),1)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),3)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),19))
       +NVL((SELECT SUM(sumo) FROM t1.pretenz WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       +NVL((SELECT SUM(sumo) FROM t1.pereoc WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       saldo_pred ,
       
      nvl((SELECT sum(nvl(sumop,0))
                          FROM t1.packa
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17)
                          AND kod =a.kod1),0) 
                          
       + 
       nvl((SELECT sum(nvl(sumo,0)) 
                          FROM t1.kassa  
                          WHERE data>=to_date('$today','dd.mm.yyyy')
                          AND data<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17)
                          AND kod =a.kod1),0)
                                       
       +
       nvl((SELECT sum(nvl(sumop,0)) 
                          FROM t1.spravki s
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                         AND  vid_uslugi not in (2,17)
                          AND s.kod1=a.kod1
                         ) ,0) summa_oplat,


   GREATEST(NVL((SELECT max(datop)
                          FROM t1.packa
                          WHERE  vid_uslugi not in (2,17)
                                     AND  datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND kod=a.kod1),TO_DATE('01.01.1999','dd.mm.yyyy')),
                          
   nvl((SELECT max(k.data) 
                          FROM t1.kassa   k
                          WHERE   vid_uslugi not in (2,17)
                                     AND  data<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND kod=a.kod1),to_date('01.01.1999','dd.mm.yyyy')),
                                       
  nvl((SELECT MAX(datop) 
                          FROM t1.spravki s
                          WHERE  vid_uslugi not in (2,17)
                                     AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND s.kod1=a.kod1
                          ),TO_DATE('01.01.1999','dd.mm.yyyy')) ) date_last_oplat                            
      
         
FROM 
(SELECT
               a.kod kod1,              
               (SELECT DECODE( a.vid_uslugi,1,MAX(zenwoda),MAX(zenstok)) 
                FROM t1.cena WHERE kod=a.grzen   
                 AND vid_uslugi=a.vid_uslugi
                 AND to_date('$today','dd.mm.yyyy') BETWEEN DATA AND data2
                GROUP BY kod) tarif, 
               nachisl_tek.*, nachisl_odn.*     
           FROM  (select kod,v.id vid_uslugi ,grzen from t1.spr_abon,t1.spr_vid_uslug  v 
                 WHERE dubyt= TO_DATE('31.12.9999','dd.mm.yyyy') and kod ='$login' AND v.id IN(1,3,19)  
                  AND  not(kujkx in (128991,1396,31838,31885))
                        AND t1.F_IS_EPD(kod)<>0
                   ) a ,
              (SELECT sum(nvl(n.sumo,0)) summa_uslugi,
                      DECODE(vid_uslugi,1,SUM(woda+NVL(wodpol,0)),3,SUM(stoki),19,SUM(woda+NVL(wodpol,0))) volume_uslugi,
                      vid_uslugi,
                 --     DECODE(prvod,'n','Норматив','v','Прибор учета','o','Прибор учета','d','Норматив','p','Норматив') spos_opred,                      
                      DECODE(prvod,'p',sum(nvl(n.sumo,0)),
                      'v',
                      CASE WHEN MAX(date_end)<MAX(date_ot) 
                           then sum(nvl(n.sumo,0)) 
                           ELSE 0 end) summa_perer,
                      prvod ,
                      kod
               from t1.nachis n,t1.nachpol p
               WHERE date_ot=to_date('$today','dd.mm.yyyy')
               AND kod ='$login'
               AND  n.id=p.idn(+)
               AND vid_uslugi IN(1,3)
               and prvod<>'u' 
               GROUP  BY  kod,vid_uslugi,prvod ) nachisl_tek,
               (SELECT sum(nvl(n.sum_woda,0)) sum_woda,
                       sum(nvl(n.sum_stok,0)) sum_stoki,
                       SUM(woda) volume_woda,
                       SUM(stoki) volume_stoki,
                       kod
               from t1.nachis n
               WHERE date_ot=to_date('$today','dd.mm.yyyy')
               AND vid_uslugi=4
               and prvod<>'u'
               AND kod ='$login'
               GROUP  BY  kod ) nachisl_odn

         WHERE nachisl_tek.kod(+)=a.kod
          AND  nachisl_tek.vid_uslugi(+)=a.vid_uslugi
          AND nachisl_odn.kod(+)=a.kod
      )a      
        WHERE tarif <>0 
  GROUP BY ROLLUP(kod1,vid_uslugi ,tarif/*,spos_opred*/)  
  HAVING grouping_id(kod1,vid_uslugi ,tarif/*,spos_opred*/) IN(0,7)
  ORDER BY kod1,NVL(vid_uslugi,10),tarif DESC
";


    $result = oci_parse($db, $sql);

    oci_execute($result, OCI_DEFAULT);
    $row = oci_fetch_array($result, OCI_BOTH);


    if ($row['SALDO_PRED'] < 0) {
        $debt = 0;
        $overpayment = $row['SALDO_PRED'];
    } elseif ($row['SALDO_PRED'] > 0) {
        $overpayment = 0;
        $debt = $row['SALDO_PRED'];
    } elseif ($row['SALDO_PRED'] == 0) {
        $debt = 0;
        $overpayment = 0;

    }


    function toUtf(string $s): string
    {
        return mb_convert_encoding($s, 'utf-8', 'cp1251');
    }


    $html = include_template('template.php', [
        'title' => 'He, world1',
        'kod' => $login,
        'date' => $today,
        'DEPT' => $debt,
        'OVERPAY' => $overpayment,
        'DATE' => $row['DATE_LAST_OPLAT'],
        'SUMMA_OPLAT' => $row['SUMMA_OPLAT'],
        'SUMMA_ALL' => $row['SUMMA_ALL'],
        'GOSP' => $row['GOSP'],
        'FIO' => toUtf($row['FIO']),
        'S' => $row['S'],
        'ADDRESS' => $adrres,
        'countTenants' => $row['KOLJIL'],
        'vodomers' => $vodomers,
        'table3' => $table3,
        'usl' => $str,
        'summa' => $row
    ]);

    use Dompdf\Dompdf;

// instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');


// Render the HTML as PDF
    $dompdf->render();

// Output the generated PDF to Browser
    $output = $dompdf->output();

    header("Content-type: application/pdf");
    header("Content-Disposition: filename=filename.pdf");


    echo $output;
