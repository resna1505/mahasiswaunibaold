<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
#echo $idfakultas;
$konfigkartu = getsettingkopfakultas( $idfakultas );
#print_r($konfigkartu);exit();
$gambarbackground = "";
if ( $konfigkartu[LATAR] == 0 )
{
    $bgkartu = "background:#{$konfigkartu['LATARWARNA']};";
}
else
{
    $bgkartu = "background:url(../nilai/kartu/{$idfakultas}/{$konfigkartu['LATARFOTO']});background-repeat:no-repeat;background-position: center;";
}
$tmpkop = "\r\n\t\t<table width=100% cellpadding=1 cellspacing=1>\r\n\t\t  <tr style='background-color:#FFFFFF;  '>";
if ( $konfigkartu[ISLOGOKIRI] == 1 && $konfigkartu[LOGOKIRI] != "" && file_exists( "../nilai/kartu/{$idfakultas}/{$konfigkartu['LOGOKIRI']}" ) )
{
    $tmpkop .= "\r\n        <td align=left valign=top width=10% style=border:none; style='background-color:#FFFFFF;  '>\r\n      \t\t<img  src='../nilai/kartu/{$idfakultas}/{$konfigkartu['LOGOKIRI']}' style='width:{$konfigkartu['PLKIRI']}mm;height:{$konfigkartu['LLKIRI']}mm;' > \r\n        </td>\r\n        ";
}
else
{
    $tmpkop .= "\r\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>&nbsp;\r\n         </td>\r\n        ";
}
$tmpkop .= "\r\n        <td nowrap align='{$konfigkartu['RATA']}'   valign=top style=border:none; style='background-color:#FFFFFF;  '>\r\n        <b>";
if ( trim( $konfigkartu[HEADER1] ) != "" )
{
    $tmpkop .= "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER1']}pt;font-family:{$konfigkartu['FHEADER1']};color:#{$konfigkartu['WHEADER1']};'>\r\n\t\t{$konfigkartu['HEADER1']}<br></font> \r\n          ";
}
if ( trim( $konfigkartu[HEADER2] ) != "" )
{
    $tmpkop .= "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER2']}pt;font-family:{$konfigkartu['FHEADER2']};color:#{$konfigkartu['WHEADER2']};'>\r\n\t\t{$konfigkartu['HEADER2']}<br></font> \r\n          ";
}
if ( trim( $konfigkartu[HEADER3] ) != "" )
{
    $tmpkop .= "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER3']}pt;font-family:{$konfigkartu['FHEADER3']};color:#{$konfigkartu['WHEADER3']};'>\r\n\t\t{$konfigkartu['HEADER3']}<br></font> \r\n          ";
}
if ( trim( $konfigkartu[HEADER4] ) != "" )
{
    $tmpkop .= "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER4']}pt;font-family:{$konfigkartu['FHEADER4']};color:#{$konfigkartu['WHEADER4']};'>\r\n\t\t{$konfigkartu['HEADER4']}</font> \r\n          ";
}
$tmpkop .= "\r\n        </td>";
if ( $konfigkartu[ISLOGOKANAN] == 1 && $konfigkartu[LOGOKANAN] != "" && file_exists( "../nilai/kartu/{$idfakultas}/{$konfigkartu['LOGOKANAN']}" ) )
{
    $tmpkop .= "\r\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>\r\n      \t\t<img  src='../nilai/kartu/{$idfakultas}/{$konfigkartu['LOGOKANAN']}' style='width:{$konfigkartu['PLKANAN']}mm;height:{$konfigkartu['LLKANAN']}mm;' > \r\n        </td>\r\n        ";
}
else
{
    $tmpkop .= "\r\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>&nbsp;\r\n         </td>\r\n        ";
}
$tmpkop .= "\r\n      </tr>\r\n\t\t</table>\r\n\t\t<hr>\r\n \t\t ";
?>
