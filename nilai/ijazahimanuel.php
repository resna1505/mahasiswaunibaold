<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$styletdjudul = "style=' font-size:14pt;'";
$styletdjudul2 = "style=' font-size:22pt;'";
$styletd = "style=' font-size:13pt;'";
$styletd2 = "style=' font-size:16pt;'";
$styletdf = "style=' font-size:15pt;'";
$styletdh2 = "style=' font-size:16pt;'";
$q = "SELECT * FROM setingijazah ";
$hl = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hl ) )
{
    $dl = sqlfetcharray( $hl );
    $rektor = $dl[REKTOR];
    $niprektor = $dl[NIPREKTOR];
}
$q = "SELECT NOMBAMSPST FROM mspst WHERE IDX='{$d['IDX']}'";
$h2 = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h2 );
if ( $d[TINGKAT] == "C" )
{
    $NAMAPROGRAM = "PROGRAM SARJANA";
    $AKREDITASI = "<br> TERAKREDITASI BAN PT NOMOR: {$d2['NOMBAMSPST']} ";
}
else if ( $d[TINGKAT] == "E" )
{
    $NAMAPROGRAM = "PROGRAM DIPLOMA III";
}
$bodyijazah .= "\n    <center   style='page-break-after:always;'> \n    \n    <table width=1000  >\n    <tr>\n    <td align=right {$styletdjudul}>\n    Nomor : {$noseriijazah}\n    <BR><BR>\n     </td>\n    </tr>\n    <tr>\n    <td align=center >\n      <b {$styletdjudul2}>SEKOLAH TINGGI ILMU KESEHATAN (STIK) IMANUEL</b>\n      <br> \n      <b {$styletdh2}>SK MENDIKNAS NOMOR: 14/D/0/2002</b>\n    </td>\n    </tr>\n    <tr>\n    <td align=center  valign=top>\n     <table width=100% cellpadding=4 >\n \n \n        <tr>\n          <td align=center {$styletd}>\n    <br><br>dengan ini menyatakan bahwa\n    <br><br>\n    <font style='font-family: Monotype Corsiva  ;font-size:32pt;'><b>{$d['NAMA']}</b></font>\n    <br><br>\n    Nomor Induk Mahasiswa : {$d['ID']} <br>\n    lahir di {$d['TEMPAT']}, {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}\n    <br><br>\n    telah menyelesaikan dengan baik serta memenuhi segala syarat pendidikan<br><br>\n     <font style='font-family: Arial  ;font-size:20pt;'><b>  {$NAMAPROGRAM} {$d['NAMAP']}</b>  {$AKREDITASI} </font>\n    \n    <br><br>\n    \n    oleh sebab itu kepadanya diberikan gelar\n    <br><br>\n    <font style='font-family: Arial  ;font-size:22pt;'><b>{$d['GELAR']}</b></font>\n    \n    <br><br>\n    \n    beserta segala hak dan kewajiban yang melekat pada gelar tersebut.\n    <br>\n    Diberikan di ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}\n        </td>\n        </tr>\n      </table>\n      \n    \n\n    </td>\n    </tr>\n    </table>\n    <br><br>\n    <table width=900 border=0>\n      <tr valign=top align=center>\n        <td  {$styletdf}  width=30% nowrap>\n          Ketua \n           \n            <br><br><br><br>\n            <u>{$rektor}</u><br>\n            {$niprektor}\n          </td>\n          <td width=* align=center>\n";
if ( file_exists( "../mahasiswa/foto/{$d['ID']}" ) )
{
    $bodyijazah .= "\n          <img src='../mahasiswa/foto/{$d['ID']}' width=160 height=200>\n          ";
}
$bodyijazah .= "          \n          </td>\n        <td width=30% {$styletdf} nowrap>\n           Pembantu Ketua 1,\n          <br><br><br> <br>\n           Wintai Hariningsih,SKp.M.H.Kes \n        </td>\n      </tr>\n    </table>\n    </center>\n    \n    ";
?>
