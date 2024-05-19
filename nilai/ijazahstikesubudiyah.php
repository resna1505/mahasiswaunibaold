<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$terakreditasi = $peringkatakreditasi = $noakreditasi = $tglakreditasi = $kodejenjangprodi = $NO_SERIIJAZAH = $tglyudisium = "";
$NO_SERIIJAZAH = "";
$q = "SELECT NOIJATRLSM,TGLRETRLSM,KDJENTRLSM,KDPSTTRLSM FROM trlsm WHERE NIMHSTRLSM='{$d['ID']}' AND STMHSTRLSM ='L'";
$hi = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hi ) )
{
    $di = sqlfetcharray( $hi );
    $NO_SERIIJAZAH = $di[NOIJATRLSM];
    $tmpy = explode( "-", $di[TGLRETRLSM] );
    $tglyudisium = "{$tmpy['2']}-{$tmpy['1']}-{$tmpy['0']}";
    $q = "SELECT *,DATE_FORMAT(TGLBAMSPST,'%d-%m-%Y') AS TGL FROM mspst WHERE  KDJENMSPST='{$di['KDJENTRLSM']}' AND  KDPSTMSPST='{$di['KDPSTTRLSM']}'";
    $hi = mysqli_query($koneksi,$q);
    $di = sqlfetcharray( $hi );
    if ( $di[KDSTAMSPST] != "" )
    {
        $terakreditasi = "\"Terakreditasi\"";
        $peringkatakreditasi = "{$di['KDSTAMSPST']}";
        $noakreditasi = $di[NOMBAMSPST];
        $tglakreditasi = "{$di['TGL']}";
        $kodejenjangprodi = $di[KDJENMSPST];
    }
}
$detilperingkatakreditasi = "";
if ( $ifperingkat == 1 )
{
    $detilperingkatakreditasi = "dengan peringkat Akreditasi {$peringkatakreditasi} (".$arraynamaakreditasipt[$peringkatakreditasi]."),";
}
$border0 = " style='border:0pt;'";
$bodyijazah .= "\r\n    <center   style='page-break-after:always;'> \r\n    <table border=0 width=1100 style='border:0pt;'>\r\n      <tr>\r\n        <td align=right  {$border0}><p style ='font-family:times new roman; font-size:15px;'><u>No:<i> {$NO_SERIIJAZAH}</u></p></td>\r\n      </tr>\r\n    </table>\r\n\t<center>\r\n    <div align=center><font style='font-size:32pt; font-family:times new roman; font-weight:bold;'>STIKES U'BUDIYAH BANDA ACEH</font></center><br> \r\n    <table width=1000  border=0 style='border:0pt;'>\r\n    <tr {$border0} >\r\n    <td {$border0}  align=center>\r\n      <p style='font-size:16px; font-weight:bold;'>Dengan ini menyatakan bahwa :</p>\r\n     \r\n    </td>\r\n    </tr>\r\n    <tr>\r\n    <td nowrap  {$border0}  align=center style=' font-size:12pt;'>\r\n      <b><font style='font-family: Monotype Corsiva  ;font-size:22pt;'>\r\n      {$d['NAMA']}<br> \r\n      NIM : <i><font style='font-family: Monotype Corsiva  ;font-size:22pt;'>{$d['ID']}</i></b></font> <br> \r\n        <font style=' font-size:16pt; font-family: Monotype Corsiva;'>\r\n      Lahir di {$d['TEMPAT']}, {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      telah menyelesaikan dengan baik dan memenuhi segala syarat \r\n      pendidikan<br> pada Program Studi :\r\n      <br> \r\n            <b><i>\r\n<font style=' font-size:22pt; font-family: Monotype Corsiva; '>".$arraynamajenjang[$kodejenjangprodi]." {$d['NAMAP']}</font></i></b><br>  \r\n\r\n\r\n{$terakreditasi} {$detilperingkatakreditasi} Berdasarkan Surat Keputusan Badan Akreditasi Nasional Perguruan Tinggi<br>\r\nNomor: {$noakreditasi} tanggal {$tglakreditasi}\r\n\r\n\r\n<br>  \r\n        Oleh sebab itu kepadanya diberikan gelar <br><br>\r\n      </b>\r\n      <b><i>\r\n      <font style='font-size:22pt; font-family: Monotype Corsiva;'>{$d['GELAR']}</font></i></b>\r\n      \r\n       <font style='font-size:16pt; font-family: Monotype Corsiva;'>\r\n      <br><br>\r\n      Beserta segala hak dan kewajiban yang melekat pada gelar tersebut.\r\n      <br>\r\n      Diberikan di Banda Aceh pada tanggal  <b style='font-size:16pt; font-family: Monotype Corsiva;'>{$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}</b>\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    <br> \r\n    <table width=900  >\r\n      <tr valign=top>\r\n        <td {$border0}  width=100% nowrap>\r\n          <b>\r\n           <font style=' font-size:18;'>PEMBANTU AKADEMIK I, \r\n          <br><br><br><br><br> \r\n          <U><font style=' font-size:18;'>{$d['NAMAPUKET1AKADEMIK']}</U><br>\r\n          NIP. {$d['NIPPUKET1AKADEMIK']}\r\n        </td>\r\n        <td {$border0}  >&nbsp;\r\n";
$bodyijazah .= "          \r\n        </td>\r\n        <td nowrap {$border0}  width=40% nowrap>\r\n          <b>\r\n          <font style=' font-size:18;'>STIKES U'BUDIYAH BANDA ACEH<br>\r\n          KETUA,\r\n          <br><br><br><br> \r\n          <u><font style=' font-size:18;'>{$d2['REKTOR']}</u><br>\r\n          NIP. {$d2['NIPREKTOR']}\r\n        </td>\r\n      </tr>\r\n    </table>\r\n    </center>\r\n    \r\n    ";
?>
