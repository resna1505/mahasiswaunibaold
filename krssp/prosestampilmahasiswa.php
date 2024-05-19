<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND ID LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND pengambilanmksp.SEMESTER = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $sort == "" )
{
    $sort = "  ID  ";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM  mahasiswa \r\n\tWHERE  \r\n\t IDDOSEN='{$users}'\r\n\t{$qfield}\r\n \r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT   ID,mahasiswa.NAMA  ,\r\n\tmahasiswa.ANGKATAN \r\n\t \r\n\tFROM  mahasiswa \r\n\tWHERE  IDDOSEN='{$users}'\r\n\t \r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
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
	echo "							<div class=\"caption\">";
												printmesg("Data Mahasiswa Perwalian Semester Pendek");
		echo "						</div>";	
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Mahasiswa Perwalian" );
        printmesg( $qjudul );
    }
    /*else
    {
        printjudulmenucetak( "Data Mahasiswa Perwalian" );
        printmesgcetak( $qjudul );
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n  \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n \t\t\t\t<td>Nama Mahasiswa</td>\r\n \t\t\t\t<td>Angkatan</td>\r\n \t\t\t\t<td>Data KRS</td>\r\n \t\t\t\t";
    */
	echo "
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n  \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=ID'>NIM</td>\r\n \t\t\t\t<td>Nama Mahasiswa</td>\r\n \t\t\t\t<td>Angkatan</td>\r\n \t\t\t\t<td>Data KRS</td>\r\n \t\t\t\t";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "												</tr>";
	echo "											</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n    \t\t\t\t<td align=left>{$d['ID']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n   \t\t\t\t<td align=center nowrap>{$d['ANGKATAN']}</td>\r\n   \t\t\t\t<td align=center nowrap><a href='index.php?pilihan={$pilihan}&idmahasiswa={$d['ID']}&aksi=krs'>lihat</td>\r\n \t\t\t\t\t\r\n \t\t\t\t\t";
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "\r\n \r\n\t\t</table>";
	echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								<!--end::Section-->
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
    $errmesg = "Data Mahasiswa Perwalian Semester Pendek Tidak Ada";
    $aksi = "";
}
?>
