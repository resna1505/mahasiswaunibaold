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
        $q = "\r\n\r\n          REPLACE INTO   `konfigpengumumanpmb` (\r\n           ID,\r\n          `SUBJEK` ,\r\n          `ISI`  ,\r\n          `ISI2`  ,\r\n          `UPDATER` ,\r\n          `TANGGALUPDATE`  \r\n          )\r\n          VALUES ( 'PMB',  '{$subjek}',  '{$isi}', '{$isi2}', \r\n          '{$users}',  NOW() \r\n          )\r\n        \r\n        ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Konfigurasi Pengumuman Kelulusan berhasil disimpan";
        }
        else
        {
            $errmesg = "Konfigurasi Pengumuman Kelulusan tidak berhasil disimpan";
        }
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    #printjudulmenu( "Konfigurasi PENGUMUMAN KELULUSAN CALON MAHASISWA" );
    #printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM konfigpengumumanpmb WHERE ID='PMB'";
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
								printmesg("Konfigurasi Pengumuman Kelulusan Calon Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post onSubmit=\"return confirm('Simpan data konfigurasi pengumuman?')\" class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
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
										<label class=\"col-lg-2 col-form-label\">Untuk yang lulus</label>\r\n    
										<label class=\"col-form-label\">
											
											<textarea id=isi name=isi class=\"form-control\" cols=50 rows=20>";
											echo $d['ISI'];	
	echo"									</textarea>
											<br>Kata Kunci yang dapat digunakan:
											<br><b><ul>\r\n        <li>[IDCALONMAHASISWA] <br>\r\n      <li>[NAMACALONMAHASISWA] <br>\r\n      <li>[STATUSKELULUSAN] <br> \r\n      <li>[PILIHANPRODI] <br> \r\n      <li>[PILIHANFAKULTAS]</ul></b>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Untuk yang TIDAK lulus</label>\r\n    
										<label class=\"col-form-label\">											
											<textarea id=isi2 name=isi2 class=\"form-control\" cols=50 rows=20>";
											echo $d['ISI2'];
	echo"									</textarea>
											<br>Kata Kunci yang dapat digunakan:
											<br><b><ul><li>[IDCALONMAHASISWA] <br>\r\n      <li>[NAMACALONMAHASISWA] <br>\r\n      <li>[STATUSKELULUSAN] <br></ul>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
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
