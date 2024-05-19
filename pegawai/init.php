<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arrayjenisoperator[0] = "Biasa";
$arrayjenisoperator[1] = "Supervisor";
$arraynamagrup[0] = "Divisi";
$arraynamagrup[1] = "Pangkat / Golongan";
$arraynamagrup[2] = "Jabatan Struktural";
$arraynamagrup[3] = "Jabatan Fungsional";
$arraynamagrup[4] = "Departemen";
$arraynamagrup[5] = "Lokasi";
$arraynamagrup[6] = "Status Operator";
$arraynamagrup[7] = "Waktu Kerja";
$arraynamagrup[8] = "Status Kerja";
$arraynamagrup[9] = "Shift Kehadiran";
$arraynamagrup[10] = "Status Nikah";
$arraynamagrup[11] = "Jenis Kelamin";
$arraynamagrup[12] = "Kelompok Usia";
$arraynamagrup[13] = "Agama";
$arraynamagrup[14] = "Pendidikan";
$arraynamagrup[15] = "Golongan Darah";
$arraynamagrup[16] = "Jumlah Anak";
$arraygrup[0] = "divisi";
$arraygrup[1] = "pangkat";
$arraygrup[2] = "jabatan";
$arraygrup[3] = "fungsional";
$arraygrup[4] = "bidang";
$arraygrup[5] = "lokasi";
$arraygrup[6] = "statuspegawai";
$arraygrup[7] = "waktukerja";
$arraygrup[8] = "statuskerja";
$arraygrup[9] = "shift";
$arraygrup[10] = "statusnikah";
$arraygrup[11] = "kelamin";
$arraygrup[12] = "kelompok usia";
$arraygrup[13] = "agama";
$arraygrup[14] = "pendidikan";
$arraygrup[15] = "goldarah";
$arraygrup[16] = "jmlanak";
$arraykelompokusia[0][a] = 0;
$arraykelompokusia[0][b] = 10;
$arraykelompokusia[1][a] = 11;
$arraykelompokusia[1][b] = 25;
$arraykelompokusia[2][a] = 26;
$arraykelompokusia[2][b] = 35;
$arraykelompokusia[3][a] = 36;
$arraykelompokusia[3][b] = 45;
$arraykelompokusia[4][a] = 46;
$arraykelompokusia[4][b] = 55;
$arraykelompokusia[5][a] = 56;
$arraykelompokusia[5][b] = 65;
$arraykelompokusia[6][a] = 66;
$arraykelompokusia[6][b] = 100;
$USIA = "\r\n\r\n\t(YEAR(NOW())-YEAR(TGLLAHIR)) \r\n\t+  \r\n  \tIF(MONTH(NOW())>MONTH(TGLLAHIR),0,IF(MONTH(NOW())<MONTH(TGLLAHIR),-1,IF(DAYOFMONTH(NOW())>=DAYOFMONTH(TGLLAHIR),0,-1)))\r\n";
echo " \r\n";
?>
