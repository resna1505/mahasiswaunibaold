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
$arraysort[0] = "diskonbeasiswa.IDMAHASISWA";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "diskonbeasiswa.IDKOMPONEN";
$arraysort[3] = "komponenpembayaran.NAMA";
$arraysort[4] = "diskonbeasiswa.DISKON";
$arraysort[5] = "diskonbeasiswa.KET";
$arraysort[6] = "diskonbeasiswa.TAHUN,diskonbeasiswa.SEMESTER";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
#print_r($tingkataksesusers);
if ( $idmahasiswa != "" )
{
    $qfield .= " AND diskonbeasiswa.IDMAHASISWA = '{$idmahasiswa}'";
    $qjudul .= " ID Mahasiswa =  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $idkomponen != "" )
{
    $qfield .= " AND diskonbeasiswa.IDKOMPONEN = '{$idkomponen}'";
    $qjudul .= " ID Komponen '{$idkomponen}' <br>";
    $qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
    $href .= "idkomponen={$idkomponen}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT diskonbeasiswa.*,IF(mahasiswa.APPROVEBEASISWA=1,'approve','belum approve') AS status_beasiswa,mahasiswa.NAMA,komponenpembayaran.NAMA AS NAMAKOMPONEN  ,\r\n\tCOUNT(diskonbeasiswa_log.ID) AS JUMLAHLOG\r\n  FROM diskonbeasiswa LEFT JOIN diskonbeasiswa_log \r\n  ON \r\n  diskonbeasiswa.IDKOMPONEN=diskonbeasiswa_log.IDKOMPONEN AND\r\n  diskonbeasiswa.IDMAHASISWA=diskonbeasiswa_log.IDMAHASISWA  AND\r\n  diskonbeasiswa.TAHUN=diskonbeasiswa_log.TAHUN AND\r\n  diskonbeasiswa.SEMESTER=diskonbeasiswa_log.SEMESTER \r\n  \r\n  \r\n   ,mahasiswa, komponenpembayaran\r\n\tWHERE diskonbeasiswa.IDMAHASISWA=mahasiswa.ID AND\r\n  diskonbeasiswa.IDKOMPONEN=komponenpembayaran.ID \r\n\t{$qfield}\r\n  GROUP BY diskonbeasiswa.IDKOMPONEN,diskonbeasiswa.IDMAHASISWA,diskonbeasiswa.TAHUN,diskonbeasiswa.SEMESTER\r\n\r\n\tORDER BY ".$arraysort[$sort]."";
#echo $q;
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Beasiswa Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Data Beasiswa Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Data Beasiswa Mahasiswa");
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
                                <span class=\"caption-subject bold uppercase\"> Data Beasiswa Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakbeasiswa.php'>\r\n\t\t\t ".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetakbeasiswa.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";

        #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbeasiswa.php'>\r\n\t\t\t ".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'><b>ID Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'><b>Nama Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'><b>ID Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'><b>Nama Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'><b>Periode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'><b>Diskon Pembayaran (%)</td><td><a class='{$cetak}' href='{$href}"."sort=4'><b>Diskon Pembayaran (Rp)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'><b>Keterangan</td><td><a class='{$cetak}' href='{$href}"."sort=6'><b>Status</td>\r\n \t\t\t\t ";
    echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'><b>ID Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'><b>Nama Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'><b>ID Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'><b>Nama Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'><b>Periode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'><b>Diskon Pembayaran (%)</td><td><a class='{$cetak}' href='{$href}"."sort=4'><b>Diskon Pembayaran (Rp)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'><b>Keterangan</td><td><a class='{$cetak}' href='{$href}"."sort=6'><b>Status</td>\r\n \t\t\t\t ";
	
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  ><b>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "												</tr>
													</thead>
													<tbody>";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $idkomponen = $d[IDKOMPONEN];
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
        {
            $d[PERIODE] = "".( $d[TAHUN] - 1 )."/{$d['TAHUN']}";
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            $d[PERIODE] = "".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]];
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
        {
            $d[PERIODE] = "".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]];
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
        {
            $d[PERIODE] = $arraybulan[$d[SEMESTER] - 1]." ".$d[TAHUN];
        }
		if($d[DISKON]>100){
	
			$diskon_rp=$d[DISKON];
			$diskon=0;
		}else{
		
			$diskon=$d[DISKON];
			$diskon_rp=0;
		}
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['IDMAHASISWA']}</td>\r\n   \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n  \t\t\t\t\t<td align=center>{$d['IDKOMPONEN']}</td>\r\n   \t\t\t\t\t<td align=left nowrap>{$d['NAMAKOMPONEN']}</td>\r\n   \t\t\t\t\t<td align=left nowrap>{$d['PERIODE']}</td>\r\n   \t\t\t\t\t<td align=center>{$diskon}</td><td align=center>{$diskon_rp}</td><td align=left>{$d['KET']}</td><td align=left>{$d['status_beasiswa']}</td>\r\n  \t\t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" && $_SESSION['users']!='elly123')
        {
            echo "\r\n\t\t\t\t\t\t\t\t<!-- \r\n                <td nowrap  align=center><a href='index.php?pilihan=historybeasiswa&idmahasiswaupdate={$d['IDMAHASISWA']}&idkomponenupdate={$d['IDKOMPONEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}'>history ({$d['JUMLAHLOG']})</td>\r\n\t\t\t\t\t\t\t\t-->\r\n                <td   align=center><a class=\"btn green\" href='index.php?pilihan=updatebeasiswa&idmahasiswaupdate={$d['IDMAHASISWA']}&idkomponenupdate={$d['IDKOMPONEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Beasiswa Mahasiswa dengan ID {$d['IDMAHASISWA']} dan Komponen Pembayaran {$d['IDKOMPONEN']}?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idmahasiswahapus={$d['IDMAHASISWA']}&idkomponenhapus={$d['IDKOMPONEN']}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&sessid={$_SESSION['token']}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table></div></div></div></div></div>";
	echo "							</tbody>
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
    $errmesg = "Data Komponen Pembayaran Tidak Ada";
    $aksi = "";
}
?>
