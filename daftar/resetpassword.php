<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
@cekuser( "" );
if ( $_POST['sessid'] == $_SESSION['token'] && $aksi2 == "Reset Password" && $REQUEST_METHOD == POST )
{
    $ok = true;
    if ( trim( $passlama ) == "" )
    {
        $ok = false;
        $errmesg = "Untuk alasan keamanan, Password login Anda harus diisi";
        buatlog( 5, $iduser );
    }
    else
    {
        #$q = "SELECT ID FROM user WHERE ID='{$users}' AND PASSWORD=PASSWORD('{$passlama}') AND (STATUS=1  OR ID='superadmin') ";
		$q = "SELECT ID FROM calonmahasiswa WHERE ID='{$idupdate}' AND GELOMBANG='{$gelupdate}' AND TAHUN='{$tahunupdate}' AND PILIHAN='{$pilihanupdate}'";
		#echo $q;exit();
        $h = doquery($koneksi,$q);
        //echo mysql_error( );
        if ( 0 < sqlnumrows( $h ) )
        {
            $q = "SELECT \r\n          \tcalonmahasiswa.* \r\n          \tFROM calonmahasiswa  WHERE \r\n          \tcalonmahasiswa.ID='{$idupdate}'\r\n          \tAND  TAHUN='{$tahunupdate}' AND GELOMBANG='{$gelupdate}' AND\r\n          \tPILIHAN='{$pilihanupdate}'\r\n          \t";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                #$passwordacak = substr( md5( uniqid( rand( ), TRUE ) ), 0, 8 );
				$passwordacak = $passlama;
                $dr = get_resetpassword( "PMB" );
                $dmail[subject] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", html_entity_decode( $dr[SUBJEK] ) );
                $dmail[subject] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[subject] );
                $dmail[subject] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[subject] );
                $dmail[body] = str_replace( "[IDCALONMAHASISWA]", "{$d['ID']}", html_entity_decode( $dr[ISI] ) );
                $dmail[body] = str_replace( "[NAMACALONMAHASISWA]", "{$d['NAMA']}", $dmail[body] );
                $dmail[body] = str_replace( "[PASSWORDBARU]", "{$passwordacak}", $dmail[body] );
                if ( $jenis == "email" )
                {
                    $query = "UPDATE calonmahasiswa SET STATUS='1',PASSWORD=MD5('{$passwordacak}')   ,COUNTERPASSWORD=COUNTERPASSWORD+1,\r\n               TANGGALUPDATE=NOW(),\r\n              UPDATER\t='{$users}'\r\n            \t\tWHERE ID='{$idupdate}' AND GELOMBANG='{$gelupdate}' AND TAHUN='{$tahunupdate}' AND PILIHAN='{$pilihanupdate}'  ";
                    doquery($koneksi, $query);
                    if ( sqlaffectedrows( $koneksi ) == 1 )
                    {
                        if ( $d[EMAIL] == "" )
                        {
                            $errmesg = "Password Calon Mahasiswa telah diganti dengan yang baru  tetapi gagal dikirim ke email/HP mahasiswa ybs karena alamat emailnya tidak ada. Terima kasih. <br> ";
                        }
                        else
                        {
                            $dmail[to] = $d[EMAIL];
                            $hasil = kirimemail_calonmahasiswa( $dmail );
                            $ketlog = "Reset Password Calon Mahasiswa - Email. ID={$idupdate}";
                            buatlog( 84 );
                            if ( $hasil == 1 )
                            {
                                $errmesg = "Password Calon Mahasiswa telah diganti dengan yang baru  dan dikirim ke email  mahasiswa ybs. Terima kasih";
                            }
                            else
                            {
                                $errmesg = "Password Calon Mahasiswa telah diganti dengan yang baru  tetapi gagal dikirim ke email  mahasiswa ybs. Terima kasih. <br> {$hasil}";
                            }
                        }
                    }
                    else
                    {
                        $errmesg = "Maaf. Password Calon Mahasiswa tidak berhasil diganti dengan yang baru. Terima kasih";
                    }
                }
                else
                {
                    if ( $jenis == "sms" )
                    {
                        #$q = "SELECT * FROM konfigsms LIMIT 0,1";
                        #$hx = doquery($koneksi,$q);
                        #if ( 0 < sqlnumrows( $hx ) )
                        #{
                            /*$dx = sqlfetcharray( $hx );
                            $headerSMS = strtoupper( trim( $dx[KODE] ) );
                            $url = trim( $dx[URL] );
                            $url = str_replace( basename( $url ), "prosessms_sikad.php", $url );
                            $postfields = "ID_PROGRAM=".urlencode( ID_PROGRAM );
                            $postfields .= "&TES=1";
                            $ch = curl_init( );
                            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
                            curl_setopt( $ch, CURLOPT_URL, $url."?".$postfields );
                            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                            $hasil = curl_exec( $ch );
                            if ( curl_errno( $ch ) )
                            {
                                $errorcurl = curl_error( $ch );
                            }
                            curl_close( $ch );*/
							   
                           # if ( $hasil == "1" )
                           # {
                                $query = "UPDATE calonmahasiswa SET PASSWORD=MD5('{$passwordacak}')   ,COUNTERPASSWORD=COUNTERPASSWORD+1,\r\n                  \r\n                  \r\n                        TANGGALUPDATE=NOW(),\r\n                        UPDATER\t='{$users}'\r\n                      \t\t\tWHERE ID='{$idupdate}' AND GELOMBANG='{$gelupdate}' AND TAHUN='{$tahunupdate}' AND PILIHAN='{$pilihanupdate}'  ";
                                doquery($koneksi,$query);
                                if ( 0 < sqlaffectedrows( $koneksi ) )
                                {
                                    $isisms = strip_tags( $dmail[body] );
                                    $dmail[to] = $d[HP];
								    $dmail[body] = str_replace( "&nbsp;", "", $dmail[body] );
								    /*$postfields = "ID_PROGRAM=".urlencode( ID_PROGRAM );
                                    $postfields .= "&TUJUAN=".urlencode( $dmail[to] );
                                    $postfields .= "&PESAN=".urlencode( strip_tags( $dmail[body] ) );
                                    $ch = curl_init( );
                                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                                    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
                                    curl_setopt( $ch, CURLOPT_URL, $url."?".$postfields );
                                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                                    $hasil = curl_exec( $ch );
                                    if ( curl_errno( $ch ) )
                                    {
                                        $errorcurl = curl_error( $ch );
                                        $hasilakhir = "0";
                                    }
                                    curl_close( $ch );*/
									$berhasil=0;
									$MSISDN=$d[hp];
									$TEXT=strip_tags( $dmail[body] );
									$panjangteks=strlen($TEXT);
									$jumlahsms=ceil($panjangteks/159);
									for ($ii=0;$ii<$jumlahsms;$ii++) {
									  $textkirim=substr($TEXT,$ii*159,159);
									  if ($ii==0) {
										$trxid="'$TRX_ID'";
									  } else {
										$trxid="NULL";
									  }
									  $idmasuk=-mt_rand(1,2147483647) ;
									  #$q=" INSERT INTO db_smsgateway.keluar 
										#  (no_tujuan,date_terkirim,date_dibuat,pesan_keluar,status,IDMASUK,BIAYA)  
										 # VALUES ('$MSISDN',NOW(),NOW(),'$textkirim','P','$idmasuk',0)  
										 $q=" INSERT INTO db_smsgateway.sentitems 
										  (UpdatedInDB,InsertIntoDB,date_terkirim,date_dibuat,pesan_keluar,status,IDMASUK,BIAYA)  
										 VALUES (NOW(),NOW(),'$MSISDN',NOW(),NOW(),'$textkirim','P','$idmasuk',0)  
									  ";
									 #echo $
									  $h=doquery($koneksi,$q);
									  //echo mysql_error();
									  $errmesg=$q.mysqli_error($koneksi);
									  if (sqlaffectedrows($koneksi)>0) {
										$berhasil++;
									  }  
									}
                                    $ketlog = "Reset Password Calon Mahasiswa - SMS. ID={$idupdate}";
                                    buatlog( 83 );
                                    #if ( $hasil == "1" )
									if ( $berhasil>0)
                                    {
                                        $errmesg = "Password Calon Mahasiswa telah diganti dengan yang baru dan sedang dikirim via SMS ke nomer HP ybs. Terima kasih.";
                                    }
                                    else
                                    {
                                        $errmesg = "Password Calon Mahasiswa telah diganti dengan yang baru tetapi tidak berhasil dikirim via SMS ke nomer HP ybs. Terima kasih. <br>{$hasil}";
                                    }
                                }
                                else
                                {
                                    $errmesg = "Error: Database.  ";
                                }
                            /*}
                            else
                            {
                                $errmesg = "Error: Program SMS Gateway Tidak Ada.  ";
                            }*/
                        /*}
                        else
                        {
                            $errmesg = "Error: Setting SMS Gateway Tidak Ada.  ";
                        }*/
                    }
                }
            }
        }
        else
        {
            $errmesg = "Maaf, autentikasi gagal.";
        }
        $passlama = "";
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT \r\n\tcalonmahasiswa.*,YEAR(NOW())-YEAR(calonmahasiswa.TANGGALLAHIR) AS UMUR \r\n\tFROM calonmahasiswa  WHERE \r\n\tcalonmahasiswa.ID='{$idupdate}'\r\n\tAND  TAHUN='{$tahunupdate}' AND GELOMBANG='{$gelupdate}' AND\r\n\tPILIHAN='{$pilihanupdate}'\r\n\t";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGALLAHIR] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALIJAZAH] );
        $tglijazah[thn] = $tmp[0];
        $tglijazah[tgl] = $tmp[2];
        $tglijazah[bln] = $tmp[1];
        /*echo "<form action=index.php method=post onSubmit=\"return confirm('Lakukan reset password calon mahasiswa? Password baru akan dikirim ke email/HP calon mahasiswa tersebut.');\">\r\n";
        echo IKONKUNCI48;
        echo "\r\n";*/
		echo "	<br>
					<div class=\"m-portlet\">
						<!--begin::Form-->";
		echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post onSubmit=\"return confirm('Lakukan reset password calon mahasiswa? Password baru akan dikirim ke email/HP calon mahasiswa tersebut.');\">";	
        echo 				createinputhidden( "sessid", $_SESSION['token'], "" )."
							<input type=hidden name=tab value='{$tab}'>
							<input type=hidden name=aksi value='{$aksi}'>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=idupdate value='{$idupdate}'>
							<input type=hidden name=tahunupdate value='{$tahunupdate}'>
							<input type=hidden name=gelupdate value='{$gelupdate}'>
							<input type=hidden name=pilihanupdate value='{$pilihanupdate}'>
							<div class=\"m-portlet__body\">	
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Daftar</label>\r\n    
									<label class=\"col-form-label\">
										{$d['TAHUN']} 
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
									<label class=\"col-form-label\">
										{$d['GELOMBANG']} 
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
									<label class=\"col-form-label\">
										".$arraypilihanpmb[$d[PILIHAN]]." 
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">ID</label>\r\n    
									<label class=\"col-form-label\">
										{$d['ID']} 
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Nama Lengkap</label>\r\n    
									<label class=\"col-form-label\">
										{$d['NAMA']} </label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
									<label class=\"col-form-label\">
										{$d['HP']}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
									<label class=\"col-form-label\">
										{$d['EMAIL']}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">
										Password baru dikirim via
									</label>
									<div class=\"col-lg-6\">
										<div class=\"m-radio-list\">
											<label class=\"m-radio\">
												<input type=radio name=jenis value=email checked> E-mail 
												<span></span>
											</label>
											
										</div>
									</div>
								</div>";
		echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">
										Password Login Anda
									</label>\r\n    
									<label class=\"col-form-label\">
										<input class=form-control m-input type=password name=passlama size=20  >
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input class=\"btn btn-brand\" type=submit name=aksi2 value='Reset Password'>
									</div>
								</div>
							</div>
						</form>
					</div>";
    }
}
echo "\r\n";
?>
