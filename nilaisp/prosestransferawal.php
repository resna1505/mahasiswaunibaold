<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$arraysort[6] = "SKS";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&tahun={$tahun}&semester={$semester}&";
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
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT SUM(pengambilanmksp.SKSMAKUL) AS SKS,\r\n  mahasiswa.ID,mahasiswa.NAMA,IDPRODI,ANGKATAN,STATUS,IDDOSEN \r\n  FROM mahasiswa , pengambilanmksp\r\n\tWHERE 1=1 \r\n  AND\r\n  mahasiswa.ID=pengambilanmksp.IDMAHASISWA AND\r\n  pengambilanmksp.TAHUN='{$tahun}' AND\r\n  pengambilanmksp.SEMESTER='{$semester}'\r\n  \r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tGROUP BY mahasiswa.ID\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Mahasiswa yang Mengambil KRS Semester Pendek" );
        printmesg( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
    }
    else
    {
        #printjudulmenucetak( "Data Mahasiswa yang Mengambil KRS Semester Pendek" );
        printmesgcetak( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
    }*/
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    if ( $aksi != "cetak" )
    {
        /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Mahasiswa yang Mengambil KRS Semester Pendek </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='prosestransfernilai.php' method=post>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Proses Transfer Nilai'>\r\n\t\t\t\t<input type=hidden name=tahun value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name=sessid value='{$token}'>\r\n\t\t\t\t<input type=hidden name=semester value='{$semester}'>\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
	echo "						<div class=\"caption\">";
										printmesg("Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul);
										printmesg("Data Mahasiswa yang Mengambil KRS Semester Pendek");
    echo "						</div>";
	echo "						<div class=\"tools\">
										<form action='prosestransfernilai.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Proses Transfer Nilai'>\r\n\t\t\t\t<input type=hidden name=tahun value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name=sessid value='{$token}'>\r\n\t\t\t\t<input type=hidden name=semester value='{$semester}'>\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
	
        #echo " \t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='prosestransfernilai.php' method=post>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Proses Transfer Nilai'>\r\n\t\t\t\t<input type=hidden name=tahun value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name=sessid value='{$token}'>\r\n\t\t\t\t<input type=hidden name=semester value='{$semester}'>\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
	echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
    echo "												<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Total SKS</td>\r\n        \r\n \t\t\t</tr>\r\n\t\t";
    echo "			
													</thead>
													<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left nowrap> {$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arraydosen[$d[IDDOSEN]]."</td>\r\n           <td align=center>{$d['SKS']}</td>\r\n  \t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
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
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
