<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\t \r\n\tbody {\r\n\t\tfont-family:\"cambria\", tahoma;\r\n\t\t\r\n\t\t}\r\n\r\n\ti {\r\n\t\tfont-family:\"Microsoft Himalaya\", Lucida Fax, Monaco, monospace;\r\n\t\t}\r\n\t\t\r\n\tb,td {\r\n\t\tline-height:1.1;\r\n\t\tfont-style:normal;\r\n\t\t}\r\n\t\t\r\n\ttd {\r\n\t\tfont-size:12px;\r\n\t\tmargin:0px;\r\n\t\tpadding:0px;\r\n\t\t}\r\n\t\t\r\n</style>\r\n";
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
$bodyijazah .= "\r\n    <div   style='page-break-after:always;'> \r\n    <table width=1000 style='margin:-35px auto;' >\r\n    <tr valign=top>\r\n    <td   align=right   class=loseborder >\r\n       Nomor Seri Ijazah : <u>{$noseriijazah}</u>\r\n      <br><br> \r\n      \r\n    </td>\r\n    </tr>\r\n\r\n    <tr >\r\n    <td align=center  class=loseborder style='height:3cm;'>&nbsp;\r\n    <!-- \r\n        <b style='font-family:cambria; font-size:20pt;'>UNIVERSITAS 17 AGUSTUS 1945 JAKARTA<br>\r\n        IJAZAH\r\n        <br><br>\r\n        -->\r\n    </td>\r\n    </tr>\r\n\r\n\r\n    <tr >\r\n    <td align=center class=loseborder style='font-size:16pt;' >\r\n      <b>menyatakan bahwa </b> <br>\r\n      <i>certify that</i>\r\n       <br><br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n      <td  class=loseborder>\r\n      <table width=100%>\r\n        <tr valign=top>\r\n          <td  class=loseborder width=400 style='font-size:12pt;'>\r\n            <b>Nama</b><br>\r\n            <i>Name</i>\r\n            <br>\r\n          </td>\r\n          <td  class=loseborder >\r\n            :\r\n          </td>          \r\n          <td  class=loseborder><font style='font-family: Monotype Corsiva  ;font-size:14pt;'>{$d['NAMA']}</td>\r\n        </tr>\r\n        <tr valign=top>\r\n          <td  class=loseborder width=400 style='font-size:12pt;'>\r\n            <b>NPM</b><br>\r\n            <i>Student Registration Number</i>\r\n               <br>\r\n          </td>\r\n          <td  class=loseborder >\r\n            :\r\n          </td>          \r\n          <td  class=loseborder><font style='font-family: Monotype Corsiva  ;font-size:14pt;'>{$d['ID']}</td>\r\n        </tr>\r\n        <tr valign=top>\r\n          <td  class=loseborder width=400 style='font-size:12pt;'>\r\n            <b>Tempat dan Tanggal Lahir</b><br>\r\n            <i>Place and date of birth</i>\r\n               <br><br>\r\n          </td>\r\n          <td  class=loseborder >\r\n            :\r\n          </td>          \r\n          <td  class=loseborder><font style='font-family: Monotype Corsiva  ;font-size:14pt;'>{$d['TEMPAT']}, {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} </td>\r\n        </tr>\r\n\r\n      </table>\r\n      </td>\r\n    </tr> \r\n\r\n    <tr >\r\n    <td align=left class=loseborder style='font-size:12pt;' >\r\n      <b>Telah memenuhi semua persyaratan akademik untuk mendapatkan gelar</b> <br>\r\n      <i>has fulfilled all academic requirements and is therefore attained the degree of</i>\r\n    </td>\r\n    </tr>\r\n    <tr >\r\n    <td align=left  class=loseborder >\r\n\t<BR>\r\n      <b  style=' font-size:18pt;'>{$d['GELAR']}&nbsp;</b>\r\n    <br>\r\n    </td>\r\n    </tr>";
if ( $PASCA == 1 )
{
    $bodyijazah .= "\r\n\r\n    <tr >\r\n    <td align=left style='font-size:16pt;' class=loseborder >\r\n      <b>Program Pascasarjana </b><br>\r\n      <i>Postgraduate Program </i>\r\n       <br> \r\n    </td>\r\n    </tr>";
}
else
{
    $bodyijazah .= "\r\n\r\n    <tr >\r\n    <td align=left style='font-size:12pt;' class=loseborder >\r\n      <b>Fakultas {$d['NAMAF']}</b><br>\r\n      <i>{$d['NAMAF2']}</i>\r\n       <br> \r\n    </td>\r\n    </tr>";
}
$bodyijazah .= "\r\n    <tr >\r\n    <td align=left style='font-size:12pt;' class=loseborder >\r\n      <b>Program Studi {$d['NAMAP']}</b> \r\n       <br> \r\n    </td>\r\n    </tr>\r\n    <tr >\r\n    <td align=left style='font-size:12pt;' class=loseborder >\r\n      <b>Beserta segala hak dan tanggung jawab yang melekat pada gelar tersebut</b> <br>\r\n      <i>with all right and resposibilities thereof</i>\r\n       <br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n      <td  class=loseborder style='font-size:12px;'>\r\n\t   \r\n      <table  >\r\n        <tr valign=top>\r\n          <td  class=loseborder width=200 style='font-size:14px;'>\r\n            Diberikan di<br>\r\n            <i style='font-size:16px;'>Attained in</i>\r\n            <br> \r\n          </td>\r\n          <td  class=loseborder >\r\n            :\r\n          </td>          \r\n          <td  class=loseborder><b>Jakarta</br></td>\r\n        </tr>\r\n        <tr valign=top>\r\n          <td  class=loseborder width=200 style='font-size:14px;'>\r\n            Pada tanggal<br>\r\n            <i style='font-size:16px;'>on</i>\r\n               <br> \r\n          </td>\r\n          <td  class=loseborder >\r\n            :\r\n          </td>          \r\n          <td  class=loseborder> {$tglyudisium2}</td>\r\n        </tr>\r\n \r\n\r\n      </table>\r\n      </td>\r\n    </tr> \r\n\r\n     <br><br>\r\n     <center>\r\n    <table width=1000>\r\n      <tr valign=top align=center>\r\n         <td width=50% class=loseborder>\r\n          <br><br>   \r\n         <b>Rektor</b><br/>\r\n\t\t\t<i style='font-size:16px;'>Rector</i>\r\n          <br><br><br><br><br><br>\r\n          <u style='font-family:Monotype Corsiva;font-size:22px;'>{$d2['REKTOR']}</u><br>\r\n         <!-- {$d2['NIPREKTOR']} -->\r\n        </td>\r\n  \r\n        <td width=50% class=loseborder><br>";
if ( $PASCA == 1 )
{
    $bodyijazah .= "\r\n          \r\n            <br>Direktur Program Pascasarjana \r\n            <br>\r\n            <i>Director of Postgraduate Program</i>\r\n            <br><br><br><br><br>\r\n            <U> {$namapasca}</U><br>\r\n            ";
}
else
{
    $bodyijazah .= "\r\n            <br><b>Dekan</b><br/>\r\n\t\t\t<i style='font-size:16px;'>Dean</i>\r\n            <br><br><br><br><br><br>\r\n            <u style='font-family:Monotype Corsiva;font-size:22px;'>{$d['DEKAN']}</u><br>\r\n            <!-- {$d['NIPDEKAN']} -->";
}
$bodyijazah .= "   \r\n        </td>\r\n      </tr>\r\n    </table>\r\n    </div>\r\n    \r\n    ";
?>
