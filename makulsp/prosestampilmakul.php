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
$arraysort[0] = "makul.IDPRODI";
$arraysort[1] = "makul.ID";
$arraysort[2] = "makul.NAMA";
$arraysort[3] = "makul.SKS";
$arraysort[4] = "makul.SEMESTER";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
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
if ( $arraysort[$sort] == "" )
{
    $sort = 1;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM makul \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT * FROM makul \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
        #printjudulmenu( "Data Mata Kuliah" );
        printmesg( $qjudul );
		printmesg( $errmesg );
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakmakul.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
    }
    #else
    #{
        #printjudulmenucetak( "Data Mata Kuliah" );
    #    printmesgcetak( $qjudul );
    #}
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
                                <span class=\"caption-subject bold uppercase\"> Data Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakmakul.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";

        #echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmakul.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }*/
	echo "						<div class=\"caption\">";
												printmesg("Data Mata Kuliah SP");
	echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi</td>";
    echo "<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Semester</td>\r\n\t\t\t\t \r\n\t\t\t\t \r\n\t\t \r\n\t\t\t\t";
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi</td>";
    #echo "<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Semester</td>\r\n\t\t\t\t \r\n\t\t\t\t \r\n\t\t \r\n\t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Aksi</td>\r\n\t\t\t\t\t\t\t";
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
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidepmakul[$d[IDPRODI]]."&nbsp;</td>";
        echo "\r\n  \t\t\t\t\t<td align=left>{$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['SKS']}&nbsp;</td>\r\n \t\t\t\t\t<td >{$d['SEMESTER']}&nbsp;</td>\r\n \t\t\t\t\t \r\n \t\t\t\t \r\n \t\t\t\t\t \r\n \t\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            /*echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."&nbsp;</td>";*/
			echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>"."<i class=\"fa fa-edit\"></i>"."</td>";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table> </div></div>{$tpage} {$tpage2}</div></div></div>";
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
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "";
}
?>
