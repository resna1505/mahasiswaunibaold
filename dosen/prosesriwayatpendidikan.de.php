<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.tableform {\r\n\tborder-bottom:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\r\n.makeborder {\r\n\tborder-left:1px solid black;\r\n\tborder-top:1px solid black;\r\n\t}\r\n\t\r\n\r\n</style>\r\n\r\n";
periksaroot( );
printjudulmenukecil( "Riwayat Pendidikan" );
$q = "SELECT riwayatpendidikandosen.*,\r\n     DATE_FORMAT(TANGGALLULUS,'%d-%m-%Y') AS TGL,\r\n\t\t tbpti.NMPTITBPTI AS NAMAPTX\r\n\t\t  FROM riwayatpendidikandosen LEFT JOIN tbpti ON\r\n      riwayatpendidikandosen.KODEPT=tbpti.KDPTITBPTI  \r\n\t\t  WHERE IDDOSEN='{$id}'\r\n\t\t   \r\n\t\t  ORDER BY TANGGALLULUS";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n\t\t\t\t<table class='tableform' cellpadding='0' cellspacing='0'>\r\n \t\t\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td class='makeborder'>No</td>\r\n \t\t\t\t\t\t<td class='makeborder'>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Gelar</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Kode PT</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Nama PT</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Kota Asal</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Kode Negara</td>\r\n\t\t\t\t\t\t<td class='makeborder'>Tanggal<br>Ijazah</td>\r\n\r\n \t\t\t\t\t</tr>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $q = "SELECT * FROM mspds WHERE NODOSMSPDS='{$d['IDDOSEN']}' AND NORUTMSPDS='{$d['ID']}'";
        $h2 = doquery($koneksi,$q);
        if ( sqlnumrows( $h2 ) <= 0 )
        {
            $q = "INSERT INTO mspds (NODOSMSPDS,NORUTMSPDS) VALUES ('{$d['IDDOSEN']}','{$d['ID']}')";
            doquery($koneksi,$q);
            $q = "SELECT * FROM mspds WHERE NODOSMSPDS='{$d['IDDOSEN']}' AND NORUTMSPDS='{$d['ID']}'";
            $h2 = doquery($koneksi,$q);
        }
        $d2 = sqlfetcharray( $h2 );
        $tmp = explode( "-", $d[TANGGALLULUS] );
        $tmp2[tgl] = $tmp[2];
        $tmp2[bln] = $tmp[1];
        $tmp2[thn] = $tmp[0];
        echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} >\r\n\t\t\t\t\t\t<td align=center  class='makeborder'>{$i} &nbsp;</td>\r\n\t\t\t\t\t\t<td align=center class='makeborder'>".$arraypendidikantertinggi[$d2[JENJAMSPDS]]."&nbsp;</td>\r\n\t\t\t\t\t\t<td class='makeborder'>{$d['GELAR']}&nbsp;</td>\r\n\t\t\t\t\t\t<td class='makeborder'>{$d['KODEPT']}&nbsp;</td>\r\n\t\t\t\t\t\t<td class='makeborder'>{$d['NAMAPTX']}&nbsp;</td>\r\n \r\n\t\t\t\t\t\t<td class='makeborder'>{$d['BIDANG']}&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center class='makeborder'>{$d2['KOTAAMSPDS']}&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center class='makeborder'>{$d2['KDNEGMSPDS']}&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center nowrap class='makeborder'>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}&nbsp;</td>\r\n \t\t\t\t\t</tr>";
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
