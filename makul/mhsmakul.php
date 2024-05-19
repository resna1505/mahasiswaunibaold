<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.noborder td{\r\n\tborder:none;\r\n\t}\r\n\r\n</style>\r\n\r\n";
$q = "SELECT mahasiswa.NAMA,mahasiswa.ID,mahasiswa.IDPRODI FROM mahasiswa,pengambilanmk WHERE 
mahasiswa.ID=pengambilanmk.IDMAHASISWA
AND pengambilanmk.IDMAKUL='{$idmakul}'
AND pengambilanmk.TAHUN='{$tahun}' AND pengambilanmk.SEMESTER='{$semester}' 
and mahasiswa.IDPRODI='{$idprodi}' ORDER BY mahasiswa.ID ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "DAFTAR MAHASISWA PENGAMBIL MATA KULIAH" );
        #echo "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakmhsmakul.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodi", "{$idprodi}", "" ).createinputhidden( "idmakul", "{$idmakul}", "" ).createinputhidden( "namamakul", "{$namamakul}", "" ).createinputhidden( "tahun", "{$tahun}", "" ).createinputhidden( "kelas", "{$kelas}", "" ).createinputhidden( "semester", "{$semester}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakmhsmakul.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn btn-brand\"></input>
														".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodi", "{$idprodi}", "" ).createinputhidden( "idmakul", "{$idmakul}", "" ).createinputhidden( "namamakul", "{$namamakul}", "" ).createinputhidden( "tahun", "{$tahun}", "" ).createinputhidden( "kelas", "{$kelas}", "" ).createinputhidden( "semester", "{$semester}", "" )."\r\n\t\t\t\t{$qinput}
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
	}
    #else
    #{
    #    printjudulmenu( "DAFTAR MAHASISWA PENGAMBIL MATA KULIAH" );
    #}
    /*echo "\r\n \t\t\t<table class=noborder>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".$arrayprodidep[$idprodi]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n      <tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>{$idmakul} / {$namamakul}\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t</table>\r\n  \t";
    echo "\r\n        \r\n        <table   {$border} class=data{$cetak} width=100%>";
    echo "\r\n\t\t\t\t\t<thead  style='display: table-header-group;' >\r\n\t\t\t\t\t <tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td {$rowspan}>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan}>NIM</td>\r\n\t\t\t\t\t\t<td {$rowspan}>Nama</td> \r\n<!--\t\t\t\t\t\t<td {$rowspan}>Prodi</td> -->\r\n             </tr>\r\n  \t\t\t\t \r\n        </thead>";
    */
	echo "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".$arrayprodidep[$idprodi]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n      <tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>{$idmakul} / {$namamakul}\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t</table></div></div>\r\n";

	echo "						<div class=\"caption\">";
												printmesg("Daftar Mahasiswa Pengambil Mata Kuliah");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
														<th {$rowspan}>NO</td>
														<th {$rowspan}>NIM</th>
														<th {$rowspan}>Nama</th>
														";
	echo "			</tr> 
				</thead>
					<tbody>";														
	$i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>\r\n\t\t\t\t\t\t\t \r\n\t\r\n\t\t\t\t\t\t\t<td  align=center nowrap>{$i}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td> \r\n<!--\t\t\t\t\t\t\t<td  align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td> -->\r\n  \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$i;
    }
    #echo "</table>\r\n\t\t\t\t<br><br>\r\n        \r\n        ";
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
    $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
    printmesg( $errmesg );
}
echo "\r\n\t\t\t</td></tr>\r\n     </table> \r\n      ";
?>
