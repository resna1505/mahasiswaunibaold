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
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "Urutan Calon Mahasiswa harus diisi";
    }
    else
    {
        if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Calon Mahasiswa harus diisi";
        }
	else if ( trim( $data[biaya] ) == "" || trim( $data[biaya] ) == "0")
        {
            $errmesg = "Biaya Masuk harus diisi";
        }

        else
        {
            if ( $notes == "" )
            {
                $tmp = explode( "/", $arraypilihanpmb2[$idpilihan] );
                foreach ( $tmp as $k => $v )
                {
                    if ( trim( $v ) == "TAHUN" )
                    {
                        $notes .= $tahuna;
                    }
                    else if ( trim( $v ) == "GEL" )
                    {
                        $notes .= $gelombang;
                    }
                    else if ( trim( $v ) == "PIL" )
                    {
                        $notes .= $idpilihan;
                    }
                    else if ( trim( $v ) == "URUT" )
                    {
                        $notes .= $id;
                    }
                }
            }
            $q = "\r\n\t\t\tUPDATE calonmahasiswa SET \r\n \t\t\tNAMA='".strtoupper( $data[nama] )."',\r\n\t\t\tID='{$id}',\r\n\t\t\tTAHUN='{$tahuna}',\r\n\t\t\tGELOMBANG='{$gelombang}',\r\n\t\t\tPILIHAN='{$idpilihan}',\r\n\t\t\tKUITANSI='{$data['kuitansi']}',\r\n\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\tTEMPATLAHIR='{$data['tempat']}',\r\n\t\t\tTANGGALLAHIR='{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n\t\t\tKELAMIN='{$data['kelamin']}',\r\n\t\t\tSTATUSNIKAH='{$data['statusnikah']}',\r\n\t\t\tAGAMA='{$data['agama']}',\r\n\t\t\tTELEPON='{$data['telepon']}',\r\n\t\t\tHP='{$data['hp']}',\r\n\t\t\tWN='{$data['wn']}',\r\n\t\t\tASALSMA='{$data['asal']}',\r\n      NOIJAZAH='{$noijazah}',\r\n      TANGGALIJAZAH='{$tglijazah['thn']}-{$tglijazah['bln']}-{$tglijazah['tgl']}',\r\n      NILAIUN='{$jumlahun}',\r\n      NILAIUNS='{$jumlahuns}',\r\n      NAMAAYAH='{$namaayah}',\r\n      NAMAIBU='{$namaibu}',\r\n      PEKERJAANORTU='{$pekerjaanortu}',\r\n      ALAMATORTU='{$data['alamatortu']}',\r\n      PRODI1='{$idprodi1}',\r\n      PRODI2='{$idprodi2}',\r\n      STATUSPRODI1='{$statusprodi1}',\r\n      STATUSPRODI2='{$statusprodi2}',\r\n      BIAYA='{$data['biaya']}',\r\n      NOTES='{$notes}',\r\n\r\n \t\t\t\tEMAIL='{$data['email']}' ,\r\n \t\t\tKOTA='{$data['kota']}',\r\n \t\t\tPROVINSI='{$data['provinsi']}',\r\n \t\t\t\tTAHUNLULUSSMA='{$data['tahunlulussma']}' ,\r\n \t\t\t\tPENDIDIKAN='{$data['pendidikan']}' ,\r\n      ALAMATIBU='{$data['alamatibu']}',\r\n      TELEPONAYAH='{$data['teleponayah']}',\r\n      TELEPONIBU='{$data['teleponibu']}',\r\n\r\n\r\n      TANGGALUPDATE=NOW(),\r\n      UPDATER\t='{$users}'\r\n \r\n\t\t\tWHERE ID='{$idupdate}' \r\n      AND TAHUN='{$tahunupdate}' \r\n      AND GELOMBANG='{$gelupdate}'\r\n      AND PILIHAN='{$pilihanupdate}'\r\n\t\t";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
				#$q = "\r\n\t\t\tUPDATE mahasiswa SET IDCALONMAHASISWA='{$id}',TANGGALUPDATE=NOW(),UPDATER\t='{$users}'\r\n \r\n\t\t\tWHERE ID='{$idupdate}' \r\n      AND TAHUN='{$tahunupdate}' \r\n      AND GELOMBANG='{$gelupdate}'\r\n      AND PILIHAN='{$pilihanupdate}'\r\n\t\t";
				#doquery($koneksi,$q);
            
                if ( $foto != "" )
                {
                    move_uploaded_file( $foto, "foto/{$idupdate}" );
                }
                if ( $ijazah != "" )
                {
                    move_uploaded_file( $ijazah, "ijazah/{$idupdate}" );
                }
                $errmesg = "Data Calon Mahasiswa berhasil diupdate";
                $idupdate = $id;
                $tahunupdate = $tahuna;
                $gelupdate = $gelombang;
                $pilihanupdate = $idpilihan;
                $ketlog = "Update Calon Mahasiswa. ID={$idupdate}";
                buatlog( 81 );
            }
            else
            {
                $errmesg = "Data Calon Mahasiswa tidak diupdate";
            }
        }
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
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
        if ( $d[NOTES] == "" )
        {
            $tmp = explode( "/", $arraypilihanpmb2[$idpilihan] );
            $notes = "";
            foreach ( $tmp as $k => $v )
            {
                if ( trim( $v ) == "TAHUN" )
                {
                    $notes .= $tahuna;
                }
                else if ( trim( $v ) == "GEL" )
                {
                    $notes .= $gelombang;
                }
                else if ( trim( $v ) == "PIL" )
                {
                    $notes .= $idpilihan;
                }
                else if ( trim( $v ) == "URUT" )
                {
                    $notes .= $id;
                }
            }
            $d[NOTES] = $notes;
        }
        #if ( file_exists( "foto/{$d['ID']}" ) )
		if ( file_exists( "../pmb.univbatam.ac.id/daftar/foto/{$d['ID']}" ) )
		
        {
            $fotosaatini = "\r\n\t \t\t\r\n\t \t\t<img src='../pmb.univbatam.ac.id/daftar/foto/{$d['ID']}' border=0 width=100><br>\r\n\t \t\t";
        }else{
	    $fotosaatini = "\r\n\t \t\t\r\n\t \t\t<img src='http://pendaftaran.univbatam.ac.id/registrasi/foto/{$d['ID']}' border=0 width=100><br>\r\n\t \t\t";
	
	}

        #if ( file_exists( "ijazah/{$d['ID']}" ) )
		if ( file_exists( "../pmb.univbatam.ac.id/daftar/ijazah/{$d['ID']}" ) )
        {
            $ijazahsaatini = "\r\n\t\t\t <img src='../pmb.univbatam.ac.id/daftar/ijazah/{$d['ID']}' border=0 width=200> \r\n\t\t\t<br>\r\n\t\t\t";
            $ijazahsaatini="<a target=_blank href='../pmb.univbatam.ac.id/daftar/ijazah/{$d['ID']}'  >lihat ijazah</a><br>";	
	}else{
	    $ijazahsaatini = "<a target=_blank href='http://pendaftaran.univbatam.ac.id/registrasi/ijazah/{$d['ID']}'  >lihat ijazah</a><br>";
	
	}

		/*echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>
			<table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "gelupdate", "{$gelupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."
		<tr class=judulform>\r\n\t\t\t<td>Tahun Daftar</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $d[TAHUN], " class=form-control m-input " )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang</td>";
        */
		echo "	<br>
					<div class=\"m-portlet\">
						<!--begin::Form-->";
		echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE=\"MULTIPART/FORM-DATA\">		
						".createinputhidden( "pilihan", $pilihan, "" ).
						createinputhidden( "aksi", "update", "" ).
						createinputhidden( "idupdate", "{$idupdate}", "" ).
						createinputhidden( "gelupdate", "{$gelupdate}", "" ).
						createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).
						createinputhidden( "pilihanupdate", "{$pilihanupdate}", "" ).
						createinputhidden( "tab", "{$tab}", "" )."
						<div class=\"m-portlet__body\">	
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Tahun Daftar</label>\r\n    
									<label class=\"col-form-label\">
									".createinputtahun( "tahuna", $d[TAHUN], " class=form-control m-input " )."
									</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
								<label class=\"col-form-label\">";
									if ( $gelombang == "" )
									{
										$gelombang = 1;
									}
									if ( $tahuna == "" )
									{
										$tahuna = $w[now];
									}
									if ( $idpilihan == "" )
									{
										$idpilihan = $arraypilihan[$initidpilihan];
									}
        echo "						".createinputtext( "gelombang", $d[GELOMBANG], " class=form-control m-input  size=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "idpilihan", $arraypilihanpmb, $d[PILIHAN], "", " class=form-control m-input" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">ID/No. Tes</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "id", $d[ID], " class=form-control m-input  maxlength=12 size=5" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Biaya Rp.</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[biaya]", $d[BIAYA], " class=form-control m-input  size=10" )."
								</label>
							</div>
							<!--<tr class=judulform>
								<td>Kuitansi</td>
								<td>".createinputtext( "data[kuitansi]", $d[KUITANSI], " class=form-control m-input  size=20" )."</td>\r\n\t\t
							</tr>\r\n\r\n\t\t-->
							<!--<tr class=judulform>
								<td>No. Tes</td>
								<td>".createinputtext( "notes", $d[NOTES], " class=form-control m-input  size=20" )."</td>
							</tr>
							<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n \t\t</tr>\r\n-->
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama Calon Mahasiswa *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama]", "{$d['NAMA']}", " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">KTP Calon Mahasiswa *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[ktp]", "{$d['KTP']}", " class=form-control m-input  size=50" )."
								</label>
							</div>
	
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Foto</label>\r\n    
								<label class=\"col-form-label\">
									{$fotosaatini}\r\n\t\t\t<input type=file name=foto class=form-control m-input>
								</label>
							</div>";
								if ( $d[UMUR] <= 15 )
								{
									$kelas = "style='background-color:#ffff00'";
								}
        echo "				<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[tempat]", $d[TEMPATLAHIR], " class=form-control m-input style=\"width:auto;display:inline-block;\" size=10" )." / ".createinputtanggal( "data", $d, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[kelamin]", $arraykelamin, $d[KELAMIN], "", " class=form-control m-input " )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Agama</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[agama]", $arrayagama, $d[AGAMA], "", " class=form-control m-input " )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Status Nikah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[statusnikah]", $arraystatusnikah, $d[STATUSNIKAH], "", " class=form-control m-input " )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]", "{$d['ALAMAT']}", " class=form-control m-input  cols=50 rows=4" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">No Telepon Rumah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[telepon]", $d[TELEPON], " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[hp]", $d[HP], " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[email]", $d[EMAIL], " class=form-control m-input  size=50" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kewarganegaraan</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[wn]", $arraywn, $d[WN], "", " class=form-control m-input " )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Asal Sekolah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[asal]", $d[ASALSMA], " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun Lulus</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[tahunlulussma]", $d[TAHUNLULUSSMA], " class=form-control m-input  size=4 maxlength=4" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">No. Ijazah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "noijazah", $d[NOIJAZAH], " class=form-control m-input size=20" )."</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtanggal( "tglijazah", $tglijazah, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">File Ijazah</label>\r\n    
								<label class=\"col-form-label\">
									{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=form-control m-input>
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Jumlah Nilai Ujian Nasional</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "jumlahun", $d[NILAIUN], " class=form-control m-input size=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jumlah Nilai Ujian Sekolah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "jumlahuns", $d[NILAIUNS], " class=form-control m-input size=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Pendidikan Terakkhir</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[pendidikan]", $d[PENDIDIKAN], " class=form-control m-input size=20" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Nama Ayah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "namaayah", $d[NAMAAYAH], " class=form-control m-input size=30" )."{$wajibdiisi}</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat Ayah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamatortu]", $d[ALAMATORTU], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">No. Kontak Ayah</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[teleponayah]", $d[TELEPONAYAH], " class=form-control m-input size=30" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama Ibu</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "namaibu", $d[NAMAIBU], " class=form-control m-input size=30" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Alamat Ibu</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamatibu]", $d[ALAMATIBU], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">No. Kontak Ibu</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[teleponibu]", $d[TELEPONIBU], " class=form-control m-input size=30" )."{$wajibdiisi}
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">";
									$arrayprodidep[0] = "-";
        #echo "\r\n    \r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 1</td>\r\n\t\t\t<td>".createinputselect( "idprodi1", $arrayprodidep, $d[PRODI1], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 2</td>\r\n\t\t\t<td>".createinputselect( "idprodi2", $arrayprodidep, $d[PRODI2], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n\t\t<!--\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Pilihan 1</td>\r\n\t\t\t<td>".createinputselect( "statusprodi1", $arraystatuslulus, $d[STATUSPRODI1], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Pilihan 2</td>\r\n\t\t\t<td>".createinputselect( "statusprodi2", $arraystatuslulus, $d[STATUSPRODI2], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    -->\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
		echo "						Pilihan Program Studi 1</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "idprodi1", $arrayprodidep, $d[PRODI1], "", " class=form-control m-input" )."</label>
							</div>
							<!--\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Pilihan 1</td>\r\n\t\t\t<td>".createinputselect( "statusprodi1", $arraystatuslulus, $d[STATUSPRODI1], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Pilihan 2</td>\r\n\t\t\t<td>".createinputselect( "statusprodi2", $arraystatuslulus, $d[STATUSPRODI2], "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    -->
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Update' class=\"btn blue\">
									<input type=reset value='Reset' class=\"btn default\">
								</div>
							</div>
						</div>
					</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
<script>form.id.focus();</script>";

	}
    else
    {
        $errmesg = "Data Calon Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
