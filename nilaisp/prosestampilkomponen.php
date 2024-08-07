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
$arraysort[0] = "dosenpengajarsp.IDPRODI";
$arraysort[1] = "dosenpengajarsp.TAHUN";
$arraysort[2] = "komponensp.SEMESTER";
$arraysort[3] = "dosenpengajarsp.IDMAKUL";
$arraysort[4] = "komponensp.KELAS";
$arraysort[5] = "komponensp.NAMA";
$arraysort[6] = "komponensp.BOBOT";
$arraysort[7] = "komponensp.IDDOSEN";
$arraysort[8] = "komponensp.TAHUN,komponensp.SEMESTER,dosenpengajarsp.IDMAKUL,komponensp.KELAS";
$tabeldosen = "komponensp";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajarsp.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND komponensp.IDDOSEN LIKE '%{$iddosen}%'";
    $qjudul .= " NIDN Dosen mengandung '{$iddosen}' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND dosenpengajarsp.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND dosenpengajarsp.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND dosenpengajarsp.SEMESTER = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND komponensp.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 8;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM dosenpengajarsp,makul,dosen,komponensp {$tabeltambahan}\r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\tAND makul.ID=dosenpengajarsp.IDMAKUL\r\n\tAND komponensp.IDMAKUL=makul.ID\r\n\tAND komponensp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND komponensp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND komponensp.KELAS=dosenpengajarsp.KELAS\r\n\tAND komponensp.IDDOSEN=dosenpengajarsp.IDDOSEN\r\n\tAND komponensp.IDPRODI=dosenpengajarsp.IDPRODI\r\n\t{$qfieldtambahan}\r\n\t{$qfield}\r\n {$qfieldx2}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT dosenpengajarsp.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN,komponensp.NAMA,\r\n\tkomponensp.BOBOT \r\n\tFROM dosenpengajarsp,makul,dosen,komponensp {$tabeltambahan}\r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\tAND makul.ID=dosenpengajarsp.IDMAKUL\r\n\tAND komponensp.IDMAKUL=makul.ID\r\n\tAND komponensp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND komponensp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND komponensp.KELAS=dosenpengajarsp.KELAS\r\n\tAND komponensp.IDDOSEN=dosenpengajarsp.IDDOSEN\r\n\t{$qfieldtambahan}\r\n\t{$qfield}\r\n\t{$qfieldx2}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Komponen Nilai Mata Kuliah" );
        printmesg( $qjudul );
    }
    else
    {
        #printjudulmenucetak( "Data Komponen Nilai Mata Kuliah" );
        printmesgcetak( $qjudul );
    }*/
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
                                <span class=\"caption-subject bold uppercase\"> Data Komponen Nilai Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakkomponen.php'>\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
						printmesg( $errmesg );
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakkomponen.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";	

        #echo " \r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkomponen.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table> ";
    }
	echo "						<div class=\"caption\">";
												printmesg("Data Komponen Nilai Mata Kuliah");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">";
    #echo "\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>ID Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Sem </td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Komp. Nilai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Bobot (%)</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n \r\n\t\t\t</tr>\r\n\t\t";
    echo "										<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>ID Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Sem </td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kelas</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Komp. Nilai</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Bobot (%)</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td></tr>";
	echo "											</thead>
														<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $styleerror = "";
        $errornamakurikulum = "";
        $namamakulkurikulum = getnamamk( "{$d['IDMAKUL']}", "".( $d[TAHUN] - 1 )."{$d['SEMESTER']}", $d[IDPRODI] );
        if ( $namamakulkurikulum == "" )
        {
            $styleerror = "style='background-color:#ffaaaa'";
            $errornamakurikulum = "tidak ada di kurikulum";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left nowrap >".$arrayprodidep[$d[IDPRODI]]."</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$namamakulkurikulum} {$errornamakurikulum}</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=right>{$d['BOBOT']}</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left  >{$d['NAMADOSEN']}</td>\r\n\t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
			<!--end::Portlet-->
		</div>
	</div>
	";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Komponen Nilai  Tidak Ada";
    $aksi = "";
}
?>
