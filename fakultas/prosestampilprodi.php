<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$arraysort[0] = "prodi.IDDEPARTEMEN";
$arraysort[1] = "prodi.NAMA";
$arraysort[2] = "prodi.TINGKAT";
$arraysort[3] = "prodi.JENIS";
$arraysort[4] = "prodi.GELAR";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $iddepartemen != "" )
{
    $qfield .= " AND IDDEPARTEMEN='{$iddepartemen}'";
    $qjudul .= " Kode Jurusan '{$iddepartemen}' / ".$arraydepfak[$iddepartemen]."";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $namaprodi != "" )
{
    $qfield .= " AND NAMA LIKE '%{$namaprodi}%'";
    $qjudul .= " Nama Program Studi '{$namaprodi}'";
    $qinput .= " <input type=hidden name=namaprodi value='{$namaprodi}'>";
    $href .= "namaprodi={$namaprodi}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM prodi \r\n\tWHERE 1=1\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = doquery($koneksi, $q );
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                       ";
    if ( $aksi != "cetak" )
    {
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakprodi.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi value=Cetak class=\"btn btn-success\"></input>
													</td>
												</tr>
											</table>
										</form>
									</div>";
        
        #printhelp( trim( $arrayhelp[hasilprodi] ), "bantuan" );
        #printmesg( $qjudul );
        #printmesg( $errmesg );
    }
    #else
    #{
        #printjudulmenucetak( "Data Program Studi" );
        #printmesgcetak( $qjudul );
    #}
    #if ( $aksi != "cetak" )
    #{
        /*echo "\r\n\t\t\t<form target=_blank action='cetakprodi.php'>\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr valign=top><td >\r\n      ".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak Data Dikti'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t\t</td></tr></table>\r\n\t\t\t</form>\r\n";*/
    #}
    /*echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n            <thead>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n            \r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td>Kode</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>{$JUDULFAKULTAS} / Jurusan</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Prog. Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Tingkat</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Gelar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Jenis</td>\r\n\t\t\t\t";*/

   
		echo "						<div class='portlet-title'>";
										printmesg($errmesg);
										printtitle("Data Jurusan");
										printtitle($qjudul);
		echo "						</div>";
		echo "						<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th>No</th>
															<th>Kode</th>
															<th>{$JUDULFAKULTAS} / Jurusan</th>
															<th>Nama Prog. Studi</th>
															<th>Tingkat</th>
															<th>Gelar</th>
															<th>Jenis</th>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        #echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 ></td>\r\n\t\t\t\t\t\t\t";
		echo "<th>Edit</th>
						<th>Hapus</th>";
    }
    #echo "\r\n\t\t\t</tr>\r\n            </thead>\r\n\t\t";
	 echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td>{$d['ID']}</td>\r\n  \t\t\t\t\t<td align=left>".$arraydepfak[$d['IDDEPARTEMEN']]."</td>\r\n  \t\t\t\t\t<td align=left>{$d['NAMA']}<br><i>{$d['NAMA2']}</i></td>\r\n \t\t\t\t\t<td align=left>".$arrayjenjang[$d['TINGKAT']]."<br><i>{$d['NAMAJENJANG2']}</td>\r\n  \t\t\t\t\t<td align=left>{$d['GELAR']}<br><i>{$d['GELAR2']}</i></td>\r\n \t\t\t\t\t<td align=left>".$arrayjenisprodi[$d['JENIS']]."</td>\r\n \t\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-edit\"></i>"."\r\n                </td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data Program Studi Dengan Nama = {$d['NAMA']} ? Seluruh data Mata Kuliah, Mahasiswa, dan data yang berhubungan dengan Program Studi ini akan dihapus ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>\r\n                "."<i class=\"fa fa-trash\"></i>"." </td>\r\n\t\t\t\t\t\t\t\t";

        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    /*echo "</table>";*/
    echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Program Studi Tidak Ada";
    $aksi = "";
}
?>
