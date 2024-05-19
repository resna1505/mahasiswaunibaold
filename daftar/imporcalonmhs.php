<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );

if ( $aksi == "Simpan" )
{
	#echo "lll";exit();
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Calon Mahasiswa", TAMBAH_DATA );
        $aksi = "";
    }
    else if ( is_array( $dataimpor ) )
    {
        $berhasil = $gagal = 0;
        foreach ( $dataimpor as $k => $v )
        {
            if ( $v[tahun] == "" || $v[gelombang] == "" || $v[pilihan] == "" || $v[id] == "" )
            {
                ++$gagal;
            }
            else
            {
                $qfield = $qvalue = "";
                foreach ( $v as $key => $d )
                {
                    if ( $key == "tgllahir" )
                    {
                        $qfield .= "tanggallahir,";
                        $qvalue .= "'".mysqli_real_escape_string($koneksi, $d[thn]."-".$d[bln]."-".$d[tgl] )."',";
                    }
                    else if ( $key == "tglijazah" )
                    {
                        $qfield .= "tanggalijazah,";
                        $qvalue .= "'".mysqli_real_escape_string($koneksi, $d[thn]."-".$d[bln]."-".$d[tgl] )."',";
                    }
                    else
                    {
                        $qfield .= "{$key},";
                        $qvalue .= "'".mysqli_real_escape_string($koneksi, $d )."',";
                    }
                }
                $q = "INSERT INTO calonmahasiswa ({$qfield} PASSWORD  ) VALUES ({$qvalue} MD5('".mysqli_real_escape_string($koneksi, $v[id] )."') ) ";
                doquery($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    ++$berhasil;
                }
                else
                {
                    ++$gagal;
                }
            }
        }
        $errmesg = "{$berhasil} data berhasil disimpan. {$gagal} data tidak berhasil disimpan.";
        $aksi = "";
    }
}
if ( $aksi == "Proses" )
{
    if ( $fileimpor == "" )
    {
        $errmesg = "File CSV harus diisi";
    }
    else if ( $delimiter == "" )
    {
        $errmesg = "Karakter pemisah kolom harus diisi";
    }
    else
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        $arraydata = file( $fileimpor );
		#print_r($arraydata);
        echo "<div class=\"page-content\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class=\"portlet light\">
            <div class=\"portlet-title\">
            <div class=\"caption font-green-haze\">
<i class=\"icon-settings font-green-haze\"></i>
<span class=\"caption-subject bold uppercase\">IMPOR DATA</span>
                        </div>
<div class=\"actions\"></div></div>
<div class=\"portlet-body form\"> <form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n  \t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."  \r\n      <tr class=juduldata align=center>\r\n        <td>No</td>\r\n        <td>Tahun Daftar</td>\r\n        <td>Gelombang</td>\r\n        <td>Kode Pilihan</td>\r\n        <td>ID/No Tes</td>\r\n        <td>Nama</td>\r\n \r\n        <td>Tempat Lahir</td>\r\n        <td>Tanggal Lahir</td>\r\n        <td>Jenis Kelamin</td>\r\n        <td>Agama</td>\r\n        <td>Status Nikah</td>\r\n\r\n        <td>Alamat</td>\r\n        <td>Kota</td>\r\n        <td>Provinsi</td>\r\n        <td>Telepon Rumah</td>\r\n        <td>HP</td>\r\n\r\n        <td>E-mail</td>\r\n        <td>WN</td>\r\n        <td>Asal Sekolah</td>\r\n        <td>Tahun Lulus</td>\r\n        <td>No Ijazah</td>\r\n\r\n        <td>Tanggal Ijazah</td>\r\n        <td>Nilai UN</td>\r\n        <td>Nilai US</td>\r\n        <td>Pendidikan Terakhir</td>\r\n\r\n        <td>Nama Ayah</td>\r\n        <td>Alamat Ayah</td>\r\n        <td>No Kontak Ayah</td>\r\n        <td>Nama Ibu</td>\r\n        <td>Alamat Ibu</td>\r\n        <td>No Kontak Ibu</td>\r\n\r\n        <td>Pilihan Prodi 1</td>\r\n        <td>Pilihan Prodi 2</td><td>Catatan</td>\r\n\r\n      </tr>\r\n            \r\n    ";
        $i = 1;
        $arraykelamin[''] = "";
        $arrayagama[''] = "";
        $arraystatusnikah[''] = "";
        $arraypilihanpmb[''] = "";
        $arraywn[''] = "";
        $arrayprodidep[''] = "";
        foreach ( $arraydata as $k => $v )
        {
            if ( $k != 0 )
            {
                $d = explode( $delimiter, $v );
				#print_r($d);
                $tahundaftar = trim( $d[0] );
                $gelombang = trim( $d[1] );
                $kodepilihan = trim( $d[2] );
                $id = trim($d[3]);
				#echo $kodepilihan."mmm".$id;exit();
                if ( $kodepilihan == "" || $id == "" )
                {
                }
                else
                {
                    $nama = trim( $d[4] );
                    $tempatlahir = trim( $d[5] );
                    $tanggallahir = trim( $d[6] );
                    $tmp = explode( "/", $tanggallahir );
                    $tgllahir[tgl] = $tmp[0];
                    $tgllahir[bln] = $tmp[1];
                    $tgllahir[thn] = $tmp[2];
                    $kelamin = trim( $d[7] );
                    $agama = trim( $d[8] );
                    $statusnikah = trim( $d[9] );
                    $alamat = trim( $d[10] );
                    $kota = trim( $d[11] );
                    $provinsi = trim( $d[12] );
                    $telepon = trim( $d[13] );
                    $hp = trim( $d[14] );
                    $email = trim( $d[15] );
                    $wn = trim( $d[16] );
                    $asalsma = trim( $d[17] );
                    $tahunlulussma = trim( $d[18] );
                    $noijazah = trim( $d[19] );
                    $tanggalijazah = trim( $d[20] );
                    $tmp = explode( "/", $tanggalijazah );
                    $tglijazah[tgl] = $tmp[0];
                    $tglijazah[bln] = $tmp[1];
                    $tglijazah[thn] = $tmp[2];
                    $nilaiun = trim( $d[21] );
                    $nilaiuns = trim( $d[22] );
                    $pendidikan = trim( $d[23] );
                    $namaayah = trim( $d[24] );
                    $alamatortu = trim( $d[25] );
                    $teleponayah = trim( $d[26] );
                    $namaibu = trim( $d[27] );
                    $alamatibu = trim( $d[28] );
                    $teleponibu = trim( $d[29] );
                    $prodi1 = trim( $d[30] );
                    $prodi2 = trim( $d[31] );
					$catatan = trim( $d[32] );
                    echo "\r\n        <tr>\r\n          <td align=center>{$i}</td>\r\n          <td><input type=text size=4 name='dataimpor[{$i}][tahun]' value='{$tahundaftar}'></td>\r\n          <td><input type=text size=2 name='dataimpor[{$i}][gelombang]' value='{$gelombang}'></td>\r\n          <td>".createinputselect( "dataimpor[{$i}][pilihan]", $arraypilihanpmb, $kodepilihan, "", " class=masukan" )."</td>\r\n          <td><input type=text size=15 name='dataimpor[{$i}][id]' value='{$id}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][nama]' value='{$nama}'></td>\r\n\r\n          <td><input type=text size=5 name='dataimpor[{$i}][tempatlahir]' value='{$tempatlahir}'></td>\r\n          <td nowrap>".createinputtanggalblank( "dataimpor[{$i}][tgllahir]", $tgllahir, " class=masukan" )."</td>\r\n          <td>".createinputselect( "dataimpor[{$i}][kelamin]", $arraykelamin, $kelamin, "", " class=masukan" )."</td>\r\n          <td>".createinputselect( "dataimpor[{$i}][agama]", $arrayagama, $agama, "", " class=masukan" )."</td>\r\n          <td>".createinputselect( "dataimpor[{$i}][statusnikah]", $arraystatusnikah, $statusnikah, "", " class=masukan" )."</td>\r\n\r\n          <td><input type=text size=15 name='dataimpor[{$i}][alamat]' value='{$alamat}'></td>\r\n          <td><input type=text size=5 name='dataimpor[{$i}][kota]' value='{$kota}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][provinsi]' value='{$provinsi}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][telepon]' value='{$telepon}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][hp]' value='{$hp}'></td>\r\n\r\n          <td><input type=text size=5 name='dataimpor[{$i}][email]' value='{$email}'></td>\r\n          <td>".createinputselect( "dataimpor[{$i}][wn]", $arraywn, $wn, "", " class=masukan" )."</td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][asalsma]' value='{$asalsma}'></td>\r\n          <td><input type=text size=4 name='dataimpor[{$i}][tahunlulussma]' value='{$tahunlulussma}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][noijazah]' value='{$noijazah}'></td>\r\n\r\n          <td nowrap>".createinputtanggalblank( "dataimpor[{$i}][tglijazah]", $tglijazah, " class=masukan" )."</td>\r\n          <td><input type=text size=2 name='dataimpor[{$i}][nilaiun]' value='{$nilaiun}'></td>\r\n          <td><input type=text size=2 name='dataimpor[{$i}][nilaiuns]' value='{$nilaiuns}'></td>\r\n          <td><input type=text size=5 name='dataimpor[{$i}][pendidikan]' value='{$pendidikan}'></td>\r\n\r\n          <td><input type=text size=5 name='dataimpor[{$i}][namaayah]' value='{$namaayah}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][alamatortu]' value='{$alamatortu}'></td>\r\n          <td><input type=text size=5 name='dataimpor[{$i}][teleponayah]' value='{$teleponayah}'></td>\r\n          <td><input type=text size=5 name='dataimpor[{$i}][namaibu]' value='{$namaibu}'></td>\r\n          <td><input type=text size=10 name='dataimpor[{$i}][alamatibu]' value='{$alamatibu}'></td>\r\n          <td><input type=text size=5 name='dataimpor[{$i}][teleponibu]' value='{$teleponibu}'></td>\r\n\r\n          <td>".createinputselect( "dataimpor[{$i}][prodi1]", $arrayprodidep, $prodi1, "", " class=masukan" )."</td>\r\n          <td>".createinputselect( "dataimpor[{$i}][prodi2]", $arrayprodidep, $prodi2, "", " class=masukan" )."</td><td><input type=text size=15 name='dataimpor[{$i}][catatan]' value='{$catatan}'></td></tr>\r\n      ";
                    ++$i;
                }
            }
        }
        echo "\r\n       </table>\r\n       \r\n       <input type=submit name=aksi value='Simpan' onClick=\"return confirm('Simpan data calon mahasiswa?')\">\r\n       \r\n      </form>  \r\n    \r\n    ";
    }
}
if ( $aksi == "" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printmesg( $errmesg );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Impor Data Calon Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
								".createinputhidden( "pilihan", $pilihan, "" )."
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">File CSV</label>\r\n    
										<label class=\"col-form-label\">
											<input type=file name=fileimpor size=40>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Karakter pemisah kolom</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text name=delimiter size=1 value=';' class='form-control m-input'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<button type='submit' value='proses' name=aksi  class='btn btn-brand'>Proses</button>
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
?>
