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
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = "Sesi login telah berubah. Silahkan ulangi proses update data alumni";
    }
    else
    {
        $vld[] = cekvaliditasnama( "Nama Perusahaan", $data['instansi'] );
        $vld[] = cekvaliditastelp( "Telpon perusahaan", $data['teleponinstansi'] );
        $vld[] = cekvaliditasnama( "Jabatan di Perusahaan", $data['jabatan'] );
        $vld[] = cekvaliditasthnbulan( "Bulan/Tahun Masuk", $data['thn'], $data['bln'] );
        $vld[] = cekvaliditaskode( "Status/Bentuk Perusahaan", $data['statusinstansi'] );
        $vld[] = cekvaliditasinteger( "Lama dapat pekerjaan", $data['tahunlama'], 2 );
        $vld[] = cekvaliditasthnbulan( "Lama dapat pekerjaan", 2000, $data['bulanlama'] );
        $vld[] = cekvaliditasnumerik( "Gaji Pertama", $data['gaji'] );
        $vld = array_unique( array_filter( $vld, "filter_not_empty" ) );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = "Data ".inv_message( $vld )." yang Anda berikan tidak valid.<br>Data tidak disimpan";
            unset( $vld );
        }
        else
        {
            cekhaktulis( $kodemenu );
            $qf = "";
            if ( is_array( $arraykerja ) )
            {
                $qf = "PROSESMASUKKERJA = '";
                foreach ( $arraykerja as $k => $v )
                {
                    $qf .= "{$k} ";
                }
                $qf .= "',";
            }
            $q = "\r\n\t\t\tUPDATE alumni SET \r\n \t\t\tINSTANSI='{$data['instansi']}',\r\n\t\t\tALAMATINSTANSI='{$data['alamatinstansi']}',\r\n\t\t\tTELEPONINSTANSI='{$data['teleponinstansi']}',\r\n\t\t\tTANGGALMASUKINSTANSI='{$data['thn']}-{$data['bln']}-01',\r\n\t\t\tJABATAN='{$data['jabatan']}',\r\n\t\t\tTAHUNLAMA='{$data['tahunlama']}',\r\n\t\t\tBULANLAMA='{$data['bulanlama']}',\r\n\t\t\tGAJI='{$data['gaji']}',\r\n\t\t\t{$qf}\r\n\t\t\tSTATUSINSTANSI='{$data['statusinstansi']}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
            mysqli_query($koneksi,$q);
            buatlog( 13 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Update Data Alumni dengan \r\n\t\t\t\t\tID ={$idupdate}  \r\n\t\t\t\t\t";
                buatlog( 43 );
                $errmesg = "Data Alumni berhasil diupdate";
            }
            else
            {
                $errmesg = "Data Alumni tidak diupdate";
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    $q = "SELECT ID FROM alumni WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO ALUMNI (ID) VALUES('{$idupdate}')";
        mysqli_query($koneksi,$q);
    }
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS,alumni.*\r\n\tFROM mahasiswa,prodi,alumni WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\tAND alumni.ID=mahasiswa.ID\r\n\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
       
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        $tmp = explode( "-", $d[TANGGALMASUKINSTANSI] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( " ", $d[PROSESMASUKKERJA] );
        if ( is_array( $tmp ) )
        {
            foreach ( $tmp as $k => $v )
            {
                $arraykerja[$v] = 1;
            }
        }

        /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">Update Data Alumni</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">";
		*/
		echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">							
								<!-- BEGIN SAMPLE FORM PORTLET-->
								<div class=\"portlet light\">";
									printmesg( $errmesg );
		echo "						<div class=\"portlet-body form\">
										<div class='tab-pane' id='tab_1'>
											<div class='portlet box blue'>
												<div class='portlet-title'>
													<div class='caption'>";
														printmesg("Update Data Alumni");
		echo "										</div>
												<div class=\"m-portlet\">				
													<!--begin::Form-->
													<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>
														<div class=\"portlet-body\">
															".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
																<label class=\"col-form-label\">
																	".$arrayprodidep[$d[IDPRODI]]."
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
																<label class=\"col-form-label\">
																	{$d['ANGKATAN']}
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Dosen Wali</label>\r\n    
																<label class=\"col-form-label\">
																	".$arraydosendep[$d[IDDOSEN]]."
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
																<label class=\"col-form-label\">
																	{$d['ID']}
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
																<label class=\"col-form-label\">
																	<b>{$d['NAMA']}</b>
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\"><b>Penempatan Kerja</b></label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Nama Perusahaan</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[instansi]", $d[INSTANSI], " class=form-control m-input  size=40" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Alamat Perusahaan</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtextarea( "data[alamatinstansi]", $d[ALAMATINSTANSI], " class=form-control m-input  cols=30 rows=4" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Telepon Perusahaan</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[teleponinstansi]", $d[TELEPONINSTANSI], " class=form-control m-input  size=30" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Jabatan di Perusahaan</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[jabatan]", $d[JABATAN], " class=form-control m-input  size=40" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Bulan/Tahun Masuk</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputbulantahun( "data", $d, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Status/bentuk Perusahaan</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[statusinstansi]", $d[STATUSINSTANSI], " class=form-control m-input  size=20" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\">Berapa lama<br>dapat pekerjaan<br>semenjak lulus</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[tahunlama]", $d[TAHUNLAMA], " class=form-control m-input style=\"width:auto;display:inline-block;\"  size=2" )." tahun ".createinputtext( "data[bulanlama]", $d[BULANLAMA], " class=form-control m-input style=\"width:auto;display:inline-block;\"  size=2" )." bulan
																</label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Gaji Pertama Rp.</label>\r\n    
																<label class=\"col-form-label\">
																	".createinputtext( "data[gaji]", $d[GAJI], " class=form-control m-input  size=10" )."
																</label>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
																<label class=\"col-lg-2 col-form-label\"><b>Proses Penempatan Kerja</b></label>
															</div>
															<div class=\"form-group m-form__group row\">
																<label class=\"col-lg-2 col-form-label\">Masuk kerja melalui</label>
																<div class=\"col-lg-6\">
																	<div class=\"m-checkbox-list\">";
																		foreach ( $arraymasukkerja as $k => $v )
																		{
																			$cek = "";
																			if ( $arraykerja[$k] == 1 )
																			{
																				$cek = "checked";
																			}
																echo "	<label class=\"m-checkbox\">
																			<input type=checkbox name=arraykerja[{$k}] value=1 {$cek}> {$v}
																			<span></span>
																		</label>";
																		}
        echo "														</div>
																</div>
															</div>
															<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
								</div>
								<script>form.id.focus();\r\n\t\t\t</script>";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
   
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>".createinputtahun( "tahun", $tahun, " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Wali *</td>\r\n\t\t\t<td>".createinputselect( "iddosen", $arraydosendep, $iddosen, "", " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=form-control m-input  size=20" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password *</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=form-control m-input  size=20" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Foto</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=file name=foto class=form-control m-input>\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", "Bandung", " class=form-control m-input  size=10" )." / ".createinputtanggal( "data", $data, " class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $data[kelamin], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".createinputselect( "data[agama]", $arrayagama, $data[agama], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $data[telepon], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>".createinputtext( "data[asal]", $data[asal], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>".createinputtahun( "tahunlulus", $tahunlulus, " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Masuk</td>\r\n\t\t\t<td>".createinputtanggal( "dtm", $dtm, " class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>".createinputtanggalblank( "dtk", $dtk, " class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Status</td>\r\n\t\t\t<td>".createinputselect( "status", $arraystatusmahasiswa, $status, "", " class=form-control m-input " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>".createinputtextarea( "data[ta]", $data[ta], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".createinputtextarea( "data[dosenta]", $data[dosenta], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table></div></div>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "" )
{
    #echo "lll";
    printmesg( $errmesg );
    #echo "\r\n\t\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";

    /*echo "<div class=\"page-content\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Lihat Data Alumni</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                            <form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    */
	  echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Lihat Data Alumni");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>
							<input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
	foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
								<div class=\"col-lg-6\">";
    $waktu = getdate( );
    echo "							<select name=angkatan class=form-control m-input>
										<option value=''>Semua</option>";
    $arrayangkatan = getarrayangkatan( "A" );
    foreach ( $arrayangkatan as $k => $v )
    {
        echo "							<option value='{$k}' {$cek}>{$v}</option>";
    }
    echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "id", $id, " class=form-control m-input size=20 id='inputStringListAlumni' onkeyup=\"lookupListAlumni(this.value,form.idprodi.value,form.angkatan.value);\" placeholder=\"Ketik NIM / Nama Alumni...\" " )."
									<!--<a href=\"javascript:daftaralumni('form,wewenang,id',document.form.id.value)\" >daftar alumni</a>-->
									<div class=\"suggestionsBox\" id=\"suggestionsAlumni\" style=\"display: none;\">
										<div class=\"suggestionsListALumni\" id=\"autoSuggestionsListAlumni\"></div>
									</div>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input size=50" )."</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
								<div class=\"col-lg-6\"><input type=submit value='Tampilkan' class=\"btn btn-brand\"></div>
							</div>
							</div>
				</form>
			</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->
		<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
