<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
$qfield = " AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}'";
$qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
$qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
$qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
$href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
if ( $idprodi != "" )
{
    $qfield .= " AND IDX='{$idprodi}'";
    $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $id != "" )
{
    $qfield .= " AND ID LIKE '%{$id}%'";
    $qjudul .= " Kode mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $semester != "" )
{
    $qfield .= " AND SEMESTER = '{$semester}'";
    $qjudul .= " Semester '{$semester}' <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $sks != "" )
{
    $qfield .= " AND SKS = '{$sks}'";
    $qjudul .= " SKS '{$sks}' <br>";
    $qinput .= " <input type=hidden name=sks value='{$sks}'>";
    $href .= "sks={$sks}&";
}
if ( $jenismakul != "" )
{
    $qfield .= " AND JENIS='{$jenismakul}'";
    $qjudul .= " Jenis '".$arrayjenismakul[$jenismakul]."' <br>";
    $qinput .= " <input type=hidden name=jenismakul value='{$jenismakul}'>";
    $href .= "jenismakul={$jenismakul}&";
}
if ( $kelompokmakul != "" )
{
    $qfield .= " AND KELOMPOK='{$kelompokmakul}'";
    $qjudul .= " Kelompk '".$arraykelompokmakul[$kelompokmakul]."' <br>";
    $qinput .= " <input type=hidden name=kelompokmakul value='{$kelompokmakul}'>";
    $href .= "kelompokmakul={$kelompokmakul}&";
}
$qfield .= " AND KELOMPOKKURIKULUM='{$kelompokkurikulum}'";
$qjudul .= " Kelompok Kurikulum '".$arraykelompokkurikulum[$kelompokkurikulum]."' <br>";
$qinput .= " <input type=hidden name=kelompokkurikulum value='{$kelompokkurikulum}'>";
$href .= "kelompokkurikulum={$kelompokkurikulum}&";
if ( $kelompok != "" )
{
    $qfield .= " AND KDKELTBKMK='{$kelompok}'";
    $qjudul .= " Kelompok Mata Kuliah '".$arraykelompokmk[$kelompok]."' <br>";
    $qinput .= " <input type=hidden name=kelompok value='{$kelompok}'>";
    $href .= "kelompok={$kelompok}&";
}
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML \r\n    FROM makul,mspst,tbkmk\r\n\tWHERE 1=1 AND\r\n  makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n {$qprodideptbkmk} \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT tbkmk.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmk.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER\r\n      \r\n      FROM makul ,mspst,tbkmk\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n {$qprodideptbkmk}\r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
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
								printmesg( $qjudul );
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Pembagian Kelas Mata Kuliah" );
        
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakmakul2kelas.php' method=post>
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
    #else
    #{
    #    printjudulmenucetak( "Pembagian Kelas Mata Kuliah" );
    #    printmesgcetak( $qjudul );
    #}
    #if ( $aksi != "cetak" )
    #{
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
                                <span class=\"caption-subject bold uppercase\"> Pembagian Kelas Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakmakul2kelas.php'>\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
        #echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmakul2kelas.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    #}
	echo "						<div class=\"caption\">";
												printmesg("Pembagian Kelas Mata Kuliah");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
    #echo "\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDPRODI'>Jurusan / Program Studi Penyelenggara</td>";
    echo "<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=IDPRODI'>Jurusan / Program Studi Penyelenggara</td>";
    
	echo "<td><a class='{$cetak}' href='{$href}"."&sort=ID'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=NAMA'>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=KDKELTBKMK'>Kelompok Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=SKS'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=SEMESTER'>Semester</td>\r\n\t\t\t\t<td>Jml Mhs</td>\r\n\t\t\t\t \r\n\t\t\t\t \r\n\t\t \r\n\t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap    >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $datadikti = "";
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>";
        $q = "SELECT COUNT(IDMAHASISWA) AS JML \r\n          FROM pengambilanmk,mahasiswa\r\n          WHERE\r\n          pengambilanmk.IDMAHASISWA=mahasiswa.ID AND\r\n          TAHUN='{$tahunk}' AND SEMESTER='{$semesterk}'\r\n          AND IDMAKUL='{$d['ID']}' AND IDPRODI='{$d['IDPRODI']}'\r\n          ";
        $hj = mysqli_query($koneksi,$q);
        $dj = sqlfetcharray( $hj );
        $jumlahmhs = $dj[JML];
        echo "\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td >".$arraykelompokmk[$d[KDKELTBKMK]]."</td>\r\n  \t\t\t\t\t<td >{$d['SKS']}</td>\r\n\t\t\t\t\t<td >{$d['SEMESTER']}</td>\r\n \t\t\t\t\t<td >{$jumlahmhs}</td>\r\n \t\t\t\t\t \r\n \t\t\t\t \r\n \t\t\t\t\t \r\n \t\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan=kelas&aksi=formupdate&tab=1&idupdate={$d['ID']}&tahunk={$tahunk}&semesterk={$semesterk}&idprodi={$d['IDPRODI']}&prodiupdate={$d['KDPSTTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&sks={$d['SKS']}&semkul={$d['SEMESTER']}'>Edit Kelas</td>\r\n\t\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table> </div></div></div></div></div></div>";
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
			</div>
			</div>
			</div>";
	
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "";
}
?>
