<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ll";
set_time_limit(0);
/*$tmpkop .= "
<style type=\"text/css\">
	* 
	{
		font-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;
	}
	
	.makeborder td 
	{
		padding:2px;
		border:none;
	}
</style>";*/
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$konfigkartu = getsettingkop();
#print_r($konfigkartu);exit();
$gambarbackground = "";
if ( $konfigkartu[LATAR] == 0 )
{
    $bgkartu = "background:#{$konfigkartu['LATARWARNA']};";
}
else
{
    $bgkartu = "background:url(../nilai/kartu/{$konfigkartu['LATARFOTO']});background-repeat:no-repeat;background-position: center;";
}
$tmpkop .= " \n\t\t<table width=100% class='makeborder' cellpadding=1 cellspacing=1 style='background-color:#FFFFFF;  '>\n \n\t\t  <tr style='background-color:#FFFFFF;  '>";
#echo "../nilai/kartu/{$konfigkartu['LOGOKIRI']}";
if ( $konfigkartu[ISLOGOKIRI] == 1 && $konfigkartu[LOGOKIRI] != "" && file_exists( "../nilai/kartu/{$konfigkartu['LOGOKIRI']}" ) )
{
	#echo "kkk";exit();
    $tmpkop .= "\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>\n      \t\t<img  src='../nilai/kartu/{$konfigkartu['LOGOKIRI']}' style='width:{$konfigkartu['PLKIRI']}mm;height:{$konfigkartu['LLKIRI']}mm;' > \n        </td>\n        ";
}
else
{
    $tmpkop .= "\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>&nbsp;\n         </td>\n        ";
}
#$tmpkop .= "\n        <td nowrap align='{$konfigkartu['RATA']}' valign=top width=80% style='background-color:#FFFFFF;  '>\n        <b>";
$tmpkop .= "\n        <td nowrap align='{$konfigkartu['RATA']}' valign=top width=10% style='background-color:#FFFFFF;  '>\n        <b>";
if ( trim( $konfigkartu[HEADER1] ) != "" )
{
    $tmpkop .= "\n\t\t<font style='font-size:{$konfigkartu['UHEADER1']}pt;font-family:{$konfigkartu['FHEADER1']};color:#{$konfigkartu['WHEADER1']};'>\n\t\t{$konfigkartu['HEADER1']}<br></font> \n          ";
}
if ( trim( $konfigkartu[HEADER2] ) != "" )
{
    $tmpkop .= "\n\t\t<font style='font-size:{$konfigkartu['UHEADER2']}pt;font-family:{$konfigkartu['FHEADER2']};color:#{$konfigkartu['WHEADER2']};'>\n\t\t{$konfigkartu['HEADER2']}<br></font> \n          ";
}
if ( trim( $konfigkartu[HEADER3] ) != "" )
{
    $tmpkop .= "\n\t\t<font style='font-size:{$konfigkartu['UHEADER3']}pt;font-family:{$konfigkartu['FHEADER3']};color:#{$konfigkartu['WHEADER3']};'>\n\t\t{$konfigkartu['HEADER3']}<br></font> \n          ";
}
if ( trim( $konfigkartu[HEADER4] ) != "" )
{
    $tmpkop .= "\n\t\t<font style='font-size:{$konfigkartu['UHEADER4']}pt;font-family:{$konfigkartu['FHEADER4']};color:#{$konfigkartu['WHEADER4']};'>\n\t\t{$konfigkartu['HEADER4']}</font> \n          ";
}
$tmpkop .= "\n        </td>\n  ";
if ( $konfigkartu[ISLOGOKANAN] == 1 && $konfigkartu[LOGOKANAN] != "" && file_exists( "../nilai/kartu/{$konfigkartu['LOGOKANAN']}" ) )
{
    $tmpkop .= "\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>\n      \t\t<img  src='../nilai/kartu/{$konfigkartu['LOGOKANAN']}' style='width:{$konfigkartu['PLKANAN']}mm;height:{$konfigkartu['LLKANAN']}mm;' > \n        </td>\n        ";
}
else
{
    $tmpkop .= "\n        <td align=right valign=top width=10% style='background-color:#FFFFFF;  '>&nbsp;\n         </td>\n        ";
}
$tmpkop .= "\n      </tr>\n\t\t</table>\n\t\t<hr>\n \t\t ";
?>
