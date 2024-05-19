<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
$q = "SELECT * FROM trakm WHERE NIMHSTRAKM='{$idupdate}' AND THSMSTRAKM='{$tahunsemester}'";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = $d2[THSMSTRAKM];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
echo "\r\n     <tr class=judulform>\r\n\t\t\t<td>Tahun/Semester Data</td>\r\n\t\t\t<td>";
$waktu = getdate( );
if ( $tahun2 == "" )
{
    $tahun2 = $waktu[year];
}
echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahun2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=masukan> \r\n\t\t\t\t\t\t ";
unset( $arraysemester[3] );
foreach ( $arraysemester as $k => $v )
{
    if ( $k == $semester2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>\r\n\r\n\t\t\t\r\n  </td>\r\n\t\t</tr>".( "<tr >\r\n\t\t\t<td>IP Semester</td>\r\n\t\t\t<td> " ).createinputtext( "ips", $d2[NLIPSTRAKM], " class=masukan size=3" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>SKS Semester</td>\r\n\t\t\t<td>".createinputtext( "skss", $d2[SKSEMTRAKM], " class=masukan  size=3" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>IPK Akhir</td>\r\n\t\t\t<td>".createinputtext( "ipk", $d2[NLIPKTRAKM], " class=masukan  size=3" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>No. SK Yudisium</td>\r\n\t\t\t<td>".createinputtext( "sksk", $d2[SKSTTTRAKM], " class=masukan  size=3" )."</td>\r\n\t\t</tr>\r\n  \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n \r\n\t\t";
?>
