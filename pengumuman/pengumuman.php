<?php
#echo "masuk pengumuman";exit();
#echo "AKSI=".$aksi;exit();
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
	if(isset($_GET["tanggalgrafik"])){
       		$tanggalgrafik=$_GET["tanggalgrafik"];
       
	}else{
	   $tanggalgrafik=date('dd/mm/yyyy');
	}
	// $tanggalgrafik='2023';
	// echo "TAHUN GRAFIK=".$tahungrafik;
	
	#echo "ID MHS=".$idupdate;
	//ambil semester mahasiswa skrg
	$semestermhsskrg=getsemestermahasiswa2($users);
    	
	//ambil ips ipk terakhir mhs melalui proses ips ipk
	$q1 = "SELECT NLIPSTRAKM AS nilaiips,NLIPKTRAKM AS nilaiipk,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$users}' ORDER ".
	"BY THSMSTRAKM DESC LIMIT 1";
	#echo $q1.'<br>';
    	$h1 = mysqli_query($koneksi,$q1);
    	
	$data1=mysqli_fetch_array($h1);
	$ipsmhs=$data1['nilaiips'];
	$ipkmhs=$data1['nilaiipk'];
	$thntrakm=$data1['THSMSTRAKM'];

	//ambil ips ipk terakhir mhs sebelumnya
	$qsblm = "SELECT NLIPSTRAKM AS nilaiips,NLIPKTRAKM AS nilaiipk,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$users}' AND ".
	"THSMSTRAKM<'$thntrakm' ORDER BY THSMSTRAKM DESC LIMIT 1";
	#echo $qsblm.'<br>';
    $hsblm = mysqli_query($koneksi,$qsblm);
    	
	$datasblm=mysqli_fetch_array($hsblm);
	$ipsmhssblm=$datasblm['nilaiips'];
	$ipkmhssblm=$datasblm['nilaiipk'];
	

	//ambil history ips ipk terakhir mhs melalui proses ips ipk
	$q2 = "SELECT THSMSTRAKM, NLIPSTRAKM AS nilaiips,NLIPKTRAKM AS nilaiipk FROM trakm WHERE NIMHSTRAKM='{$users}' ".
	"ORDER BY THSMSTRAKM DESC";
	#echo $q2.'<br>';
    	$h2 = mysqli_query($koneksi,$q2);
    	
	while($data2=mysqli_fetch_array($h2)){	
		$ipsmhs=$data2['nilaiips'];
		$ipkmhs=$data2['nilaiipk'];
	}	

	//ambil jadwal kuliah mahasiswa
	$q3="SELECT jadwalkuliah.IDMAKUL,jadwalkuliah.TANGGAL,jadwalkuliah.MULAI,jadwalkuliah.SELESAI,".
	"pengambilanmk.IDMAHASISWA FROM jadwalkuliah JOIN pengambilanmk ON jadwalkuliah.IDMAKUL=pengambilanmk.IDMAKUL ".
	"WHERE 1=1 AND pengambilanmk.IDMAHASISWA='{$users}' AND TANGGAL='$tanggalgrafik'  ORDER BY jadwalkuliah.TANGGAL DESC,jadwalkuliah.MULAI ASC";

    $jadwalKuliah = doquery($koneksi,$q3);
    // $h3 = mysqli_query($koneksi,$q3);
	// while($data3=mysqli_fetch_array($h3)){
	// 	$namamakul=getnamafromtabel( $data3['IDMAKUL'], "makul" );
	// }

	//ambil data pengumuman
	$q4="SELECT ID,DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,SUBSTRING(RINCIAN,1,500) AS RINCIAN2,".
	"IF(LENGTH(RINCIAN)>500,1,0) AS P,IF(TO_DAYS(TANGGALMULAI)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI FROM pengumuman ".
	"ORDER BY TANGGALMULAI DESC LIMIT 1";
	#echo $q4.'<br>';
    // $h4 = mysqli_query($koneksi,$q4);
    $dataPengumuman = doquery($koneksi,$q4);
    $pengumuman=mysqli_fetch_array($dataPengumuman);
    # echo $pengumuman['JUDUL'];
	
    // while($data4=mysqli_fetch_array($h4)){
		
	// }


	echo '
	<div class="dashboard mt-3">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="row">
                            <div class="col-4 pt-4 d-none d-sm-block">
                                <img src="gambar/img.png" alt="" class="img-fluid">
                            </div>
                            <div class="col-sm-12 col-lg-8 pt-3 ps-4">
                                <p class="fs-6 fw-bold">Hai,'.$namausers.'</p>
                                <p style="font-size: 13px;">Saat ini anda berada di Semester '.$semestermhsskrg.' dengan hasil IPS & IPK sebagai berikut. Untuk melihat detail perkuliahan silahkan klik <font style="font-weight: bold;color: blue;">
                                    <a href="../mahasiswa2/index.php?pilihan=&aksi=&tab=6&idupdate='.$users.'" style="text-decoration: none;">Lihat Detail</a>
                                </font></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2">
                        <div class="row p-3">
                            <div class="col-sm-6 col-lg-12">
                                <div class="row">';
                                if ($ipsmhs >= $ipsmhssblm) {
                                    echo '
                                    <div class="col-7">
                                        <p class="m-0" style="font-size: 12px;">IPS</p>
                                        <h2>'.$ipsmhs.'</h2>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="gambar/up_indicator.svg" alt="">
                                        <p style="font-size: 12px;margin-top: 5px;">'.($ipsmhs - $ipsmhssblm).'</p>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="col-7">
                                        <p class="m-0" style="font-size: 12px;">IPS</p>
                                        <h2>'.$ipsmhs.'</h2>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="gambar/down_indicator.svg" alt="">
                                        <p style="font-size: 12px;margin-top: 5px;">'.($ipsmhs - $ipsmhssblm).'</p>
                                    </div>';
                                }
                                    
                                    echo '
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-12">
                                <div class="row">
                                ';
                                if ($ipkmhs >= $ipkmhssblm) {
                                    echo '
                                    <div class="col-7">
                                        <p class="m-0" style="font-size: 12px;">IPK</p>
                                        <h2>'.$ipkmhs.'</h2>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="gambar/up_indicator.svg" alt="">
                                        <p style="font-size: 12px;margin-top: 5px;">'.($ipkmhs - $ipkmhssblm).'</p>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="col-7">
                                        <p class="m-0" style="font-size: 12px;">IPS</p>
                                        <h2>'.$ipkmhs.'</h2>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="gambar/down_indicator.svg" alt="">
                                        <p style="font-size: 12px;margin-top: 5px;">'.($ipkmhs - $ipkmhssblm).'</p>
                                    </div>';
                                }
                                    
                                    echo '                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <figure class="highcharts-figure">
                            <div id="ipk-mahasiswa"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-lg-8 pb-3">
                <p class="fs-6 fw-bold">Jadwal Kuliah</p>
                    <div class="card">
                        <div class="row">
                            <div class="col-12 p-4">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-lg-8">
                                        <p style="color: #a9a9a9;">Anda memiliki 3 aktivitas perkuliahan hari ini</p>
                                    </div>
                                    <div class="col-12 col-sm-12 col-lg-4 pe-5 ps-5">
                                        <form class="row">
                                        '.createinputhidden( "aksi", "pengumuman", "" ).'
                                            <input type="date" name="tanggalgrafik" id="tanggalgrafik" onchange="this.form.submit()">';
                                        echo '</form>
                                    </div>
                                </div>';
                                if (mysqli_num_rows($jadwalKuliah) > 0) {
                                    while ( $q3=mysqli_fetch_array($jadwalKuliah)) {
                                        echo' 
                                        <div class="row m-3 p-3 border border-primary rounded-3">    
                                            <div class="col-8 col-sm-10 col-lg-10">
                                                <p class="fs-6 fw-bold">'.$namamakul=getnamafromtabel( $q3['IDMAKUL'], "makul" ).'</p>
                                            </div>
                                            <div class="col-4 col-sm-2 col-lg-2">
                                                <p class="fw-bold" style="color: blue;"><i class="bi bi-files" style="color: blue;"></i> 2 SKS</p>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-6">
                                                <div class="row">
                                                    <div class="col-2 mt-1">
                                                        <i class="bi bi-clock-fill" style="color: blue;background-color: #e9e9e9;border-radius: 10px;padding: 5px;"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <p class="m-0 p-0">Jam</p>
                                                        <p style="color: #a9a9a9;">'.$q3['MULAI'].' - '.$q3['SELESAI'].'</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-6">
                                                <div class="row">
                                                    <div class="col-2 mt-1">
                                                        <i class="bi bi-file-spreadsheet-fill" style="color: blue;background-color: #e9e9e9;border-radius: 10px;padding: 5px;"></i>
                                                    </div>
                                                    <div class="col-10">
                                                        <p class="m-0 p-0">Ruangan</p>
                                                        <p style="color: #a9a9a9;">'.$q3['IDMAKUL'].'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                        }
                                } else {
                                    echo '<div class="row">
                                        <div class="col-12 d-flex align-items-center justify-content-center p-5">
                                            <img src="https://assets.siakadcloud.com/assets/v1/v2/icon/dashboard/illustrasi_empty_jadwal_kuliah.svg" alt="">
                                        </div>
                                        <p class="text-center">Tidak ada jadwal kuliah saat ini</p>
                                        <p class="text-center" style="color: #a9a9a9;font-size: 14px;padding-left: 5rem;padding-right: 5rem;">Istirahat dulu ya, tidak ada jadwal kuliah saat ini. Tapi jangan lupa, tetap belajar dan kerjakan tugas.</p>
                                    </div>';
                                }
                                echo'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="row">
                        <div class="col-sm-6 col-lg-12 pb-3">
                            <p class="fs-6 fw-bold">Riwayat Keuangan</p>
                            <div class="card p-3"> 
                            <img src="gambar/tagihan_lunas.svg" alt="" height="120">
                                <p class="text-center" style="font-size: 16px;">Lihat Pembayaran Anda</p>
                                <p style="font-size: 12px;" class="text-center">Anda dapat melihat secara langsung rincian riwayat pembayaran.</p>
                                <button type="button" class="btn btn-primary btn-block">
                                    <a class="text-white" href="../mahasiswa2/index.php?pilihan=&aksi=&tab=7&idupdate='.$users.'" style="text-decoration: none; display: block; width: 100%;">Lihat Riwayat</a>
                                </button>
                            </div>
                            <!-- <div class="card p-3">
                                <p style="font-size: 13px;margin-bottom: 5px;">Tagihan Jatuh Tempo</p>
                                <p class="fs-5 fw-bold" style="margin-bottom: 5px;">Rp. 2.410.000</p>
                                <p style="font-size: 13px;">Bayar sebelum tanggal <font style="color: red;font-weight: bold;"> 7 Jan 2023</font></p>
                                <button type="button" class="btn btn-primary"><font style="font-size: 14px;">Bayar Sekarang</font></button>
                            </div> -->
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <p class="fs-6 fw-bold">Pengumuman</p>
                            <div class="card p-3">
                                <p>'.$pengumuman['JUDUL'].'</p>';
                                echo html_entity_decode($pengumuman['RINCIAN2']);
                                echo '<p style="font-size: 12px;margin: 0px;"> <font class="fw-bold">Tanggal : </font><font>'.$pengumuman['TGL'].'</font> </p>
                                <p style="font-size: 12px;"><font class="fw-bold">Penulis : </font>'.$pengumuman['IDUSER'].'</p>
                                <button type="button" class="btn btn-primary"><font style="font-size: 14px;">Lihat Detail</font></button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
			
';
}
?>
