<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
#echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
$q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}' ORDER BY THSMSTRLSM DESC";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    #echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Lulus</td>\r\n          <td>Total SK Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td>\r\n          <td>Tanggal S.K. Yudisium</td>\r\n          <td>Nomor Seri Ijazah</td>\r\n          <td>Jalur</td>\r\n          <td>Skripsi Individu atau Kelompok</td>\r\n          <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td>\r\n \r\n \r\n        </tr>";
    echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n          <td>Tanggal Keluar / Lulus</td>\r\n          <td>Total SKS Lulus</td>\r\n          <td>IPK Akhir</td>\r\n          <td>Nomor S.K. Yudisium</td><td>Tanggal S.K. Yudisium</td><td>Nomor Seri Ijazah</td><td>Jalur</td><td>Skripsi Individu / Kelompok</td>  <td>Bulan-Tahun Awal Bimbingan</td>\r\n          <td>Bulan-Tahun Akhir Bimbingan</td>\r\n          <td>NIDN Dosen Pembimbing #1</td>\r\n          <td>NIDN Dosen Pembimbing #2</td></tr>";
		echo "				</thead>
							<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d2[TGLLSTRLSM] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d[TGLRETRLSM] );
        $tglsk[thn] = $tmp[0];
        $tglsk[tgl] = $tmp[2];
        $tglsk[bln] = $tmp[1];
        $tmp = $d[THSMSTRLSM];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d[BLAWLTRLSM];
        $bulanawal = $tmp[0].$tmp[1];
        $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
        $tmp = $d[BLAKHTRLSM];
        $bulanakhir = $tmp[0].$tmp[1];
        $tahunakhir = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
        echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>".$arraystatusmahasiswa[$d[STMHSTRLSM]]."</td>\r\n          <td nowrap>{$d['TGLLSTRLSM']}</td>\r\n          <td>{$d['SKSTTTRLSM']}</td>\r\n          <td>{$d['NLIPKTRLSM']}</td>\r\n          <td>{$d['NOSKRTRLSM']}</td>\r\n          <td nowrap>{$d['TGLRETRLSM']}</td>\r\n          <td>{$d['NOIJATRLSM']}</td>\r\n          <td>".$arrayjalurskripsi[$d[STLLSTRLSM]]."</td>\r\n          <td>".$arrayskripsiindividu[$d[JNLLSTRLSM]]."</td>\r\n          <td>{$bulanawal}-{$tahunawal}</td>\r\n          <td>{$bulanakhir}-{$tahunakhir}</td>\r\n          <td>{$d['NODS1TRLSM']}</td>\r\n          <td>{$d['NODS2TRLSM']}</td>\r\n           \r\n            </tr>\r\n          ";
        ++$i;
    }
   # echo "\r\n      </table>\r\n    ";
   echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
}
else
{
    printmesg( "Data  Kelulusan Mahasiswa tidak ada" );
}
echo "\r\n   \r\n  ";
?>
