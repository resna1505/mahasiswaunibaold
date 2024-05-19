<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "NIM Mahasiswa harus diisi";
    }
    else if ( trim( $data[nama] ) == "" )
    {
        $errmesg = "Nama Mahasiswa harus diisi";
    }
    else
    {
        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $kodept = $d[KDPTIMSPST];
            $kodejenjang = $d[KDJENMSPST];
            $kodeps = $d[KDPSTMSPST];
        }
        if ( $dtk[thn] + 0 == 0 )
        {
            $tanggallulus = NULL;
        }
        else
        {
            $tanggallulus = "'{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}'";
        }
        $q = "\r\n      UPDATE msmhs\r\n      SET\r\n \r\n      KDPTIMSMHS ='{$kodept}',KDPSTMSMHS ='{$kodeps}',KDJENMSMHS='{$kodejenjang}',\r\n      NIMHSMSMHS='{$id}',NMMHSMSMHS='{$data['nama']}',TPLHRMSMHS='{$data['tempat']}',\r\n      TGLHRMSMHS='{$data['thn']}-{$data['bln']}-{$data['tgl']}',KDJEKMSMHS='{$data['kelamin']}',\r\n      TAHUNMSMHS='{$tahuna}',SMAWLMSMHS='{$tahun}{$semester}',\r\n      BTSTUMSMHS='{$tahun2}{$semester2}',ASSMAMSMHS='{$kodeprop}',TGMSKMSMHS='{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}',\r\n      TGLLSMSMHS={$tanggallulus},\r\n      STMHSMSMHS='{$status}',STPIDMSMHS='{$statusbaru}',SKSDIMSMHS='{$sksbaru}',\r\n      ASNIMMSMHS='{$nimasal}',ASPTIMSMHS='{$ptasal}',ASJENMSMHS='{$jasal}',ASPSTMSMHS='{$psasal}',\r\n      BISTUMSMHS='{$kodebiaya}',PEKSBMSMHS='{$kodekerja}',NMPEKMSMHS='{$tempatkerja}',\r\n      PTPEKMSMHS='{$ptkerja}',PSPEKMSMHS='{$pskerja}',\r\n      NOPRMMSMHS='{$nidnpro}',NOKP1MSMHS='{$nidnpro1}',NOKP2MSMHS='{$nidnpro2}',\r\n      NOKP3MSMHS='{$nidnpro3}',NOKP4MSMHS='{$nidnpro4}',\r\n      SHIFTMSMHS='{$kodekelas}'\r\n      \r\n      WHERE NIMHSMSMHS = '{$idupdate}'\r\n     ";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
            buatlog( 13 );
            $errmesg = "Data Mahasiswa berhasil diupdate";
        }
        mysqli_query($koneksi,$q);
        if ( trim( $data[password] ) != "" )
        {
            $qpwd = "\r\n\t\t\tPASSWORD=PASSWORD('{$data['password']}'),\r\n\t\t\t";
        }
        if ( trim( $data[ipkuap] ) != "" )
        {
            $qipkuap = "\r\n\t\t\t\t\tIPKUAP='{$data['ipkuap']}',\r\n\t\t\t\t";
        }
        if ( $tahunlulus + 0 == 0 )
        {
            $tahunlulus = "'{$tahunlulus}'";
        }
        else
        {
            $tahunlulus = "NULL";
        }
        $q = "\r\n\t\t\tUPDATE mahasiswa SET \r\n \t\t\tNAMA='{$data['nama']}',\r\n\t\t\tID='{$id}',\r\n\t\t\tALAMAT='{$data['alamat']}',\r\n\t\t\t{$qpwd}\r\n\t\t\tTEMPAT='{$data['tempat']}',\r\n\t\t\tTANGGAL='{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n\t\t\tKELAMIN='{$data['kelamin']}',\r\n\t\t\tAGAMA='{$data['agama']}',\r\n\t\t\tTELEPON='{$data['telepon']}',\r\n\t\t\tASAL='{$data['asal']}',\r\n\t\t\tSTATUS='{$status}',\r\n\t\t\tANGKATAN='{$tahuna}',\r\n\t\t\tTAHUNLULUS={$tahunlulus},\r\n\t\t\tIDDOSEN='{$iddosen}',\r\n\t\t\tTA='{$data['ta']}',\r\n\t\t\tDOSENTA='{$data['dosenta']}',\r\n\t\t\tKELAS='{$data['kelas']}',\r\n\t\t\tTANGGALMASUK='{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}',\r\n\t\t\tTANGGALKELUAR='{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n\t\t\t{$qipkuap}\r\n\t\t\tIDPRODI='{$idprodi}'\r\n\t\t\tWHERE ID='{$idupdate}'\r\n\t\t";
        mysqli_query($koneksi,$q);
        $ketlog = "Update data Mahasiswa dengan ID={$idupdate} ({$data['nama']})";
        buatlog( 13 );
        $errmesg = "Data Mahasiswa berhasil diupdate";
        if ( $id != $idupdate )
        {
            $q = "UPDATE pengambilanmk SET IDMAHASISWA='{$id}' WHERE IDMAHASISWA='{$idupdate}'";
            mysqli_query($koneksi,$q);
            $q = "UPDATE nilai SET IDMAHASISWA='{$id}' WHERE IDMAHASISWA='{$idupdate}'";
            mysqli_query($koneksi,$q);
            if ( $file == "" )
            {
                if ( file_exists( "foto/{$idupdate}" ) )
                {
                    rename( "foto/{$idupdate}", "foto/{$id}" );
                }
            }
            else if ( $foto != "" )
            {
                move_uploaded_file( $foto, "foto/{$id}" );
                if ( file_exists( "foto/{$idupdate}" ) )
                {
                    unlink( "foto/{$idupdate}" );
                }
            }
            $idupdate = $id;
        }
        else if ( $foto != "" )
        {
            move_uploaded_file( $foto, "foto/{$idupdate}" );
        }
        $data[password] = "";
        if ( $foto != "" )
        {
            move_uploaded_file( $foto, "foto/{$idupdate}" );
        }
    }
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    $q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
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
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
        }
        echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, "{$d['IDPRODI']}", "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", "{$d['ANGKATAN']}", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Wali </td>\r\n\t\t\t<td>".createinputtext( "iddosen", "{$d['IDDOSEN']}", " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\t\t <br>\r\n\t\t\t<b>".getfield( "NAMA", "dosen", "WHERE ID='{$d['IDDOSEN']}'" )."</b>\r\n      </td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "id", "{$d['ID']}", " class=masukan  size=20" )."</td>\r\n\t\t</tr> \t\t \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Password</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=masukan  size=20" )."\r\n\t\t\t<br>Password tidak akan diubah jika tidak diisi\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", "{$d['NAMA']}", " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Foto</td>\r\n\t\t\t<td>\r\n\t\t\t{$fotosaatini}\r\n\t\t\t<input type=file name=foto class=masukan> \r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", "{$d['ALAMAT']}", " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", $d[TEMPAT], " class=masukan  size=10" )." / ".createinputtanggal( "data", $d, " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $d[KELAMIN], "", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".createinputselect( "data[agama]", $arrayagama, $d[AGAMA], "", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $d[TELEPON], " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>".createinputtext( "data[asal]", $d[ASAL], " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>".createinputtext( "tahunlulus", "{$d['TAHUNLULUS']}", " class=masukan size=4" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas Default Pengambilan Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "data[kelas]", $d[KELAS], " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t<tr >\r\n\t\t\t<td>Tanggal Masuk</td>\r\n\t\t\t<td>".createinputtanggal( "dtm", $dtm, " class=masukan" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>".createinputtanggalblank( "dtk", $dtk, " class=masukan" )."</td>\r\n\t\t</tr>"."\r\n\t\t<tr class=judulform>\r\n\t\t\t<td>Status Kuliah</td>\r\n\t\t\t<td>".createinputselect( "status", $arraystatusmahasiswa, "{$d['STATUS']}", "", " class=masukan " )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>".createinputtextarea( "data[ta]", $d[TA], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".createinputtextarea( "data[dosenta]", $d[DOSENTA], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>";
        if ( $d[JENIS] == 1 )
        {
            echo "<tr class=judulform>\r\n\t\t\t\t<td>IP Ujian Akhir Praktek</td>\r\n\t\t\t\t<td>".createinputtext( "data[ipkuap]", $d[IPKUAP], " class=masukan  size=4" )."</td>\r\n\t\t\t</tr>";
        }
        include( "mahasiswa2.php" );
        echo "\r\n\t\r\n \t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
