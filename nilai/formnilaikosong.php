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
$updatenilai = 0;
if ( $aksi == "lihatdata" && $aksi == "lihatdata" && $pilihan == "formnilaikosong" )
{
    include( "prosestampilformnilaikosong.php" );
}
unset( $kp );
if ( $aksi == "formtambah" )
{
    if ( $jenisusers == 1 && $aturaneditnilaidosen == 0 )
    {
        echo "Maaf, Anda tidak dapat mengedit nilai.";
        exit( );
    }
    else
    {
        $aturaneditnilai = getaturan( "EDITNILAI" );
        $q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\tAND SIMBOL=''\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
        $ht = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $ht ) )
        {
            session_register_sikad( "statusnilai" );
            $statusnilai = 1;
            if ( $aturaneditnilai == 1 && $pilihan == "editmhs" )
            {
                $q = "\r\n    \t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n    \t\t\t\tpengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n    \t\t\t\tFROM mahasiswa,pengambilanmk\r\n    \t\t\t\tWHERE \r\n    \t\t\t\tmahasiswa.ID='{$id}' AND\r\n            mahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n     \t\t\t\tAND SIMBOL=''\r\n    \t\t\t\tLIMIT 0,1\r\n    \t\t\t";
                $ht = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $ht ) )
                {
                    session_register_sikad( "statusnilai" );
                    $statusnilai = 1;
                }
            }
            else
            {
                session_register_sikad( "statusnilai" );
                $statusnilai = 1;
            }
        }
    }
    if ( !session_is_registered_sikad( "statusnilai" ) || $statusnilai != 1 )
    {
        include( "passwordnilai.php" );
    }
    else if ( session_is_registered_sikad( "statusnilai" ) && $statusnilai == 1 )
    {
        if ( $aksi == "formtambah" && $pilihan == "ntambah" )
        {
            include( "prosestampileditnilai.php" );
        }
        else if ( $aksi == "formtambah" && $pilihan == "ntambahm" )
        {
            include( "prosestampileditnilaim.php" );
        }
        else if ( $aksi == "formtambah" && $pilihan == "editmhs" )
        {
            include( "proseseditnilaimahasiswa.php" );
        }
    }
}
if ( $aksi == "tampilkanawal" )
{
    $aksi = " ";
    session_unregister_sikad( "statusnilai" );
    include( "prosestampilformnilaikosongawal.php" );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilnilai.php" );
}
if ( $aksi == "tambahawal" )
{
    printjudulmenu( "FORMULIR NILAI KOSONG" );
    printmesg( $errmesg );
    session_unregister_sikad( "statusnilai" );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>\r\n\t\t\t<table class=form>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidepmakul as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $jenisusers == 0 )
    {
        echo "\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIDN Dosen</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.iddosen.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    }
    echo "<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=masukan  size=10" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $waktu[year] == $i )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option {$cek} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n              <select name='kelas' >\r\n                <option value=''>Semua</option>\r\n            ";
    $ik = 1;
    while ( $ik < 100 )
    {
        if ( $ik < 10 )
        {
            $idkelas = "0{$ik}";
        }
        else
        {
            $idkelas = "{$ik}";
        }
        $selected = "";
        if ( $idkelas == $kelas )
        {
            $selected = "selected";
        }
        echo "<option value='{$idkelas}' {$selected} >{$idkelas}</option>";
        ++$ik;
    }
    echo "\r\n            </select>\r\n      \r\n      </td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
