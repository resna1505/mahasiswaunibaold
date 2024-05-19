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
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        if ( trim( $id ) == "" )
        {
            $errmesg = "NIDN Dosen harus diisi";
        }
        else
        {
            if ( trim( $data[nama] ) == "" )
            {
                $errmesg = "Nama Dosen harus diisi";
            }
            else
            {
                $valdata[] = cekvaliditasinteger( "Jurusan", $data[iddepartemen] );
                $valdata[] = cekvaliditaskode( "KTP", $ktp );
                $valdata[] = cekvaliditasinteger( "NIDN", $id, 32 );
                $valdata[] = cekvaliditaskode( "Singkatan Gelar Tertinggi", $gelar );
                $valdata[] = cekvaliditaskode( "NIP", $data[nippns], 20 );
                $valdata[] = cekvaliditasnama( "Nama", $data[nama] );
                $valdata[] = cekvaliditasnama( "Tempat Lahir", $data[tempat], 32, false );
                $valdata[] = cekvaliditastanggal( "Tanggal Lahir", $data[tgl], $data[bln], $data[thn] );
                $valdata[] = cekvaliditaskode( "Kode Kelamin", $data[kelamin], 2, false );
                $valdata[] = cekvaliditaskode( "Password", $data[password], 16 );
                $valdata[] = cekvaliditasinteger( "Instansi", $instansidosen );
                $valdata[] = cekvaliditaskode( "Akte Mengajar", $data[akte], 2 );
                $valdata[] = cekvaliditaskode( "Izin Mengajar", $data[izin], 2 );
                $valdata[] = cekvaliditaskode( "Status Kerja", $data[statuskerja], 2 );
                $valdata[] = cekvaliditasinteger( "Mulai Semester", $semester2, 5 );
                $valdata[] = cekvaliditasinteger( "Semester Awal Mengajar", $semesterawal, 5 );
                $valdata = array_filter( $valdata, "filter_not_empty" );
                if ( isset( $valdata ) && 0 < count( $valdata ) )
                {
                    $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
                    unset( $valdata );
                }
                else
                {
                    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$data['iddepartemen']}'";
                    $h = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $d = sqlfetcharray( $h );
                        $kodept = $d[KDPTIMSPST];
                        $kodejenjang = $d[KDJENMSPST];
                        $kodeps = $d[KDPSTMSPST];
                    }
                    $qlogout = "";
                    if ( $iflogout == 1 )
                    {
                        $qlogout = ", STATUSLOGIN=0 ";
                    }
                    $q = "UPDATE msdos SET\r\n \r\n\t\t\t      KDPTIMSDOS='{$kodept}',KDPSTMSDOS='{$kodeps}',KDJENMSDOS='{$kodejenjang}',NOKTPMSDOS='{$ktp}',\r\n\t\t\t      NODOSMSDOS='{$id}',NMDOSMSDOS='{$data['nama']}',GELARMSDOS='{$gelar}',TPLHRMSDOS='{$data['tempat']}',\r\n\t\t\t      \r\n\t\t\t      TGLHRMSDOS='{$data['thn']}-{$data['bln']}-{$data['tgl']}',KDJEKMSDOS='{$data['kelamin']}',\r\n\t\t\t      KDJANMSDOS='{$jabatan}',KDPDAMSDOS='{$pendidikan}',\r\n\t\t\t      KDSTAMSDOS='{$data['status']}',STDOSMSDOS='{$data['statuskerja']}', \r\n\t\t\t      NIPNSMSDOS='{$data['nippns']}',PTINDMSDOS='{$instansidosen}'  ,\r\n\t\t\t      STKATMSDOS='{$data['akte']}',SRTIJMSDOS='{$data['izin']}',\r\n\t\t\t      MLSEMMSDOS='{$semester2}',NIDNNMSDOS='{$id}',\r\n            SMAWLMSDOS='{$semesterawal}'\r\n\t\t\t      WHERE NODOSMSDOS='{$idupdate}'";
                    doquery($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Update data dosen dengan ID={$idupdate} dan Nama={$data['nama']}";
                        buatlog( 10 );
                        $errmesg = "Data Dosen berhasil diupdate";
                    }
                    if ( trim( $data[password] ) != "" )
                    {
                        $qpwd = "PASSWORD=MD5('{$data['password']}'),\r\n\t\t\t\tFLAGPASSWORD=1,";
                    }
                    $q = "\r\n\t\t\t\tUPDATE dosen SET \r\n\t \t\t\tNAMA='{$data['nama']}',\r\n\t\t\t\tID='{$id}',\r\n\t\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t\t{$qpwd}\r\n\t\t\t\tSTATUS='{$data['status']}',\r\n\t\t\t\tNIPPNS='{$data['nippns']}',\r\n\t\t\t\tINSTANSI='{$instansidosen}',\r\n\t\t\t\tAKTE='{$data['akte']}',\r\n\t\t\t\tIZIN='{$data['izin']}',\r\n\t\t\t\tSTATUSKERJA='{$data['statuskerja']}',\r\n\t\t\t\tIDDEPARTEMEN='{$data['iddepartemen']}',\r\n\t\t\t\tJABATAN='{$data['jabatan']}',\r\n\t\t\t\tSESUAIBIDANG='{$sesuaibidang}'\r\n\t\t\t      {$qlogout}\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
                    doquery($koneksi,$q);
                    $ketlog = "Update data dosen dengan ID={$idupdate} dan Nama={$data['nama']}";
                    buatlog( 10 );
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "";
                        if ( !( $id === $idupdate ) )
                        {
                            $q = "UPDATE dosenpengajar SET IDDOSEN='{$id}' WHERE IDDOSEN='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE riwayatpendidikandosen SET IDDOSEN='{$id}' WHERE IDDOSEN='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE msdos SET NODOSMSDOS='{$id}' WHERE NODOSMSDOS='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE mspds SET NODOSMSPDS='{$id}' WHERE NODOSMSPDS='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE trakd SET NODOSTRAKD='{$id}' WHERE NODOSTRAKD='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE trlsd SET NODOSTRLSD='{$id}' WHERE NODOSTRLSD='{$idupdate}'";
                            doquery($koneksi,$q);
                            $q = "UPDATE trpud SET NODOSTRPUD='{$id}' WHERE NODOSTRPUD='{$idupdate}'";
                            doquery($koneksi,$q);
                        }
                        $errmesg .= "Data Dosen berhasil diupdate <br>";
                        $idupdate = $id;
                        if ( $issinkron == 1 )
                        {
                            $q = "SELECT * FROM tbdos WHERE NIDNNTBDOS = '{$idupdate}'";
                            $htbdos = doquery($koneksi,$q);
                            if ( 0 < sqlnumrows( $htbdos ) )
                            {
                                $dtbdos = sqlfetcharray( $htbdos );
                                $q = "UPDATE dosen SET\r\n              NAMA ='{$dtbdos['NMDOSTBDOS']}',\r\n               STATUS ='{$dtbdos['KDSTATBDOS']}',\r\n               NIPPNS ='{$dtbdos['NIPPPTBDOS']}',\r\n              INSTANSI ='{$dtbdos['PTINDTBDOS']}'\r\n               WHERE ID = '{$idupdate}'";
                                doquery($koneksi,$q);
                                $q = "UPDATE msdos SET\r\n              NMDOSMSDOS ='{$dtbdos['NMDOSTBDOS']}',\r\n              NOKTPMSDOS = '{$dtbdos['NOKTPTBDOS']}',\r\n              TPLHRMSDOS ='{$dtbdos['TPLHRTBDOS']}',\r\n              TGLHRMSDOS ='{$dtbdos['TGLHRTBDOS']}',\r\n              KDJEKMSDOS ='{$dtbdos['KDJEKTBDOS']}',\r\n              KDJANMSDOS ='{$dtbdos['KDJANTBDOS']}',\r\n              KDPDAMSDOS ='{$dtbdos['KDPDATBDOS']}',\r\n              KDSTAMSDOS ='{$dtbdos['KDSTATBDOS']}',\r\n              STDOSMSDOS ='{$dtbdos['STDOSTBDOS']}',\r\n              PTINDMSDOS ='{$dtbdos['PTINDTBDOS']}',\r\n              KDJENMSDOS ='{$dtbdos['KDJENTBDOS']}',\r\n              KDPSTMSDOS ='{$dtbdos['KDPSTTBDOS']}',\r\n              NIPNSMSDOS ='{$dtbdos['NIPPPTBDOS']}'\r\n              WHERE NODOSMSDOS = '{$idupdate}'";
                                doquery($koneksi,$q);
                                $errmesg .= "Data dosen telah disinkron-kan dengan TBDOS<br>";
                            }
                            else
                            {
                                $errmesg .= "Data dosen tidak ditemukan di TBDOS<br>";
                            }
                        }
                        #sinkronisasi_pusaka( $jenis = "UPDATE", $idupdate, 1 );
                        $data = "";
                    }
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Biodata Dosen", SIMPAN_DATA );
    }
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM dosen WHERE ID='{$idupdate}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $jabatanakademik = $d[JABATAN];
        unset( $dtbdos );
        $q = "SELECT * FROM tbdos WHERE NIDNNTBDOS = '{$idupdate}'";
        $htbdos = doquery($koneksi,$q);
        if ( 0 < sqlnumrows( $htbdos ) )
        {
            $dtbdos = sqlfetcharray( $htbdos );
        }
        /*echo "<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[iddepartemen]", $arrayprodidep, $d[IDDEPARTEMEN], "", " class=form-control m-input" )."</td>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen *</td>\r\n\t\t\t<td>".createinputtext( "id", $d[ID], " class=form-control m-input  size=20 maxlength=10" )."\r\n  \t\t\t<a href=\"javascript:daftardos('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n      \r\n      </td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=form-control m-input  size=20" )."[<a target=_blank href='../passwordacak.php'>buat password acak</a>]\r\n\t\t\t<br>Password tidak akan diubah jika tidak diisi\r\n\t\t\t</td>\r\n\t\t</tr> ";
        */
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	
					".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\">".createinputselect( "data[iddepartemen]", $arrayprodidep, $d[IDDEPARTEMEN], "", " class=form-control m-input" )."</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen *</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtext( "id", $d[ID], " class=form-control m-input  size=20 maxlength=10 id='inputStringListDosenNidn' onkeyup=\"lookupListDosenNidn(this.value);\"" )."
								<!--<a href=\"javascript:daftardos('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >daftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n-->  
								<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn\" style=\"display: none;\">
										<div class=\"suggestionsListDosenNidn\" id=\"autoSuggestionsListDosenNidn\"></div>
									</div>	
									Data otomatis muncul saat anda ketik di kotak, kemudian pilih nama yang sesuai
								</div>
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Password</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputpassword( "data[password]", $data[password], " class=form-control m-input  size=20" )."Maksimal 16 karakter<br>
								<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]-->
								Password tidak akan diubah jika tidak diisi
							</div>
						</div>";
		$styletr = "";
        if ( $d[NAMA] != $dtbdos[NMDOSTBDOS] )
        {
            $styletr = "style='background-color:#FFFF00;'";
        }
        #echo "\r\n \t\t<tr {$styletr} class=judulform>\r\n\t\t\t<td>Nama Dosen *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $d[NAMA], " class=form-control m-input  size=30" )." \r\n       TBDOS : <b>{$dtbdos['NMDOSTBDOS']} </b>\r\n      \r\n      <br>Nama tanpa gelar, titel, tanpa titik, sebaiknya huruf Kapital\r\n      \r\n      </td>\r\n\t\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $d[ALAMAT], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr> \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Akte Mengajar</td>\r\n\t\t\t<td>".createinputselect( "data[akte]", $arrayya, $d[AKTE], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Izin Mengajar</td>\r\n\t\t\t<td>".createinputselect( "data[izin]", $arrayya, $d[IZIN], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>";
        echo "<div class=\"form-group m-form__group row\" {$styletr}>
				<label class=\"col-lg-2 col-form-label\">Nama Dosen *</label>\r\n    
					<div class=\"col-lg-6\">".createinputtext( "data[nama]", $d[NAMA], " class=form-control m-input  size=30" )." \r\n       TBDOS : <b>{$dtbdos['NMDOSTBDOS']} </b>\r\n      \r\n      <br>Nama tanpa gelar, titel, tanpa titik, sebaiknya huruf Kapital </div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
					<div class=\"col-lg-6\">".createinputtextarea( "data[alamat]", $d[ALAMAT], " class=form-control m-input  cols=50 rows=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Akte Mengajar</label>\r\n    
					<div class=\"col-lg-6\">".createinputselect( "data[akte]", $arrayya, $d[AKTE], "", " class=form-control m-input" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Izin Mengajar</label>\r\n    
					<div class=\"col-lg-6\">".createinputselect( "data[izin]", $arrayya, $d[IZIN], "", " class=form-control m-input" )."</div>
			</div>";
        
		$styletr = "";
        if ( $d[STATUSKERJA] != $dtbdos[STDOSTBDOS] )
        {
            $styletr = "style='background-color:#FFFF00;'";
        }
        #echo "\r\n <tr {$styletr}>\r\n\t\t\t<td>Status Dosen</td>\r\n\t\t\t<td> ".createinputselect( "data[statuskerja]", $arraystatuskerjadosen, $d[STATUSKERJA], "", " class=form-control m-input" )."\r\n       TBDOS : <b>{$dtbdos['STDOSTBDOS']}-".$arraystatuskerjadosen[$dtbdos[STDOSTBDOS]]." </b>\r\n      \r\n      </td> \t\t\t\r\n\t\t</tr>\r\n\r\n\r\n    <tr>\r\n      <td>Bidang Keahlian sesuai dengan  Program Studi</td>\r\n      <td>\r\n          ".createinputselect( "sesuaibidang", $arraysesuaibidangdosen, $d[SESUAIBIDANG], "", "", "" )."\r\n      </td>\r\n    </tr>    \r\n    \r\n    \r\n    ";
    echo "	<div class=\"form-group m-form__group row\" {$styletr}>
				<label class=\"col-lg-2 col-form-label\">Status Dosen</label>\r\n    
					<div class=\"col-lg-6\"> ".createinputselect( "data[statuskerja]", $arraystatuskerjadosen, $d[STATUSKERJA], "", " class=form-control m-input" )."\r\n       TBDOS : <b>{$dtbdos['STDOSTBDOS']}-".$arraystatuskerjadosen[$dtbdos[STDOSTBDOS]]." </b></div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Bidang Keahlian sesuai dengan  Program Studi</label>\r\n    
					<div class=\"col-lg-6\">".createinputselect( "sesuaibidang", $arraysesuaibidangdosen, $d[SESUAIBIDANG], "", "class=form-control m-input", "" )."</div>
			</div>";
        
		include( "dosen2.php" );
        #echo "\t<tr>\r\n\t\t<td  colspan=2><hr size=1><b>Status Login<hr size=1></td>\r\n\t</tr>\r\n  <tr>\r\n    <td>Status </td>\r\n    <td>".$arraystatuslogin[$d[STATUSLOGIN]]."</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Login Terakhir</td>\r\n    <td>{$d['LASTLOGIN']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Waktu Aktifitas Terakhir </td>\r\n    <td>{$d['LASTAKSI']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td>Logout Paksa</td>\r\n    <td><input type=checkbox value=1 name=iflogout > Ubah status login menjadi Logout/tidak login</td>\r\n  </tr>\r\n  \r\n  \r\n  ";
        #echo "\r\n\r\n\t\t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit value='Update' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t\t<input type=checkbox name=issinkron value=1> Sinkronisasi Data dengan TBDOS\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t</div></div></div></div></div></div></div>";
		echo "	<div class='portlet-title'>";
					printmesg("Status Login");
				echo "	</div>";
		echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arraystatuslogin[$d[STATUSLOGIN]]."</label>
				</div>
				<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Waktu Login Terakhir</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['LASTLOGIN']}</label>
				</div>
				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
					<label class=\"col-lg-2 col-form-label\">Waktu Aktifitas Terakhir</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$d['LASTAKSI']}</label>
				</div>
				<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Logout Paksa</label>\r\n    
					<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><input type=checkbox value=1 name=iflogout > Ubah status login menjadi Logout/tidak login</label>
				</div>
				<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
        $errmesg = "Data Dosen dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
