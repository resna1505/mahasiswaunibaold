<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#echo "<s";
#echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\t}\r\n\r\n\r\nbody {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.makeborder {\r\n\tfont-size:12px;\r\n\t}\r\n\t\r\ntd {\r\n\tpadding:5px;\r\n\t}\r\n\r\n</style>\r\n\r\n";
periksaroot();
$idupdate = $id;
$q = "SELECT * FROM dosen WHERE ID='{$id}'";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Rincian Data Dosen", "bantuan" );
        printhelp( trim( $arrayhelp[hasildosen] ), "bantuan" );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Rincian Data Dosen" );
        printmesgcetak( $errmesg );
    }
    $d = sqlfetcharray( $h );
    if ( $aksi != "cetak" )
    {
        #echo "\r\n\t\t\t\t<table class=form{$cetak}>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklengkap.php'>\r\n\t\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=hidden name=id value='{$id}'>\r\n \t\t\t\t \r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t<table class=form><tr class=judulform>\r\n\t\t\t<td width=200>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDDEPARTEMEN]]."\r\n\t\t\t</td>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen </td>\r\n\t\t\t<td>{$d['ID']}&nbsp;</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Dosen</td>\r\n\t\t\t<td>{$d['NAMA']}&nbsp;</td>\r\n\t\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."&nbsp;</td>\r\n\t\t</tr> \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Akte Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[AKTE]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Izin Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[IZIN]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Dosen</td>\r\n\t\t\t<td>".$arraystatuskerjadosen[$d[STATUSKERJA]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>";
    //include( "dosen2lengkap.php" ); //Terpakai ngak
/*echo "	<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
    echo "				<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
							<div class='portlet box blue'>
								<div class='portlet-title'>
									<div class='caption'>";
										printmesg("Rincian Data Dosen");
	echo"							</div>
								</div>
								<div class='portlet-body form'>
									<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
										<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr class=judulform>\r\n\t\t\t<td width=200>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDDEPARTEMEN]]."\r\n\t\t\t</td>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen </td>\r\n\t\t\t<td>{$d['ID']}&nbsp;</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Nama Dosen</td>\r\n\t\t\t<td>{$d['NAMA']}&nbsp;</td>\r\n\t\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."&nbsp;</td>\r\n\t\t</tr> \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Akte Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[AKTE]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Izin Mengajar</td>\r\n\t\t\t<td>".$arrayya[$d[IZIN]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Dosen</td>\r\n\t\t\t<td>".$arraystatuskerjadosen[$d[STATUSKERJA]]."&nbsp;</td> \t\t\t\r\n\t\t</tr>";
	echo "									</table>
										</div>
									</form>
								</div>";
							/*</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Rincian Data Dosen");
								echo "	</div>";
						echo "<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>
						<div class=\"m-portlet__body\">	
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d[IDDEPARTEMEN]]."</label>\r\n 
							</div>
							<div class=\"form-group m-form__group row\" style=\"padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">NIDN Dosen:</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['ID']}&nbsp;</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['NAMA']}&nbsp;</label>\r\n
							</div>
							<div class=\"form-group m-form__group row\" style=\"padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".nl2br( $d[ALAMAT] )."&nbsp;</label>\r\n
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Akte Mengajar</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayya[$d[AKTE]]."&nbsp;</label>\r\n
							</div>
							<div class=\"form-group m-form__group row\" style=\"padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Izin Mengajar</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayya[$d[IZIN]]."&nbsp;</label>\r\n
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;padding-right:0;\">
								<label class=\"col-lg-2 col-form-label\">Status Dosen</label>\r\n    
								<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraystatuskerjadosen[$d[STATUSKERJA]]."&nbsp;</label>\r\n
							</div>";
    include( "../mahasiswa/biodata2lengkap.php" );
    include( "prosesriwayatpendidikan.php" );
    echo "<br>";
    include( "prosespublikasi.php" );
	echo "</div>
				</form>
			<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
}
else
{
    $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
