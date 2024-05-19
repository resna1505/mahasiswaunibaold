<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" ) //hapus fakultas
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] == $_GET['sessid'] )
    {
        $q = "SELECT COUNT(*) AS JML FROM departemen WHERE IDFAKULTAS='{$idhapus}'";
        $h = doquery($koneksi, $q );
        $d = sqlfetcharray( $h );
        if ( 0 < $d['JML'] )
        {
            $errmesg = "Data Fakultas tidak dapat dihapus karena ada data Jurusan yang terkait di dalamnya.";
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM fakultas WHERE ID='{$idhapus}'";
            doquery($koneksi, $q );
            buatlog( 2 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data {$JUDULFAKULTAS} dengan Kode = '{$idhapus}' berhasil dihapus";
                $q = "SELECT ID FROM departemen WHERE IDFAKULTAS='{$idhapus}'";
                $hx = doquery($koneksi, $q );
				if( 0 < sqlnumrows( $hx )){
					
						while ($dx = sqlfetcharray($hx))
						{
							$q = "SELECT ID FROM prodi WHERE IDDEPARTEMEN='{$dx['ID']}'";
							$h = doquery($koneksi, $q );
							if ( 0 < sqlnumrows( $h ) )
							{
								#do
								#{
									if ( !( $d = sqlfetcharray( $h ) ) )
									{
										break;
									}
									else
									{
										$q = "SELECT ID FROM makul WHERE IDPRODI='{$d['ID']}'";
										$h2 = doquery($koneksi, $q );
										if( 0 < sqlnumrows($h2)){
											
											while ($d2 = sqlfetcharray( $h2 ) ){
												
												$q = "DELETE FROM komponen WHERE IDMAKUL='{$d2['ID']}'";
												doquery($koneksi, $q );
												$q = "DELETE FROM konversi WHERE IDMAKUL='{$d2['ID']}'";
												doquery($koneksi, $q );
												$q = "DELETE FROM dosenpengajar WHERE IDMAKUL='{$d2['ID']}'";
												doquery($koneksi, $q );
												$q = "DELETE FROM nilai WHERE IDMAKUL='{$d2['ID']}'";
												doquery($koneksi, $q );
												$q = "DELETE FROM pengambilanmk WHERE IDMAKUL='{$d2['ID']}'";
												doquery($koneksi, $q );
											} 
										}
										
										$q = "DELETE FROM makul WHERE IDPRODI='{$d['ID']}'";
										doquery($koneksi, $q );
										$q = "DELETE FROM mahasiswa WHERE IDPRODI='{$d['ID']}'";
										doquery($koneksi, $q );
									}
								#} while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) );								
								
							}
							$q = "DELETE FROM prodi WHERE IDDEPARTEMEN='{$dx['ID']}'";
							doquery($koneksi, $q );
							$q = "DELETE FROM dosen WHERE IDDEPARTEMEN='{$dx['ID']}'";
							doquery($koneksi, $q );
						}
						$q = "DELETE FROM departemen WHERE IDFAKULTAS='{$idhapus}'";
						doquery($koneksi, $q );
						$q = "DELETE FROM msfak WHERE KDFAKMSFAK='{$idhapus}'";
						doquery($koneksi, $q );
				}
            }
            else
            {
                $errmesg = "Data {$JUDULFAKULTAS} dengan Kode = '{$idhapus}' tidak berhasil dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Fakultas", HAPUS_DATA );
    }
    $aksi = "";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST ) //update fakultas
{
    cekhaktulis( $kodemenu );
    if ( $POST['sessid'] != $_SESION['token'] )
    {
        $errmesg = token_err_mesg( "Fakultas", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasinteger( "Kode Fakultas", $id, 2, false );
        if ( !validasi_angka_int( $id, 2 ) )
        {
            $vld[] = cekvaliditasnama( "Nama Fakultas", $data['nama'], 64, false );
        }
        $vld[] = cekvaliditaskode( "NIP Pimpinan", $data['nippimpinan'], 20, false );
        $vld[] = cekvaliditasnama( "Nama Pimpinan", $data['namapimpinan'], 64, false );
        $vld[] = cekvaliditasnama( "Alamat Fakultas", $data['alamat'], 128, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
		
			$errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else
        {
            cekhaktulis( $kodemenu );
            $q = "SELECT KDPTIMSPTI FROM mspti LIMIT 0,1";
            $h = doquery($koneksi, $q );
            $d = sqlfetcharray( $h );
            $kodept = $d['KDPTIMSPTI'];
            $q = "SELECT * FROM msfak WHERE KDFAKMSFAK='{$idupdate}' AND KDPTIMSFAK='{$kodept}'";
            $h = doquery($koneksi, $q );
            if ( sqlnumrows( $h ) <= 0 )
            {
                $q = "INSERT INTO msfak (KDPTIMSFAK,KDFAKMSFAK,NMFAKMSFAK) \r\n\t\t\t\tVALUES ('{$kodept}','{$idupdate}','{$data['nama']}') ";
				echo $q.'<br>';
                doquery($koneksi, $q );
                $q = "SELECT * FROM msfak WHERE KDFAKMSFAK='{$idupdate}'";
				echo $q.'<br>';
                $h = doquery($koneksi, $q );
            }
            $q = "\r\n\t    \t\tUPDATE msfak \r\n\t\t\t\tSET NMFAKMSFAK='{$data['nama']}'\r\n\t\t\t\tWHERE\r\n\t\t\t\tKDPTIMSFAK='{$kodept}' AND \r\n\t\t\t\tKDFAKMSFAK='{$id}'\r\n\t    \t\t";
            #echo $q.'<br>';
			doquery($koneksi, $q );
            $isifile = $qupdatefile = "";
            if ( $filettd != "" )
            {
                $ext = strtolower( array_pop( explode( ".", $filettd_name ) ) );
                if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
                {
                    $isifile = addslashes( file_get_contents( $filettd ) );
                    $qupdatefile = ",FILE='{$isifile}'";
                }
            }
            if ( $hapusfilettd == 1 )
            {
                $qupdatefile = ",FILE=''";
            }
            $q = "\r\n\t\t\t\tUPDATE fakultas SET \r\n\t\t\t\tID='{$id}',\r\n\t\t\t\tNAMA='{$data['nama']}',\r\n\t\t\t\tNAMA2='{$data['nama2']}',\r\n\t\t\t\tNIPPIMPINAN='{$data['nippimpinan']}',\r\n\t\t\t\tNAMAPIMPINAN='{$data['namapimpinan']}',\r\n\t\t\t\tNIPPD1='{$data['nippd1']}',\r\n\t\t\t\tNAMAPD1='{$data['namapd1']}',\r\n\t\t\t\tALAMAT='{$data['alamat']}'\r\n\t\t\t\t{$qupdatefile}\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
            #echo $q.'<br>';
			doquery($koneksi, $q );
			
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 1 );
                $q = "UPDATE departemen SET IDFAKULTAS='{$id}' WHERE IDFAKULTAS='{$idupdate}'";
                doquery($koneksi, $q );
                $q = "UPDATE msfak SET KDFAKMSFAK ='{$id}' WHERE KDFAKMSFAK ='{$idupdate}'";
                doquery($koneksi, $q );
                $q = "UPDATE mspst SET KDFAKMSPST ='{$id}' WHERE KDFAKMSPST ='{$idupdate}'";
                doquery($koneksi, $q );
                $errmesg = "Data {$JUDULFAKULTAS} berhasil diupdate";
                $idupdate = $id;
            }
            else
            {
                $errmesg = "Data {$JUDULFAKULTAS} tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" ) //update fakultas
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM fakultas WHERE ID='{$idupdate}'";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {       
        $d = sqlfetcharray( $h );        
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Edit Data ".$JUDULFAKULTAS);
								echo "	</div>";
		echo "<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
					<div class=\"m-portlet__body\">		
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Kode {$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "id", $d[ID], " class=form-control m-input size=2 maxlength=2" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama {$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama]", $d[NAMA], " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama {$JUDULFAKULTAS} Dalam Bahasa Inggris</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama2]", $d[NAMA2], " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Dekan/Pimpinan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nippimpinan]", $d[NIPPIMPINAN], " class=form-control m-input  size=30" )."
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Dekan/Pimpinan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[namapimpinan]", $d[NAMAPIMPINAN], " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Pembantu Dekan/Pimpinan I </label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nippd1]", $d[NIPPD1], " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Pembantu Dekan/Pimpinan I</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[namapd1]", $d[NAMAPD1], " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat {$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]", $d[ALAMAT], " class=form-control m-input cols=50 rows=3" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">File Tandatangan (KHS)\r\n        </label>\r\n    
								<label class=\"col-form-label\">
									<input size=10  type=file name='filettd'  class=\"form-control-file\" >
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
							</div>
							
						</div>
						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
</div>
<!--end::page-content-->
	<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";		
	}
    else
    {
        $errmesg = "Data {$JUDULFAKULTAS} dengan Kode = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST ) //tambah data fakultas
{
	#echo "aaaa";exit();
	#print_r($_FILES); 
	#echo $filettd;exit();	
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditasinteger( "Kode Fakultas", $id, 2, false );
    $vld[] = cekvaliditasnama( "Nama Fakultas", $data['nama'], 64, false );
    $vld[] = cekvaliditaskode( "NIP Pimpinan", $data['nippimpinan'], 20, false );
    $vld[] = cekvaliditasnama( "Nama Pimpinan", $data['namapimpinan'], 64, false );
    $vld[] = cekvaliditasnama( "Alamat Fakultas", $data['alamat'], 128, false );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
		$errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        unset( $vld );
    }
    else
    {
		#echo "sini";exit();
               
        cekhaktulis( $kodemenu );
        $isifile = $qupdatefile = "";
        if ( $filettd != "" )
        {
            $ext = strtolower( array_pop( explode( ".", $filettd_name ) ) );
            if ( $ext == "jpg" || $ext == "jpeg" || $ext == "png" )
            {
                $isifile = addslashes( file_get_contents( $filettd ) );
                $qupdatefile = ",FILE='{$isifile}'";
            }
        }
        $q = "\r\n\t\t\t\tINSERT INTO fakultas (ID,NAMA,NIPPIMPINAN,NAMAPIMPINAN,ALAMAT,FILE,NAMA2) \r\n\t\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['nippimpinan']}','{$data['namapimpinan']}','{$data['alamat']}','{$isifile}','{$nama2}')\r\n\t\t\t";
		echo $q.'<br>';
		doquery($koneksi, $q );
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            buatlog(0);
            $q = "SELECT KDPTIMSPTI FROM mspti LIMIT 0,1";
            $h = doquery($koneksi, $q );
            $d = sqlfetcharray( $h );
            $kodept = $d['KDPTIMSPTI'];
            $q = "INSERT INTO msfak (KDPTIMSFAK,KDFAKMSFAK,NMFAKMSFAK) VALUES ('{$kodept}','{$id}','{$data['nama']}')\r\n\t\t    \t\t";
            doquery($koneksi, $q );
            $errmesg = "Data {$JUDULFAKULTAS} berhasil ditambah";
            $data = "";
            $id = "";
        }
        else
        {
			$errmesg = "Data {$JUDULFAKULTAS} tidak berhasil ditambah.<br>\r\n        Kode Fakultas sudah ada di basisdata. Silakan gunakan Kode yang lain.";
            #$errmesg = token_err_mesg("Fakultas", TAMBAH_DATA );
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
   
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Tambah Data ".$JUDULFAKULTAS);
								echo "	</div>";
										
	echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\" ENCTYPE='MULTIPART/FORM-DATA'>
					<div class=\"m-portlet__body\">		
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kode {$JUDULFAKULTAS} *</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "id", $id, " class=form-control m-input  size=2 maxlength=2" )."
									</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama {$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama]","", " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama {$JUDULFAKULTAS} Dalam Bahasa Inggris</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama2]","", " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Dekan/Pimpinan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nippimpinan]","", " class=form-control m-input  size=30" )."
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Dekan/Pimpinan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[namapimpinan]","", " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat {$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]","", " class=form-control m-input cols=30 rows=3" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">File Tandatangan (KHS)\r\n        </label>\r\n    
								<label class=\"col-form-label\">
									<input size=10  type=file name='filettd'  class=\"form-control-file\" >
								</label>
								<!--<div class=\"col-lg-4 col-md-9 col-sm-12\">
									<div class=\"m-dropzone dropzone\" action=\"#\" id=\"m-dropzone-one\">
										<div class=\"m-dropzone__msg dz-message needsclick\">
											<h3 class=\"m-dropzone__msg-title\">
												Drop files here or click to upload.
											</h3>
											
										</div>
									</div>
								</div>-->
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
							</div>
						</div>
						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
</div>
<!--end::page-content-->
<!--begin::Page Resources -->
	<!--<script src='".$root."tampilan/default/assets/demo/default/custom/crud/forms/widgets/dropzone.js' type='text/javascript'></script>-->
<!--end::Page Resources -->		
<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
				
}
if ( $aksi == "" )
{
    include( "prosestampilfakultas.php" );
}
?>
