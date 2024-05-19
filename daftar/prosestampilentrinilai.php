<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "calonmahasiswa.NOTES";
$arraysort[1] = "calonmahasiswa.NAMA";
$arraysort[2] = "calonmahasiswa.TAHUN";
$arraysort[3] = "calonmahasiswa.GELOMBANG";
$arraysort[4] = "calonmahasiswa.PILIHAN";
$arraysort[5] = "calonmahasiswa.PRODI1";
$arraysort[6] = "calonmahasiswa.PRODI2";
$arraysort[7] = "calonmahasiswa.NILAI DESC";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $tahunmasuk != "" )
{
    $qfield .= " AND TAHUN='{$tahunmasuk}'";
    $qjudul .= " Tahun Masuk '{$tahunmasuk}' <br>";
    $qinput .= " <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>";
    $href .= "tahunmasuk={$tahunmasuk}&";
}
if ( $notes != "" )
{
    $qfield .= " AND NOTES = '{$notes}'";
    $qjudul .= " No. Tes '{$notes}' <br>";
    $qinput .= " <input type=hidden name=notes value='{$notes}'>";
    $href .= "notes={$notes}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID = '{$id}'";
    $qjudul .= " Urutan '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $idpilihan != "" )
{
    $qfield .= " AND PILIHAN='{$idpilihan}'";
    $qjudul .= " Pilihan '".$arraypilihanpmb["{$idpilihan}"]."' <br>";
    $qinput .= " <input type=hidden name=idpilihan value='{$idpilihan}'>";
    $href .= "idpilihan={$idpilihan}&";
}
if ( $idprodi1 != "" )
{
    $qfield .= " AND PRODI1='{$idprodi1}'";
    $qjudul .= " Pilihan 1 '".$arrayprodi[$idprodi1]."' <br>";
    $qinput .= " <input type=hidden name=idprodi1 value='{$idprodi1}'>";
    $href .= "idprodi1={$idprodi1}&";
}
if ( $idprodi2 != "" )
{
    $qfield .= " AND PRODI2='{$idprodi2}'";
    $qjudul .= " Pilihan 2 '".$arrayprodi[$idprodi2]."' <br>";
    $qinput .= " <input type=hidden name=idprodi2 value='{$idprodi2}'>";
    $href .= "idprodi2={$idprodi2}&";
}
if ( $statusprodi1 != "" )
{
    $qfield .= " AND STATUSPRODI1='{$statusprodi1}'";
    $qjudul .= " Status Pilihan 1 '".$arraystatuslulus[$statusprodi1]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi1 value='{$statusprodi1}'>";
    $href .= "statusprodi1={$statusprodi1}&";
}
if ( $statusprodi2 != "" )
{
    $qfield .= " AND STATUSPRODI2='{$statusprodi2}'";
    $qjudul .= " Status Pilihan 2 '".$arraystatuslulus[$statusprodi2]."' <br>";
    $qinput .= " <input type=hidden name=statusprodi2 value='{$statusprodi2}'>";
    $href .= "statusprodi2={$statusprodi2}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM calonmahasiswa \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT *,YEAR(NOW())-YEAR(TANGGALLAHIR) AS UMUR \r\n  FROM calonmahasiswa \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
#echo $q;
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Nilai Ujian Calon Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Nilai Ujian Calon Mahasiswa" );
        printmesgcetak( $qjudul );
        printmesgcetak( $errmesg );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printmesg("Nilai Ujian Calon Mahasiswa");
    if ( $aksi != "cetak" )
    {
		printmesg( $qjudul );	
        echo "						<div class=\"tools\">
										<!--<form target=_blank action='cetakmahasiswa.php' method=post>-->
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td width='1%'>";		
		echo "											<form target=_blank action='cetaknilai.php' method=post>
															<input type=hidden name=pilihan value='{$pilihan}'>
															<input type=hidden name=aksi value='{$aksi}'>
															<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
															<input type=hidden name=gelombang value='{$gelombang}'>
															<input type=hidden name=idpilihan value='{$idpilihan}'>
															<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>
															{$qinput}{$input}
														</form>
													</td>
													<td>
														<form  action='index.php' method=post>
															<input type=hidden name=pilihan value='{$pilihan}'>
															<input type=hidden name=aksi value='{$aksi}'>
															<input type=hidden name=tahunmasuk value='{$tahunmasuk}'>
															<input type=hidden name=gelombang value='{$gelombang}'>
															<input type=submit name=aksi2 class=\"btn btn-brand\" value='Simpan Nilai Ujian'>{$qinput}{$input}
													</td>
												</tr>
											</table>
										</div>{$tpage} {$tpage2}";
        
        #echo " \r\n\t\t\t<form  action='index.php' method=post>\r\n\t\t\t   <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t   <input type=hidden name=aksi value='{$aksi}'>\r\n\t\t\t   <input type=hidden name=tahunmasuk value='{$tahunmasuk}'>\r\n\t\t\t   <input type=hidden name=gelombang value='{$gelombang}'>\r\n\t\t\t   <input type=hidden name=idpilihan value='{$idpilihan}'>\r\n\r\n\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t<tr><td align=right>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Simpan Nilai Ujian'>\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\t\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>No. Tes</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>Urutan</td> -->\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Pilihan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Pilihan 1</td>\r\n \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Pilihan 2</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>NILAI UJIAN</td>\r\n \r\n \r\n\t\t\t</tr>\r\n\t\t";
    echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>No. Tes</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Gel.</td>\r\n\t\t\t<!--\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>Urutan</td> -->\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Pilihan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Pilihan 1</td>\r\n \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Pilihan 2</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>NILAI UJIAN</td>\r\n \r\n \r\n\t\t\t</tr>
													</thead>
													<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $d[UMUR] <= 15 && $aksi != "cetak" )
        {
            $kelas = "style='background-color:#ffff00'";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$cetak} >\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=center>{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=center>{$d['GELOMBANG']}</td>\r\n \t\t\t\t\t<!--<td align=center>{$d['ID']}</td>-->\r\n \t\t\t\t\t<td align=center>".$arraypilihanpmb[$d[PILIHAN]]."</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[PRODI1]]."</td>\r\n \r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[PRODI2]]."</td>\r\n          <td align=center>";
        if ( $aksi != "cetak" )
        {
            echo "\r\n              <input type=text size=4 name='nilai[{$d['GELOMBANG']}][{$d['PILIHAN']}][{$d['ID']}]' value='{$d['NILAI']}'>\r\n              <input type=hidden name='gel[{$d['ID']}]' value='{$d['GELOMBANG']}'>\r\n              <input type=hidden name='pil[{$d['ID']}]' value='{$d['PILIHAN']}'>\r\n              ";
        }
        else
        {
            echo "\r\n              {$d['NILAI']}";
        }
        echo "\r\n          </td>\r\n \r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>\r\n    \t</form>\r\n    </div></div>{$tpage} {$tpage2}</div></div></div>";
	echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Calon Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
