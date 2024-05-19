<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$waktu = getdate( time( ) );
$ok = false;
if ( $aksi2 == "Update" && $REQUEST_METHOD == "POST" )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pengumuman", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Judul", $judulp, 256, false );
        $vld[] = cekvaliditasfile( "File Gambar", $_FILES['filelogo'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $judulp ) == "" )
        {
            $errmesg = "Judul Pengumuman harus diisi";
        }
        else if ( trim( $ket ) == "" )
        {
            $errmesg = "Isi Pengumuman harus diisi";
        }
        else
        {
            $query = "UPDATE pengumuman SET \r\n\t\t\tRINCIAN='{$ket}', \r\n\t\t\tIDUSER='{$users}',\t\t\r\n\t\t\tJUDUL='{$judulp}' \r\n\t\t\tWHERE ID='{$idpengumuman}' AND LOKASI='{$lokasipengumuman}'";
            $hasil = doquery($koneksi, $query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Update data pengumuman    berhasil dilakukan.";
            }
            else
            {
                $errmesg = "Update data pengumuman    tidak dilakukan.";
            }
            if ( $filelogo != "none" )
            {
                if ( isset( $WINDIR ) )
                {
                    $filelogo = str_replace( "\\\\", "\\", $filelogo );
                }
                $namafile = basename( $filelogo_name );
                if ( ( eregi_sikad( "\\.jpg\$", $filelogo_name ) || eregi_sikad( "\\.jpeg\$", $filelogo_name ) || eregi_sikad( "\\.png\$", $filelogo_name ) ) && 0 < $filelogo_size )
                {
                    if ( file_exists( "gambar/{$idpengumuman}".".txt" ) )
                    {
                        $logo = file( "gambar/{$idpengumuman}".".txt" );
                        $namafilelama = $logo[0];
                        @unlink( @"gambar/{$namafilelama}" );
                    }
                    $f = fopen( "gambar/{$idpengumuman}".".txt", "w" );
                    fwrite( $f, $namafile, strlen( $namafile ) );
                    fclose( $f );
                    @move_uploaded_file( @$filelogo, @"gambar/".@$namafile );
                    $errmesg .= "<br>Update data gambar pengumuman  berhasil dilakukan.";
                }
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi2 == "Hapus" && $REQUEST_METHOD == "POST" )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pengumuman", HAPUS_DATA );
    }
    else
    {
        $query = "DELETE FROM pengumuman WHERE ID='{$idpengumuman}' AND LOKASI='{$lokasipengumuman}'";
        $hasil = doquery($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Penghapusan data pengumuman    berhasil dilakukan.";
            if ( file_exists( "gambar/{$idpengumuman}".".txt" ) )
            {
                $logo = file( "gambar/{$idpengumuman}".".txt" );
                $namafilelama = $logo[0];
                @unlink( @"gambar/{$namafilelama}" );
                @unlink( @"gambar/{$idpengumuman}".".txt" );
            }
        }
        else
        {
            $errmesg = "Penghapusan data pengumuman    gagal dilakukan.";
        }
        $aksi = "tampilkan";
    }
}
else if ( $aksi == "Tambah" && $REQUEST_METHOD == "POST" )
{
    cekhaktulis( $kodemenu );
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pengumuman", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Judul", $judulp, 256, false );
        $vld[] = cekvaliditasfile( "File Gambar", $_FILES['filelogo'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            unset( $vld );
        }
        else if ( trim( $judulp ) == "" )
        {
            $errmesg = "Judul Pengumuman harus diisi";
        }
        else if ( trim( $ket ) == "" )
        {
            $errmesg = "Isi Pengumuman harus diisi";
        }
        else
        {
            $q = "SELECT MAX(ID)+1 AS IDB FROM pengumuman WHERE LOKASI='{$idlokasikantor}'";
            $h = doquery($koneksi, $q);
            $d = mysqli_fetch_array( $h );
            $id = $d['IDB'];
            if ( $id == "" )
            {
                $id = 0;
            }
            $pengumuman = $id;
            $query = "INSERT INTO pengumuman (ID,TANGGALMULAI,TANGGALSELESAI,JUDUL,RINCIAN,LOKASI,IDUSER) VALUES('$pengumuman','{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}','{$judulp}','{$ket}','{$idlokasikantor}','{$users}')";
            #echo $query;exit();
			$hasil = doquery($koneksi, $query);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                if ( $filelogo != "none" )
                {
                    if ( isset( $WINDIR ) )
                    {
                        $filelogo = str_replace( "\\\\", "\\", $filelogo );
                    }
                    $namafile = basename( $filelogo_name );
                    if ( ( eregi_sikad( "\\.jpg\$", $filelogo_name ) || eregi_sikad( "\\.jepg\$", $filelogo_name ) || eregi_sikad( "\\.png\$", $filelogo_name ) ) && 0 < $filelogo_size )
                    {
                        $f = fopen( "gambar/{$pengumuman}".".txt", "w" );
                        fwrite( $f, $namafile, strlen( $namafile ) );
                        fclose( $f );
                        @move_uploaded_file( @$filelogo, @"gambar/".@$namafile );
                    }
                }
                $errmesg = "Penambahan data pengumuman berhasil dilakukan.";
                $judulp = $ket = "";
            }
            else
            {
                $errmesg = "Penambahan data pengumuman gagal dilakukan.";
            }
        }
    }
    $aksi = "tampilawal";
}
if ( $aksi == "tampilkan" )
{
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    $query = "SELECT ID,TANGGALMULAI,TANGGALSELESAI, JUDUL, RINCIAN,LOKASI FROM pengumuman WHERE MONTH(TANGGALMULAI)='{$blndari}' AND YEAR(TANGGALMULAI) = '{$thndari}' ORDER BY TANGGALMULAI DESC";
    #echo $query;
    $hasil = doquery($koneksi,$query);
    if ( 0 < mysqli_num_rows( $hasil ) )
    {
       echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printmesg("Data Pengumuman");
	$i = 0;
        settype( $i, "integer" );
        while ( $datauser = mysqli_fetch_array( $hasil ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "class=datagenap";
            }
            else
            {
                $kelas = "class=dataganjil";
            }
            $ket = $datauser['RINCIAN'];
            $judulp = $datauser['JUDUL'];
            $tanggal = $datauser['TANGGALMULAI'];
            $pengumuman = $datauser['ID'];
            $lokasipengumuman = $datauser['LOKASI'];
            $filelogo = "tidak ada";
            if ( file_exists( "gambar/".$datauser['ID'].".txt" ) )
            {
                $logo = file( "gambar/".$datauser['ID'].".txt" );
                $filelogo = $logo[0];
                $size = imgsizeprop( "gambar/{$filelogo}", 80 );
                $img = "<br><img height={$size['1']} width={$size['0']} src='gambar/{$filelogo}'>";
                $filelogo = "({$filelogo})";
            }
            ++$i;
            /*echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<form ENCTYPE='MULTIPART/FORM-DATA' action=index.php?pilihan=lihat&aksi=tampilkan method=post>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\r\n\t\t\t\t\t\t\t\t<input type=hidden name=aksi value={$aksi}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=blndari value={$blndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=sessid value={$token}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=thndari value={$thndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=pilihan value='lihat'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=idpengumuman value='{$pengumuman}'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=lokasipengumuman value='{$lokasipengumuman}'>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center width=15%>\r\n\t\t\t\t\t\t\t\t{$tanggal}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\tJudul: <BR><input type=text class=form-control m-input name=judulp value='{$judulp}' size=40 maxlength=50><br>\r\n\t\t\t\t\t\t\t\tIsi: ";
            echo " <br><textarea name=ket class=mce cols=45 rows=20>{$ket}</textarea>\r\n\t\t\t\t\t\t\t\t<br> Lokasi: ".$arraylokasi[$lokasipengumuman]."\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center nowrap>";
            */
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th scope=\"col\">No</th>
															<th>Tanggal</th>
															<th>Judul</th>
															<th>Isi</th>
															<th>Lokasi</th>
															<th>Aksi</th>";															
			echo "<!--begin::Form-->
                        <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
							<input type=hidden name=aksi value={$aksi}>
							<input type=hidden name=blndari value={$blndari}>
							<input type=hidden name=sessid value={$token}>
							<input type=hidden name=thndari value={$thndari}>
							<input type=hidden name=pilihan value='lihat'>
							<input type=hidden name=idpengumuman value='{$pengumuman}'>
							<input type=hidden name=lokasipengumuman value='{$lokasipengumuman}'>";
			echo "			<tr align=center {$kelas}{$aksi}>
								<td align=center>{$i}</td>
								<td align=center>{$tanggal}</td>
								<td width=30%><input type=text class=form-control m-input name=judulp value='{$judulp}' size=40 maxlength=50></td>";
			echo " 				<td><textarea id=ket name=ket rows=10>{$ket}</textarea></td>
								<td>".$arraylokasi[$lokasipengumuman]."</td>\r\n\t\t\t\t\t\t\t<td align=center nowrap>";            
			if ( $tingkataksesusers[$kodemenu] == "T" )
            {
            echo "	<input type=submit name=aksi2 value='Update' class=\"btn btn-brand\">
					<input type=submit name=aksi2 value='Hapus' class=\"btn btn-secondary\" onclick=\"return confirm('Hapus pengumuman dengan tanggal = {$tanggal}');\">";
            }
            echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
            $img = "";
            $filelogo = "";
        }
        #echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t</center>\r\n\t\t\t\t\t<br>\r\n\t\t\t\t";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
        $errmesg = "Daftar pengumuman bulan ".$arraybulan[$blndari - 1]." {$thndari} tidak ada.";
        $aksi = "";
    }
}
if ( $aksi == "caripengumuman" )
{
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Cari Pengumuman");
								echo "	</div>";
						echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->";
    echo "	<form name=formisian class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php?pilihan=edit&aksi=tampilkan method=post>
				<input type=hidden name=pilihan value=edit>
				<input type=hidden name=aksi value=\"tampilkan\">
				<div class=\"m-portlet__body\">		
					<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
						<label class=\"col-lg-2 col-form-label\">Bulan dan Tahun Pengumuman</label>\r\n    
						<div class=\"col-lg-6\">";
    echo "					<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=blndari>\r\n\t\t\t\t\t\t\t\t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( $i == $waktu[mon] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>".$arraybulan[$i - 1]."</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t\t";
    echo "<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=thndari>\r\n\t\t\t\t\t\t\t\t\t";
    $i = $tahuninstal - 5;
    while ( $i <= $waktu[year] )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "<option value={$i} {$cek}>{$i}</option>";
        $cek = "";
        ++$i;
    }
    echo "\t\t\t\t\t\t\t\t</select>
						</div>
					</div>
					<div class=\"form-group m-form__group row\">
						<label class=\"col-lg-2 col-form-label\">
							<input class=\"btn btn-brand\" type=submit value='Cari'>
							<input class=\"btn btn-secondary\" type=reset value=Reset>
						</label>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
	</div>
	</div>";
}
if ( $aksi == "tampilawal" )
{
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Tambah Data Pengumuman" );
    /*printmesg( $errmesg );
    echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Tambah Data Pengumuman </span>
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
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Tambah Data Pengumuman");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form ENCTYPE=\"MULTIPART/FORM-DATA\" action=index.php?pilihan=tambah method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=aksi value=\"Tambah\">
								<input type=hidden name=sessid value='$token'>";
    echo "						<input type=hidden name=pilihan value=\"tambah\">
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Judul</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input type=text size=40 maxlength=50 name=judulp value='$judulp'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Isi Pengumuman</label>\r\n    
										<label class=\"col-form-label\">
											<textarea id=ket name=ket class=\"form-control\" cols=50 rows=15>";
												echo $ket;
    #echo "</textarea>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tFile gambar (jpg/png)\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input type=file class=form-control m-input name=filelogo size=50>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td ></td><td>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=submit value='  Tambah  '>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</";
    echo "									</textarea>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Mulai</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "mulai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Selesai</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "selesai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input class=\"btn btn-brand\" type=submit value='Tambah'>
											<input class=\"btn btn-secondary\" type=reset value=Reset>
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
if ( $aksi == "" )
{
	$arrayangkatan = getarrayangkatan( "K", $addnumber );
	print_r($arrayangkatan);

	#echo "lll";exit();
    /*$token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
	#$bln_jalan=date('m');
	#$bln_jalan=date('Y');
    $query = "SELECT ID,TANGGAL, JUDUL, RINCIAN,LOKASI FROM pengumuman WHERE MONTH(TANGGAL)=MONTH(NOW()) AND YEAR(TANGGAL) = YEAR(NOW()) ORDER BY TANGGAL DESC";
    #echo $query;
	$hasil =mysqli_query($koneksi,$query);
    #echo sqlnumrows($hasil);
	if ( 0 < sqlnumrows( $hasil ) )
    {
      
        #printmesg( "<br>Bulan ".$arraybulan[$blndari - 1]." {$thndari}" );
        printmesg( $errmesg );
		if($jenisusers==0){
		
			echo "\r\n\t\t\t\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Pengumuman </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\"><div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t\t\t<td width=10>\r\n\t\t\t\t\t\t\t\tNo\r\n\t\t\t\t\t\t\t</td>\r\n\r\n\t\t\t\t\t\t\t<td width=10%>\r\n\t\t\t\t\t\t\t\tTanggal\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tGambar/Isi Pengumuman\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\tAksi\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t";
        
		}else{
	
			echo "<table class=data><tr align=center class=juduldata><td width=10>No</td><td width=10%>Tanggal</td><td>Gambar/Isi Pengumuman</td></tr>";
    
		}
		$i = 0;
        settype( $i, "integer" );
        while ( $datauser = sqlfetcharray( $hasil ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "class=datagenap";
            }
            else
            {
                $kelas = "class=dataganjil";
            }
            $ket = $datauser[RINCIAN];
            $judulp = $datauser[JUDUL];
            $tanggal = $datauser[TANGGAL];
            $pengumuman = $datauser[ID];
            $lokasipengumuman = $datauser[LOKASI];
            $filelogo = "tidak ada";
            if ( file_exists( "gambar/".$datauser[ID].".txt" ) )
            {
                $logo = file( "gambar/".$datauser[ID].".txt" );
                $filelogo = $logo[0];
                $size = imgsizeprop( "gambar/{$filelogo}", 80 );
                $img = "<br><img height={$size['1']} width={$size['0']} src='gambar/{$filelogo}'>";
                $filelogo = "({$filelogo})";
            }
            ++$i;
			#echo $jenisusers;
            if($jenisusers==0){
				echo "\r\n\t\t\t\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t\t\t\t<form ENCTYPE='MULTIPART/FORM-DATA' action=index.php?pilihan=lihat&aksi=tampilkan method=post>\r\n\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t{$i}\r\n\r\n\t\t\t\t\t\t\t\t<input type=hidden name=aksi value={$aksi}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=blndari value={$blndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=sessid value={$token}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=thndari value={$thndari}>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=pilihan value='lihat'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=idpengumuman value='{$pengumuman}'>\r\n\t\t\t\t\t\t\t\t<input type=hidden name=lokasipengumuman value='{$lokasipengumuman}'>\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center width=15%>\r\n\t\t\t\t\t\t\t\t{$tanggal}\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\tJudul: <BR><input type=text class=form-control m-input name=judulp value='{$judulp}' size=40 maxlength=50><br>\r\n\t\t\t\t\t\t\t\tIsi: ";
				echo " <br><textarea name=ket class=mce cols=45 rows=20>{$ket}</textarea>\r\n\t\t\t\t\t\t\t\t<br> Lokasi: ".$arraylokasi[$lokasipengumuman]."\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center nowrap>";
				if ( $tingkataksesusers[$kodemenu] == "T" )
				{
					echo "\r\n\t\t\t\t\t\t\t\t<input type=submit name=aksi2 value='Update' class=\"btn blue\" tombol>\r\n\t\t\t\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=\"btn red\"tombol onclick=\"return confirm('Hapus pengumuman dengan tanggal = {$tanggal}');\">\r\n\t\t\t\t\t\t\t\t";
				}
				echo "\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
				$img = "";
				$filelogo = "";
			
			}else{
				echo "<tr valign=top {$kelas}><td align=center>{$i}</td><td align=center width=15%>{$tanggal}</td><td>Judul: <BR>{$judulp}<br>Isi: ";
				echo $ket.'<br>';
				$ket=strip_tags($ket);
				echo $ket;
				echo " <br>{$ket}<br> Lokasi: ".$arraylokasi[$lokasipengumuman]."</td></tr>";
				
			}
        }
        echo "\r\n\t\t\t\t\t</table></div></div></div></div></div>\r\n\t\t\t\t\t</center>\r\n\t\t\t\t\t<br>\r\n\t\t\t\t";
    }
    else
    {
        #$errmesg = "Daftar pengumuman bulan ".$arraybulan[$blndari - 1]." {$thndari} tidak ada.";
		$errmesg = "Daftar pengumuman tidak ada.";
        echo "<div class=\"page-title\"> <h1> $errmesg </h1> ";
        echo "</div>";
        $aksi = "";
    }*/
	 //Selecting events records from events table
    $query      = doquery($koneksi,"SELECT * FROM pengumuman");
    $data  = array(); 
    $resp = array();
    $i             = 0;
    $row         = mysqli_num_rows($query);
    if($row > 0){
        while($data['events'] = mysqli_fetch_assoc($query))
        {
			$i++;
            //Geting event days
            $start = date("Y-m-d",strtotime($data['events']['TANGGALMULAI']));//die;
            $timestamp_start = strtotime($start);
            $end = date("Y-m-d",strtotime($data['events']['TANGGALSELESAI']));
            $timestamp_end = strtotime($end);
            $diff = abs($timestamp_end - $timestamp_start); // that's it!
            
            $days = floor($diff/(60*60*24));
            $days = $days+1;
            //Defining colors to events
            if($days == 1){
                $color='#FFDAB9';
            }elseif($days > 1 and $days <= 15){
                $color='#8FBC8F';
            }elseif($days > 15 and $days <= 30){
                $color='#C0C0C0';
            }elseif($days > 30 and $days <= 60){
                $color='#90EE90';
            }else{
                $color='#F4A460';
            }
            //Creating event short name with ...
            if(!empty($data['events']['JUDUL'])){
                for ($i = 1; $i <= $days; $i++) {
                    $add_day = $i - 1;
                    $start = date('Y-m-d', strtotime("+{$add_day} day", $timestamp_start));
                    $event_short_name = $data['events']['JUDUL'];
                   
                    #$event_short_name .= ' - ('.$i.$sub.' Day)';
                    
                    $startDate = strtotime($start);
                    //Colecting data in array         
                    $resp[$start . '_' . $data['events']['ID'] . '_' . $i] = array(
                        'id'    => $data['events']['ID'],
                        'title' => $event_short_name,
						'description' => strip_tags(html_entity_decode($data['events']['RINCIAN'])),
                        'start' => $start,
                        'color' => $color,
                    );
                }
            }            
        }
        $resp = array_values($resp);
    }
echo "\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"../tiny_mce/init_tiny_mce.js\"></script>\r\n";
#echo "<script src='../tampilan/default/assets/app/js/dashboard.js' type='text/javascript'></script>";
?>
<script>
	$(document).ready(function() {
    $('#m_calendar').fullCalendar({
		themeSystem: 'bootstrap4',
		
        defaultView: 'month',
		editable: false,
        events: <?php echo json_encode($resp)?>,
        eventRender: function(eventObj, $el) {
			$el.popover({
			  content: eventObj.description,
			  trigger: 'hover',
			  placement: 'top',
			  container: 'body'
			});
		  },
    });
	
});    
</script>

<?php
#echo "PILIHAN".$pilihan;

echo "	<div class=\"row\">
				<div class=\"col-xl-12\">
					<!--begin::Portlet-->
					<div class=\"m-portlet \" id=\"m_portlet\">
						<div class=\"m-portlet__head\">
							<div class=\"m-portlet__head-caption\">
								<div class=\"m-portlet__head-title\">
									<span class=\"m-portlet__head-icon\">
										<i class=\"flaticon-map-location\"></i>
									</span>
									<h3 class=\"m-portlet__head-text\">
										Calendar
									</h3>
								</div>
							</div>
							
						</div>
						<div class=\"m-portlet__body\">
							<div id=\"m_calendar\"></div>
						</div>
					</div>
					<!--end::m-portlet-->
				</div>
				<!--end::col-xl-12-->
			</div>
			<!--end::row-->
		
";
}
?>
