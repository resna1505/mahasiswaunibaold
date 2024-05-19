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
        $q = "DELETE FROM jadwalkuliah WHERE ID='{$idhapus}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Jadwal Kuliah  berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Jadwal Kuliah  tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Jadwal Kuliah", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $data['tahun'], $data['semester'], false );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $makul, 12, false );
        $vld[] = cekvaliditasinteger( "Kode Kelas", $data['kelas'], 2 );
        $vld[] = cekvaliditaskode( "Hari", $data['hari'], 1 );
        $vld[] = cekvaliditasinteger( "Rencana Tatap Muka".$data['rencana'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else if ( trim( $makul ) == "" )
        {
            $errmesg = "Kode Mata Kuliah harus diisi";
        }
        else if ( trim( $data[mulai] ) == "" )
        {
            $errmesg = "Jam Mulai Jadwal Kuliah harus diisi";
        }
        else if ( trim( $data[mulai] ) == "" )
        {
            $errmesg = "Jam Selesai Jadwal Kuliah harus diisi";
        }
        else
        {
            $q = "SELECT COUNT(THSMSTBKMK) AS JML FROM tbkmk WHERE\r\n      THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' AND\r\n      KDKMKTBKMK='{$makul}'  \r\n      ";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            if ( $d[JML] + 0 <= 0 )
            {
                $errmesg = "Maaf. Mata Kuliah {$makul} tidak ada di Kurikulum ".( $data[tahun] - 1 )."/{$data['tahun']}   ".$arraysemester[$data[semester]];
            }
            else
            {
                $q = "SELECT * FROM jadwalkuliah WHERE\r\n          (\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['selesai']}' >= MULAI ) OR\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= MULAI AND '{$data['selesai']}' >= SELESAI )\r\n          )\r\n          AND IDRUANGAN='{$data['ruangan']}' \r\n          AND HARI='{$data['hari']}'\r\n          AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'\r\n          AND ID!='{$idupdate}'\r\n          AND IDMAKUL!='{$makul}'\r\n         ";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $errmesg = "Data Jadwal Kuliah bentrok dengan yang lain : <br>\r\n            (Makul {$d['IDMAKUL']} ".getnamafromtabel( $d[IDMAKUL], "makul" ).", Kelas ".$arraylabelkelas[$d[KELAS]].").<br>\r\n            Silakan ubah jam, hari, atau ruangan kuliah.";
                }
                else
                {
                    $q = "\r\n        \t\t\tUPDATE jadwalkuliah \r\n        \t\t\tSET\r\n              TAHUN= '{$data['tahun']}',\r\n              SEMESTER='{$data['semester']}',\r\n              IDMAKUL='{$makul}',\r\n              KELAS='{$data['kelas']}',\r\n              IDRUANGAN='{$data['ruangan']}',\r\n              HARI='{$data['hari']}',\r\n              MULAI='{$data['mulai']}',\r\n        \t\t\tSELESAI='{$data['selesai']}',\r\n              RENCANA='{$data['rencana']}',\r\n              TIM='{$tim}',\r\n              IDPRODI='{$data['idprodi']}'\r\n         \r\n        \t\t\tWHERE ID='{$idupdate}'\r\n        \t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Jadwal Kuliah berhasil disimpan";
                        $data = "";
                        $id = "";
                    }
                    else
                    {
                        $errmesg = "Data Jadwal Kuliah tidak   disimpan";
                    }
                }
            }
        }
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Update Data Jadwal Kuliah" );
    printmesg( $errmesg );
    $q = "SELECT * FROM jadwalkuliah WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $arrayprodidep[''] = "";
        echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", $idupdate, "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[idprodi]", $arrayprodidep, "{$d['IDPRODI']}", "", " class=masukan" )."</td>\r\n\t\t</tr> \t\t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".createinputtahunajaran( "data[tahun]", $d[TAHUN], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputselect( "data[semester]", $arraysemester, $d[SEMESTER], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr>\r\n    \r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "makul", $d[IDMAKUL], " class=masukan  size=10 maxlength=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,makul',\r\n\t\t\tdocument.form.makul.value)\" >\r\n\t\t\tdaftar Makul\r\n\t\t\t</a></td>\r\n\t\t</tr> \r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n    ".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "" )."\r\n      \r\n      \r\n  </td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Ruangan</td>\r\n\t\t\t<td>".createinputselect( "data[ruangan]", $arrayruangan, $d[IDRUANGAN], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Hari</td>\r\n\t\t\t<td>".createinputselect( "data[hari]", $arrayhari, $d[HARI], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Mulai</td>\r\n\t\t\t<td>".createinputtext( "data[mulai]", $d[MULAI], " class=masukan  size=5" )."(jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Selesai</td>\r\n\t\t\t<td>".createinputtext( "data[selesai]", $d[SELESAI], " class=masukan  size=5" )."\r\n      (jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Rencana Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "data[rencana]", $d[RENCANA], " class=masukan  size=2" )."</td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN Tim Pengajar <br>(pisahkan dengan Enter)</td>\r\n\t\t\t<td>".createinputtextarea( "tim", $d[TIM], " class=masukan  rows=5 cols=40" )."\r\n      \t<a \r\n\t\t\thref=\"javascript:daftardosentextarea('form,wewenang,tim',\r\n\t\t\tdocument.form.tim.value)\" >\r\n\t\t\tdaftar NIDN Dosen\r\n\t\t\t</a>\r\n      </td>\r\n\t\t</tr>\t\t \r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    #cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Surat Keterangan Mahasiswa", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        /*if ( trim( $makul ) == "" )
        {
            $errmesg = "Kode Mata Kuliah harus diisi";
        }
        else if ( trim( $data[mulai] ) == "" )
        {
            $errmesg = "Jam Mulai Jadwal Kuliah harus diisi";
        }
        else if ( trim( $data[mulai] ) == "" )
        {
            $errmesg = "Jam Selesai Jadwal Kuliah harus diisi";
        }*/
        #else
        #{
            /*$q = "SELECT COUNT(*) AS JML FROM tbkmk WHERE\r\n       \r\n      KDKMKTBKMK='{$makul}'  AND\r\n      THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' \r\n      ";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            if ( $d[JML] + 0 <= 0 )
            {
                $errmesg = "Maaf. Mata Kuliah {$makul} tidak ada di Kurikulum ".( $data[tahun] - 1 )."/{$data['tahun']}   ".$arraysemester[$data[semester]];
            }
            else
            {*/
                /*$q = "SELECT * FROM jadwalkuliah WHERE\r\n          (\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['selesai']}' >= MULAI ) OR\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI )\r\n          )\r\n          AND IDRUANGAN='{$data['ruangan']}' \r\n          AND HARI='{$data['hari']}'\r\n          AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}' \r\n          AND IDMAKUL!='{$makul}'\r\n          \r\n         ";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $errmesg = "Data Jadwal Kuliah bentrok dengan yang lain : <br>\r\n            (Makul {$d['IDMAKUL']} ".getnamafromtabel( $d[IDMAKUL], "makul" ).", Kelas ".$arraylabelkelas[$d[KELAS]].").<br>\r\n            Silakan ubah jam, hari, atau ruangan kuliah.";
                }
                else
                {*/
					#echo $fakultasskm;
					list($fak,$jur)=explode("/",$fakultasskm);
					$fak=trim($fak);
					$jur=trim($jur);
					
                    $q = "INSERT INTO skm (tanggal,nim,nama,alamat,tempat_lahir,tanggal_lahir,fakultasskm,jurusanskm,semesterskm,status,jns_surat) ".
					"VALUES (NOW(),'{$nim}','{$nama}','{$alamatskm}','{$tempat_lahir}','{$tanggal_lahir}','{$fak}','{$jur}','{$data['semesterskm']}','NEW','{$data['jenis_surat']}')";
                    #echo $q;exit();
					mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data SKM berhasil ditambah";
                        $id = "";
                        $tim = "";
                    }
                    else
                    {
                        $errmesg = "Data SKM tidak berhasil ditambah";
                    }
                #}
            #}
        #}
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    #cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Tambah SKM" );
    
	#$q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$users}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
    $q="SELECT mahasiswa.*,prodi.JENIS,prodi.TINGKAT,mspst.KDPSTMSPST,fakultas.ID AS IDFAK
	FROM mahasiswa JOIN prodi ON prodi.ID=mahasiswa.IDPRODI JOIN mspst ON prodi.ID=mspst.IDX 
	LEFT JOIN departemen ON departemen.ID=prodi.IDDEPARTEMEN
	LEFT JOIN fakultas ON fakultas.ID=departemen.IDFAKULTAS WHERE mahasiswa.ID='{$users}'";
	
	#echo $q;
	$h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
		printmesg( $errmesg );
		$d = sqlfetcharray( $h );
		$tmp = explode( "-", $d[TANGGAL] );
        $d[thn] = $tmp[0];
        $d[tgl] = $tmp[2];
        $d[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALMASUK] );
        $dtm[thn] = $tmp[0];
        $dtm[tgl] = $tmp[2];
        $dtm[bln] = $tmp[1];
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $dtk[thn] = $tmp[0];
        $dtk[tgl] = $tmp[2];
        $dtk[bln] = $tmp[1];
		#echo $d[IDFAK];
		#print_r($arrayprodifakultas['1003']);
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputtext( "pilihan", $pilihan, "" ).createinputtext( "sessid", $token, "" ).createinputtext( "aksi", "tambah", "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td width=250>Fakultas / Jurusan</td><td>".$arrayprodidepbuatskm[$d[IDPRODI]]."<input type='hidden' name='fakultasskm' value='".$arrayprodidepbuatskm[$d[IDPRODI]]."'></td></tr> \t\t\r\n    <tr><td>Angkatan</td><td>{$d['ANGKATAN']}<input type='text' name='angkatan' value='{$d['ANGKATAN']}'></td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa</td>\r\n\t\t\t<td><b>{$d['ID']}<input type='text' name='nim' value='{$d['ID']}'></td>\r\n\t\t</tr>\r\n    \r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}<input type='text' name='nama' value='{$d['NAMA']}'></td></tr>";
    $arraylabelkelas[''] = "Semua";
    echo "\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".nl2br( $d[ALAMAT] )."<input type='text' name='alamatskm' value='{$d['ALAMAT']}'></td>\r\n\t\t</tr>\r\n\t\t<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td> {$d['TEMPAT']}  /  {$d['tgl']}-{$d['bln']}-{$d['thn']} <input type='text' name='tempat_lahir' value='{$d['TEMPAT']}'><input type='text' name='tanggal_lahir' value='{$d['thn']}-{$d['bln']}-{$d['tgl']}'></td>\r\n\t\t</tr>\r\n \t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputselect( "data[semesterskm]", $arraysemesterskm, $d[semesterskm], "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jenis Surat</td>\r\n\t\t\t<td>".createinputselect( "data[jenis_surat]", $arrayskm, "", "", " class=masukan" )."</td> \t\t\t\r\n\t\t</tr><tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
	}
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildosen.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat SKM " );
    include( "prosestampilskm.php" );
}
echo " \t\r\n";
?>
