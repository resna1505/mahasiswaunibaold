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
if ( $aksi2 == "Tes Kirim Email ke" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else
    {
        $q = "SELECT * FROM konfigsmtp WHERE ID='PMB'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $dmail[to] = $tesemail;
            $dmail[subject] = "Tes Kirim Email / SMTP - PMB";
            $dmail[body] = "Konfigurasi SMTP sudah benar.";
            $hasil = kirimemail_calonmahasiswa( $dmail );
            if ( $hasil == 1 )
            {
                $errmesg = "Tes pengiriman email ke {$tesemail} berhasil dilakukan. Konfigurasi sudah benar. Terima kasih";
            }
            else
            {
                $errmesg = "Tes pengiriman email ke {$tesemail} tidak berhasil dilakukan. Konfigurasi mungkin belum benar. Terima kasih<br>{$hasil}";
            }
        }
        else
        {
            $errmesg = "Maaf, onfigurasi tidak ada.";
        }
    }
    $aksi = "";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else
    {
        $q = "\r\n\r\n          REPLACE INTO   `konfigsmtp` (\r\n           ID,\r\n          `FROM` ,\r\n          `HOST` ,\r\n          `PORT` ,\r\n          `USERNAME` ,\r\n          `PASSWORD` ,\r\n          `UPDATER` ,\r\n          `TANGGALUPDATE`  \r\n          )\r\n          VALUES ( 'PMB',  '{$from}',  '{$host}',  '{$port}',  '{$username}',  '{$password}',  \r\n          '{$users}',  NOW() \r\n          )\r\n        \r\n        ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Konfigurasi Mail/SMTP berhasil disimpan";
        }
        else
        {
            $errmesg = "Konfigurasi Mail/SMTP tidak berhasil disimpan";
        }
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    #printjudulmenu( "Konfigurasi SMTP" );
    #printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM konfigsmtp WHERE ID='PMB'";
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
								printmesg("Konfigurasi SMTP");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							".createinputhidden( "sessid", $_SESSION['token'], "" )."
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Email Pengirim</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "from", $d[FROM], " class=form-control m-input" )."
										</label>
										<label class=\"col-form-label\">
										Alamat email yang akan digunakan untuk mengirim email pada pemrosesan PMB (misal untuk reset password PMB). Contoh: pmb@gmail.com
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Host</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "host", $d[HOST], " class=form-control m-input  size=50" )." Server SMTP. Contoh : ssl://smtp.gmail.com\r\n
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Port</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "port", $d[PORT], " class=form-control m-input  size=5" )." Port SMTP. Contoh 465 (ssl)
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">User name</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "username", $d[USERNAME], " class=form-control m-input  size=50" )." username SMTP contoh : pmb@gmail.com
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Password</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "password", $d[PASSWORD], " class=form-control m-input  size=50" )." Password Username SMTP
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\" onClick=\"return confirm('Simpan data konfigurasi Mail/SMTP?')\"> 
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<div class=\"col-lg-6\">	
											<label class=\"col-form-label\" style=padding-right:4.5px;>
											<input type=submit name=aksi2 value='Tes Kirim Email ke' class=\"btn btn-brand\">
											</label>
											<label class=\"col-form-label\" style=padding-right:4.5px;>
											<input type=text name=tesemail value='{$d['FROM']}' size=20 class=form-control m-input>
											</label>
										</div>
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
