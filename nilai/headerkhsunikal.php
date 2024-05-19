<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $dosenta );
unset( $iddosenta );
$tmp = explode( "\n", $d[DOSENTA] );
if ( trim( $tmp[0] ) != "" )
{
    $iddosenta = trim( $tmp[0] );
    $dosenta = getfieldfromtabel( $iddosenta, "NAMA", "dosen" );
}
$idmahasiswa = $d[ID];
$headerkhs .= " \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t\t<table width=95%>\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=70%  class='loseborder'>\r\n\t\t\t\t<table   >\r\n\t\t\t\t  <tr valign=top align=center>\r\n\t\t\t\t    <td  class='loseborder'> <img height=90 src='logounikal.jpg'><br>\r\n\t\t\t\t    <td  class='loseborder'><font style='font-size:16pt;'><b>Universitas Pekalongan</font><br>\r\n            <font style='font-size:18;'><b>( UNIKAL )</font></b>\r\n            <br>\r\n            <b  style='font-size:14;'>Jl. Sriwijaya 3 Telp 0285-42196 Pekalongan\r\n            </td>\r\n          </tr>\r\n        </table>\r\n\t\t\t\t</td>\r\n\t\t\t\t<td width=30%  class='loseborder'>\r\n\t\t\t\t<table  width=100%  >\r\n\t\t\t\t  <tr align=center>\r\n\t\t\t\t    <td  class='loseborder'><font style='font-size:16;'>Kartu Hasil Studi</font><br>\r\n            <font style='font-size:22pt;'><b>( K H S )</b></td>\r\n          </tr>\r\n        </table>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n        </table>\r\n\t\t\t<table   width=95% >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%  class='loseborder'>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left class='loseborder' >\r\n\t\t\t\t\t\t<td class='loseborder'>NPM</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: {$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Nama Mahasiswa</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: {$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Fakultas/Program Studi</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: ".$arrayfakultas[$d[IDFAKULTAS]]."&nbsp;/".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Dosen Wali</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: {$d['NAMADOSEN']}&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50% class='loseborder'>\r\n\r\n\t\t\t\t<table    > \r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Kelas</td>\r\n\t\t\t\t\t\t<td class='loseborder'>:  {$d['KELAS']}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Semester</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: \r\n            \r\n          {$semesterhitung} {$kurawal} ".$arraysemester[$semester]." {$kurakhir}   \r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class='loseborder'>Thn Akademik</td>\r\n\t\t\t\t\t\t<td class='loseborder'>: ".( $tahun - 1 )."/{$tahun}\r\n            &nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t \r\n\t\t\t";
?>
