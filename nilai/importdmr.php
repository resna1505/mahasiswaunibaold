<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksi2 == "Import" )
{
    if ( $filenilai == "none" )
    {
        $errmesg = "File nilai DMR harus Diisi";
    }
    else
    {
        $nilaidmr = file( $filenilai );
        $jmlupdate = 0;
        if ( is_array( $nilaidmr ) )
        {
            foreach ( $nilaidmr as $k => $v )
            {
                $tmp = explode( ";", $v );
                if ( 2 < count( $tmp ) )
                {
                    $nip = trim( $tmp[1] );
                    $nilai = trim( $tmp[3] );
                }
                else
                {
                    $nip = trim( $tmp[0] );
                    $nilai = trim( $tmp[1] );
                }
                $data = getrowfromtabelsyarat( "WHERE \r\n\t\t\t\t\tIDMAHASISWA='{$nip}'\r\n\t\t\t\t\tAND IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND TAHUN='{$tahunupdate}' \r\n\t\t\t\t\tAND SEMESTER='{$semesterupdate}' \r\n\t\t\t\t\tAND KELAS='{$kelasupdate}' \r\n\t\t\t\t\t", "IDMAHASISWA", "pengambilanmk" );
                if ( $data[IDMAHASISWA] != "" )
                {
                    $q = "\r\n\t\t\t\t\t\tINSERT INTO nilai (IDMAKUL,IDMAHASISWA,TAHUN,KELAS,IDKOMPONEN,NILAI,SEMESTER)\r\n\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t('{$idmakulupdate}','{$nip}','{$tahunupdate}','{$kelasupdate}','{$datacek['import']}','{$nilai}',\r\n\t\t\t\t\t\t'{$semesterupdate}')\r\n\t\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( sqlaffectedrows( $koneksi ) <= 0 )
                    {
                        $q = "UPDATE nilai SET NILAI='{$nilai}' \r\n\t\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\t\tIDMAHASISWA='{$nip}'\tAND\r\n\t\t\t\t\t\t\tTAHUN='{$tahunupdate}' \r\n\t\t\t\t\t\t\tAND \r\n\t\t\t\t\t\t\tSEMESTER='{$semesterupdate}' \r\n\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\tKELAS='{$kelasupdate}' AND\r\n\t\t\t\t\t\t\tIDKOMPONEN='{$datacek['import']}' AND\r\n\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'";
                        mysqli_query($koneksi,$q);
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            $ketlog = "Update Data Nilai via DMR dengan \r\n\t\t\t\t\t\t\t\t\tID Makul={$idmakulupdate}, \r\n\t\t\t\t\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\t\t\t\t\tID Komponen={$datacek['import']},\r\n\t\t\t\t\t\t\t\t\tID Mahasiswa={$nip}\r\n\t\t\t\t\t\t\t\t\t";
                            buatlog( 37 );
                            ++$jmlupdate;
                        }
                    }
                    else
                    {
                        $ketlog = "Tambah Data Nilai via DMR dengan \r\n\t\t\t\t\t\t\t\tID Makul={$idmakulupdate}, \r\n\t\t\t\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\t\t\t\tID Komponen={$datacek['import']},\r\n\t\t\t\t\t\t\t\tID Mahasiswa={$nip}\r\n\t\t\t\t\t\t\t\t";
                        buatlog( 36 );
                        ++$jmlupdate;
                    }
                }
            }
        }
        if ( 0 < $jmlupdate )
        {
            $errmesg = "Data nilai telah diupdate sebanyak {$jmlupdate} buah";
        }
        else
        {
            $errmesg = "Tidak ada data nilai yang diupdate";
        }
    }
    $aksi = "formtambah";
}
if ( $aksitambah == "Update" )
{
    if ( is_array( $data ) )
    {
        $jmlaf = 0;
        $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA  FROM komponen\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}' \r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            while ( $d = sqlfetcharray( $h ) )
            {
                $kp[] = $d[IDKOMPONEN];
            }
            foreach ( $data as $k => $v )
            {
                foreach ( $kp as $kk => $vk )
                {
                    $q = "\r\n\t\t\t\t\t\t\t\tINSERT INTO nilai (IDMAHASISWA,IDKOMPONEN,IDMAKUL,TAHUN,KELAS,NILAI,SEMESTER)\r\n\t\t\t\t\t\t\t\tVALUES\r\n\t\t\t\t\t\t\t\t('{$k}','{$vk}','{$idmakulupdate}','{$tahunupdate}','{$kelasupdate}','".$v[$vk]."','{$semesterupdate}')\r\n\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        ++$jmlaf;
                    }
                    else
                    {
                        $q = "\r\n\t\t\t\t\t\t\t\t\tUPDATE nilai \r\n\t\t\t\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\t\t\t\tNILAI='".$v[$vk]."'\r\n\t\t\t\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}' \r\n\t\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t\tIDMAHASISWA='{$k}'\r\n\t\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t\tIDKOMPONEN='{$vk}'\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t";
                        mysqli_query($koneksi,$q);
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            ++$jmlaf;
                        }
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data nilai   berhasil diupdate";
            }
            else
            {
                $errmesg = "Data nilai tidak diupdate";
            }
        }
    }
    $aksi = "formtambah";
}
unset( $kp );
if ( $aksi == "formtambah" )
{
    include( "prosestampileditnilaidmr.php" );
}
if ( $aksi == "tampilkanawal" )
{
    $aksi = " ";
    include( "prosestampildmrawal.php" );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilnilai.php" );
}
if ( $aksi == "tambahawal" )
{
    printjudulmenu( "Import Nilai Mata Kuliah Dari DMR" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>\r\n\t\t\t<table class=form>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $jenisusers == 0 )
    {
        echo "\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIDN Dosen</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.iddosen.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    }
    echo "<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=masukan  size=10" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>".createinputtext( "kelas", $kelas, " class=masukan  size=4" )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
