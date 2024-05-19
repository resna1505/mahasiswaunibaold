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
$aksi = "";
if ( $aksi2 == "Copy" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bank Soal", SIMPAN_DATA );
    }
    else if ( $tahunmasuk == $tahunmasuk2 && $gelombang == $gelombang2 && $idfakultas == $idfakultas2 )
    {
        $errmesg = "Tidak dapat menyalin dari parameter yang sama.";
    }
    else
    {
        $q = "SELECT * FROM banksoalpmb WHERE TAHUN='{$tahunmasuk}' AND GELOMBANG='{$gelombang}' AND FAKULTAS='{$idfakultas}'";
        #$h = mysqli_query($koneksi,$q);
		$h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            while ( $d = sqlfetcharray( $h ) )
            {
                $q = "SELECT * FROM banksoalpmb WHERE PERTANYAAN='{$d['PERTANYAAN']}' AND TAHUN='{$tahunmasuk2}' AND GELOMBANG='{$gelombang2}' AND FAKULTAS='{$idfakultas2}'";
                $h2 = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h2 ) )
                {
                    ++$sudahada;
                }
                else
                {
                    $q = "\r\n\r\n          INSERT INTO   `banksoalpmb` (\r\n           TAHUN,\r\n          `GELOMBANG` ,\r\n          `FAKULTAS` ,\r\n          `IDBIDANG` ,\r\n          `PERTANYAAN` ,\r\n          `GAMBAR` ,\r\n          `NILAI` ,\r\n          `NILAISALAH` ,\r\n          `JENIS` ,\r\n          `JAWABAN1` ,\r\n          `JAWABAN2` ,\r\n          `JAWABAN3` ,\r\n          `JAWABAN4` ,\r\n          `JAWABAN5` ,\r\n          `JAWABAN6` ,\r\n          `KUNCIBS` ,\r\n          `UPDATER` ,\r\n          `TANGGALUPDATE` ,\r\n          `KUNCI`\r\n          )\r\n          VALUES ( \r\n          '{$tahunmasuk2}',  \r\n          '{$gelombang2}',  \r\n          '{$idfakultas2}',  \r\n          '".mysqli_real_escape_string($koneksi, $d[BIDANG] )."',  \r\n          '".mysqli_real_escape_string($koneksi, $d[PERTANYAAN] )."',  \r\n          '',  \r\n          '".mysqli_real_escape_string($koneksi, $d[NILAI] )."',  \r\n          '".mysqli_real_escape_string($koneksi, $d[NILAISALAH] )."',  \r\n          '".mysqli_real_escape_string($koneksi, $d[JENIS] )."', \r\n           '".mysqli_real_escape_string($koneksi, $d[JAWABAN1] )."',  \r\n           '".mysqli_real_escape_string($koneksi, $d[JAWABAN2] )."',  \r\n           '".mysqli_real_escape_string($koneksi, $d[JAWABAN3] )."',  \r\n           '".mysqli_real_escape_string($koneksi, $d[JAWABAN4] )."', \r\n            '".mysqli_real_escape_string($koneksi, $d[JAWABAN5] )."',  \r\n            '".mysqli_real_escape_string($koneksi, $d[JAWABAN6] )."',  \r\n           '".mysqli_real_escape_string($koneksi, $d[KUNCIBS] )."',  \r\n           '{$users}',  NOW(),  \r\n           '".mysqli_real_escape_string($koneksi, $d[KUNCI] )."'\r\n          )\r\n        \r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        ++$berhasil;
                        if ( $d[GAMBAR] != "" && file_exists( "gambar/{$d['GAMBAR']}" ) )
                        {
                            $id = mysqli_insert_id( $koneksi );
                            $ext = get_file_extension( $d[GAMBAR] );
                            @copy( @"gambar/{$d['GAMBAR']}", @"gambar/{$id}.{$ext}" );
                            $qgambar = ",GAMBAR='{$id}.{$ext}'  ";
                            $q = "UPDATE banksoalpmb SET GAMBAR='".mysqli_real_escape_string($koneksi, $id.$ext )."' WHERE ID='{$id}' ";
                            mysqli_query($koneksi,$q);
                        }
                    }
                    else
                    {
                        ++$gagal;
                    }
                }
            }
            $errmesg = "\r\n        ".( $berhasil + 0 )." data bank soal berhasil disalin.<br>\r\n        ".( $gagal + 0 )." data bank soal gagal disalin.<br>\r\n        ".( $sudahada + 0 )." data bank tidak disalin karena sudah ada atau duplikat.<br>\r\n        ";
        }
        else
        {
            $errmesg = "Data bank soal tidak ada.";
        }
    }
    $aksi = "";
}
if ( $aksi == "" )
{
    printjudulmenu( "Copy Data Bank Soal PMB " );
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    echo "\r\n\t\t<form name=form action=index.php method=post onSubmit=\"return confirm('Salin data bank soal?')\">\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Salin Dari</td>\r\n\t\t\t<td> \r\n  \t\t\t</td>\r\n\t\t</tr>  \t\t\t\r\n    <tr>\t\r\n\t\t\t\t<td width=200 >\r\n\t\t\t\t\tTahun Masuk/Angkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "  \r\n\t\t\t\t\t\t<select name=tahunmasuk class=masukan> \r\n\t\t\t\t\t ";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $tahunmasuk == $i )
        {
            $cek = "selected";
        }
        else if ( $tahunmasuk == "" && $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    echo "\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Gelombang</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."\r\n  \t\t\t</td>\r\n\t\t</tr>";
    unset( $arrayfakultas[''] );
    echo "\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Fakultas</td>\r\n\t\t\t<td>".createinputselect( "idfakultas", $arrayfakultas, $idfakultas, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Ke</td>\r\n\t\t\t<td> \r\n  \t\t\t</td>\r\n\t\t</tr>  \r\n    <tr>\t\r\n\t\t\t\t<td width=200 >\r\n\t\t\t\t\tTahun Masuk/Angkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "  \r\n\t\t\t\t\t\t<select name=tahunmasuk2 class=masukan> \r\n\t\t\t\t\t ";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $cek = "";
        if ( $tahunmasuk2 == $i )
        {
            $cek = "selected";
        }
        else if ( $tahunmasuk2 == "" && $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $gelombang2 == "" )
    {
        $gelombang2 = 1;
    }
    echo "\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Gelombang</td>\r\n\t\t\t<td>".createinputtext( "gelombang2", $gelombang2, " class=masukan  size=2" )."\r\n  \t\t\t</td>\r\n\t\t</tr>";
    unset( $arrayfakultas[''] );
    echo "\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Fakultas</td>\r\n\t\t\t<td>".createinputselect( "idfakultas2", $arrayfakultas, $idfakultas2, "", " class=masukan" )."</td>\r\n\t\t</tr>\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Copy' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \r\n\t";
}
?>
