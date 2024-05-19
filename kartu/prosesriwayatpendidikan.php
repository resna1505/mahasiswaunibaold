<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "Riwayat Pendidikan" );
$q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n\t\t\t\t<table  {$border} class=form{$cetak} >\r\n \t\t\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\r\n \t\t\t\t\t</tr>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TGIJAMSPHS] );
        $tmp2[tgl] = $tmp[2];
        $tmp2[bln] = $tmp[1];
        $tmp2[thn] = $tmp[0];
        echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} >\r\n\t\t\t\t\t\t<td align=center >{$i} </td>\r\n\t\t\t\t\t\t<td align=center>".$arraypendidikantertinggi[$d[JENJAMSPHS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['GELARMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['ASPTIMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['NMPTIMSPHS']}</td>\r\n \r\n\t\t\t\t\t\t<td>{$d['BIDILMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KOTAAMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KDNEGMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}</td>\r\n \t\t\t\t\t</tr>";
        ++$i;
    }
    echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
}
else
{
    echo "<p>";
    printmesg( "Data Riwayat Pendidikan tidak ada" );
    echo "</p>";
}
echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
?>
