<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
$q = "SELECT * FROM trnlm WHERE NIMHSTRNLM='{$idupdate}' AND THSMSTRNLM='{$tahunsemester}'\r\n     AND KDKMKTRNLM='{$makulupdate}' ";
$h2 = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = $d2[THSMSTRNLM];
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
echo "\r\n\t\t\t\t\t\t</select>\r\n\r\n\t\t\t\r\n  </td>\r\n\t\t</tr>".( "<tr >\r\n\t\t\t<td width=150>Kode Makul</td>\r\n\t\t\t<td> " ).createinputtext( "kodemakul", $d2[KDKMKTRNLM], " class=masukan size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,kodemakul',\r\n\t\t\tdocument.form.kodemakul.value)\" >\r\n\t\t\tdaftar Mata Kuliah\r\n\t\t\t</a>      \r\n      <br>\r\n      <b>".getfield( "NAMA", "makul", " WHERE ID='{$d2['KDKMKTRNLM']}'" )."\r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Nilai</td>\r\n\t\t\t<td>".createinputtext( "nilai", $d2[NLAKHTRNLM], " class=masukan  size=3" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Bobot</td>\r\n\t\t\t<td>".createinputtext( "bobot", $d2[BOBOTTRNLM], " class=masukan  size=3" )."</td>\r\n\t\t</tr> \r\n   \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n \r\n\t\t";
?>
