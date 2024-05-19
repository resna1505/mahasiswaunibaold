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
if ( $aksi == "Simpan" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Keterangan Ujian", SIMPAN_DATA );
    }
    else
    {
        $q = "\r\n \r\nREPLACE INTO   `keteranganujianpmb` (ID,\r\n SEBELUMUJIAN,\r\n SESUDAHUJIAN,\r\n CETAKFORM,\r\n`UPDATER` ,\r\n`LASTUPDATE`  \r\n \r\n)\r\nVALUES (0, '{$sebelumujian}',  '{$sesudahujian}' ,'{$cetakform}' ,  '{$users}',  NOW() \r\n);\t\t    \r\n \r\n\t\t";
        doquery($koneksi,$q);
        echo mysqli_error($koneksi);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Keterangan berhasil disimpan";
        }
        else
        {
            $errmesg = "Keterangan tidak disimpan";
        }
    }
}
$q = "SELECT * FROM keteranganujianpmb WHERE ID=0 LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
unset( $d );
if ( 0 <= sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
cekhaktulis( $kodemenu );
#printjudulmenu( "Keterangan Ujian PMB" );
#printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Keterangan Ujian PMB");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
echo "						<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "pilihan", $pilihan, "" )."".
								createinputhidden( "sessid", $_SESSION['token'], "" )."";
echo "							<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Saat Cetak Form</label>\r\n    
										<label class=\"col-form-label\">
											<textarea name=cetakform class=form-control m-input cols=60 rows=20>{$d['CETAKFORM']}</textarea>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Sebelum Ujian (Informasi Ujian)</label>\r\n    
										<label class=\"col-form-label\">
											<textarea name=sebelumujian class=form-control m-input cols=60 rows=20>{$d['SEBELUMUJIAN']}</textarea>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Sesudah Ujian</label>\r\n    
										<label class=\"col-form-label\">
											<textarea name=sesudahujian class=form-control m-input cols=60 rows=20>{$d['SESUDAHUJIAN']}</textarea>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-secondary\">
										</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
?>
