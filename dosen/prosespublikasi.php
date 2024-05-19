<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#printjudulmenukecil( "Daftar Publikasi" );
echo "			<div class=\"caption\">";
					printmesg("Daftar Publikasi");
echo "			</div>";
$q = "SELECT * FROM trpud WHERE NODOSTRPUD='{$idupdate}' ORDER BY THSMSTRPUD DESC, NORUTTRPUD";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    #echo "\r\n\t\t\t\t<table {$border} class=data{$cetak} >\r\n \t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester</td>\r\n\t\t\t\t\t\t<td>Jenis Penelitian</td>\r\n\t\t\t\t\t\t<td>Media Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun/Bulan Publikasi</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t</tr>";
    echo "		<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester</td>\r\n\t\t\t\t\t\t<td>Jenis Penelitian</td>\r\n\t\t\t\t\t\t<td>Media Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun/Bulan Publikasi</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t</tr>";
	echo "						</thead>
								<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = $d[THSMSTRPUD];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d[THNBLTRPUD];
        $tp[thn] = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $tp[bln] = $tmp[4].$tmp[5];
        $judulp = $d[JUDU1TRPUD].$d[JUDU2TRPUD].$d[JUDU3TRPUD].$d[JUDU4TRPUD].$d[JUDU5TRPUD];
        echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} valign=top >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center nowrap>".$arraysemester[$semester]." {$tahun}\r\n             </td>\r\n\t\t\t\t\t\t<td>".$arrayjenispenelitian[$d[KDLITTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraymediapublikasi[$d[KDPUBTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arrayperanpenulisan[$d[KDATHTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraykegiatanmandiri[$d[KDKELTRPUD]]."</td>\r\n\t\t\t\t\t\t<td nowrap>".$arraybulan[$tp[bln] - 1]." {$tp['thn']}</td>\r\n\t\t\t\t\t\t<td>".$arraypembiayaan[$d[KDBIYTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".nl2br( $judulp )."</td>\r\n\r\n \t\t\t\t\t\t \r\n\t\t\t\t\t</tr>";
        ++$i;
    }
    #echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
	echo "								</tbody>
									</table>
								</div>
						</div>
					</div>
					<!--end::Portlet-->	";
}
else
{
    echo "<p>";
    printmesg( "Data Publikasi tidak ada" );
    echo "</p>";
}
echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
?>
