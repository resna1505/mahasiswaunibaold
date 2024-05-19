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
$aksi = "";
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else
    {
        $q = "\r\n\r\n          REPLACE INTO   `konfigresetpassword` (\r\n           ID,\r\n          `SUBJEK` ,\r\n          `ISI`  ,\r\n          `UPDATER` ,\r\n          `TANGGALUPDATE`  \r\n          )\r\n          VALUES ( 'PMB',  '{$subjek}',  '{$isi}', \r\n          '{$users}',  NOW() \r\n          )\r\n        \r\n        ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Konfigurasi Reset Password berhasil disimpan";
        }
        else
        {
            $errmesg = "Konfigurasi Reset Password tidak berhasil disimpan";
        }
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    #printjudulmenu( "Konfigurasi RESET PASSWORD CALON MAHASISWA" );
    #printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM konfigresetpassword WHERE ID='PMB'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
    }
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Konfigurasi Reset Password Calon Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post onSubmit=\"return confirm('Simpan data konfigurasi Reset Password?')\" class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								".createinputhidden( "sessid", $_SESSION['token'], "" )."
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Subjek</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "subjek", $d[SUBJEK], " class=form-control m-input  size=50" )." Subjek/judul yang akan dikirim
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Isi</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtextarea( "isi", $d[ISI], " class=form-control m-input  cols=50 rows=20" )."
											<br>Kata Kunci yang dapat digunakan:<br><b>[IDCALONMAHASISWA] <br>[NAMACALONMAHASISWA] <br>
											[PASSWORDBARU] <br>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn blue\">
										</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
}
?>
