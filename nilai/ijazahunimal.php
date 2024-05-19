<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$akreditasi = 0;
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
        $akreditasi = 1;
        $terakreditasi = "\"Terakreditasi\"";
        $peringkatakreditasi = "{$di['KDSTAMSPST']}";
        $noakreditasi = $di[NOMBAMSPST];
        $tglakreditasi = "{$di['TGL']}";
        $kodejenjangprodi = $di[KDJENMSPST];
    }
}
$bodyijazah = "\r\n<table cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.7cm;' valign=bottom>\r\n    <td class=loseborder  style='width:3cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:6cm  ;' align=center>{$noseriijazah}</td>\r\n   </tr>\r\n</table>\r\n<table cellpadding=0 cellspacing=0>\r\n  <tr style='height:3.6cm;' valign=bottom>\r\n    <td class=loseborder  style='width:7cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:13cm;font-size:20pt;' align=center>{$d['NAMA']}</td>\r\n   </tr>\r\n</table>\r\n\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.8cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:12cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:17cm; ' >{$d['ID']} </td>\r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:1cm;' valign=bottom>\r\n    <td class=loseborder  style='width:4.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:9.5cm; ' > {$d['TEMPAT']} </td>\r\n    <td class=loseborder  style='width:10cm; ' >   {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr  style='height:1.9cm;'   valign=bottom>\r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:10cm; ' >{$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus} </td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.8cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:10cm; ' >".$arraynamajenjang[$d[TINGKAT]]." </td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.8cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:10cm; ' >{$d['NAMAF']} </td> \r\n   </tr>\r\n</table>\r\n\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.8cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:10cm; ' >{$d['NAMAP']} </td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:0.8cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:10cm; ' >Terakreditasi No SK {$noakreditasi} </td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:2.3cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:7cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:13cm; ' align=center >{$d['GELAR']}</td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:1.2cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:20cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:5cm; ' align=left >{$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}</td> \r\n   </tr>\r\n</table>\r\n<table  cellpadding=0 cellspacing=0>\r\n  <tr style='height:4.7cm;'  valign=bottom>\r\n    <td class=loseborder  style='width:2.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:8cm; '  >{$d['DEKAN']}</td> \r\n    <td class=loseborder  style='width:6.5cm;'>&nbsp;</td>\r\n    <td class=loseborder  style='width:8cm; '  >{$d2['REKTOR']}</td> \r\n   </tr>\r\n</table>\r\n";
?>
