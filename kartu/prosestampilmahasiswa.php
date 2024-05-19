<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "kk";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&jenis={$jenis}&tahun={$tahun}&semester={$semester}&kopsurat={$kopsurat}&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
$qjudul .= " Tahun Akademik ".( $tahun - 1 )."/{$tahun} <br>";
$qjudul .= " Semester ".$arraysemester[$semester]." <br>";
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa WHERE 1=1 {$qprodidep2} {$qfield} ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d['JML'];
include( "../paginating.php" );
$q = "SELECT * FROM mahasiswa WHERE 1=1 {$qprodidep2} {$qfield} ORDER BY ".$arraysort[$sort]." {$qlimit}";
#echo $q.'<br>';
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
    if ( $aksi != "cetak" )
    {
		printmesg( $errmesg );
        printmesg( $qjudul );
        echo " {$tpage} {$tpage2}<div class=\"tools\">
					<form target=_blank action='cetakmahasiswa.php'>
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td>";
        if ($pilihan == "krs")
        {
            echo "\r\n        \r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak KRS'>";
        }
        if ($pilihan == "ujian")
        {
            echo "\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak Kartu Ujian'>";
        }
        echo "\r\n         <input type=hidden name=tahun value='{$tahun}'>\r\n         <input type=hidden name=semester value='{$semester}'>\r\n         <input type=hidden name=jenis value='{$jenis}'>\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n  \t\t\t\t{$qinput} \t\t\t\t{$input}";
		echo "						</td>
								</tr>
							</table>
						</div>					
					</form>
				</div>";
	}
    
    echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td></tr>
													</thead>
													<tbody>";
	$stylestrike = "\r\n        style='  text-decoration:line-through; background: #DDDDDD; '\r\n        ";
    $aturankeuangan = getaturan( "KRSONLINE" );
    $aturankartuujian = getaturan( "KARTUUJIAN" );
	#echo $aturankeuangan."CCCC".$aturankartuujian."FFFF"."<br>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $strikeit = "";
        $lunas = 0;
        if ( $aturankeuangan == 3 )
        {
            $tjenis = $jenis;
            if ( $tjenis == "" )
            {
                $tjenis = "KRS";
            }
			#echo "KKK".$jenis;exit();
            #$lunas = getstatusminimalpembayaransppmahasiswa( $d[ID], $tahun, $semester, $tjenis );
	    $lunas = getstatusminimalpembayaranmahasiswa( $d[ID], $tahun, $semester, $tjenis );
            if ( $lunas[LUNAS] < 0 )
            {
                $strikeit = $stylestrike;
            }
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} {$strikeit} >\r\n\t\t\t\t\t<td>{$i} </td>\r\n\t\t\t\t\t<td align=left>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['ANGKATAN']}  </td>\r\n \t\t\t\t\t<td align=left> {$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']} <!-- {$lunas['STATUS']} --></td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]." </td>";
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
	#echo exit();
    echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					";
					
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
