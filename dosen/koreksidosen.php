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
$arraystatuskoreksi[0] = "NIDN Dosen tidak ada di MSDOS";
$arraystatuskoreksi[1] = "NIDN Dosen tidak ada di TBDOS";
$arraystatuskoreksi[2] = "Program Studi Dosen tidak ada di TBPST";
if ( $aksi == "" )
{
    $q = "\r\n  SELECT dosen.ID,dosen.NAMA AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  0 AS STATUS\r\n  FROM dosen \r\n  LEFT JOIN msdos\r\n  ON msdos.NODOSMSDOS=dosen.ID\r\n  WHERE msdos.NODOSMSDOS IS NULL\r\n\r\n\r\n  UNION\r\n\r\n  SELECT dosen.ID,dosen.NAMA AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  1 AS STATUS\r\n  FROM dosen, msdos\r\n  LEFT JOIN tbdos\r\n  ON \r\n  tbdos.NIDNNTBDOS=msdos.NODOSMSDOS\r\n \r\n  WHERE \r\n  msdos.NODOSMSDOS=dosen.ID AND\r\n   \r\n  (tbdos.NIDNNTBDOS IS NULL)\r\n\r\n  \r\n  UNION\r\n\r\n  SELECT dosen.ID,dosen.NAMA AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS,\r\n  2 AS STATUS\r\n  FROM dosen, msdos\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=msdos.KDPSTMSDOS AND\r\n  tbpst.KDJENTBPST=msdos.KDJENMSDOS\r\n \r\n  WHERE \r\n  msdos.NODOSMSDOS=dosen.ID AND\r\n   \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n\r\n\r\n  ORDER BY ID\r\n  ";
    $h = doquery($koneksi,$q);
    #echo mysqli_error($koneksi);
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
            #printjudulmenu( "KOREKSI DATA DOSEN", "bantuan" );
            #printhelp( "{$help_koreksidosen}", "bantuan" );
            //echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkoreksidosen.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
			/* echo "\r\n\t\t\t<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						<div class=\"portlet light\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class=\"portlet-title\">
										<div class=\"caption\">";
											printmesg("Koreksi Data Dosen");
			echo "						</div>
									</div>
									<div class=\"portlet-body form\">
										<form action=cetakkoreksidosen.php target=_blank method=post>
											<div class=\"portlet-body\">
												<div class=\"table-scrollable\">
													<table class=\"table table-striped table-bordered table-hover\">\n\t\t\t\t<tr>\r\n\t\t\t\t<td ><input class=\"btn btn-brand\" tombol  name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>";
			echo "									</table>
												</div>
											</div>";*/
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakkoreksidosen.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td ><input class=\"btn btn-success\" name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t</td>
												</tr>
											</table>
										</form>
									</div>";
		}
        #else
        #{
        #    printjudulmenucetak( "KOREKSI DATA DOSEN" );
        #}
        //echo "\r\n    <table class=form {$border}>\r\n      <tr class=juduldata{$cetak} valign=top align=center>\r\n        <td>No</td>\r\n        <td>ID</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>Nama Dosen</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";

        /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"caption\">
										<i class=\"fa fa-cogs font-white-sharp\"></i>
										KOREKSI DATA DOSEN
									</div>
									<div class=\"tools\">
										<form target=_blank action='cetakkoreksidosen.php' method=post>
											<input type=submit name=aksi value=Cetak class=\"btn green\"></input>
										</form>
									</div>
								</div>
								<div class=\"portlet-body\">
									<table class=\"table table-striped table-bordered table-hover\">
									<thead>
									<tr>
										<th scope=\"col\">No</th>
										<th scope=\"col\">ID</th>
										<th scope=\"col\">Kode PST</th>
										<th scope=\"col\">Kode Jenjang</th>
										<th scope=\"col\">Nama Dosen</th>
										<th scope=\"col\">Keterangan</th>
									</tr>
									</thead> ";*/
		/*echo "<div class=\"m-portlet m-portlet--mobile\">
				";
	echo "<div class=\"m-portlet__body\">
			<!--begin: Datatable -->
			<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_2\">
				<thead>
					<tr>
						    <th>No</th>
                                <th>ID</th>
                                <th>Kode PST</th>
                                <th>Kode Jenjang</th>
                                <th>Nam Progdi</th>
                                <th>Keterangan</th>
                            ";
		echo "			</tr> 
				</thead>
					<tbody>";*/
		echo "						<div class=\"caption\">";
										printmesg("Koreksi Data Dosen");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th>No</th>
															<th>ID</th>
															<th>Kode PST</th>
															<th>Kode Jenjang</th>
															<th>Nam Progdi</th>
															<th>Keterangan</th>
														</tr>";
    
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n       <tr {$kelas}{$cetak} valign=top align=center>\r\n        <td>{$i}</td>\r\n        <td>{$d['ID']}</td>\r\n        <td>{$d['KDPSTMSDOS']}</td>\r\n        <td>{$d['KDJENMSDOS']}-".$arrayjenjang[$d[KDJENMSDOS]]."</td>\r\n        <td align=left>{$d['NAMA']}</td>\r\n        <td align=left>".IKONWARNING." {$statustambahan}".$arraystatuskoreksi[$d[STATUS]]." </td>\r\n      </tr>\r\n    ";
        }
        /*echo "</table>
                </div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    </div>";*/
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
        printjudulmenu( "KOREKSI DATA DOSEN", "bantuan" );
        printhelp( "{$help_koreksidosen}", "bantuan" );
        printmesg( "Tidak ada data Dosen yang berpotensi tidak valid berdasarkan tabel referensi." );
    }
}
?>
