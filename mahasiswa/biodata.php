<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );

if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
	#echo "kkk";exit();
	#print_r($data);exit();
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
		
        $errmesg = token_err_mesg( "Mahasiswa", SIMPAN_DATA );
    }
    else
    {
		#echo "mm";exit();
        unset( $_SESSION['token'] );
        $vldts[] = cekvaliditasinteger( "Jurusan/Program Studi", $idprodi, 32, false );
	$vldts[] = cekvaliditasemail( "E-mail", $data[email], 50, false );
	$vldts[] = cekvaliditasemail( "E-mail Pembayaran", $data[email2], 50, false );
        $vldts[] = cekvaliditastahun( "Angkatan", $tahuna, 4, false );
        $vldts[] = cekvaliditaskode( "Gelombang Masuk", $gelombang );
        $vldts[] = cekvaliditasinteger( "NIDN Dosen Wali", $iddosen );
        $vldts[] = cekvaliditaskode( "NIM", $id, 32, false );
        $vldts[] = cekvaliditasnama( "Nama", $data['nama'], 64, false );
        $vldts[] = cekvaliditasfile( "Foto", $_FILES['foto'], 0 );
        $vldts[] = cekvaliditasnama( "Tempat Lahir", $data['tempat'] );
        $vldts[] = cekvaliditastanggal( "Tanggal Lahir", $data['tgl'], $data['bln'], $data['thn'] );
        $vldts[] = cekvaliditaskode( "Kelamin", $data['kelamin'], 1 );
        $vldts[] = cekvaliditaskode( "Agama", $data['agama'], 1 );
        $vldts[] = cekvaliditastelp( "Telpon/HP", $data['telepon'] );
        $vldts[] = cekvaliditasnama( "Asal Sekolah", $data['asal'] );
        $vldts[] = cekvaliditasnama( "Nama Ayah", $namaayah );
        $vldts[] = cekvaliditastelp( "No Kontak Ayah", $noayah );
        $vldts[] = cekvaliditaskode( "Penghasilan Ayah/bulan", $penghasilanayah );
        $vldts[] = cekvaliditasnama( "Nama Ibu", $namaibu );
        $vldts[] = cekvaliditastelp( "No Kontak Ibu", $noibu );
        $vldts[] = cekvaliditaskode( "Penghasilan Ibu/bulan", $penghasilanibu );
        $vldts[] = cekvaliditaskode( "Kelas default", $data['kelas'] );
        $vldts[] = cekvaliditaskode( "Jenis Kelas default", $jeniskelas );
        $vldts[] = cekvaliditastanggal( "Tanggal Masuk", $dtm['tgl'], $dtm['bln'], $dtm['thn'] );
        $vldts[] = cekvaliditastanggal( "Tanggal Keluar/Lulus", $dtk['tgl'], $dtk['bln'], $dtk['thn'] );
        $vldts[] = cekvaliditaskode( "Status", $status, 1 );
        $vldts[] = cekvaliditaskode( "Kelas", $kodekelas, 1 );
        $vldts[] = cekvaliditasthnajaran( "Semester Awal terdaftar", $tahun, $semester );
        $vldts[] = cekvaliditasthnajaran( "Batas Studi", $tahun2, $semester2 );
        $vldts[] = cekvaliditaskode( "Kode propinsi", $kodeprop, 4 );
        $vldts[] = cekvaliditaskode( "Status Awal mahasiswa", $statusbaru, 1 );
        $vldts[] = cekvaliditasinteger( "Jumlah SKS diakui (Pindahan)", $sksbaru );
        $vldts[] = cekvaliditaskode( "NIM Asal (Pindahan)", $nimasal );
        $vldts[] = cekvaliditaskode( "Kode PT Asal (Pindahan)", $ptasal );
        $vldts[] = cekvaliditaskode( "Jenjang PT Asal(Pindahan)", $jasal, 1 );
        $vldts[] = cekvaliditaskode( "Kode Prodi Sebelumnya (Pindahan)", $psasal, 16 );
        $vldts[] = cekvaliditaskode( "Kode Biaya Studi (S3)", $kodebiaya, 1 );
        $vldts[] = cekvaliditaskode( "Kode Pekerjaan (S3)", $kodekerja, 1 );
        $vldts[] = cekvaliditasnama( "Nama Tempat Kerja (S3)", $tempatkerja );
        $vldts[] = cekvaliditasinteger( "Kode PT tempat Kerja (S3)", $ptkerja, 8 );
        $vldts[] = cekvaliditaskode( "Program Studi Tempat Kerja(S3)", $pskerja, 8 );
        $vldts[] = cekvaliditasinteger( "NIDN Promotor (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #1 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #2 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #3 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #4 (S3)", $nidnpro, 10 );
        $vldts = array_filter( $vldts, "filter_not_empty" );
        if ( isset( $vldts ) && 0 < count( $vldts ) )
        {
            $errmesg = val_err_mesg( $vldts, 2, SIMPAN_DATA );
            unset( $vldts );
        }
        else
        {
	    #$digitpertama=substr(trim($data['hp']),0,1);
		#echo "digit=".$digitpertama;exit();
			#echo "vvv";exit();
            cekhaktulis( $kodemenu );
            if ( trim( $id ) == "" )
            {
                $errmesg = "NIM Mahasiswa harus diisi";
            }
            else if ( trim( $data['nama'] ) == "" )
            {
                $errmesg = "Nama Mahasiswa harus diisi";
            }
	    else if ( trim( $data['no_ktp'] ) == "" )
            {
                $errmesg = "No KTP harus diisi";
            }
	    else if ( trim( $data['nisn'] ) == "" )
            {
                $errmesg = "NISN harus diisi";
            }
	
	    else if ( trim( $kecamatan ) == "" )
            {
                $errmesg = "Kecamatan harus diisi";
            }
	    else if ( trim( $data['KECAMATAN'] ) == "" )
            {
                $errmesg = "Kecamatan harus diisi";
            }
	    else if ( trim( $data['KELURAHAN'] ) == "" )
            {
                $errmesg = "Kelurahan harus diisi";
            }
	    elseif ( trim( $data[email] ) == "" )
	    {
		$errmesg .= "Email harus diisi<br>";
	    }
	    elseif ( trim( $data[email2] ) == "" )
	    {
		$errmesg .= "Email Pembayaran harus diisi<br>";
	    }	
	    else if ( substr(trim($data['hp']),0,1) != "0" )
            {
                $errmesg = "Digit Pertama No HP harus angka 0";
            }		
	    else if ( trim( $namaayah ) == "" )
            {
                $errmesg = "Nama Ayah harus diisi";
            }
            else if ( trim( $namaibu ) == "" )
            {
                $errmesg = "Nama Ibu harus diisi";
            }	
	    else if ( trim( $data[password] ) != "" && strlen(trim( $data[password] ))<6)
            {
		$errmesg = "Password Mahasiswa minimal 6 Karakter atau lebih";					
	    }	
	    else if ( trim( $data[password2] ) != "" && strlen(trim( $data[password2] ))<6)
            {
		$errmesg = "Password Orang Tua / Wali minimal 6 Karakter atau lebih";	
	    }		
	    else
            {
				#echo "LL";exit();
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                if ( $dtk[thn] + 0 == 0 )
                {
                    $tanggallulus = "NULL";
                }
                else
                {
                    $tanggallulus = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
                }
                $q = "\r\n      UPDATE msmhs\r\n      SET\r\n \r\n      KDPTIMSMHS ='{$kodept}',KDPSTMSMHS ='{$kodeps}',KDJENMSMHS='{$kodejenjang}',\r\n      NMMHSMSMHS='".strtoupper( $data[nama] )."',TPLHRMSMHS='{$data['tempat']}',\r\n      TGLHRMSMHS='{$data['thn']}-{$data['bln']}-{$data['tgl']}',KDJEKMSMHS='{$data['kelamin']}',\r\n      TAHUNMSMHS='{$tahuna}',SMAWLMSMHS='{$tahun}{$semester}',\r\n      BTSTUMSMHS='{$tahun2}{$semester2}',ASSMAMSMHS='{$kodeprop}',TGMSKMSMHS='{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}',\r\n      TGLLSMSMHS={$tanggallulus},\r\n      STMHSMSMHS='{$status}',STPIDMSMHS='{$statusbaru}',SKSDIMSMHS='{$sksbaru}',\r\n      ASNIMMSMHS='{$nimasal}',ASPTIMSMHS='{$ptasal}',ASJENMSMHS='{$jasal}',ASPSTMSMHS='{$psasal}',\r\n      BISTUMSMHS='{$kodebiaya}',PEKSBMSMHS='{$kodekerja}',NMPEKMSMHS='{$tempatkerja}',\r\n      PTPEKMSMHS='{$ptkerja}',PSPEKMSMHS='{$pskerja}',\r\n      NOPRMMSMHS='{$nidnpro}',NOKP1MSMHS='{$nidnpro1}',NOKP2MSMHS='{$nidnpro2}',\r\n      NOKP3MSMHS='{$nidnpro3}',NOKP4MSMHS='{$nidnpro4}',\r\n      SHIFTMSMHS='{$kodekelas}'\r\n      \r\n      WHERE NIMHSMSMHS = '{$idupdate}'\r\n     ";
                #echo $q;exit();
				doquery($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
                    buatlog( 13 );
                    $errmesg = "Data Mahasiswa berhasil diupdate";
                }
                $qpwd = "";
                if ( trim( $data[password] ) != "" )
                {
                    $qpwd .= "\r\n\t\t\tPASSWORD=PASSWORD('{$data['password']}'),\r\n\t\t\tFLAGPASSWORD=1,\r\n\t\t\t";
                }
                if ( trim( $data[password2] ) != "" )
                {
                    $qpwd .= "\r\n\t\t\tPASSWORD2=PASSWORD('{$data['password2']}'),\r\n\t\t\t";
                }
                if ( trim( $data[ipkuap] ) != "" )
                {
                    $qipkuap = "\r\n\t\t\t\t\tIPKUAP='{$data['ipkuap']}',\r\n\t\t\t\t\tLAMBANGUAP='{$data['lambanguap']}',\r\n\t\t\t\t";
                }
                if ( $tahunlulus + 0 != 0 )
                {
                    $tahunlulus = "'{$tahunlulus}'";
                }
                else
                {
                    $tahunlulus = "NULL";
                }
                $qlogout = "";
                if ( $iflogout == 1 )
                {
                    $qlogout = ", STATUSLOGIN=0 ";
                }
                if ( $iflogout2 == 1 )
                {
                    $qlogout = ", STATUSLOGIN2=0 ";
                }
                $q = "\r\n\t\t\tUPDATE mahasiswa SET \r\n \t\t\tNAMA='".strtoupper( $data[nama] )."',\r\n\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t{$qpwd}\r\n\t\t\tTEMPAT='{$data['tempat']}',\r\n\t\t\tTANGGAL='{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n\t\t\tKELAMIN='{$data['kelamin']}',\r\n\t\t\tAGAMA='{$data['agama']}',\r\n\t\t\tTELEPON='{$data['telepon']}',\r\n\t\t\tASAL='{$data['asal']}',\r\n\t\t\tSTATUS='{$status}',\r\n\t\t\tANGKATAN='{$tahuna}',\r\n\t\t\tTAHUNLULUS={$tahunlulus},\r\n\t\t\tIDDOSEN='{$iddosen}',\r\n\t\t\tTA='{$data['ta']}',\r\n\t\t\tTA2='{$data['ta2']}',\r\n\t\t\tDOSENTA='{$data['dosenta']}',\r\n\t\t\tKELAS='{$data['kelas']}',\r\n\t\t\tTANGGALMASUK='{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}',\r\n\t\t\tTANGGALKELUAR='{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n\t\t\t{$qipkuap}\r\n\t\t\tIDPRODI='{$idprodi}',\r\n\t\t\tNAMAAYAH='{$namaayah}',\r\n\t\t\tALAMATAYAH='{$alamatayah}',\r\n\t\t\tNOAYAH='{$noayah}',\r\n\t\t\tPENGHASILANAYAH='{$penghasilanayah}',\r\n\t\t\tNAMAIBU='{$namaibu}',\r\n\t\t\tALAMATIBU='{$alamatibu}',\r\n\t\t\tNOIBU='{$noibu}',\r\n\t\t\tPENGHASILANIBU='{$penghasilanibu}',\r\n\t\t\tGELOMBANG='{$gelombang}',\r\n\t\t\tJENISKELAS='{$jeniskelas}',\r\n\t\t\tSISTEMKRS='{$sistemkrs}',\r\n\t\t\tKELOMPOKKURIKULUM='{$kelompokkurikulum}',\r\n\t\t\t\r\n\t\t\t\r\n\t\t\tKOTA='{$data['kota']}',\r\n\t\t\tPROVINSI='{$data['provinsi']}',\r\n\t\t\tPENDIDIKAN='{$data['pendidikan']}',\r\n\t\t\tHP='{$data['hp']}',KTP='{$data['no_ktp']}',NISN='{$data['nisn']}',NIRM='{$nirm}',EMAIL='{$data['email']}',EMAIL2='{$data['email2']}',SKPINDAHAN='{$skpindahan}',\r\n\t\t\tTANGGALSKPINDAHAN='{$tanggalskpindahan['thn']}-{$tanggalskpindahan['bln']}-{$tanggalskpindahan['tgl']}',\r\n\t\t\tTANGGALKARTU='{$tanggalkartu['thn']}-{$tanggalkartu['bln']}-{$tanggalkartu['tgl']}'\r\n\t\t\t\r\n      {$qlogout}\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
				#echo $q.'<br>';
				doquery($koneksi,$q);
				
				$idcalmas = getfield( "IDCALONMAHASISWA", "mahasiswa", " WHERE ID='{$idupdate}'" );
                
				#$q_update_calon = "\r\n\t\t\tUPDATE calonmahasiswa SET ID='{$idcalonmahasiswa}',KTP='{$data['no_ktp']}', WHERE ID='{$idcalmas}'\r\n\t\t";
				$q_update_calon = "UPDATE calonmahasiswa SET ID='{$idcalonmahasiswa}',KELURAHAN='{$data['KELURAHAN']}',KECAMATAN='{$data['KECAMATAN']}',KTP='{$data['no_ktp']}',NISN='{$data['nisn']}',JASALMAMATER='{$data['baju']}' WHERE ID='{$idcalmas}'\r\n\t\t";
					#echo $q_update_calon.'<br>';
					mysqli_query($koneksi,$q_update_calon);
					
					$q_update_mahasiswalagi = "\r\n\t\t\tUPDATE mahasiswa SET IDCALONMAHASISWA='{$idcalonmahasiswa}',KELURAHAN='{$data['KELURAHAN']}',KECAMATAN='{$data['KECAMATAN']}',KTP='{$data['no_ktp']}',NISN='{$data['nisn']}',JASALMAMATER='{$data['baju']}' WHERE ID='{$idupdate}'\r\n\t\t";
					#echo $q_update_mahasiswalagi.'<br>';
					mysqli_query($koneksi,$q_update_mahasiswalagi);
					#exit();
					
				if ( 0 < sqlaffectedrows( $koneksi ) )
                {
					
                    $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
                    buatlog( 13 );
                    $errmesg = "Data Mahasiswa berhasil diupdate";
                    if ( !( $id === $idupdate ) )
                    {
                        $q = "UPDATE pengambilanmk SET IDMAHASISWA='{$id}' WHERE IDMAHASISWA='{$idupdate}'";
                        doquery($koneksi,$q);
                        $q = "UPDATE nilai SET IDMAHASISWA='{$id}' WHERE IDMAHASISWA='{$idupdate}'";
                        doquery($koneksi,$q);
                        $q = "UPDATE trakm SET NIMHSTRAKM='{$id}' WHERE NIMHSTRAKM='{$idupdate}'";
                        doquery($koneksi,$q);
                        $q = "UPDATE trnlm SET NIMHSTRAKM='{$id}' WHERE NIMHSTRNLM='{$idupdate}'";
                        doquery($koneksi,$q);
                        $q = "UPDATE trnlmsp SET NIMHSTRAKM='{$id}' WHERE NIMHSTRNLM='{$idupdate}'";
                        doquery($koneksi,$q);
                        $q = "UPDATE trskr SET NIMHSTRAKM='{$id}' WHERE NIMHSTRSKR='{$idupdate}'";
                        doquery($koneksi,$q);
                        if ( $file == "" )
                        {
                            if ( file_exists( "foto/{$idupdate}" ) )
                            {
                                rename( "foto/{$idupdate}", "foto/{$id}" );
                            }
                        }
                        else if ( $foto != "" )
                        {
                            move_uploaded_file( $foto, "foto/{$id}" );
                            if ( file_exists( "foto/{$idupdate}" ) )
                            {
                                unlink( "foto/{$idupdate}" );
                            }
                        }
                        #echo "Wooooiii:: ";
                        echo $idupdate = $id;
                    }
                    else if ( $foto != "" )
                    {
                        move_uploaded_file( $foto, "foto/{$idupdate}" );
                    }
                    $data[password] = $data[password2] = "";
                    #sinkronisasi_pusaka( $jenis = "UPDATE", $idupdate, 2 );
                }
                else if ( $foto != "" )
                {
					$errmesg = "Data Mahasiswa berhasil diupdate";
                    move_uploaded_file( $foto, "foto/{$idupdate}" );
                }
				
				$errmesg = "Data Mahasiswa berhasil diupdate";
            }
        }
    }
	#$errmesg=$errmesg;
}
if ( $aksi == "formupdate" )
{
	#echo "aaaa";
	#echo $errmesg;
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.*,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR ,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    #echo $q;
	$h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg($errmesg);
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALSKPINDAHAN] );
        $tanggalskpindahan[thn] = $tmp[0];
        $tanggalskpindahan[tgl] = $tmp[2];
        $tanggalskpindahan[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKARTU] );
        $tanggalkartu[thn] = $tmp[0];
        $tanggalkartu[tgl] = $tmp[2];
        $tanggalkartu[bln] = $tmp[1];

	if(empty($d['IDCALONMAHASISWA'])){

		//ambil data ktp dari table mahasiswa
		$sql_mahasiswa_lama="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER,NISN FROM mahasiswa WHERE ID='{$d[ID]}'";
        	$h_mahasiswa_lama = mysqli_query($koneksi,$sql_mahasiswa_lama);
		$d_mahasiswa_lama = sqlfetcharray( $h_mahasiswa_lama );
		$KTP=$d_mahasiswa_lama['KTP'];
		$NISN=$d_mahasiswa_lama['NISN'];
		$KELURAHAN=$d_mahasiswa_lama['KELURAHAN'];
        	$KECAMATAN=$d_mahasiswa_lama['KECAMATAN'];
		$JASALMAMATER=$d_mahasiswa_lama['JASALMAMATER'];

	
	}else{
		//ambil data ktp dari table calon mahasiswa
		$sql_calon_mahasiswa="SELECT KTP,KELURAHAN,KECAMATAN,JASALMAMATER,NISN FROM calonmahasiswa WHERE ID='{$d[IDCALONMAHASISWA]}'";
        	#echo $sql_calon_mahasiswa;
		$h_calon_mahasiswa = mysqli_query($koneksi,$sql_calon_mahasiswa);
		$d_calon_mahasiswa = sqlfetcharray( $h_calon_mahasiswa );
		$KTP=$d_calon_mahasiswa['KTP'];
		$NISN=$d_calon_mahasiswa['NISN'];
		$KELURAHAN=$d_calon_mahasiswa['KELURAHAN'];
        	$KECAMATAN=$d_calon_mahasiswa['KECAMATAN'];
		$JASALMAMATER=$d_calon_mahasiswa['JASALMAMATER'];
	}
	

        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
		
        echo "	<br>
					<div class=\"m-portlet\">
						<!--begin::Form-->";
		echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>								
							".createinputhidden( "pilihan", $pilihan, "" ).
							createinputhidden( "aksi", "update", "" ).
							createinputhidden( "sessid", $_SESSION['token'], "" ).
							createinputhidden( "idupdate", "{$idupdate}", "" ).
							createinputhidden( "tab", "{$tab}", "" )."
							<div class=\"m-portlet__body\">	
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<label class=\"col-form-label\">
											".createinputselect( "idprodi", $arrayprodidep, "{$d['IDPRODI']}", "", " class=form-control m-input" )."
										</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<label class=\"col-form-label\">
											".createinputtahun( "tahuna", "{$d['ANGKATAN']}", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Gelombang Masuk</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "gelombang", "{$d['GELOMBANG']}", " class=form-control m-input size=2 readonly" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$d['KELOMPOKKURIKULUM']}", "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "iddosen", "{$d['IDDOSEN']}", " class=form-control m-input  size=20" )."
										<!--<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.id.value)\" >daftar dosen</a>-->
										<br><b>".getfield( "NAMA", "dosen", "WHERE ID='{$d['IDDOSEN']}'" )."</b>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "id", "{$d['ID']}", " class=form-control m-input  maxlength=12 size=20 readonly" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">NIRM</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "nirm", "{$d['NIRM']}", " class=form-control m-input  size=20  " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Password</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[password]", $data[password], " class=form-control m-input  size=20" )."
										<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]\-->
										<br>Password tidak akan diubah jika tidak diisi
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Password Orang Tua/Wali</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[password2]", $data[password2], " class=form-control m-input  size=20" )."
										<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]-->
										<br>Password tidak akan diubah jika tidak diisi
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No KTP*</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[no_ktp]", $KTP, " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NISN*</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nisn]", $NISN, " class=form-control m-input  size=50" )."
									</label>
								</div>

								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nama]", "{$d['NAMA']}", " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Foto</label>\r\n    
									<label class=\"col-form-label\">
										{$fotosaatini}<input type=file name=foto class=form-control m-input>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[alamat]", "{$d['ALAMAT']}", " class=form-control m-input  cols=50 rows=4" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kelurahan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[KELURAHAN]", $KELURAHAN, " class=form-control m-input size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">	
									<label class=\"col-lg-2 col-form-label\">Kecamatan</label>
									<div class=\"col-lg-6\">
										".createinputtext( "kecamatan", $arraykecamatan{$KECAMATAN}, "class=form-control m-input  size=30 id='inputStringKecamatan' onkeyup=\"lookupKecamatan(this.value,'');\" \r\n\t" ).createinputhidden( "data[KECAMATAN]", $KECAMATAN, " class=masukan  size=20      id='inputStringDataKecamatan'" )."{$wajibdiisi} 
										<div class=\"suggestionsBox\" id=\"suggestionsKecamatan\" style=\"display: none;\">
											<div class=\"suggestionList\" id=\"autoSuggestionsListKecamatan\"></div>
										</div>
									</div>
								</div> 
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[kota]", $d[KOTA], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Provinsi</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[provinsi]", $d[PROVINSI], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>";       
									if ( $d[UMUR] <= 15 )
									{
										$kelas = "style='background-color:#ffff00'";
									}
        echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[tempat]", $d[TEMPAT], " class=form-control m-input  style=\"width:auto;display:inline-block;\" size=10" )." / ".createinputtanggal( "data", $d, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[kelamin]", $arraykelamin, $d[KELAMIN], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Agama</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[agama]", $arrayagama, $d[AGAMA], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No Telepon</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[telepon]", $d[TELEPON], " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[hp]", $d[HP], " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[email]", $d[EMAIL], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">E-mail Pembayaran</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[email2]", $d[EMAIL2], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Asal Sekolah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[asal]", $d[ASAL], " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Lulus</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "tahunlulus", "{$d['TAHUNLULUS']}", " class=form-control m-input size=4" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Pendidikan Terakkhir</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[pendidikan]", $d[PENDIDIKAN], " class=form-control m-input size=20" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">ID Calon Mahasiswa</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "idcalonmahasiswa", $d[IDCALONMAHASISWA], " maxlength=12 class=form-control m-input size=15" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Nama Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "namaayah", $d[NAMAAYAH], " class=form-control m-input size=40" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Alamat Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "alamatayah", $d[ALAMATAYAH], " cols=40 rows=5 class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">No. Kontak Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "noayah", $d[NOAYAH], " class=form-control m-input size=20" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Penghasilan Ayah per bulan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "penghasilanayah", $arraypenghasilan, $d[PENGHASILANAYAH], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Nama Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "namaibu", $d[NAMAIBU], " class=form-control m-input size=40" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Alamat Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "alamatibu", $d[ALAMATIBU], " cols=40 rows=5 class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">No. Kontak Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "noibu", $d[NOIBU], " class=form-control m-input size=20" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Penghasilan Ibu per bulan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "penghasilanibu", $arraypenghasilan, $d[PENGHASILANIBU], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Masa berlaku Kartu Mahasiswa</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "tanggalkartu", $tanggalkartu, "class=form-control m-input style=\"width:auto;display:inline-block;\"","" )."
									</label>
								</div>
								
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kelas Default Pengambilan Mata Kuliah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "" )."
									</label>
								</div> ";
        
		if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
        {
            echo "				<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
									<label class=\"col-form-label\">
										<select name='jeniskelas' >\r\n      ";
											foreach ( $arraykelasstei as $k => $v )
											{
												$selected = "";
												if ( $k == $d[JENISKELAS] )
												{
													$selected = "selected";
												}
												echo "<option value='{$k}' {$selected}>{$v}</option>";
											}
            echo "						</select>
									</label>
								</div>";
        }
        echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Masuk</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "dtm", $dtm, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Ukuran Baju Almamater</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[baju]", $arraybaju, "{$JASALMAMATER}", "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Keluar/Lulus</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggalblank( "dtk", $dtk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Status Kuliah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "status", $arraystatusmahasiswa, "{$d['STATUS']}", "", " class=form-control m-input " )."
									</label>
								</div>";
        /*if ( $UNIVERSITAS == "UNIKAL" )
        {
            echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Sistem KRS</td>\r\n\t\t\t<td>".createinputselect( "sistemkrs", $arraysistemkrs, $d[SISTEMKRS], "", " class=form-control m-input " )."</td>\r\n\t\t</tr> \r\n";
        }*/
        if ( $d[JENIS] == 1 )
        {
            echo "				<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">IP Ujian Akhir Praktek</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[ipkuap]", $d[IPKUAP], " class=form-control m-input  size=4" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Simbol Ujian Akhir Praktek</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[lambanguap]", $d[LAMBANGUAP], " class=form-control m-input  size=4" )."
									</label>
								</div>";
        }
        include( "mahasiswa2.php" );
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Judul Tugas Akhir/Skripsi</label>\r\n    
									<label class=\"col-form-label\">
										Bahasa Indonesia<br>".createinputtextarea( "data[ta]", $d[TA], " class=form-control m-input  cols=50 rows=4" )."
										<br><i>English</i><br>".createinputtextarea( "data[ta2]", $d[TA2], " class=form-control m-input  cols=50 rows=4" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[dosenta]", $d[DOSENTA], " class=form-control m-input  cols=50 rows=4" )."
									</label>
								</div>";
        echo "	<div class='portlet-title'>";
					printtitle("Status Login");
				echo "	</div>";
		/*echo "\t<tr>\r\n\t\t<td  colspan=2><hr size=1><b>Status Login Mahasiswa<hr size=1></td>\r\n\t</tr>\r\n  <tr>\r\n    <td>Status </td>\r\n    <td>".$arraystatuslogin[$d[STATUSLOGIN]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Login Terakhir</td>\r\n    <td>{$d['LASTLOGIN']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Aktifitas Terakhir </td>\r\n    <td>{$d['LASTAKSI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Logout Paksa</td>\r\n    <td><input type=checkbox value=1 name=iflogout > Ubah status login menjadi Logout/tidak login</td>\r\n  </tr>\r\n  \r\n  \r\n  ";
        echo "\t<tr>\r\n\t\t<td  colspan=2><hr size=1><b>Status Login Wali/Ortu<hr size=1></td>\r\n\t</tr>\r\n  <tr>\r\n    <td>Status </td>\r\n    <td>".$arraystatuslogin[$d[STATUSLOGIN2]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Login Terakhir</td>\r\n    <td>{$d['LASTLOGIN2']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Aktifitas Terakhir </td>\r\n    <td>{$d['LASTAKSI2']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Logout Paksa</td>\r\n    <td><input type=checkbox value=1 name=iflogout2 > Ubah status login menjadi Logout/tidak login</td>\r\n  </tr>\r\n  \r\n  \r\n  ";
        
		echo "\t\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit value='Update' class='btn btn-brand'>\r\n\t\t\t\t\t<input type=reset value='Reset' class=btn btn-secondary>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table></div></div></div></div>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
		*/
		echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
					<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraystatuslogin[$d[STATUSLOGIN]]."</label>
				</div>
				<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Waktu Login Terakhir</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['LASTLOGIN']}</label>
				</div>
				<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
					<label class=\"col-lg-2 col-form-label\">Waktu Aktifitas Terakhir</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['LASTAKSI']}</label>
				</div>
				<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Logout Paksa</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><input type=checkbox value=1 name=iflogout > Ubah status login menjadi Logout/tidak login</label>
				</div>
				<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=submit value='Update' class=\"btn btn-brand\"></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
						</div>
			</div>
		</form>
	<!--end::Form-->
</div>
<!--end::Portlet-->";
	}
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
