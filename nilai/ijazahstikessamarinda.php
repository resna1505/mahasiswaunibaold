<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$bodyijazah .= "\r\n    <center   style='page-break-after:always;height:100%;'> \r\n    <table width=95%  >\r\n    <tr>\r\n    <td class=loseborder>\r\n    <table width=100% class=loseborder>\r\n    <tr class=loseborder>\r\n    <td   align=left  class=loseborder >\r\n    <b style='font-family: Verdana;font-size:12pt;'>No: {$noseriijazah}\r\n     </td>\r\n    <td   align=right  class=loseborder >\r\n    <b style='font-family: Ms Mincho;font-size:14pt;'>No: ".cetakdigitnol( $noblanko, 7 )."\r\n     </td>\r\n     \r\n     </tr></table>\r\n     </td>\r\n    </tr>\r\n\t<tr >\r\n    <td align=center class=loseborder style='height:2cm;'>\r\n    &nbsp;\r\n    </td>\r\n    </tr>\r\n    <tr >\r\n    <td align=center class=loseborder >\r\n\t<br/>\r\n\t<br/>\r\n  \t<b style='font-family:  Times New Roman;font-size:26pt;' >IJAZAH <br/></b> <p style='font-family:  Times New Roman;font-size:11pt;'><b>Diberikan Kepada : </b></p>\r\n      <br><br>\r\n    </td>\r\n    </tr>\r\n    <!--     \r\n    <tr >\r\n    <td align=center class=loseborder >\r\n  \t<br><br>  <fonr style='font-family: Tahoma;font-size:14pt;'>  Dengan ini menyatakan bahwa :   </font>\r\n      \r\n    </td>\r\n    </tr>\r\n    -->\r\n    <tr>\r\n    <td align=center style=' font-size:12pt;' class=loseborder>\r\n      <font style='font-family: Times New Roman  ;font-size:26pt;font-weight:bold;'>\r\n      {$d['NAMA']}</font><br>\r\n      <font style='font-family: Tahoma  ;font-size:12pt; font-weight:bold;'>NPM :  {$d['ID']} </font> <br><br>\r\n      <p align=justify>\r\n        <font style='font-family: Tahoma  ;font-size:14pt;'>\r\n      Lahir di {$d['TEMPAT']}, {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      masuk di Sekolah Tinggi Ilmu Kesehatan Muhammadiyah Samarinda Tahun {$d['ANGKATAN']}, dan\r\n      telah menyelesaikan dengan baik dan memenuhi segala syarat \r\n      pendidikan ".$arraynamajenjang_sm[$d[TINGKAT]]." pada Program Studi  ".$arraynamajenjang_sm[$d[TINGKAT]]." ".ucwords( strtolower( $d[NAMAP] ) ).", tanggal {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}.\r\n       Oleh sebab itu kepadanya diberikan gelar : <br><br>\r\n      </b><b>\r\n      </p>\r\n      <font style='font-family: Times New Roman  ;font-size:28pt;'>\r\n      {$d['GELAR']}\r\n      </font></b>\r\n      <p align=left>\r\n       <font style='font-family: Tahoma  ;font-size:14pt;'>\r\n      <br> \r\n       Beserta segala hak dan kewajiban yang melekat pada gelar tersebut.</p>\r\n       <p align=left><br> \r\n       <font style='font-family: Tahoma  ;font-size:14pt;'>\r\n     Diberikan di Samarinda Pada Tanggal    ".angkatoteks( $tgllap[tgl] )." ".$arraybulan[$tgllap[bln] - 1]." ".angkatoteks( $tgllap[thn] )."\r\n    </p>\r\n    </td>\r\n    </tr>\r\n    </table>";
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE1];
    $gambarttd2 = $dttd[FILE2];
    $field1 = "FILE1";
    $field2 = "FILE2";
    $idprodix = "";
}
unset( $dttd );
$bodyijazah .= " \r\n\t\t\t\t\t  <br><br>\r\n\t\t\t\t\t\t<table border=0 width=85%  >\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td width=70% class=loseborder><font style='font-family: Tahoma  ;font-size:14pt;'>\r\n                ";
if ( $namadirektur2 != "" )
{
    $bodyijazah .= "\r\n                <br><br>\r\n                {$jabatandirektur2}";
    if ( $gambarttd2 == "" )
    {
        $bodyijazah .= "\r\n\t\t\t\t\t\t\t\t<br><br><br>";
    }
    else
    {
        $bodyijazah .= "\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field2}' height=80> \r\n\t\t\t\t\t\t\t\t ";
    }
    $bodyijazah .= "\r\n\t\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t\t<u style='font-family: Tahoma  ;font-size:14pt;'>{$namadirektur2}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur2}\r\n                ";
}
$bodyijazah .= "\r\n                \r\n                </td>\r\n\t\t\t\t\t\t\t\t\r\n \t\t\t\t\t\t\t\t<td align=left nowrap width=15% class=loseborder><font style='font-family: Tahoma  ;font-size:14pt;'>\r\n\t\t\t\t\t\t\t\t<div style='margin-left:50px;margin-top:22px;font-size:14pt;'>\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t{$jabatandirektur}";
if ( $gambarttd1 == "" )
{
    $bodyijazah .= "\r\n\t\t\t\t\t\t\t\t<br><br><br>";
}
else
{
    $bodyijazah .= "\r\n\t\t\t\t\t\t\t\t<br><br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$bodyijazah .= "<br>\r\n\t\t\t\t\t\t\t\t\t<u style='font-family: Tahoma  ;font-size:14pt;'>{$namadirektur}</u><br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur}\r\n\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t</center>\t\r\n\t\t\t\t \r\n\t\t\t\t\t";
?>
