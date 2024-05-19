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
$arraysort[0] = "pengambilanmksp.TAHUN";
$arraysort[1] = "pengambilanmksp.TAHUN";
$arraysort[2] = "pengambilanmksp.IDMAHASISWA";
$arraysort[3] = "";
$arraysort[4] = "pengambilanmksp.IDMAKUL";
$arraysort[5] = "";
$arraysort[6] = "pengambilanmksp.SKSMAKUL";
$arraysort[7] = "pengambilanmksp.KELAS";
$arraysort[8] = "pengambilanmksp.TAHUN,pengambilanmksp.IDMAHASISWA,pengambilanmksp.IDMAKUL";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND makul.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idprodim != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodim}'";
    $qjudul .= " Jurusan / Program Studi Mahasiswa '".$arrayprodidep[$idprodim]."' <br>";
    $qinput .= " <input type=hidden name=idprodim value='{$idprodim}'>";
    $href .= "idprodim={$idprodim}&";
}
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
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
if ( $kelas != "" )
{
    $qfield .= " AND KELAS = '{$kelas}'";
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 8;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM pengambilanmksp,makul,mahasiswa \r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND mahasiswa.ID=pengambilanmksp.IDMAHASISWA AND makul.ID=pengambilanmksp.IDMAKUL\r\n\t{$qfield}\r\n \r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT pengambilanmksp.*,makul.NAMA AS NAMAMAKUL,mahasiswa.NAMA AS NAMAMAHASISWA,\r\n\tmahasiswa.ANGKATAN,\r\n\tmakul.SKS\r\n\tFROM pengambilanmksp,makul,mahasiswa \r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND mahasiswa.ID=pengambilanmksp.IDMAHASISWA AND makul.ID=pengambilanmksp.IDMAKUL\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
        #printjudulmenu( "Data Pengambilan M-K Mahasiswa (KRS)" );
        #printmesg( $qjudul );
		 printmesg( $errmesg );
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakmakul2.php' method=post>
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
    }
    /*else
    {
        #printjudulmenucetak( "Data Pengambilan M-K Mahasiswa (KRS)" );
        printmesgcetak( $qjudul );
    }*/
    /*if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Pengambilan M-K Mahasiswa (KRS) </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakmahasiswa.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=\"btn blue\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";

        #echo " {$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmahasiswa.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }*/
	echo "						<div class=\"caption\">";
												printmesg("Data Pengambilan M-K Mahasiswa (KRS)");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<tr class=juduldata{$aksi} align=center>
																<td>No</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Akademik</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=1'>Semester</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>
																<td>Nama Mahasiswa</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kode</td>
																<td>Nama Mata Kuliah</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=6'>SKS</td>
																<td><a class='{$cetak}' href='{$href}"."&sort=7'>Kelas</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $semesterx = "";
        $kurawal = "";
        $kurtutup = "";
        if ( $d[SEMESTER] != 3 )
        {
            $semesterx = "".( ( $d[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d[SEMESTER] )."";
            $kurawal = "(";
            $kurtutup = ")";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left  nowrap>{$semesterx} {$kurawal} ".$arraysemester[$d[SEMESTER]]." {$kurtutup}&nbsp; </td>\r\n   \t\t\t\t<td align=left>{$d['IDMAHASISWA']}&nbsp;</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMAMAHASISWA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMAMAKUL']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['SKS']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}&nbsp;</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        $totalsks += $d[SKS];
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&idmahasiswaupdate={$d['IDMAHASISWA']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data Pengambilan M-K Mahasiswa  ?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idmakulhapus={$d['IDMAKUL']}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&idmahasiswahapus={$d['IDMAHASISWA']}&sessid={$token}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t<td colspan=7 align=right>Total SKS</td>\r\n   \t\t\t\t<td align=center>{$totalsks}&nbsp;</td>\r\n   \t\t\t\t<td align=left colspan=3>&nbsp;</td>\r\n\t\t\t\t</tr>";
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
    $errmesg = "Data Pengambilan M-K Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
