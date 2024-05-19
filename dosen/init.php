<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$FOLDERFILE = "foto";
$NAMATABEL = "dosen";
$NAMATABELBEBAS = "dosen2";
$arraynamagrup[0] = "Jurusan/Program Studi";
$arraynamagrup[2] = "Jenis Kelamin";
$arraynamagrup[3] = "Status Ikatan Kerja";
$arraynamagrup[4] = "Status Aktifitas";
$arraynamagrup[5] = "Usia";
$arraygrup[0] = "IDDEPARTEMEN";
$arraygrup[2] = "KDJEKMSDOS";
$arraygrup[3] = "STATUS";
$arraygrup[4] = "STATUSKERJA";
$arraygrup[5] = "USIA";
$arraykelompokusia[0]['a'] = 0;
$arraykelompokusia[0]['b'] = 10;
$arraykelompokusia[1]['a'] = 11;
$arraykelompokusia[1]['b'] = 25;
$arraykelompokusia[2]['a'] = 26;
$arraykelompokusia[2]['b'] = 35;
$arraykelompokusia[3]['a'] = 36;
$arraykelompokusia[3]['b'] = 45;
$arraykelompokusia[4]['a'] = 46;
$arraykelompokusia[4]['b'] = 55;
$arraykelompokusia[5]['a'] = 56;
$arraykelompokusia[5]['b'] = 65;
$arraykelompokusia[6]['a'] = 66;
$arraykelompokusia[6]['b'] = 100;
$USIA = "\r\n\r\n\t(YEAR(NOW())-YEAR(TGLHRMSDOS)) \r\n\t+  \r\n  \tIF(MONTH(NOW())>MONTH(TGLHRMSDOS),0,IF(MONTH(NOW())<MONTH(TGLHRMSDOS),-1,IF(DAYOFMONTH(NOW())>=DAYOFMONTH(TGLHRMSDOS),0,-1)))\r\n";
?>
