<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        cekhaktulis( $kodemenu );
        $q = "SELECT COUNT(*) AS JML FROM prodi WHERE IDDEPARTEMEN='{$idhapus}'";
        $h = doquery($koneksi, $q );
        $d = sqlfetcharray( $h );
        if ( 0 < $d['JML'] )
        {
            $errmesg = "Data jurusan tidak dapat dihapus karena ada data Program Studi yang terkait di dalamnya.";
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM departemen WHERE ID='{$idhapus}'";
            doquery($koneksi, $q );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog(5);
                $errmesg = "Data Jurusan dengan ID = '{$idhapus}' berhasil dihapus";
                $q = "SELECT ID FROM prodi WHERE IDDEPARTEMEN='{$idhapus}'";
                $h = doquery($koneksi, $q );
                if ( 0 < sqlnumrows( $h ) )
                {
                    #do
					while ($d=sqlfetcharray($h)) 
                    {
                        if ( $d = sqlfetcharray( $h ) )
                        {
                            $q = "SELECT ID FROM makul WHERE IDPRODI='{$d['ID']}'";
                            $h2 = doquery($koneksi, $q );
                            if( 0 < sqlnumrows( $h2 ) ){
								while ($d2=sqlfetcharray($h2)) 
								{
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
                        } 
                    }
                    $q = "DELETE FROM makul WHERE IDPRODI='{$d['ID']}'";
                    doquery($koneksi, $q );
                    $q = "DELETE FROM mahasiswa WHERE IDPRODI='{$d['ID']}'";
                    doquery($koneksi, $q );
                }
                $q = "DELETE FROM prodi WHERE IDDEPARTEMEN='{$idhapus}'";
                doquery($koneksi, $q );
                $q = "DELETE FROM dosen WHERE IDDEPARTEMEN='{$idhapus}'";
                doquery($koneksi, $q );
            }
            else
            {
                $errmesg = "Data Jurusan dengan ID = '{$idhapus}' tidak berhasil dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Jurusan", HAPUS_DATA );
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $vld[] = cekvaliditaskode( "Nama Fakultas", $data['idfakultas'], 6, false );
        $vld[] = cekvaliditasinteger( "Kode Jurusan", $id, 8, false );
        $vld[] = cekvaliditasnama( "Nama Jurusan", $data['nama'], 64, false );
        $vld[] = cekvaliditaskode( "NIP Ketua Jurusan", $data['nippimpinan'], 20, false );
        $vld[] = cekvaliditasnama( "Nama Ketua", $data['namapimpinan'], 64, false );
        $vld[] = cekvaliditasnama( "Alamat Jurusan", $data['alamat'], 255, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            if ( isset( $invalid_data ) )
            {
                $errmesg = "Format data ".compile_message( $invalid_data )." tidak valid. Silahkan cek lagi data Anda.<br>Data Jurusan  tidak ditambah";
                unset( $invalid_data );
            }
            else
            {
                $q = "\r\n\t\t\t\tUPDATE departemen SET \r\n\t\t\t\tID='{$id}',\r\n\t\t\t\tNAMA='{$data['nama']}',\r\n\t\t\t\tNIPPIMPINAN='{$data['nippimpinan']}',\r\n\t\t\t\tNAMAPIMPINAN='{$data['namapimpinan']}',\r\n\t\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t\tIDFAKULTAS='{$data['idfakultas']}'\r\n\t\t\t\tWHERE ID='{$idupdate}'\r\n\t\t\t";
                doquery($koneksi, $q );
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    buatlog( 4 );
                    $q = "UPDATE prodi SET IDDEPARTEMEN='{$id}' WHERE IDDEPARTEMEN='{$idupdate}'";
                    doquery($koneksi, $q );
                    $errmesg = "Data Jurusan berhasil diupdate";
                    $idupdate = $id;
                }
                else
                {
                    $errmesg = "Data Jurusan tidak diupdate";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Jurusan", SIMPAN_DATA );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM departemen WHERE ID='{$idupdate}'";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {
       
        #printhelp( trim( $arrayhelp[updatejurusan] ), "bantuan" );
        #printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Update Data Jurusan");
								echo "	</div>";
	echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
					<div class=\"m-portlet__body\">		
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">{$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[idfakultas]", $arrayfakultas, $d['IDFAKULTAS'], "", " class=form-control m-input" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "id", $d['ID'], " class=form-control m-input size=10" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama]", $d['NAMA'], " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Ketua *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nippimpinan]", $d['NIPPIMPINAN'], " class=form-control m-input  size=30" )."
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Ketua *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[namapimpinan]", $d['NAMAPIMPINAN'], " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]", $d['ALAMAT'], " class=form-control m-input cols=50 rows=3" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
        $errmesg = "Data Jurusan dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        cekhaktulis( $kodemenu );
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $vld[] = cekvaliditaskode( "Nama Fakultas", $data['idfakultas'], 6, false );
        $vld[] = cekvaliditasinteger( "Kode Jurusan", $id, 8, false );
        $vld[] = cekvaliditasnama( "Nama Jurusan", $data['nama'], 64, false );
        $vld[] = cekvaliditaskode( "NIP Ketua Jurusan", $data['nippimpinan'], 20, false );
        $vld[] = cekvaliditasnama( "Nama Ketua", $data['namapimpinan'], 64, false );
        $vld[] = cekvaliditasnama( "Alamat Jurusan", $data['alamat'], 255, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        }
        else
        {
            $q = "\r\n\t\t\t\tINSERT INTO departemen (ID,NAMA,NIPPIMPINAN,NAMAPIMPINAN,ALAMAT,IDFAKULTAS) \r\n\t\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['nippimpinan']}',\r\n\t\t\t\t'{$data['namapimpinan']}','{$data['alamat']}','{$data['idfakultas']}')\r\n\t\t\t";
            doquery($koneksi, $q );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 3 );
                $errmesg = "Data Jurusan berhasil ditambah";
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Jurusan tidak berhasil ditambah";
            }
        }
    }
    else
    {
        $ermesg = token_err_mesg( "Jurusan", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Tambah Data Jurusan", "bantuan" );
    #printhelp( trim( $arrayhelp[tambahjurusan] ), "bantuan" );
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>{$JUDULFAKULTAS}</td>\r\n\t\t\t<td>".createinputselect( "data[idfakultas]", $arrayfakultas, "$key", "", " class=masukan" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Kode Jurusan *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan size=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Jurusan *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>NIP Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $data[nippimpinan], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $data[namapimpinan], " class=masukan size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Alamat Jurusan *</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";*/

     /*echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Tambah Data Jurusan");
										echo "</div>
										
									</div>
									<div class='portlet-body form'>
                            <form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>{$JUDULFAKULTAS}</td>\r\n\t\t\t<td>".createinputselect( "data[idfakultas]", $arrayfakultas, "\$key", "", " class=masukan" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Kode Jurusan *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan size=10" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Jurusan *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>NIP Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[nippimpinan]", $data[nippimpinan], " class=masukan  size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Nama Ketua *</td>\r\n\t\t\t<td>".createinputtext( "data[namapimpinan]", $data[namapimpinan], " class=masukan size=30" )."</td>"."<tr class=judulform>\r\n\t\t\t<td>Alamat Jurusan *</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=masukan cols=50 rows=3" )."</td>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>
							\t\t\t\t\t <input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
                                            <input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input> \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t</div></div></div></div></div></div></div>";
							*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printtitle("Tambah Data Jurusan");
								echo "	</div>";
								
	echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
					".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."
					<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">{$JUDULFAKULTAS} *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[idfakultas]", $arrayfakultas, "{$key}", "", " class=form-control m-input" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kode Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "id", $id, " class=form-control m-input size=10" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nama]", "", " class=form-control m-input  size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Ketua *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[nippimpinan]", "", " class=form-control m-input  size=30" )."
								</label>  
							</div>		
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Nama Ketua *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "data[namapimpinan]", "", " class=form-control m-input size=30" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Alamat Jurusan *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]", "", " class=form-control m-input cols=50 rows=3" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
if ( $aksi == "tampilkan" )
{
	#echo "masuk";exit();
    $aksi = " ";
    include( "prosestampildepartemen.php" );
}
if ( $aksi == "" )
{
   
    #printhelp( trim( $arrayhelp[carijurusan] ), "bantuan" );
    printmesg( $errmesg );
    

    echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class='portlet-title'>";
									printtitle("Cari Data Jurusan");
	echo "						</div>
								<div class='portlet-body form'>
									<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'><div class=\"portlet-body\">
									<div class=\"table-scrollable\">
										<table class=\"table table-striped2 table-bordered table-hover\"><tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\t{$JUDULFAKULTAS}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idfakultas>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayfakultas as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
											echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr><br>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table><br><br>\r\n\t\t</form>
											<script>\r\n \t\t\t\tform.submit.focus();\r\n\t\t\t</script>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>\r\n\t";
}
?>