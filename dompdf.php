<?php

require_once 'vendor/autoload.php';
require_once "helpers.php";




$login = '06-0124470';
$today = '01.11.2019';
$period = '11.2019';
$db = oci_connect("SYTE", "SYTE80", "NAS2", "CL8MSWIN1251");


$sql1 ="SELECT 
        a.KOD,       
        a.KUJKX,
        t1.dos_to_win(u.NAIMUL) as NAIMUL,
        t1.dos_to_win(a.DOM) as DOM,
        a.KVARTIRA,       
        t1.dos_to_win(a.FIO) as FIO,
        a.koljil as koljil,                                                                                                                                      
              
                (SELECT zenstok FROM t1.cena WHERE kod=a.grzen AND data2=to_date('31.12.9999','dd.mm.yyyy')  AND (a.type_heat = type_heat)
          AND (a.etazh between etaz1 and etaz2)
          and energy=decode(a.ctp,null,0,1)
          AND vid_uslugi=3) zenstok,            
          t1.dos_to_win((select naim_mer13 from t1.spr_cena where kod=a.grzen)) st_blag,
          v.uzel, t1.dos_to_win(v.n_vodomer) n_vodomer,
          decode(v.pr_vod,1,'Холодная',2,'Горячая',3,'тепло',4,'электр') vid,
          to_char( v.dat_ust, 'dd.mm.yyyy') dat_ust,
          v.pokaz_beg,
          to_char( v.dat_pover ,'dd.mm.yyyy') dat_pover
          FROM t1.spr_abon a, t1.spr_ulic u,t1.vodomer v
          where  a.kod=v.kod(+) and a.kod='$login' and a.ULICA =u.KODUL
";
$result = oci_parse($db, $sql1);

oci_execute($result, OCI_DEFAULT);
$row = oci_fetch_array ($result, OCI_BOTH);

$address = $row['NAIMUL'].'/'.$row['KVARTIRA'].'/'.$row['DOM'];
$col =$row['KOLJIL'];
$fio = $row['FIO'];

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


$vodomers=[];

while ($row = oci_fetch_array ($result, OCI_BOTH)){
    $vodomers[] = $row;

}





$sql = "SELECT kod1 kod,
       decode(vid_uslugi,1,'Холодное водоснабжение',3,'Водоотведение',19,'Повышающий коэфициент') usl,
       decode(vid_uslugi,3,decode(spos_opred,'Норматив',spos_opred,'Иное'),spos_opred)spos_opred,
       SUM(volume_uslugi) vol,   
       NVL(tarif,0) tarif,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(sum_woda),0),3,NVL(SUM(sum_stoki),0),0),0) sum_odn,
       sum(NVL(DECODE(vid_uslugi,1,NVL(SUM(sum_woda),0),3,NVL(SUM(sum_stoki),0),0),0))over (partition by kod1) summa_all_odn,
       NVL(DECODE(vid_uslugi,1,NVL(SUM(volume_woda),0),3,NVL(sum(volume_stoki),0),0),0) volume_odn,
       NVL(SUM(NVL(summa_uslugi,0))-NVL(SUM(summa_perer),0),0) vsego_nachis, 
       NVL(SUM(NVL(SUM(NVL(summa_uslugi,0)),0)-NVL(SUM(summa_perer),0)) over (PARTITION BY kod1),0) summa_all,
       (SELECT koeff FROM t1.koeff WHERE to_date('$today','dd.mm.yyyy') BETWEEN date_begin AND date_end) povish_koef,
       NVL(DECODE(vid_uslugi,1,(SELECT sum(nvl(n.sumo,0))  FROM t1.nachis n WHERE date_ot= to_date('$today','dd.mm.yyyy') AND kod=kod1  AND vid_uslugi=19),0),0) sum_povish,
       NVL(SUM(summa_perer),0) summa_perer,
       sum(NVL(SUM(summa_perer),0)) over (partition by kod1) summa_all_perer, 
       T1.SUM_D_GOSP_SYTE(to_date('$today','dd.mm.yyyy'),kod1) gosp,
       NVL((select sum(sumo) from t1.saldo where kodab=kod1 and dats= to_date('$today','dd.mm.yyyy')),t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),1)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),3)+t1.F_SALDO_TEK(kod1,to_date('$today','dd.mm.yyyy'),19))
+NVL((SELECT SUM(sumo) FROM t1.pretenz WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       +NVL((SELECT SUM(sumo) FROM t1.pereoc WHERE per_ot='$period' AND widop=1 AND kod=kod1),0)
       saldo_pred ,

      nvl((SELECT sum(nvl(sumop,0))
                          FROM t1.packa
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17) 
                          AND kod='$login'),0) 

       + 
       nvl((SELECT sum(nvl(sumo,0)) 
                          FROM t1.kassa  
                          WHERE data>=to_date('$today','dd.mm.yyyy')
                          AND data<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17) 
                          AND kod='$login'),0)
                                       
       +
       nvl((SELECT sum(nvl(sumop,0)) 
                          FROM t1.spravki s
                          WHERE datop>=to_date('$today','dd.mm.yyyy')
                          AND datop<=LAST_DAY(to_date('$today','dd.mm.yyyy'))
                          AND  vid_uslugi not in (2,17) 
                          AND s.kod1='$login'
                         ) ,0) summa_oplat,


   GREATEST(NVL((SELECT max(datop)
                          FROM t1.packa
                          WHERE  vid_uslugi not in (2,17)
                          AND kod= '$login'),TO_DATE('$today','dd.mm.yyyy')),
                          
   nvl((SELECT max(k.data) 
                          FROM t1.kassa   k
                          WHERE  vid_uslugi not in (2,17) 
                          AND kod='$login'),TO_DATE('$today','dd.mm.yyyy')),
                                       
  nvl((SELECT MAX(datop) 
                          FROM t1.spravki s
                          WHERE   vid_uslugi not in (2,17) 
                          AND s.kod1='$login'
                          ),TO_DATE('$today','dd.mm.yyyy')) ) date_last_oplat                            
      
         
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
                 WHERE dubyt=to_date('31.12.9999','dd.mm.yyyy') and kod ='$login'AND v.id IN(1,3,19)  
                  AND  not(kujkx in (128991,1396,31838,31885)) ) a ,
              (SELECT NVL(sum(nvl(n.sumo,0)),0) summa_uslugi,
                      DECODE(vid_uslugi,1,SUM(woda+NVL(wodpol,0)),3,SUM(stoki),19,SUM(woda+NVL(wodpol,0))) volume_uslugi,
                      vid_uslugi,
                      DECODE(prvod,'n','Норматив','v','Прибор учета','o','Прибор учета','d','Норматив','p','Норматив') spos_opred,                      
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
               WHERE date_ot=to_date('$today','dd.mm.yyyy') AND vid_uslugi=4
               and prvod<>'u'
               AND kod = '$login'
               GROUP  BY  kod ) nachisl_odn

         WHERE nachisl_tek.kod(+)=a.kod
          AND  nachisl_tek.vid_uslugi(+)=a.vid_uslugi
          AND nachisl_odn.kod(+)=a.kod
      )a      
        WHERE tarif <>0 
  GROUP BY kod1,tarif,spos_opred,vid_uslugi   
  ORDER BY vid_uslugi


";



$result = oci_parse($db, $sql);

oci_execute($result, OCI_DEFAULT);
$row = oci_fetch_array ($result, OCI_BOTH);




if ($row['SALDO_PRED'] <0){
    $debt = 0; $overpayment=$row['SALDO_PRED'];
}elseif ($row['SALDO_PRED']>0){
    $overpayment= 0; $debt = $row['SALDO_PRED'];
}





$html = include_template('template.php', [
    'title' => 'He, world1',
    'kod' => $login,
    'date' => $today,
    'DEPT' =>  $debt,
    'OVERPAY' => $overpayment ,
    'DATE' => $row['DATE_LAST_OPLAT'],
    'SUMMA_OPLAT' => $row['SUMMA_OPLAT'],
    'SUMMA_ALL'  => $row['SUMMA_ALL'],
    'GOSP'  => $row['GOSP'],
    'FIO' => $fio,
    'ADDRESS' => $address,
    'countTenants' => $col,
    'vodomers' => $vodomers



]);

use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html1 = mb_convert_encoding($html, 'UTF-8', 'windows=1251');
$dompdf->loadHtml($html1);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');


// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$output = $dompdf->output();

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=filename.pdf");

file_put_contents('output'.$login.'.pdf', $output);
