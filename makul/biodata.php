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
    if ( 0 )
    {
        $errmesg = token_err_mesg( "Mata Kuliah", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodi );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $id );
        $vld[] = cekvaliditasnama( "Nama Makul", $data['nama'] );
        $vld[] = cekvaliditasinteger( "Semester", $data['semester'] );
        $vld[] = cekvaliditasinteger( "SKS", $data['sks'] );
        $vld[] = cekvaliditaskode( "Jenis", $data['jenis'], 1 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            cekhaktulis( $kodemenu );
            if ( trim( $id ) == "" )
            {
                $errmesg = "Kode Mata Kuliah harus diisi";
            }
            else if ( trim( $data[nama] ) == "" )
            {
                $errmesg = "Nama Mata Kuliah harus diisi";
            }
            else
            {
                $tidakbolehdihapus = 0;
                if ( $idupdate != $id )
                {
                    $q = "SELECT IDMAKUL FROM pengambilanmk WHERE IDMAKUL='{$idupdate}' LIMIT 0,1";
                    $h = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $tidakbolehdihapus = 1;
                    }
                    $q = "SELECT IDMAKUL FROM dosenpengajar WHERE IDMAKUL='{$idupdate}' LIMIT 0,1";
                    $h = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $tidakbolehdihapus = 1;
                    }
                }
                if ( $tidakbolehdihapus == 1 )
                {
                    $errmesg = "ID Mata Kuliah dengan ID {$idupdate} tidak boleh diubah menjadi {$id} karena ada data KRS dan Dosen Pengajar yang terkait.";
                }
                else
                {
                    $q = "\r\n\t\t\tUPDATE makul SET \r\n \t\t\tNAMA='{$data['nama']}',\r\n \t\t\tNAMA2='{$data['nama2']}',\r\n\t\t\tID='{$id}',\r\n\t\t\tKET='{$data['ket']}',\r\n\t\t\tSKS='{$data['sks']}',\r\n\t\t\tSEMESTER='{$data['semester']}',\r\n\t\t\tJENIS='{$data['jenis']}',\r\n\t\t\tKELOMPOK='{$data['kelompok']}',\r\n \t\t\tIDPRODI='{$idprodi}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
                    mysqli_query($koneksi,$q);
                    $ketlog = "Update Mata Kuliah dengan ID={$idupdate} ({$data['nama']})";
                    mysqli_error($koneksi);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Mata Kuliah berhasil diupdate";
                        if ( $idupdate != $id )
                        {
                            $q = "UPDATE tbkmk SET KDKMKTBKMK='{$id}' WHERE KDKMKTBKMK='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE dosenpengajar SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE pengambilanmk SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE nilai SET IDMAKUL='{$id}' WHERE IDMAKUL='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE trakd SET KDKMKTRAKD='{$id}' WHERE KDKMKTRAKD='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE trakm SET KDKMKTRAKM='{$id}' WHERE KDKMKTRAKM='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                            $q = "UPDATE trnlm SET KDKMKTRNLM='{$id}' WHERE KDKMKTRNLM='{$idupdate}'";
                            mysqli_query($koneksi,$q);
                        }
                        $idupdate = $id;
                        buatlog( 19 );
                    }
                    else
                    {
                        $errmesg = "Data Mata Kuliah tidak diupdate";
                    }
                }
            }
        }
    }
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT * FROM makul WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        

        echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
		<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form  action=index.php method=post>
		".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "sessid", "{$token}", "" )."
				
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "idprodi", $arrayprodidep, "{$d['IDPRODI']}", "", " class=form-control m-input" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah *</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "id", "{$d['ID']}", "readonly class=form-control m-input  size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah *</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[nama]", "{$d['NAMA']}", " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah Dalam Bahasa Inggris</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[nama2]", "{$d['NAMA2']}", " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "data[ket]", "{$d['KET']}", " class=form-control m-input  cols=50 rows=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[semester]", "{$d['SEMESTER']}", " class=form-control m-input size=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[sks]", "{$d['SKS']}", " class=form-control m-input size=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
				<div class=\"col-lg-6\">
					<select class=form-control m-input name=data[jenis]>\r\n\t\t\t\t\t\t";
						foreach ( $arrayjenismakul as $k => $v )
						{
							$cek = "";
							if ( $k == $d[JENIS] )
							{
								$cek = "selected";
							}
							echo "<option {$cek} value='{$k}'>{$v}</option>";
						}
echo "				</select>
				</div>
			</div>";
echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
						</div>
					</div>
				</form>
				<!--end::Form-->	
			</div>
			<!--end::Portlet-->			
			
		";
    }
    else
    {
        $errmesg = "Data Mata Kuliah dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
