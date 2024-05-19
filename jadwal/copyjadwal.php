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
#if ( $aksi == "update" )
if ( $aksi == "copyj" )
{
	#echo "kesini"exit();
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
                $q = "SELECT * FROM jadwalkuliah WHERE\r\n          (\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['selesai']}' >= MULAI ) OR\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= MULAI AND '{$data['selesai']}' >= SELESAI )\r\n          )\r\n          AND IDRUANGAN='{$data['ruangan']}' \r\n          AND TANGGAL= '{$copytanggal['thn']}-{$copytanggal['bln']}-{$copytanggal['tgl']}'          AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}'  AND IDMAKUL='{$makul}'\r\n         ";
                #echo $q.'<br>';
		$h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $errmesg = "Data Jadwal Kuliah Dengan data : <br>\r\n            (Makul {$d['IDMAKUL']} ".getnamafromtabel( $d[IDMAKUL], "makul" ).", Kelas ".$arraylabelkelas[$d[KELAS]].").<br>Sudah Ada.";
                }
                else
                {
                    #$q = "\r\n        \t\t\tUPDATE jadwalkuliah \r\n        \t\t\tSET\r\n              HARI= '{$data['hari']}',TAHUN= '{$data['tahun']}',\r\n              SEMESTER='{$data['semester']}',\r\n              IDMAKUL='{$makul}',\r\n              KELAS='{$data['kelas']}',\r\n              IDRUANGAN='{$data['ruangan']}',\r\n             TANGGAL='{$thnmasuk}-{$blnmasuk}-{$tglmasuk}',\r\n              MULAI='{$data['mulai']}',\r\n        \t\t\tSELESAI='{$data['selesai']}',\r\n              RENCANA='{$data['rencana']}',\r\n              TIM='{$tim}',\r\n              IDPRODI='{$data['idprodi']}'\r\n         \r\n        \t\t\tWHERE ID='{$idupdate}'\r\n        \t\t";
                    #$q = "\r\n        \t\t\tUPDATE jadwalkuliah \r\n        \t\t\tSET\r\n             TANGGAL='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}', GEDUNG='{$data['gedung']}',TAHUN= '{$data['tahun']}',\r\n              SEMESTER='{$data['semester']}',\r\n              IDMAKUL='{$makul}',\r\n              KELAS='{$data['kelas']}',\r\n              IDRUANGAN='{$data['ruangan']}',\r\n              HARI='{$data['hari']}',\r\n              MULAI='{$data['mulai']}',\r\n        \t\t\tSELESAI='{$data['selesai']}',\r\n              RENCANA='{$data['rencana']}',\r\n              TIM='{$tim}',\r\n              IDPRODI='{$data['idprodi']}'\r\n         \r\n        \t\t\tWHERE ID='{$idupdate}'\r\n        \t\t";
                    $q = "\r\n    \t\t\tINSERT INTO jadwalkuliah (TAHUN,SEMESTER,IDMAKUL,KELAS,IDRUANGAN,TANGGAL,MULAI,\r\n    \t\t\tSELESAI,RENCANA,TIM,IDPRODI,HARI) \r\n    \t\t\tVALUES ('{$data['tahun']}','{$data['semester']}','{$makul}','{$data['kelas']}','{$data['ruangan']}', '{$copytanggal['thn']}-{$copytanggal['bln']}-{$copytanggal['tgl']}','{$data['mulai']}','{$data['selesai']}','{$data['rencana']}','{$tim}','{$data['idprodi']}','{$data['hari']}')\r\n    \t\t";
                    #echo $q;exit();
			mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Copy Data Jadwal Kuliah berhasil";
                        $data = "";
                        $id = "";
                    }
                    else
                    {
                        $errmesg = "Copy Data Jadwal Kuliah Gagal";
                    }
                }
            }
        }
    }
    $aksi = "";
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
		/*$tglm = $d[TANGGAL];
		$tglm = explode( "-", $tglm );
		$tglmasuk = $tglm[2];
		$blnmasuk = $tglm[1];
		$thnmasuk = $tglm[0];*/
		$tmp = explode( "-", $d[TANGGAL] );
    
		$dt[thn] = $tmp[0];
		$dt[bln] = $tmp[1];
		$dt[tgl] = $tmp[2];
        $arrayprodidep[''] = "";
        echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", $idupdate, "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[idprodi]", $arrayprodidep, "{$d['IDPRODI']}", "", " class=form-control m-input" )."</td>\r\n\t\t</tr> \t\t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".createinputtahunajaran( "data[tahun]", $d[TAHUN], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputselect( "data[semester]", $arraysemester, $d[SEMESTER], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n    \r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "makul", $d[IDMAKUL], " class=form-control m-input  size=10 maxlength=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,makul',\r\n\t\t\tdocument.form.makul.value)\" >\r\n\t\t\tdaftar Makul\r\n\t\t\t</a></td>\r\n\t\t</tr> \r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n    ".createinputselect( "data[kelas]", $arraylabelkelas, $d[KELAS], "", "" )."\r\n      \r\n      \r\n  </td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Ruangan</td>\r\n\t\t\t<td>".createinputselect( "data[ruangan]", $arrayruangan, $d[IDRUANGAN], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Hari</td>\r\n\t\t\t<td>".createinputselect( "data[hari]", $arrayhari, $data[hari], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr></tr>\r\n \t\t\r\n\t\t<tr>\r\n          <td>Tanggal</td>\r\n          <td>".createinputtanggal( "mulai", $dt, "" )."</td>\r\n        </tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Mulai</td>\r\n\t\t\t<td>".createinputtext( "data[mulai]", $d[MULAI], " class=form-control m-input  size=5" )."(jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Selesai</td>\r\n\t\t\t<td>".createinputtext( "data[selesai]", $d[SELESAI], " class=form-control m-input  size=5" )."\r\n      (jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Rencana Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "data[rencana]", $d[RENCANA], " class=form-control m-input  size=2" )."</td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pengajar</td>\r\n\t\t\t<td>".createinputtextarea( "tim", $d[TIM], " class=form-control m-input  rows=5 cols=40" )."\r\n      \t<a \r\n\t\t\thref=\"javascript:daftardosentextarea('form,wewenang,tim',\r\n\t\t\tdocument.form.tim.value)\" >\r\n\t\t\tdaftar NIDN Dosen\r\n\t\t\t</a>\r\n      </td>\r\n\t\t</tr>\t\t \r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Update' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( $_SESSION['token'] != $_POST['sessid'] )
    {
        $errmesg = token_err_mesg( "Jadwal Kuliah", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $data['tahun'], $data['semester'], false );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $makul, 12, false );
        $vld[] = cekvaliditasinteger( "Kode Kelas", $data['kelas'], 2 );
        $vld[] = cekvaliditaskode( "Hari", $data['hari'], 1 );
        $vld[] = cekvaliditaswaktu( "Jam Mulai", $data['mulai'], false );
        $vld[] = cekvaliditaswaktu( "Jam Selesai", $data['selesai'], false );
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
            $q = "SELECT COUNT(*) AS JML FROM tbkmk WHERE\r\n       \r\n      KDKMKTBKMK='{$makul}'  AND\r\n      THSMSTBKMK='".( $data[tahun] - 1 )."{$data['semester']}' \r\n      ";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            if ( $d[JML] + 0 <= 0 )
            {
                $errmesg = "Maaf. Mata Kuliah {$makul} tidak ada di Kurikulum ".( $data[tahun] - 1 )."/{$data['tahun']}   ".$arraysemester[$data[semester]];
            }
            else
            {
                $q = "SELECT * FROM jadwalkuliah WHERE\r\n          (\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['selesai']}' >= MULAI ) OR\r\n            ( '{$data['selesai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI ) OR\r\n            ( '{$data['mulai']}' <= SELESAI AND '{$data['mulai']}' >= MULAI )\r\n          )\r\n          AND IDRUANGAN='{$data['ruangan']}' \r\n          AND TANGGAL= '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}'   AND TAHUN='{$data['tahun']}'\r\n          AND SEMESTER='{$data['semester']}' \r\n          AND IDMAKUL!='{$makul}'\r\n          \r\n         ";
                echo $q;
		$h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $errmesg = "Data Jadwal Kuliah bentrok dengan yang lain : <br>\r\n            (Makul {$d['IDMAKUL']} ".getnamafromtabel( $d[IDMAKUL], "makul" ).", Kelas ".$arraylabelkelas[$d[KELAS]].").<br>\r\n            Silakan ubah jam, tanggal, atau ruangan kuliah.";
                }
                else
                {
                    $q = "\r\n    \t\t\tINSERT INTO jadwalkuliah (TAHUN,SEMESTER,IDMAKUL,KELAS,IDRUANGAN,TANGGAL,MULAI,\r\n    \t\t\tSELESAI,RENCANA,TIM,IDPRODI,HARI) \r\n    \t\t\tVALUES ('{$data['tahun']}','{$data['semester']}','{$makul}','{$data['kelas']}','{$data['ruangan']}', '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}','{$data['mulai']}','{$data['selesai']}','{$data['rencana']}','{$tim}','{$data['idprodi']}','{$data['hari']}')\r\n    \t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Jadwal Kuliah berhasil ditambah";
                        $id = "";
                        $tim = "";
                    }
                    else
                    {
                        $errmesg = "Data Jadwal Kuliah tidak berhasil ditambah";
                    }
                }
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{	
	echo "AAA";exit();
    cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    printjudulmenu( "Tambah Data Jadwal Kuliah" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "aksi", "tambah", "" )."\r\n    <tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "data[idprodi]", $arrayprodidep, "{$data['idprodi']}", "", " class=form-control m-input" )."</td>\r\n\t\t</tr> \t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>".createinputtahunajaran( "data[tahun]", $data[tahun], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>".createinputselect( "data[semester]", $arraysemester, $data[semester], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n    \r\n     \r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "makul", $makul, " class=form-control m-input  size=10 maxlength=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,makul',\r\n\t\t\tdocument.form.makul.value)\" >\r\n\t\t\tdaftar Makul\r\n\t\t\t</a></td>\r\n\t\t</tr> ";
    $arraylabelkelas[''] = "Semua";
    #echo "\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n      ".createinputselect( "data[kelas]", $arraylabelkelas, $data[kelas], "", "" )."\r\n      \r\n \t\t\t </td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Ruangan</td>\r\n\t\t\t<td>".createinputselect( "data[ruangan]", $arrayruangan, $data[ruangan], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Hari</td>\r\n\t\t\t<td>".createinputselect( "data[hari]", $arrayhari, $data[hari], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Mulai</td>\r\n\t\t\t<td>".createinputtext( "data[mulai]", $data[mulai], " class=form-control m-input  size=5" )."(jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Selesai</td>\r\n\t\t\t<td>".createinputtext( "data[selesai]", $data[selesai], " class=form-control m-input  size=5" )."\r\n      (jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Rencana Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "data[rencana]", $data[rencana], " class=form-control m-input  size=2" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN Tim Pengajar <br>(pisahkan dengan Enter)</td>\r\n\t\t\t<td>".createinputtextarea( "tim", str_replace( "\\r\\n", "\n", $tim ), " class=form-control m-input  rows=5 cols=40" )."\r\n      \t<a \r\n\t\t\thref=\"javascript:daftardosentextarea('form,wewenang,tim',\r\n\t\t\tdocument.form.tim.value)\" >\r\n\t\t\tdaftar NIDN Dosen\r\n\t\t\t</a>\r\n      </td>\r\n\t\t</tr>\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
	echo "\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n      ".createinputselect( "data[kelas]", $arraylabelkelas, $data[kelas], "", "" )."\r\n      \r\n \t\t\t </td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Ruangan</td>\r\n\t\t\t<td>".createinputselect( "data[ruangan]", $arrayruangan, $data[ruangan], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr><tr class=judulform>\r\n\t\t\t<td>Hari</td>\r\n\t\t\t<td>".createinputselect( "data[hari]", $arrayhari, $data[hari], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Tanggal</td>\r\n\t\t\t<td>".createinputtanggal( "mulai", "", "" )."</td>\t\t\t\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Mulai</td>\r\n\t\t\t<td>".createinputtext( "data[mulai]", $data[mulai], " class=form-control m-input  size=5" )."(jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Selesai</td>\r\n\t\t\t<td>".createinputtext( "data[selesai]", $data[selesai], " class=form-control m-input  size=5" )."\r\n      (jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Rencana Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "data[rencana]", $data[rencana], " class=form-control m-input  size=2" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pengajar</td>\r\n\t\t\t<td>".createinputtextarea( "tim", str_replace( "\\r\\n", "\n", $tim ), " class=form-control m-input  rows=5 cols=40" )."\r\n      \t<a \r\n\t\t\thref=\"javascript:daftardosentextarea('form,wewenang,tim',\r\n\t\t\tdocument.form.tim.value)\" >\r\n\t\t\tdaftar NIDN Dosen\r\n\t\t\t</a>\r\n      </td>\r\n\t\t</tr>\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";

}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildosen.php" );
}
if ( $aksi == "" )
{
   cekhaktulis( $kodemenu );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Update Data Jadwal Kuliah" );
    #printmesg( $errmesg );
    $q = "SELECT * FROM jadwalkuliah WHERE ID='{$idupdate}'";
	#echo $q;exit();
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
		/*$tglm = $d[TANGGAL];
		$tglm = explode( "-", $tglm );
		$tglmasuk = $tglm[2];
		$blnmasuk = $tglm[1];
		$thnmasuk = $tglm[0];*/
		$tmp = explode( "-", $d[TANGGAL] );
    
		$dt[thn] = $tmp[0];
		$dt[bln] = $tmp[1];
		$dt[tgl] = $tmp[2];
        $arrayprodidep[''] = "";
		echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						";							
	echo "					<div class='portlet-title'>";
								printmesg("Copy Data Jadwal Kuliah");
								printmesg( $errmesg );
	echo "					</div>";
		echo "			<div class=\"m-portlet\">
					<!--begin::Form-->";
        echo "			<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\>"
							.createinputhidden( "pilihan", $pilihan, "" )
							.createinputhidden( "sessid", $token, "" )
							.createinputhidden( "aksi", "copyj", "" )
							.createinputhidden( "idupdate", $idupdate, "" )."
							<div class=\"m-portlet__body\">	
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[idprodi]", $arrayprodidep, "{$d['IDPRODI']}", "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtahunajaran( "data[tahun]", $d[TAHUN], "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[semester]", $arraysemester, $d[SEMESTER], "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah / Blok</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "makul", $makul, " class=form-control m-input  size=10 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,'');\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
										<!--<a href=\"javascript:daftarmakul('form,wewenang,makul',document.form.makul.value)\" >daftar Makul</a>-->
										<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
												<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Sub Mata Kuliah</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "data[blok]", $data[blok], " maxlength=30 class=form-control m-input  size=10" )."
										(Untuk Prodi yang menggunakan Sub Mata Kuliah / Topik dalam Perkuliahan)
									</div>
								</div>";
									$arraylabelkelas[''] = "Semua";
    #echo "\r\n\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n      ".createinputselect( "data[kelas]", $arraylabelkelas, $data[kelas], "", "" )."\r\n      \r\n \t\t\t </td>\r\n\t\t</tr>\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Ruangan</td>\r\n\t\t\t<td>".createinputselect( "data[ruangan]", $arrayruangan, $data[ruangan], "", " class=form-control m-input" )."</td> \t\t\t\r\n\t\t</tr>\r\n \t\t\r\n\t\t <tr>\r\n          <td>Tanggal</td>\r\n          <td>".createinputtanggal( "mulai", "", "" )."</td>\r\n        </tr><tr class=judulform>\r\n\t\t\t<td>Jam Mulai</td>\r\n\t\t\t<td>".createinputtext( "data[mulai]", $data[mulai], " class=form-control m-input  size=5" )."(jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Jam Selesai</td>\r\n\t\t\t<td>".createinputtext( "data[selesai]", $data[selesai], " class=form-control m-input  size=5" )."\r\n      (jj:mm:dd)</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Rencana Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "data[rencana]", $data[rencana], " class=form-control m-input  size=2" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIDN Tim Pengajar <br>(pisahkan dengan Enter)</td>\r\n\t\t\t<td>".createinputtextarea( "tim", str_replace( "\\r\\n", "\n", $tim ), " class=form-control m-input  rows=5 cols=40" )."\r\n      \t<a \r\n\t\t\thref=\"javascript:daftardosentextarea('form,wewenang,tim',\r\n\t\t\tdocument.form.tim.value)\" >\r\n\t\t\tdaftar NIDN Dosen\r\n\t\t\t</a>\r\n      </td>\r\n\t\t</tr>\r\n\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit value='Tambah' class=form-control m-input>\r\n\t\t\t\t\t<input type=reset value='Reset' class=form-control m-input>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n \r\n\t\t";
	echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kelas</label>    
									<label class=\"col-form-label\">
										".createinputselect( "data[kelas]", $arraylabelkelas, $data[kelas], "", "" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Ruangan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[ruangan]", $arrayruangan, $d[IDRUANGAN], "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Gedung Mesin Absen</label>    
									<label class=\"col-form-label\">
										".createinputselect( "data[gedung]", $arraygedung, $data[GEDUNG], "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "mulai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jam Mulai</label>    
									<label class=\"col-form-label\">
										".createinputtext( "data[mulai]", $data[mulai], " class=form-control m-input  size=5" )."(jj:mm:dd)
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jam Selesai</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[selesai]", $data[selesai], " class=form-control m-input  size=5" )."(jj:mm:dd)
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Rencana Tatap Muka</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "data[rencana]", "1", " class=form-control m-input  size=2" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Satuan Tatap Muka</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "data[satuan_tatap_muka]", $arraysatuantatapmuka, $data[SATUAN], "", " class=form-control m-input" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "tim", str_replace( "\\r\\n", "\n", $tim ), " class=form-control m-input  id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )
										/*.
										createinputhidden( "id_karyawan", str_replace( "\\r\\n", "\n", $id_karyawan ), " class=form-control m-input  rows=5 cols=40" )."
										<a href=\"javascript:daftardosenpayroll('form,wewenang,tim,id_karyawan',document.form.tim.value,document.form.id_karyawan.value)\" >daftar NIK Dosen</a>
										*/
										."<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
										   <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Copy ke Tanggal</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "copytanggal", $dt, "" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Copy Jadwal' class=\"btn btn-brand\">
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
	</div>
		<!--end::container-fluid-->";
    }
}
echo " \t\r\n";
?>
