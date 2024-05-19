<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
periksaroot( );
cekhaktulis( $kodemenu );
$arraystatuskoreksi[0] = "NIDN Dosen tidak ada di MSDOS";
$arraystatuskoreksi[1] = "NIDN Dosen tidak ada di TBDOS";
$arraystatuskoreksi[2] = "Program Studi Dosen Pengajar tidak ada di TBPST";
if ( $aksi == "tampilkan" )
{
    if ( $tahunk == "" )
    {
        $qfield = " AND THSMSTRAKD = '{$semesterk}'";
    }
    else
    {
        $qfield = " AND THSMSTRAKD = '".( $tahunk - 1 )."{$semesterk}'";
    }
    $qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
    $qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
    $qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
    $href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
    $q = "\r\n  SELECT trakd.NODOSTRAKD,trakd.THSMSTRAKD,msdos.NMDOSMSDOS AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  0 AS STATUS\r\n  FROM trakd \r\n  LEFT JOIN msdos\r\n  ON msdos.NODOSMSDOS=trakd.NODOSTRAKD\r\n  WHERE msdos.NODOSMSDOS IS NULL\r\n  {$qfield}\r\n\r\n  UNION\r\n\r\n  SELECT trakd.NODOSTRAKD,trakd.THSMSTRAKD,msdos.NMDOSMSDOS AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  1 AS STATUS\r\n  FROM trakd, msdos\r\n  LEFT JOIN tbdos\r\n  ON \r\n  tbdos.NIDNNTBDOS=msdos.NODOSMSDOS\r\n \r\n  WHERE \r\n  msdos.NODOSMSDOS=trakd.NODOSTRAKD AND\r\n   \r\n  (tbdos.NIDNNTBDOS IS NULL)\r\n{$qfield}\r\n  \r\n  UNION\r\n\r\n  SELECT trakd.NODOSTRAKD,trakd.THSMSTRAKD,msdos.NMDOSMSDOS AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  2 AS STATUS\r\n  FROM trakd, msdos\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=msdos.KDPSTMSDOS AND\r\n  tbpst.KDJENTBPST=msdos.KDJENMSDOS\r\n \r\n  WHERE \r\n  msdos.NODOSMSDOS=trakd.NODOSTRAKD AND\r\n   \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n{$qfield}\r\n\r\n  ORDER BY NODOSTRAKD\r\n  ";
    #echo $q;exit();
	$h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
		echo "\r\n\t\t\t<div class=\"page-content\">
        <div class=\"container-fluid\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
						<div class='tab-pane' id='tab_1'>
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
        if ( $cetak != "cetak" )
        {
            #printjudulmenu( "KOREKSI DATA DOSEN PENGAJAR", "bantuan" );
            printhelp( "{$help_koreksidosenpengajar}", "bantuan" );
            /*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA DOSEN PENGAJAR </span>
                            </div>
                            <div class=\"actions\">
                                <form action=cetakkoreksidosenpengajar.php target=_blank>
                                    <input type=submit name=aksi value=Cetak class=\"btn green\"></input>
                                </form>
                            </div>
                        </div>";*/
            #echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkoreksidosenpengajar.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakkoreksidosenpengajar.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td ><input class=\"btn btn-brand\" tombol  name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t</td>
												</tr>
											</table>
										</form>
									</div>";
		}
        #else
        #{
        #    printjudulmenucetak( "KOREKSI DATA DOSEN PENGAJAR" );
        #}
        /*echo "<div class=\"portlet-body\">
                            <div class=\"table-scrollable\">
                                <table class=\"table table-striped table-bordered table-hover\">
                                <thead align=\"center\">
                                    <tr align=\"center\">
                                        <th scope=\"col\">No</th>
                                        <th scope=\"col\">Tahun-Semester</th>
                                        <th scope=\"col\">Kode PST</th>
                                        <th scope=\"col\">Kode Jenjang</th>
                                        <th scope=\"col\">NIDN</th>
                                        <th scope=\"col\">Nama Dosen</th>
                                        <th scope=\"col\">Keterangan</th>
                                    </tr>
                                </thead>";*/
		echo "						<div class=\"caption\">";
										printmesg("Koreksi Data Dosen Pengajar");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th scope=\"col\">No</th>
															<th scope=\"col\">Tahun-Semester</th>
															<th scope=\"col\">Kode PST</th>
															<th scope=\"col\">Kode Jenjang</th>
															<th scope=\"col\">NIDN</th>
															<th scope=\"col\">Nama Dosen</th>
															<th scope=\"col\">Keterangan</th>
														</tr>";
        #echo "\r\n    <table class=form>\r\n      <tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n        <td>Tahun-Semester</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>NIDN</td>\r\n        <td>Nama Dosen</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n       <tr {$kelas} valign=top align=center>\r\n        <td>{$i}</td>\r\n        <td>{$d['THSMSTRAKD']}</td>\r\n        <td>{$d['KDPSTMSDOS']}</td>\r\n        <td>{$d['KDJENMSDOS']}-".$arrayjenjang[$d[KDJENMSDOS]]."</td>\r\n        <td>{$d['NODOSTRAKD']}</td>\r\n        <td align=left>{$d['NAMA']}</td>\r\n        <td align=left >".IKONWARNING." {$statustambahan}".$arraystatuskoreksi[$d[STATUS]]."</td>\r\n      </tr>\r\n    ";
        }
        /*echo "\r\n    </table>\r\n  </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                </div>
            </div>
        </div>
    </div>  <br><br><br><br>";*/
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
    }
    else
    {
        printjudulmenu( "KOREKSI DATA DOSEN PENGAJAR", "bantuan" );
        printhelp( "{$help_koreksidosenpengajar}", "bantuan" );
        printmesg( "Tidak ada data Dosen Pengajar yang berpotensi tidak valid berdasarkan tabel referensi." );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    #printjudulmenu( "KOREKSI DATA DOSEN PENGAJAR" );
    printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA DOSEN PENGAJAR </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Koreksi Data Dosen Pengajar");
								echo	"</div>
										</div>
									<div class='portlet-body form'>";

    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t\r\n\t \r\n\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tSemester Tahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\r\n            <select name=semesterk class=masukan> \r\n\t\t\t\t\t\t ";
    $arraysemester[''] = "-";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\t<select name=tahunk class=masukan> \r\n\t\t\t\t\t ";
    $arrayangkatan = getarrayangkatan( "P" );
    foreach ( $arrayangkatan as $k => $v )
    {
        $selected = "";
        if ( $k == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "<option value='' >-</option>
            </select>
                </td>
                    </tr>
					<tr>
						<td colspan='2'><input type=submit value='Tampilkan' class=\"btn btn-brand\"></td>
					</tr>
                </table>
				</form>
				</div></div></div></div></div></div></div>";
}
?>
