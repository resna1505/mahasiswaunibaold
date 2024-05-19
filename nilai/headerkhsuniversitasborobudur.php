<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$namafakultas = "";
$q = "SELECT NAMA FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
}
$sksmaksimum = "";
$semesteracuan = "";
$jenisip = "";
$q = "SELECT * FROM sksmaksimum WHERE IDPRODI='{$d['IDPRODI']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $sksmaksimum = "{$df['SKS']}";
    $semesteracuan = "{$df['SEMESTER']}";
    $jenisip = "{$df['JENISIP']}";
}
echo "<table style='line-height:1'   cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n    <td>UNIVERSITAS BOROBUDUR</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Fakultas ";
echo ucwords( strtolower( $namafakultas ) );
echo "</td>\r\n  </tr>\r\n    <tr>\r\n    <td>Jln Raya kalimalang No. 1 Jakarta</td>\r\n  </tr>\r\n    <tr>\r\n    <td><hr style='color:#000000;'></td>\r\n  </tr>\r\n</table>\r\n\r\n";
$headerkhs .= " \r\n\t\t<center> \r\n  \t\t\t<table> \r\n          <tr>\r\n            <td class='loseborder' > Tahun Akademik </td>\r\n            <td class='loseborder' > :  ".( $tahun - 1 )."/{$tahun} </td>\r\n          </tr>\r\n          <tr>\r\n            <td class='loseborder' > Semester </td>\r\n            <td class='loseborder' > :  ".$arrayromawi[getsemesetermahasiswa( $d[ID], $tahun, $semester )]." </td>\r\n          </tr>\r\n        </table> \r\n        <br>\r\n\t\t\t<table width=660>\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td   class='loseborder' valign=top >\r\n\t\t\t\t<table   >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NAMA MAHASISWA</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n          <tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>NO. POKOK MAHASISWA</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Program Pendidikan</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n            \r\n              ".$arraynamajenjang[$d[TINGKAT]]."  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Jurusan</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n            \r\n             ".$arrayprodi[$d[IDPRODI]]."  \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\t\t\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top> Kelas</td>\r\n\t\t\t\t\t\t<td class='loseborder' valign=top nowrap>: \r\n             ".$arraylabelkelas[$d[KELAS]]."  </td>\r\n\t\t\t\t\t</tr>\t\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n \r\n\t\t</table>\r\n\t\t\r\n\t \r\n\t\t\t";
?>
