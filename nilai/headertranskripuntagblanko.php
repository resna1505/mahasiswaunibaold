<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$styletranskrip = "\r\n<style type=\"text/css\">\r\n\t* {\r\n\t\tpadding:0px;\r\n\t\tmargin:0px;\r\n\t\t}\r\n</style>\r\n";
$namafakultas = "";
$q = "SELECT * FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
    $namadekan = "{$df['NAMAPIMPINAN']}";
    $nipdekan = "{$df['NIPPIMPINAN']}";
}
$PASCA = $PROFESI = $SARJANA = 0;
if ( $d[TINGKAT] == "A" || $d[TINGKAT] == "B" )
{
    $PASCA = 1;
}
else if ( $d[TINGKAT] == "J" )
{
    $PROFESI = 1;
}
else
{
    $SARJANA = 1;
}
$statusakreditasi = "";
if ( $d[KDSTAMSPST] != "" )
{
    $statusakreditasi = "\"TERAKREDITASI\"";
}
$tmp = explode( "-", $d[TANGGALKELUAR] );
$tglk = $tmp[2];
$blnk = $tmp[1];
$thnk = $tmp[0];
$tmpcetakawal .= " \r\n \r\n \r\n      <table style='margin:0px;padding:0px;'  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td     valign=top >\r\n\t\t\t<table  style='margin:0px;padding:0px;border-collapse:collapse;' border=0 >\r\n\t\t\t\t\r\n          <tr align=left>\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'   valign=top><!--Nama Mahasiswa--></td>\r\n\t\t\t\t\t\t<td style='width:10.5cm;font-size:8pt;' colspan=3 >  {$d['NAMA']} &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'  nowrap><!--Tempat/Tanggal Lahir--></td>\r\n\t\t\t\t\t\t<td  style='width:10.5cm;font-size:8pt;'   nowrap colspan=3> {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\r\n           \t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'  nowrap  nowrap width=200><!--Fakultas--></td>\r\n\t\t\t\t\t\t<td  style='width:10.5cm;font-size:8pt;' colspan=3  nowrap > {$namafakultas} &nbsp;</td>\r\n\t\t\t\t\t</tr>  \t\r\n          \t<tr align=left>\r\n\t\t\t\t\t\t<td style='width:2.5cm;font-size:8pt;'  nowrap  nowrap><!--Jurusan --></td>\r\n\t\t\t\t\t\t<td style='width:6cm;font-size:8pt;'   nowrap > {$d['NAMAP']} &nbsp;</td>\r\n\t\t\t\t\t\t<td  style='width:3cm;font-size:8pt;' nowrap ><!--Program Pendidikan--></td>\r\n\t\t\t\t\t\t<td  style=' font-size:8pt;' nowrap > ".$arraynamajenjang[$d[TINGKAT]]." &nbsp; </td>\r\n \t\t\t\t\t</tr>  \r\n \t\t\t\t\t\r\n \r\n\t\t\t\t\t\r\n\t\t\t\t\t\r\n \t\t\t\t</table> \r\n \t\t\t\t</td>\r\n \t\t\t\t<td>\r\n\t\t\t<table border=0   >\r\n\t\t\t\t\r\n  \t\t\t\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td  style='width:2.5cm;font-size:8pt;'><!--No. BI--></td>\r\n\t\t\t\t\t\t<td style=' font-size:8pt;'> {$d['ID']} &nbsp;</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td  style='width:2.5cm;font-size:8pt;' ><!--NIRM--></td>\r\n\t\t\t\t\t\t<td style=' font-size:8pt;'> {$d['NIRM']} &nbsp;</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td  style='width:2.5cm;font-size:8pt;' ><!--Tgl Yudisium--></td>\r\n\t\t\t\t\t\t<td style=' font-size:8pt;'>  {$tglyudisium2} </td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td  style='width:2.5cm;font-size:8pt;'><!--Predikat Lulus--></td>\r\n\t\t\t\t\t\t<td  style=' font-size:8pt;'> <!--PREDIKATLULUS--> &nbsp;</td>\r\n\t\t\t\t\t</tr> \r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\r\n \t\t\t\t</table> \r\n         \r\n         </td>\r\n        </tr>\r\n       </table> \r\n        \r\n\t\t ";
?>
