<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#echo $aksi;
#print_r($id);

periksaroot( );

if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    $q = "DELETE FROM calonmahasiswa WHERE ID='{$idhapus}'\r\n  AND GELOMBANG='{$gelhapus}' AND PILIHAN='{$pilihanhapus}' AND TAHUN='{$tahunhapus}'";
    doquery($koneksi,$q);
    $ketlog = "Hapus data Calon Mahasiswa dengan ID={$idhapus}";
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            @unlink( @"foto/{$d['ID']}" );
        }
        $errmesg = "Data Calon Mahasiswa dengan ID = '{$idhapus}' berhasil dihapus";
        $ketlog = "Hapus Calon Mahasiswa. ID={$idhapus}";
        buatlog( 82 );
    }
    else
    {
        $errmesg = "Data Calon Mahasiswa dengan ID = '{$idhapus}' tidak berhasil dihapus";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $tab == 0 || $tab == "" )
    {
        include( "biodata.php" );
    }
    else if ( $tab == 1 )
    {
        include( "resetpassword.php" );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Update Data Calon Mahasiswa" );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Update Data Calon Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	

    $arraymenutab[0] = "Biodata";
    $arraymenutab[1] = "Reset Password";
	
	echo "<div class=\"page-content\">
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
											printmesg("Update Data Calon Mahasiswa");
								echo	"</div>
										
									</div>
									<div class=\"portlet-body\">
						<div class=\"table-scrollable\">";

    echo "\t\t\t\r\n\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr>\r\n\t";
    if ( $tab == "" )
    {
        $tab = 0;
    }
    foreach ( $arraymenutab as $k => $v )
    {
        $bgtab = "";
        if ( $tab == $k )
        {
            $bgtab = " style='color:#004488' ";
        }
        echo "\r\n\t\t\t\t\t<td align=center ><b><a class=menux {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}&tahunupdate={$tahunupdate}&pilihanupdate={$pilihanupdate}&gelupdate={$gelupdate}&'>{$v}</td>\r\n\t\t";
    }
    echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div>\r\n\t";
    if ( $tab == 0 || $tab == "" )
    {
        include( "biodata.php" );
    }
    else if ( $tab == 1 )
    {
        include( "resetpassword.php" );
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    $idsudahada = 0;
    if ( trim( $id ) != "" )
    {
        $q = "SELECT * FROM calonmahasiswa WHERE ID='{$id}'";
		#$q = "SELECT * FROM calonmahasiswa WHERE (ID='{$id}' OR ".$data[nama]." like '%PUTRI MARLIAN%')";
		#echo $q;exit();
        $h = doquery($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $idsudahada = 1;
        }
    }
   if ( trim( $id ) == "" )
    {
        $errmesg = "Nomor Tes Calon Mahasiswa harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Calon Mahasiswa harus diisi";
    }
	else if(stripos(trim( $data[nama] ), "PUTRI MARLIAN") !== FALSE)
    {
        $errmesg = "Nama Calon Mahasiswa tidak diizinkan melakukan pendaftaran";
    }
    else if ( $idsudahada == 1 )
    {
        $errmesg = "ID {$id} sudah ada. Gunakan ID lain.";
    }
    else
    {
		#echo "ll";exit();
        $tmp = explode( "/", $arraypilihanpmb2[$idpilihan] );
        if ( $notes == "" )
        {
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
        
        if ( $foto != "" )
        {
            move_uploaded_file( $foto, PHOTOPATH."/{$id}" );
        }
        if ( $_FILES["ijazah"]["name"] != "" )
        {
            $tmp = explode(".",$_FILES["ijazah"]["name"]);
            
            move_uploaded_file( $ijazah, IJAZAHPATH."/".$id.".".$tmp[1] );
            $ijazahfile= $id.".".$tmp[1];
        }
		if ( trim( $data[alamat] ) == "" )
            {
                $errmesg .= "Alamat harus diisi<br>";
            }
            if ( trim( $data[kota] ) == "" )
            {
                $errmesg .= "Kota harus diisi<br>";
            }
            if ( trim( $data[provinsi] ) == "" )
            {
                $errmesg .= "Provinsi harus diisi<br>";
            }
            if ( trim( $data[tempat] ) == "" )
            {
                $errmesg .= "Tempat lahir harus diisi<br>";
            }
            if ( !validasi_tanggal( $data[tgl], $data[bln], $data[thn], $empty = false ) )
            {
                $errmesg .= "Tanggal lahir harus diisi dengan benar<br>";
            }
            if ( !validasi_telpon( $data[telepon], false ) )
            {
                $errmesg .= "Telepon rumah harus diisi dengan benar<br>";
            }
            if ( !validasi_telpon( $data[hp], false ) )
            {
                $errmesg .= "No. HP harus diisi dengan benar<br>";
            }
            if ( !validasi_email( $data[email], false ) )
            {
                $errmesg .= "Alamat e-mail harus diisi dengan benar<br>";
            }
            if ( trim( $data[asal] ) == "" )
            {
                $errmesg .= "Asal Sekolah harus diisi<br>";
            }
            if ( !validasi_tahun( $data[tahunlulussma], false ) )
            {
                $errmesg .= "Tahun lulus harus diisi dengan benar<br>";
            }
            if ( trim( $namaayah ) == "" )
            {
                $errmesg .= "Nama Ayah harus diisi<br>";
            }
            if ( trim( $data[alamatortu] ) == "" )
            {
                $errmesg .= "Alamat Ayah harus diisi<br>";
            }
            if ( trim( $data[teleponayah] ) == "" )
            {
                $errmesg .= "No. Kontak Ayah harus diisi<br>";
            }
            if ( trim( $namaibu ) == "" )
            {
                $errmesg .= "Nama Ibu harus diisi<br>";
            }
            if ( trim( $data[alamatibu] ) == "" )
            {
                $errmesg .= "Alamat Ibu harus diisi<br>";
            }
            if ( trim( $data[teleponibu] ) == "" )
            {
                $errmesg .= "No. Kontak Ibu harus diisi<br>";
            }
        
        /*$q = "INSERT INTO calonmahasiswa (ID,NAMA,TAHUN,GELOMBANG,PILIHAN,KUITANSI,TEMPATLAHIR,TANGGALLAHIR,KELAMIN,STATUSNIKAH,AGAMA,ALAMAT,".
		"TELEPON,HP,WN,ASALSMA,NOIJAZAH,TANGGALIJAZAH,NILAIUN,NILAIUNS,NAMAAYAH,NAMAIBU,PEKERJAANORTU,ALAMATORTU,PRODI1,PRODI2,BIAYA,NOTES,EMAIL,".
		"KOTA,PROVINSI,TAHUNLULUSSMA,PENDIDIKAN ,ALAMATIBU,TELEPONAYAH,TELEPONIBU,TANGGALUPDATE,UPDATER,IJAZAHFILE) VALUES ".
		"('{$id}','".strtoupper( $data[nama] )."','{$tahuna}','{$gelombang}','{$idpilihan}','{$data['kuitansi']}','{$data['tempat']}',".
		"'{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n      '{$data['kelamin']}','{$data['statusnikah']}','{$data['agama']}',".
		"'{$data['alamat']}','{$data['telepon']}','{$data['hp']}','{$data['wn']}','{$data['asal']}','{$noijazah}',".
		"'{$tglijazah['thn']}-{$tglijazah['bln']}-{$tglijazah['tgl']}','{$jumlahun}','{$jumlahuns}','{$namaayah}','{$namaibu}','{$pekerjaanortu}',".
		"'{$data['alamatortu']}','{$idprodi1}','{$idprodi2}','{$data['biaya']}','{$notes}','{$data['email']}' ,'{$data['kota']}',".
		"'{$data['provinsi']}','{$data['tahunlulussma']}' ,'{$data['pendidikan']}' ,".
		"'{$data['alamatibu']}','{$data['teleponayah']}', '{$data['teleponibu']}',NOW(),'{$users}','$ijazah')";*/
		$q = "INSERT INTO calonmahasiswa (ID,NAMA,TAHUN,GELOMBANG,PILIHAN,KUITANSI,TEMPATLAHIR,TANGGALLAHIR,KELAMIN,STATUSNIKAH,AGAMA,ALAMAT,".
		"TELEPON,HP,WN,ASALSMA,NOIJAZAH,TANGGALIJAZAH,NILAIUN,NILAIUNS,NAMAAYAH,NAMAIBU,PEKERJAANORTU,ALAMATORTU,PRODI1,PRODI2,BIAYA,NOTES,EMAIL,".
		"KOTA,PROVINSI,TAHUNLULUSSMA,PENDIDIKAN ,ALAMATIBU,TELEPONAYAH,TELEPONIBU,TANGGALUPDATE,UPDATER,CATATAN) VALUES ".
		"('{$id}','".strtoupper( $data[nama] )."','{$tahuna}','{$gelombang}','{$idpilihan}','{$data['kuitansi']}','{$data['tempat']}',".
		"'{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n      '{$data['kelamin']}','{$data['statusnikah']}','{$data['agama']}',".
		"'{$data['alamat']}','{$data['telepon']}','{$data['hp']}','{$data['wn']}','{$data['asal']}','{$noijazah}',".
		"'{$tglijazah['thn']}-{$tglijazah['bln']}-{$tglijazah['tgl']}','{$jumlahun}','{$jumlahuns}','{$namaayah}','{$namaibu}','{$pekerjaanortu}',".
		"'{$data['alamatortu']}','{$idprodi1}','{$idprodi2}','{$data['biaya']}','{$notes}','{$data['email']}' ,'{$data['kota']}',".
		"'{$data['provinsi']}','{$data['tahunlulussma']}' ,'{$data['pendidikan']}' ,".
		"'{$data['alamatibu']}','{$data['teleponayah']}', '{$data['teleponibu']}',NOW(),'{$users}','{$data['catatan']}')";
		
        #echo $q;exit();
		doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            
            $errmesg = "Data Calon Mahasiswa berhasil ditambah";
            $data = "";
            $ketlog = "Tambah Calon Mahasiswa. ID={$id}";
            buatlog( 80 );
            $id = $noijazah = $jumlahun = $jumlahuns = $namaayah = $namaibu = $pekerjaanortu = $notes = "";
        }
        else
        {
            $errmesg = "Data Calon Mahasiswa tidak berhasil ditambah";
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
   
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Tambah Data Calon Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
						<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" ENCTYPE='MULTIPART/FORM-DATA'>
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Daftar</label>\r\n    
									<label class=\"col-form-label\">".createinputtahun( "tahuna", $tahuna, " class=form-control m-input " )."</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Gelombang {$tahuna}</label>";
										if ( $gelombang == "" )
										{
											$gelombang = 1;
										}
										if ( $tahuna == "" )
										{
											$tahuna = $w[year];
										}
										if ( $idpilihan == "" )
										{
											$idpilihan = $arraypilihan[$initidpilihan];
										}
										$wajibdiisi = "<b style='font-size:8pt;'>Wajib Diisi</b>";
    echo "							<label class=\"col-form-label\">".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "idpilihan", $arraypilihanpmb, $idpilihan, "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">ID/Nomor Tes </label>";
    echo "							<label class=\"col-form-label\">
										".createinputtext( "id", $id, " class=form-control m-input  maxlength=12 size=40" )."{$wajibdiisi}
									</label>
								</div>
								<!--\r\n  \t<tr class=judulform>\r\n\t\t\t<td>Kuitansi</td>\r\n\t\t\t<td>".createinputtext( "data[kuitansi]", "", " class=form-control m-input  size=40" )."</td>\r\n\t\t</tr>\r\n  \t<tr class=judulform>\r\n\t\t\t<td>Biaya Rp.</td>\r\n\t\t\t<td>".createinputtext( "data[biaya]", "", " class=form-control m-input  maxlength=12 size=20" )."</td>\r\n\t\t</tr>\r\n\t\t-->\r\n    
								<!--\r\n  \t<tr class=judulform>\r\n\t\t\t<td>No. Tes</td>\r\n\t\t\t<td>".createinputtext( "notes", $notes, " class=form-control m-input  size=20" )." \r\n       \r\n      Kosongkan untuk No. Tes otomatis sesuai Pola Pilihan  </td>\r\n\t\t</tr>\r\n\t\t-->
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Nama Lengkap</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[nama]", "", " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>";
    $data[thn] = $arraydefaultmhs[tahun];
    #print_r($data);
    #echo "\r\n    <tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", $arraydefaultmhs[kota], " class=form-control m-input  size=10" )." / ".createinputtanggal( "data", $data, " class=form-control m-input" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $data[kelamin], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".createinputselect( "data[agama]", $arrayagama, $data[agama], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Status Nikah</td>\r\n\t\t\t<td>".createinputselect( "data[statusnikah]", $arraystatusnikah, $data[statusnikah], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Kota</td>\r\n\t\t\t<td>".createinputtext( "data[kota]", $data[kota], " class=form-control m-input  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Provinsi</td>\r\n\t\t\t<td>".createinputtext( "data[provinsi]", $data[provinsi], " class=form-control m-input  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>No Telepon Rumah</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $data[telepon], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>No HP</td>\r\n\t\t\t<td>".createinputtext( "data[hp]", $data[hp], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>E-mail</td>\r\n\t\t\t<td>".createinputtext( "data[email]", $data[email], " class=form-control m-input  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Kewarganegaraan</td>\r\n\t\t\t<td>".createinputselect( "data[wn]", $arraywn, $data[wn], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>".createinputtext( "data[asal]", $data[asal], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>".createinputtext( "data[tahunlulussma]", $data[tahunlulussma], " class=form-control m-input  size=4 maxlength=4" )."{$wajibdiisi}</td>\r\n\t\t</tr> \r\n\r\n\t\t\r\n\t\t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n   \t\t <tr class=judulform>\r\n\t\t\t<td>No. Ijazah</td>\r\n\t\t\t<td>".createinputtext( "noijazah", $noijazah, " class=form-control m-input size=20" )."</td>\r\n\t\t</tr>\r\n    <tr >\r\n\t\t\t<td>Tanggal Ijazah</td>\r\n\t\t\t<td>".createinputtanggal( "tglijazah", $tglijazah, " class=form-control m-input" )."</td>\r\n\t\t</tr> \r\n <tr class=judulform>\r\n\t\t\t<td>File Ijazah</td>\r\n\t\t\t<td>\r\n\t\t\t{$ijazahsaatini}\r\n\t\t\t<input type=file name=ijazah class=form-control m-input> \r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\r\n\t\t\r\n   \t\t <tr class=judulform>\r\n\t\t\t<td>Jumlah Nilai Ujian Nasional</td>\r\n\t\t\t<td>".createinputtext( "jumlahun", $jumlahun, " class=form-control m-input size=2" )."</td>\r\n\t\t</tr>\r\n   \t\t <tr class=judulform>\r\n\t\t\t<td>Jumlah Nilai Ujian Sekolah</td>\r\n\t\t\t<td>".createinputtext( "jumlahuns", $jumlahuns, " class=form-control m-input size=2" )."</td>\r\n\t\t</tr>\r\n   \t\t <tr class=judulform>\r\n\t\t\t<td width=250>Pendidikan Terakkhir</td>\r\n\t\t\t<td>".createinputtext( "data[pendidikan]", $data[pendidikan], " class=form-control m-input size=20" )."</td>\r\n\t\t</tr>\t\t\r\n\r\n\t\t\r\n\t\t\r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n\r\n   \t<tr class=judulform>\r\n\t\t\t<td>Nama Ayah</td>\r\n\t\t\t<td>".createinputtext( "namaayah", $namaayah, " class=form-control m-input size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat Ayah</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamatortu]", $data[alamatortu], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}</td>\r\n\t\t</tr>  \r\n   \t<tr class=judulform>\r\n\t\t\t<td>No. Kontak Ayah</td>\r\n\t\t\t<td>".createinputtext( "data[teleponayah]", $data[teleponayah], " class=form-control m-input size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n   \t<tr class=judulform>\r\n\t\t\t<td>Nama Ibu</td>\r\n\t\t\t<td>".createinputtext( "namaibu", $namaibu, " class=form-control m-input size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n      <tr class=judulform>\r\n\t\t\t<td>Alamat Ibu</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamatibu]", $data[alamatibu], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}</td>\r\n\t\t</tr>  \r\n   \t<tr class=judulform>\r\n\t\t\t<td>No. Kontak Ibu</td>\r\n\t\t\t<td>".createinputtext( "data[teleponibu]", $data[teleponibu], " class=form-control m-input size=30" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n\r\n \r\n   \t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 1</td>\r\n\t\t\t<td>".createinputselect( "idprodi1", $arrayprodidep, $idprodi1, "", " class=form-control m-input" )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Pilihan Program Studi 2</td>\r\n\t\t\t<td>".createinputselect( "idprodi2", $arrayprodidep, $idprodi12, "", " class=form-control m-input" )."</td>\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Catatan</td><td>".createinputtextarea( "data[catatan]", $data[catatan], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}</td></tr><tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
	echo "\r\n    				<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[tempat]", $arraydefaultmhs[kota], " class=form-control m-input  size=10 style=\"width:auto;display:inline-block;\"" )." / ".createinputtanggal( "data", $data, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[kelamin]", $arraykelamin, $data[kelamin], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Agama</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[agama]", $arrayagama, $data[agama], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Status Nikah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[statusnikah]", $arraystatusnikah, $data[statusnikah], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[alamat]", $data[alamat], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[kota]", $data[kota], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Provinsi</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[provinsi]", $data[provinsi], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">No Telepon Rumah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[telepon]", $data[telepon], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[hp]", $data[hp], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[email]", $data[email], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kewarganegaraan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[wn]", $arraywn, $data[wn], "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Asal Sekolah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[asal]", $data[asal], " class=form-control m-input  size=50" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Lulus</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[tahunlulussma]", $data[tahunlulussma], " class=form-control m-input  size=4 maxlength=4" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">No. Ijazah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "noijazah", $noijazah, " class=form-control m-input size=20" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "tglijazah", $tglijazah, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">File Ijazah / Kelulusan sementara</label>\r\n    
									<label class=\"col-form-label\">
										{$ijazahsaatini}
										<input type=file name=ijazah class=form-control m-input> {$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jumlah Nilai Ujian Nasional</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "jumlahun", $jumlahun, " class=form-control m-input size=2" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jumlah Nilai Ujian Sekolah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "jumlahuns", $jumlahuns, " class=form-control m-input size=2" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Pendidikan Terakkhir</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[pendidikan]", $data[pendidikan], " class=form-control m-input size=20" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Nama Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "namaayah", $namaayah, " class=form-control m-input size=30" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Alamat Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[alamatortu]", $data[alamatortu], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">No. Kontak Ayah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[teleponayah]", $data[teleponayah], " class=form-control m-input size=30" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "namaibu", $namaibu, " class=form-control m-input size=30" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Alamat Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[alamatibu]", $data[alamatibu], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">No. Kontak Ibu</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[teleponibu]", $data[teleponibu], " class=form-control m-input size=30" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Pilihan Program Studi 1</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "idprodi1", $arrayprodidep, $idprodi1, "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Catatan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtextarea( "data[catatan]", $data[catatan], " class=form-control m-input  cols=50 rows=4" )."{$wajibdiisi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value='Tambah'>
										<input type=\"reset\" class=\"btn btn-secondary\" value='Reset'>
									</div>
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
	<script>\r\n \t\t\t\tform.id.focus();</script>";

}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "aktivasicalon" && $REQUEST_METHOD == POST)
{
	echo "aktivasi";exit();
	$t                  = $_POST["idcalonmhs"];
	#echo $t.'<br>';
	$nim = $tmp ="";
	for($a=0;$a<count($t);$a++) {
		if(!$tmp){
			$tmp = "'".$t[$a]."'";
		}
		else{
			$tmp.=", '".$t[$a]."'";
		}
	}
	#echo $tmp.'<br>';
	$nim = "(".$tmp.")";

	$sql_update="UPDATE calonmahasiswa SET STATUS=1 WHERE ID IN {$nim}";
	#echo $sql_update;exit();
	doquery($koneksi,$sql_update);
            
            $errmesg = "Data Calon Mahasiswa berhasil diaktivasi";
            $data = "";
            $ketlog = "Aktivasi Calon Mahasiswa. ID={$nim} oleh {$users}";
            buatlog(66);
            #$id = $noijazah = $jumlahun = $jumlahuns = $namaayah = $namaibu = $pekerjaanortu = $notes = "";
    $aksi="";    
}
if ( $aksi == "" )
{
    
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Cari Calon Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Cari Calon Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Daftar</label>\r\n    
										<div class=\"col-lg-6\" >
											<div class=\"m-checkbox-list\">
												<label class=\"m-checkbox\">
													<input type=checkbox name=istglentri value=1 class=form-control m-input style=\"width:auto;display:inline-block;\">
													".createinputtanggal( "tglentri", $tglentri, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."s.d".createinputtanggal( "tglentri2", $tglentri2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
												<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
										<label class=\"col-form-label\">";
												$waktu = getdate( );
	echo "									<select name=tahunmasuk class=form-control m-input> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $i == $waktu[year] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													++$i;
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">ID/Nomor Tes</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "id", $id, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Pilihan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idpilihan><option value=''>Semua</option>";
												foreach ( $arraypilihanpmb as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Pilihan Program Studi 1</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi1>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>form.id.focus();</script>";
}
?>
