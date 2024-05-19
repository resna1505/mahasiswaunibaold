<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$arraystatuskoreksi[0] = "NIM Mahasiswa tidak ada di MSMHS";
$arraystatuskoreksi[1] = "Program Studi Mahasiswa tidak ada di TBPST";
if ( $aksi == "Proses" )
{
    $q = "\r\n  SELECT mahasiswa.ID,mahasiswa.NAMA AS NAMA,msmhs.KDPSTMSMHS,msmhs.KDJENMSMHS,\r\n  0 AS STATUS\r\n  FROM mahasiswa \r\n  LEFT JOIN msmhs\r\n  ON msmhs.NIMHSMSMHS=mahasiswa.ID\r\n  WHERE msmhs.NIMHSMSMHS IS NULL\r\n\r\n\r\n \r\n  \r\n  UNION\r\n\r\n  SELECT mahasiswa.ID,mahasiswa.NAMA AS NAMA,msmhs.KDPSTMSMHS,msmhs.KDJENMSMHS,\r\n  1 AS STATUS\r\n  FROM mahasiswa, msmhs\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=msmhs.KDPSTMSMHS AND\r\n  tbpst.KDJENTBPST=msmhs.KDJENMSMHS\r\n \r\n  WHERE \r\n  msmhs.NIMHSMSMHS=mahasiswa.ID AND\r\n   \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n\r\n\r\n  ORDER BY ID\r\n  ";
    $h = doquery($koneksi,$q);
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
            #printjudulmenu( "KOREKSI DATA MAHASISWA", "bantuan" );
            #printhelp( "{$help_koreksimhs}", "bantuan" );
            #echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t\t<!-- \r\n\t\t\t<form target=_blank action='cetakkoreksimhs.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t-->\r\n\t\t\t\t</td></tr></table>";
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakkoreksidosen.php' method=post>
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
        #    printjudulmenucetak( "KOREKSI DATA MAHASISWA" );
        #}
        #echo "\r\n    <table class=form>\r\n      <tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n        <td>ID</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
        echo "						<div class=\"caption\">";
										printmesg("Koreksi Data Dosen");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n        <td>ID</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n       <tr {$kelas} valign=top align=center>\r\n        <td>{$i}</td>\r\n        <td>{$d['ID']}</td>\r\n        <td>{$d['KDPSTMSDOS']}</td>\r\n        <td>{$d['KDJENMSDOS']}-".$arrayjenjang[$d[KDJENMSDOS]]."</td>\r\n        <td align=left>{$d['NAMA']}</td>\r\n        <td>".IKONWARNING." {$statustambahan}".$arraystatuskoreksi[$d[STATUS]]."</td>\r\n      </tr>\r\n    ";
        }
        #echo "\r\n    </table>\r\n    ";
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
        printjudulmenu( "KOREKSI DATA MAHASISWA", "bantuan" );
        printhelp( "{$help_koreksimhs}", "bantuan" );
        echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA MAHASISWA</span>
                            </div>
                            <div class=\"actions\">";

        echo "\r\n      <form method=post action=index.php></form>
                            </div>
                        </div>\r\n   <div class=\"portlet-body form\">
                            <form action=index.php method=post role=\"form\" class=\"form-horizontal\">
                            <input type=hidden name=pilihan value='{$pilihan}'>";
        printmesg( "Tidak ada data Mahasiswa yang berpotensi tidak valid berdasarkan tabel referensi." );

        echo "</div>
            </div>
        </div>
    </div>";
    }
}
if ( $aksi == "" )
{
    /*printjudulmenu( "KOREKSI DATA MAHASISWA", "bantuan" );
    echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA MAHASISWA</span>
                            </div>
                            <div class=\"actions\">";

    echo "\r\n      <form method=post action=index.php></form>
                            </div>
                        </div>\r\n   <div class=\"portlet-body form\">
                            <form action=index.php method=post role=\"form\" class=\"form-horizontal\">
                            <input type=hidden name=pilihan value='{$pilihan}'>";
    printmesg( "\r\n        Fitur ini akan melakukan pencarian terhadap data mahasiswa yang dianggap tidak valid. Tergantung dari jumlah mahasiswa yang ada, pencarian mungkin memakan waktu cukup lama,\r\n        harap bersabar menunggu sampai proses selesai dilakukan. Terima kasih." );

   
    echo "\r\n        <input class=\"btn blue\" type=submit name=aksi value='Proses' onClick=\"return confirm('Lakukan pencarian data mahasiswa yang tidak valid?');\"   >\r\n      </form>\r\n      </div>
            </div>
        </div>
    </div>";*/
	echo "\r\n\t\t\t<div class=\"page-content\">
        <div class=\"container-fluid\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
						<div class='tab-pane' id='tab_1'>
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
	echo "						<div class=\"caption\">";
										printtitle("Koreksi Data Mahasiswa");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<form method=post action=index.php></form>
                            </div>
                        </div>\r\n   <div class=\"portlet-body form\">
                            <form action=index.php method=post role=\"form\" class=\"form-horizontal\">
                            <input type=hidden name=pilihan value='{$pilihan}'>";
    printtitle( "\r\n        Fitur ini akan melakukan pencarian terhadap data mahasiswa yang dianggap tidak valid. Tergantung dari jumlah mahasiswa yang ada, pencarian mungkin memakan waktu cukup lama,\r\n        harap bersabar menunggu sampai proses selesai dilakukan. Terima kasih." );

   
    echo "\r\n        <input class=\"btn btn-brand\" type=submit name=aksi value='Proses' onClick=\"return confirm('Lakukan pencarian data mahasiswa yang tidak valid?');\"   >\r\n      </form>";
	
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
?>
