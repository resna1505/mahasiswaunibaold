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
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_GET['sessid'] )
    {
        $errmesg = token_err_mesg( "Jadwal Kuliah", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM ruangan WHERE ID='{$idhapus}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Ruangan dengan Kode = '{$idhapus}' berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Ruangan dengan Kode = '{$idhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "";
}
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Ruangan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Kode Ruangan", $id, 10, false );
        $vld[] = cekvaliditasnama( "Nama Ruangan", $data['nama'], 40, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $id ) == "" )
        {
            $errmesg = "Kode Ruangan harus diisi";
        }
        else if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Ruangan harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tUPDATE ruangan SET \r\n\t\t\tID='{$id}',\r\n\t\t\tNAMA='{$data['nama']}',\r\n \t\t\tKET='{$data['ket']}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            buatlog( 1 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $idupdate = $id;
            }
            else
            {
                $errmesg = "Data Ruangan tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    $q = "SELECT * FROM ruangan WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #printjudulmenu( "Update Data Ruangan" );
        #printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Update Data Ruangan </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";							
		echo "					<div class='portlet-title'>";
								printmesg( $errmesg );
								printmesg("Update Data Ruangan");
								
		echo "					</div>";
		echo "  			<div class=\"m-portlet\">
								<!--begin::Form-->";
        echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<div class=\"m-portlet__body\">
								".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kode Ruangan *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $d[ID], " class=form-control m-input size=10 maxlength=10" )."
										</label>
									</div>"."
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama Ruangan *</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "data[nama]", $d[NAMA], " class=form-control m-input  size=40" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtextarea( "data[ket]", $d[KET], " class=form-control m-input cols=50 rows=3" )."
										</label>"."
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Update' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-secondary\">
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			
			<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>";
    }
    else
    {
        $errmesg = "Data Ruangan dengan Kode = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Ruangan", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Kode Ruangan", $id, 10, false );
        $vld[] = cekvaliditasnama( "Nama Ruangan", $data['nama'], 40, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else if ( trim( $id ) == "" )
        {
            $errmesg = "Kode Ruangan harus diisi";
        }
        else if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Ruangan harus diisi";
        }
        else
        {
            $q = "\r\n\t\t\tINSERT INTO ruangan (ID,NAMA,KET) \r\n\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['ket']}' )\r\n\t\t";
            mysqli_query($koneksi,$q);
            buatlog( 0 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Ruangan berhasil ditambah";
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Ruangan tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Tambah Data Ruangan" );
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Tambah Data Ruangan </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						";							
	echo "					<div class='portlet-title'>";
								printmesg( $errmesg );
								printmesg("Tambah Data Jadwal Kuliah");
								
	echo "					</div>";
	echo "  				<div class=\"m-portlet\">
								<!--begin::Form-->";
    echo "						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
									<div class=\"m-portlet__body\">
										".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Kode Ruangan *</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "id", $id, " class=form-control m-input  size=10 maxlength=10" )."
											</label>
										</div>"."
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Nama Ruangan *</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "data[nama]","", " class=form-control m-input  size=40" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtextarea( "data[ket]", "", " class=form-control m-input cols=50 rows=3" )."
											</label>
										</div>"."
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit value='Tambah' class=\"btn btn-brand\">
												<input type=reset value='Reset' class=\"btn btn-secondary\">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
                </div>
            
            <script>form.id.focus();</script>";
}
if ( $aksi == "" )
{
    include( "prosestampilruangan.php" );
}
?>
